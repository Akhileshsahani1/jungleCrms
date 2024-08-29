<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class WhatsappMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $ch = curl_init();

        $params = [
            "messaging_product" => "whatsapp", 
            "recipient_type" => "individual", 
            "to" => $request->input('number'),
            "type" => "template", 
            "template" => [
                "name" => "booking_estimate", 
                "language" => [
                    "code" => "en_US"
                ], 
                "components" => [
                    [
                        "type" => "header", 
                        "parameters" => [
                            [
                                "type" => "text", 
                                "text" => "krishna" 
                            ] 
                        ] 
                    ],
                    [
                        "type" => "body", 
                        "parameters" => [
                            [
                                "type" => "text", 
                                "text" => "http://127.0.0.1:8000/send-wahtsapp-messages?number=919026574061" 
                            ] 
                        ] 
                    ] 
                ] 
            ] 
        ]; 

        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v16.0/'.env('WHATSAPP_API_CODE').'/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $headers = array();
        $headers[] = 'Authorization: Bearer '.env('WHATSAPP_API_SECRET');
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        echo "<pre>";print_r($result);"</pre>";exit;
        curl_close($ch);}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v17.0/FROM_PHONE_NUMBER_ID/messages');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"messaging_product\": \"whatsapp\",\n  \"recipient_type\": \"individual\",\n  \"to\": \"PHONE_NUMBER\",\n  \"type\": \"template\",\n  \"template\": {\n    \"name\": \"TEMPLATE_NAME\",\n    \"language\": {\n      \"code\": \"LANGUAGE_AND_LOCALE_CODE\"\n    },\n    \"components\": [\n      {\n        \"type\": \"body\",\n        \"parameters\": [\n          {\n            \"type\": \"text\",\n            \"text\": \"text-string\"\n          },\n          {\n            \"type\": \"currency\",\n            \"currency\": {\n              \"fallback_value\": \"VALUE\",\n              \"code\": \"USD\",\n              \"amount_1000\": NUMBER\n            }\n          },\n          {\n            \"type\": \"date_time\",\n            \"date_time\": {\n              \"fallback_value\": \"DATE\"\n            }\n          }\n        ]\n      }\n    ]\n  }\n}");

$headers = array();
$headers[] = 'Authorization: Bearer ACCESS_TOKEN';
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
