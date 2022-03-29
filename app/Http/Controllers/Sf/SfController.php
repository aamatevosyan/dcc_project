<?php

namespace App\Http\Controllers\Sf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sf\SendCourierRequest;
use App\Http\Requests\Sf\UpdateCourierRequest;
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
            'Status' => LawRegistration::STATUS_NEW,
            'Company' => 'Delivery Club',
            'Inn' => $request->inn,
            'PassportCode' => $request->passport_code,
            'PassportNum' => $request->passport_num,
            'Citizenship' => $request->citizenship,
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
            $response = Forrest::sobjects('Lead', $requestData);
            // log lawService response
            $apiLog->update([
                'response' => $response
            ]);
        } catch (SalesforceException $e) {
            // log lawService error as response
            $apiLog->update([
                'response' => ['error' => $e->getMessage()]
            ]);
            throw ValidationException::withMessages($this->extractValidationMessages($e));
        }

        // update db law registration info
        $lawService->lawRegistrations()->updateOrCreate([
            'user_id' => $user->id,
        ],
            [
                'ind_code' => $response['id'],
                'data' => $response,
                'status' => $data['status']
            ]
        );

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * update courier status
     */
    public function update(UpdateCourierRequest $request): RedirectResponse
    {
        $user = auth()?->user();
        $lawService = LawService::first();
        $bankService = LawService::first();

        $data = [
            'Status' => LawRegistration::STATUS_TO_BANK_APPLY,
            'CorrespondentAccount' => $request->correspondent_account,
            'Bik' => $request->bik,
            'Snils' => $request->snils,
            'Address' => $request->address,
            'BirthDate' => $request->birth_date,
        ];

        $requestData = [
            'method' => 'patch',
            'body' => $data,
            'headers' => $this->defaultHeaders(),
        ];

        // log bankService request to db
        $lawRegistration = $lawService->lawRegistrations()->findOrFail($user->uuid);
        $apiLog = $bankService->apiService->apiLogs()->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'request' => $requestData
        ]);

        $sf_id = $lawRegistration->ind_code;
        try {
            $response = Forrest::sobjects("Lead/$sf_id", $requestData);
            // log bankService response
            $apiLog->update([
                'response' => $response
            ]);
        } catch (SalesforceException $e) {
            // log bankService error as response
            $apiLog->update([
                'response' => ['error' => $e->getMessage()]
            ]);
            throw ValidationException::withMessages($this->extractValidationMessages($e));
        }

        // update db law registration status
        $lawRegistration->update(['status' => $data['status']]);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * check courier status
     */
    public function check()
    {
        $user = auth()?->user();
        $lawService = LawService::first();
        $lawRegistration = $lawService->lawRegistrations()->findOrFail($user->uuid);

        $sf_id = $lawRegistration->ind_code;
        try {
            $response = Forrest::sobjects("Lead/$sf_id", [
                'method' => 'get',
                'headers' => $this->defaultHeaders()
            ]);

        } catch (SalesforceException $e) {
            throw ValidationException::withMessages($this->extractValidationMessages($e));
        }

        // update db law registration status
        $lawRegistration->update(['status' => $response['Status']]);
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
