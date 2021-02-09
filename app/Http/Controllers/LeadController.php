<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use GuzzleHttp\Client;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $token=self::fetch_atoken();
        $leads= Leads::all();
        foreach($leads as $lead)
              dd(self::insert_leads($token,$lead));

    }

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
       // $lead = json_decode($request);

      $lead = new Leads($request->input());



      return $lead->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\leads  $leads
     * @return \Illuminate\Http\Response
     */
    public function show(leads $leads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\leads  $leads
     * @return \Illuminate\Http\Response
     */
    public function edit(leads $leads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\leads  $leads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, leads $leads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\leads  $leads
     * @return \Illuminate\Http\Response
     */
    public function destroy(leads $leads)
    {
        //
    }
  public  static function fetch_atoken()
    {
      $REFRESH_TOKEN="1000.c72c0dd5e0fecff0a6758a3570cae68d.a9f477ee88d79cb48579b1050f5200b2";
        $CLIENT_ID="1000.J7N8MS1TRBDT3LI8FB6C9RJ4TR4G1T";
        $CLIENT_SECRET="cd6ce68ae9a0dfe4394497233d7da126e3ca26b526";
        $URL='https://accounts.zoho.in/oauth/v2/token';

        $client = new \GuzzleHttp\Client();

// Create a POST request
$response = $client->request(
    'POST',
    $URL,
    [
        'form_params' => [
            'refresh_token' => $REFRESH_TOKEN,
            'client_id' => $CLIENT_ID,
            'client_secret' => $CLIENT_SECRET,
            'grant_type' => 'refresh_token'
        ]
    ]
);
$res=json_decode($response->getBody()->getContents());
return $res->access_token;
    }
    public static function insert_leads($token,$lead)
    {
              $curl_pointer = curl_init();

              $curl_options = array();
              $url = "https://www.zohoapis.com/crm/v2/Leads";

              $curl_options[CURLOPT_URL] =$url;
              $curl_options[CURLOPT_RETURNTRANSFER] = true;
              $curl_options[CURLOPT_HEADER] = 1;
              $curl_options[CURLOPT_CUSTOMREQUEST] = "POST";
              $requestBody = array();
              $recordArray = array();
              $recordObject = array();
              $recordObject["Company"]="FieldAPIValue";
              $recordObject["Last_Name"]="347706107420006";
              $recordObject["First_Name"]="34770617420006";
              $recordObject["State"]="FieldAPIValue";



              $recordArray[] = $recordObject;
              $requestBody["data"] =$recordArray;
              $curl_options[CURLOPT_POSTFIELDS]= json_encode($requestBody);
              $headersArray = array();

              $headersArray[] = "Authorization". ":" . "Zoho-oauthtoken ".$token;

              $curl_options[CURLOPT_HTTPHEADER]=$headersArray;

              curl_setopt_array($curl_pointer, $curl_options);

              $result = curl_exec($curl_pointer);
              $responseInfo = curl_getinfo($curl_pointer);
              curl_close($curl_pointer);
              list ($headers, $content) = explode("\r\n\r\n", $result, 2);
              if(strpos($headers," 100 Continue")!==false){
                  list( $headers, $content) = explode( "\r\n\r\n", $content , 2);
              }
              $headerArray = (explode("\r\n", $headers, 50));
              $headerMap = array();
              foreach ($headerArray as $key) {
                  if (strpos($key, ":") != false) {
                      $firstHalf = substr($key, 0, strpos($key, ":"));
                      $secondHalf = substr($key, strpos($key, ":") + 1);
                      $headerMap[$firstHalf] = trim($secondHalf);
                  }
              }
              $jsonResponse = json_decode($content, true);
              if ($jsonResponse == null && $responseInfo['http_code'] != 204) {
                  list ($headers, $content) = explode("\r\n\r\n", $content, 2);
                  $jsonResponse = json_decode($content, true);
              }
              return $jsonResponse;

          }

      }
