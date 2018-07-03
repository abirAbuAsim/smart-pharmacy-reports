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

        $response = $client->post('http://54.68.18.149:9696/public/order-list', [
            'headers' => [
                'APPAUTHID' => 'intel_pharma',
                'APPTOKEN' => '3fb8744b8ef6f65ed9d5687c4f45e6dd',
            ],
            'form_params' => [
                'company_id' => 7,
            ],
        ]);

        // You need to parse the response body
        // This will parse it into an array
        $response = json_decode($response->getBody(), true);
        $order_list = $response['data']['order_list'];
        //print_r($order_list);

        $name = 'San Juan Vacation';
        return view('sales', ['orders' => $order_list]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
