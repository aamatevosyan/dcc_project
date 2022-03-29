<?php

namespace App\Http\Controllers\Sf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sf\SendCourierRequest;
use App\Http\Requests\Sf\UpdateCourierRequest;
use App\Models\LawRegistration;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Inertia\Response as InertiaResponse;
use JetBrains\PhpStorm\ArrayShape;
use Omniphx\Forrest\Exceptions\SalesforceException;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SfController extends Controller
{

    /**
     * create or update courier request
     */
    public function create(SendCourierRequest $request, User $user)
    {
        try {
            $response = Forrest::sobjects('Lead', [
                'method' => 'post',
                'body' => [
                    'FirstName' => $user->first_name,
                    'LastName' => $user->last_name,
                    'Email' => $user->email,
                    'Phone' => $user->phone,
                    'Status' => LawRegistration::STATUS_NEW,
                    'Company' => 'Delivery Club',
//                    'Inn' => $request->inn,
//                    'PassportCode' => $request->passport_code,
//                    'PassportNum' => $request->passport_num,
//                    'Citizenship' => $request->citizenship,
                ],
                'headers' => $this->defaultHeaders()
            ]);
        } catch (SalesforceException $e) {
            throw ValidationException::withMessages($this->extractValidationMessages($e));
        }
        $sf_id = $response['id'];
        dd($response);
        // TODO: link id with user
    }

    /**
     * update courier status
     */
    public function update(UpdateCourierRequest $request, User $user)
    {
        $sf_id = '00Q8d000002nh6jEAA'; // TODO брать из данных по $user->uuid
        try {
            $response = Forrest::sobjects("Lead/$sf_id", [
                'method' => 'patch',
                'body' => [
                    'FirstName' => $user->first_name,
                    'LastName' => $user->last_name,
                    'Email' => $user->email,
                    'Phone' => $user->phone,
                    'Status' => LawRegistration::STATUS_TO_BANK_APPLY,
                    'Company' => 'Delivery Club',
//                    'Inn' => $request->inn,
//                    'PassportCode' => $request->passport_code,
//                    'PassportNum' => $request->passport_num,
//                    'Citizenship' => $request->citizenship,
//                    'CorrespondentAccount' => $request->correspondent_account,
//                    'Bik' => $request->bik,
//                    'Snils' => $request->snils,
//                    'Address' => $request->address,
//                    'BirthDate' => $request->birth_date,
                ],
                'headers' => $this->defaultHeaders()
            ]);
        } catch (SalesforceException $e) {
            throw ValidationException::withMessages($this->extractValidationMessages($e));
        }
        dd($response);
    }

    /**
     * check courier status
     * @return InertiaResponse
     */
    public function check(User $user)
    {
        $sf_id = '00Q8d000002nh6jEAA'; // TODO брать из данных по $user->uuid
        try {
            $response = Forrest::sobjects("Lead/$sf_id", [
                'method' => 'get',
                'headers' => $this->defaultHeaders()
            ]);
        } catch (SalesforceException $e) {
            throw ValidationException::withMessages($this->extractValidationMessages($e));
        }
        dd($response);
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
