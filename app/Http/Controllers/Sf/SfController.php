<?php

namespace App\Http\Controllers\Sf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sf\SendCourierRequest;
use App\Http\Requests\Sf\UpdateCourierRequest;
use App\Models\BankService;
use App\Models\LawRegistration;
use App\Models\LawService;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;
use Omniphx\Forrest\Exceptions\SalesforceException;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SfController extends Controller
{

    /**
     * create or update courier request
     */
    public function create(SendCourierRequest $request): RedirectResponse
    {
        $user = auth()?->user();

        $data = [
            'FirstName' => $user->first_name,
            'LastName' => $user->last_name,
            'Email' => $user->email,
            'Phone' => $user->phone,
            'RequestStatus__c' => LawRegistration::STATUS_NEW,
            'Company' => 'Delivery Club',
            'Inn__c' => $request->inn,
            'PassportCode__c' => $request->passport_code,
            'PassportNum__c' => $request->passport_num,
            'Citizenship__c' => $request->citizenship,
        ];

        $requestData = [
            'method' => 'post',
            'body' => $data,
            'headers' => $this->defaultHeaders(),
        ];

        // log lawService request to db
        $lawService = LawService::first();
        $apiLog = $lawService->apiService->apiLogs()->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'request' => $requestData
        ]);

        try {
            Forrest::authenticate();
            $response = Forrest::sobjects('Lead', $requestData);
            // log lawService response
            $apiLog->update([
                'response' => $response
            ]);
        } catch (SalesforceException $e) {
            // log lawService error as response
            $apiLog->update([
                'response' => ['error' => json_decode($e->getMessage())]
            ]);
            throw ValidationException::withMessages($this->extractValidationMessages($e));
        }

        // update db law registration info
        $lawService->lawRegistrations()->updateOrCreate([
            'user_id' => $user->id,
        ],
            [
                'ind_code' => $response['id'],
                'data' => $requestData,
                'status' => $data['RequestStatus__c']
            ]
        );

        return redirect()->route('forms');
    }

    /**
     * update courier status
     */
    public function update(UpdateCourierRequest $request): RedirectResponse
    {
        $user = auth()?->user();
        $lawService = LawService::first();
        $bankService = BankService::first();

        $data = [
            'RequestStatus__c' => LawRegistration::STATUS_TO_BANK_APPLY,
            'CorrespondentAccount__c' => $request->correspondent_account,
            'Bik__c' => $request->bik,
            'Snils__c' => $request->snils,
            'CurrentAddress__c' => $request->address,
            'BirthDate__c' => $request->birth_date,
        ];

        $requestData = [
            'method' => 'patch',
            'body' => $data,
            'headers' => $this->defaultHeaders(),
        ];

        // log bankService request to db
        $lawRegistration = $lawService->lawRegistrations()->where('user_id', $user->id)->firstOrFail();
        $apiLog = $bankService->apiService->apiLogs()->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'request' => $requestData
        ]);

        $sf_id = $lawRegistration->ind_code;
        try {
            Forrest::authenticate();
            $response = Forrest::sobjects("Lead/$sf_id", $requestData);
            // log bankService response
            $apiLog->update([
                'response' => $response
            ]);
        } catch (SalesforceException $e) {
            // log bankService error as response
            $apiLog->update([
                'response' => ['error' => json_decode($e->getMessage())]
            ]);
            throw ValidationException::withMessages($this->extractValidationMessages($e));
        }

        // update db payment account status
        $bankService->paymentAccounts()->updateOrCreate([
            'user_id' => $user->id,
        ],
            [
                'ind_code' => $sf_id,
                'data' => $requestData,
                'status' => $data['RequestStatus__c']
            ]
        );
        // update db law registration status
        $lawRegistration->update(['status' => $data['RequestStatus__c']]);

        return redirect()->route('forms');
    }

    /**
     * check courier status
     */
    public function check(): RedirectResponse
    {
        $user = auth()?->user();
        $lawService = LawService::first();
        $lawRegistration = $lawService->lawRegistrations()->where('user_id', $user->id)->first();

        if($lawRegistration != null) {
            $sf_id = $lawRegistration->ind_code;
            try {
                Forrest::authenticate();
                $response = Forrest::sobjects("Lead/$sf_id", [
                    'method' => 'get',
                    'headers' => $this->defaultHeaders()
                ]);

            } catch (SalesforceException $e) {
                throw ValidationException::withMessages($this->extractValidationMessages($e));
            }
            // update db law registration status
            $lawRegistration->update(['status' => $response['RequestStatus__c'] ?? 0]);
        }

        return redirect()->route('forms');
    }

    #[ArrayShape(['Sforce-Auto-Assign' => "string", 'Content-Type' => "string"])]
    private function defaultHeaders(): array
    {
        return [
            'Sforce-Auto-Assign' => 'true',
            'Content-Type' => 'application/json'
        ];
    }

    private function extractValidationMessages(\Exception|SalesforceException $e): array
    {
        return collect(json_decode($e->getMessage()))
            ->map((fn($elem) => $elem->message))
            ->toArray();
    }
}
