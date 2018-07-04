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

        $response = $client->post('http://3931ccf5.ngrok.io/smartChemistApi/public/all-sales-orders', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $orderList = $response['data']['order_list'];

        // Get pharmacy names
        $client = new Client;
        $response = $client->get('http://3931ccf5.ngrok.io/smartChemistApi/public/all-pharmacies-with-sales', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $pharmacyList = $response['data']['pharmacy_list'];

        return view('sales', ['orders' => $orderList, 'pharmacyList' => $pharmacyList]);
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

        $response = $client->post('http://3931ccf5.ngrok.io/smartChemistApi/public/search-sales-orders-by-params', [
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
        $response = $client->get('http://3931ccf5.ngrok.io/smartChemistApi/public/all-pharmacies-with-sales', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $pharmacyList = $response['data']['pharmacy_list'];

        return view('sales', ['orders' => $searchResultOrderList, 'pharmacyList' => $pharmacyList,
            'fromDatePickerValue' => $fromDatePickerInput, 'toDatePickerValue' => $toDatePickerInput,
            'selectedPharmacy' => $selectedPharmacy]);
    }
}
