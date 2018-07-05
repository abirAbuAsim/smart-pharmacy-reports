<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client;

        $response = $client->post('http://f883ab6c.ngrok.io/smartChemistApi/public/all-sales-orders', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $orderList = $response['data']['order_list'];

        // Get pharmacy names
        $client = new Client;
        $response = $client->get('http://f883ab6c.ngrok.io/smartChemistApi/public/all-pharmacies-with-sales', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $pharmacyList = $response['data']['pharmacy_list'];

        // Get company list
        $client = new Client;
        $response = $client->get('http://35.160.205.158:81/mrapi/v0.0.1/company-list');

        $response = json_decode($response->getBody(), true);
        $companyListFromApi = $response['data']['company_list'];

        $companyArray = array();
        foreach ($companyListFromApi as $company){
            $companyArray[$company['id']] = $company['company_name'];
        }

        return view('sales', ['orders' => $orderList, 'pharmacyList' => $pharmacyList,
            'companyArray' => $companyArray]);
    }


    public function showSearchResult(Request $request)
    {
        $fromDatePickerInput= '';
        $toDatePickerInput = '';
        $selectedPharmacy = '';

        if ($request->has('fromDatePickerInput')) {
            $fromDatePickerInput = $request->input('fromDatePickerInput');
        }

        if ($request->has('toDatePickerInput')) {
            $toDatePickerInput = $request->input('toDatePickerInput');
        }

        if ($request->has('selectedPharmacy')) {
            $selectedPharmacy = $request->input('selectedPharmacy');
        }

        $client = new Client;

        /*dd($fromDatePickerInput);
        dd($toDatePickerInput);
        dd($selectedPharmacy);*/

        $response = $client->post('http://f883ab6c.ngrok.io/smartChemistApi/public/search-sales-orders-by-params', [
            'form_params' => [
                'from_date' => $fromDatePickerInput,
                'to_date' =>$toDatePickerInput,
                'pharmacy_id' => $selectedPharmacy,
            ],
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $searchResultOrderList = $response['data']['order_list'];

        // Get pharmacy names
        $client = new Client;
        $response = $client->get('http://f883ab6c.ngrok.io/smartChemistApi/public/all-pharmacies-with-sales', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $pharmacyList = $response['data']['pharmacy_list'];

        // Get company list
        $client = new Client;
        $response = $client->get('http://35.160.205.158:81/mrapi/v0.0.1/company-list');

        $response = json_decode($response->getBody(), true);
        $companyListFromApi = $response['data']['company_list'];

        $companyArray = array();
        foreach ($companyListFromApi as $company){
            $companyArray[$company['id']] = $company['company_name'];
        }

        return view('sales', ['orders' => $searchResultOrderList, 'pharmacyList' => $pharmacyList,
            'fromDatePickerValue' => $fromDatePickerInput, 'toDatePickerValue' => $toDatePickerInput,
            'selectedPharmacy' => $selectedPharmacy, 'companyArray' => $companyArray]);
    }
}
