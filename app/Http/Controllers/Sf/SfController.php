<?php

namespace App\Http\Controllers\Sf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sf\SendCourierRequest;
use App\Models\LawRegistration;
use Illuminate\Validation\ValidationException;
use Inertia\Response as InertiaResponse;
use JetBrains\PhpStorm\ArrayShape;
use Omniphx\Forrest\Exceptions\SalesforceException;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SfController extends Controller
{

    /**
     * create or update courier request
     * @param SendCourierRequest $request
     * @return InertiaResponse
     */
    public function create(SendCourierRequest $request, User $user): InertiaResponse
    {
        try {
            $response = Forrest::sobjects('Lead', [
                'method' => 'post',
                'body' => [
                    'FirstName' => '123',
                    'LastName' => '123',
                    'Email' => '123',
                    'Phone' => '123',
                    'Status' => LawRegistration::STATUS_NEW,
                    'Company' => 'Delivery Club',
//                'Inn' => $request->inn,
//                'PassportCode' => $request->passport_code,
//                'PassportNum' => $request->passport_num,
//                'Citizenship' => $request->citizenship,
                ],
                'headers' => $this->defaultHeaders()
            ]);
        } catch (SalesforceException $e) {
            throw ValidationException::withMessages([
                'request' => $this->createValidationExceptionMessage($e)
            ]);
        }
        $sf_id = $response['id'];
        dd($response);
        // TODO: link id with user
    }

    #[ArrayShape(['Sforce-Auto-Assign' => "string", 'Content-Type' => "string"])]
    private function defaultHeaders(): array
    {
        return [
            'Sforce-Auto-Assign' => 'true',
            'Content-Type' => 'application/json'
        ];
    }

    private function createValidationExceptionMessage($e)
    {
        return collect(json_decode($e->getMessage()))
            ->implode('message', '\n');
    }
}
