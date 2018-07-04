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

        $response = $client->post('http://103.23.41.189:9696/public/all-sales-orders', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $orderList = $response['data']['order_list'];

        // Get pharmacy names
        $client = new Client;
        $response = $client->get('http://3931ccf5.ngrok.io/smartChemistApi/public/all-pharmacy-names-in-sales', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
        ]);

        $response = json_decode($response->getBody(), true);
        $pharmacyNames = $response['data']['pharmacy_names'];

        return view('sales', ['orders' => $orderList, 'pharmacyNames' => $pharmacyNames]);
    }


}
