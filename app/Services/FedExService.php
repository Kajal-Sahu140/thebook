<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Color;
use GuzzleHttp\Client;
use Carbon\Carbon;

class FedExService
{
    protected $apiUrl;
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;
    protected $tokenUrl;


   

    public function __construct()
    {
        // Set FedEx credentials
        $this->clientId = 'l77fd140f451ea4a3e912e387ed2958207';  // Store in .env file
        $this->clientSecret = 'aa1b595375884ebc8f4d45f1c978174d';  // Store in .env file

        // Use sandbox for testing, production for live
        $this->baseUrl = 'https://apis-sandbox.fedex.com';
        $this->tokenUrl = 'https://apis-sandbox.fedex.com/oauth/token';
    }

    /**
     * Get FedEx Access Token
     */
    public function getAccessToken()
    {
        try {
            $authResponse = Http::asForm()->post($this->tokenUrl, [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($authResponse->successful()) {
                return $authResponse->json()['access_token'];
            }

            Log::error('FedEx Auth Error: ' . $authResponse->body());
            return null;
        } catch (\Exception $e) {
            Log::error('FedEx Token Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get FedEx Shipping Rate
     */

     function calculateTotalAmount_2($fedexResponse,$request)
    {
        $return_data = [
            'all_shipping_methods' => [],
            'cheapest_shipping_method' => "",
        ];

        try{
      
            $fedexResponse = $fedexResponse->output->rateReplyDetails;

            if (isset($fedexResponse[0]->ratedShipmentDetails) ) {
                foreach ($fedexResponse as $key => $fd_detail) {
                    $totalAmount = 0;
                    foreach ($fd_detail->ratedShipmentDetails as $detail) {
                        if (isset($detail->totalNetCharge)) {
                            $totalAmount += $detail->totalNetCharge;
                        }
                    }

                    $estimated_time = $this->find_estimate_shipping_common($request);

                    $return_data['all_shipping_methods'][] = [
                        "serviceType" => $fd_detail->serviceType,
                        "serviceName" => $fd_detail->serviceName,
                        "unitAmount" => $totalAmount,
                        "totalAmount" => (string) 0,
                        "estimated_time" => $estimated_time,
                        "delivary" => "Delivery by 13 Apr, Tuesday",
                    ];

                    if($key == 0){
                        $return_data['cheapest_shipping_method'] = [
                            "serviceType" => $fd_detail->serviceType,
                            "serviceName" => $fd_detail->serviceName,
                            "unitAmount" => $totalAmount,
                            "totalAmount" => (string) 0,
                            "estimated_time" => $estimated_time,
                            "delivary" => "Delivery by 13 Apr, Tuesday",
                        ];
                    }else{
                        if($totalAmount < $return_data['cheapest_shipping_method']['totalAmount']){
                            $return_data['cheapest_shipping_method'] = [
                                "serviceType" => $fd_detail->serviceType,
                                "serviceName" => $fd_detail->serviceName,
                                "unitAmount" => $totalAmount,
                                "totalAmount" => (string) 0,
                                "estimated_time" => $estimated_time,
                                "delivary" => "Delivery by 13 Apr, Tuesday",
                            ];
                        }     
                    }
                }    

            }

            return $return_data;

        } catch (\Throwable $th) {
            dd($th);
            return $return_data;
        }    
    }
    public function getFedExShippingRate($request)
    {
        try {
            // Get access token
            $accessToken = $this->getAccessToken();
            // dd($accessToken);
            if (!$accessToken) {
                return response()->json(['error' => 'Failed to retrieve FedEx access token'], 500);
            }

            // Shipment details
            $data = [
                "accountNumber" => ["value" => "740561073"], // Replace with actual account number
                "requestedShipment" => [
                    "shipper" => [
                        "address" => ["postalCode" => "302026", "countryCode" => "IN"],
                    ],
                    "recipient" => [
                        "address" => ["postalCode" => "302039", "countryCode" => "IN"],
                    ],
                    "pickupType" => "REQUEST_COURIER", 
                    "rateRequestType" => ["LIST", "ACCOUNT"],
                    "requestedPackageLineItems" => [
                        [
                            "weight" => ["units" => "KG", "value" => 5], // Adjust weight as needed
                            "dimensions" => [
                                "length" => 30,
                                "width" => 30,
                                "height" => 40,
                                "units" => "IN",
                            ],
                        ],
                    ],
                ],
            ];
            // Send request to FedEx API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'X-locale' => 'en_US',
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/rate/v1/rates/quotes', $data);
                $res  = json_decode($response);
                // dd($res);
                $res1 = $this->calculateTotalAmount_2($res,$request);
                                // dd($res1);
            if (!$response->successful()) {
                Log::error('FedEx Rate API Error: ' . $response->body());
                return response()->json(['error' => 'Failed to retrieve FedEx rates', 'details' => $response->json()], 500);
            }
            return $response->json();
        } catch (\Throwable $th) {
            dd($th);
            Log::error('FedEx Rate API Exception: ' . $th->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
    public function find_estimate_shipping_common($request)
    {
        try{              
            $accountNumber = '740561jghjh073';
            $meterNumber = '1231ghjghj23';
            $key = 'l77fd140f451ea4a3e912e387ed2958207';
            $password = 'aa1b595375884ebc8f4d45f1c978174d';
            $YOUR_ACCESS_TOKEN = $this->getAccessToken();
            $data = [
                "accountNumber" => ["value" => $accountNumber],
                "requestedShipment" => [
                    "shipper" => [
                        "address" => ["postalCode" => 32003, "countryCode" => "US"],
                    ],
                    "recipient" => [
                        "address" => ["postalCode" => 32002, "countryCode" => "US"],
                    ],
                    "pickupType" => "DROPOFF_AT_FEDEX_LOCATION", // DROPOFF_AT_FEDEX_LOCATION,REQUEST_COURIER, and more
                    // "pickupType" => "REQUEST_COURIER", 
                    
                    // "serviceType" => "FEDEX_1_DAY_FREIGHT",
                    "rateRequestType" => ["LIST", "ACCOUNT"],
                    "requestedPackageLineItems" => [
                        [
                            "weight" => ["units" => "LB", "value" => 151],
                            "dimensions" => [
                                "length" => 30,
                                "width" => 30,
                                "height" => 40,
                                "units" => "IN",
                            ],
                        ],
                    ],
                ],
            ];
            $response = '{"transactionId":"624deea6-b709-470c-8c39-4b5511281492","customerTransactionId":"AnyCo_order123456789","output":{"alerts":[{"code":"string","alertType":"NOTE","message":"string"}],"transitTimes":[{"transitTimeDetails":[{"serviceType":"GROUND_HOME_DELIVERY","customerMessages":[{"code":"SERVICE.TYPE.INTERNATIONAL.MESSAGE","message":"Rate does not include dities & taxes, clearance entry fees or other import fees.  The payor of duties/taxes/fees will be responsible for any applicable Clearance Entry Fees"}],"distance":{"units":"KM","value":1.2315135367772556},"commit":{"brokerCommitTimestamp":"2020-03-05T00:00:00-06:00","cutOffTime":"18:30:00","commodityName":"copper","transitDays":{"description":"2-7 Business Days","minimumTransitTime":"TWO_DAYS","maximumTransitTime":"SEVEN_DAYS"},"commitMessageDetails":"string","derivedDestinationDetail":{"serviceArea":"100015","countryCode":"US","locationId":"631278456","airportId":"CA4562","postalCode":"685423","stateOrProvinceCode":"TN","locationNumber":7856},"dateDetail":{"dayOfWeek":"THU","time":"09:30:00","day":"Apr-13-2021"}},"destinationLocation":{"geoPositionalCoordinates":"{\"latitude\":5.637376656633329,\"longitude\":3.616076749251911}"},"serviceName":"FedEx Home Delivery"}]}],"encoded":false}}';
            // dd($res);
            $res  = json_decode($response);
            // dd($res);
            $res = $this->calculateEstimation($res,$request);
            // dd($res);
            return $res;
        } catch (\Throwable $th) {
            dd($th);
            $this->ApiHandleError($th);
        }
    }
    function calculateEstimation($fedexResponse,$request)
    {
        $return_data = [
            'all_shipping_methods' => [],
            'best_shipping_method' => "",
        ];
        try{
        //    dd($fedexResponse);
            $fedexResponse = $fedexResponse->output->transitTimes;

            if (isset($fedexResponse[0]->transitTimeDetails) ) {
                foreach ($fedexResponse as $r_key => $fd_detail) {
                    $transitDays = "";
                    foreach ($fd_detail->transitTimeDetails as $key =>  $detail) {
                        if (isset($detail->commit)) {
                            $transitDays = $detail->commit->transitDays;
                        }
                        $dateDetail = $detail->commit->dateDetail;

                        // $ShippingRates =   [
                        //     'serviceName' =>  "FedEx First Overnight®",
                        //     'serviceType' =>  "FIRST_OVERNIGHT",
                        //     'totalAmount' => 249.02,
                        // ];

                        $return_data['all_shipping_methods'][] = [
                            "serviceType" => $detail->serviceType,
                            "serviceName" => $detail->serviceName,
                            "transitDays" => $transitDays,
                            "dateDetail" => $dateDetail,
                            "delivary" => $this->formatDeliveryDate($dateDetail->day),
                            // "ShippingRates" =>   $this->getShippingRates($request)
                            // "ShippingRates" => $ShippingRates,
                        ];

                        if($key == 0){
                            $return_data['best_shipping_method'] = [
                                "serviceType" => $detail->serviceType,
                                "serviceName" => $detail->serviceName,
                               "transitDays" => $transitDays,
                               "dateDetail" => $dateDetail,
                               "delivary" => $this->formatDeliveryDate($dateDetail->day),
                            //    "ShippingRates" => $ShippingRates,
                            ];
                        }else{
                            if($totalAmount < $return_data['best_shipping_method']['totalAmount']){
                                $return_data['best_shipping_method'] = [
                                    "serviceType" => $detail->serviceType,
                                    "serviceName" => $detail->serviceName,
                                   "transitDays" => $transitDays,
                                   "dateDetail" => $dateDetail,
                                   "delivary" => $this->formatDeliveryDate($dateDetail->day),
                                //    "ShippingRates" => $ShippingRates,
                                ];
                            }     
                        }
                    }

                }    

            }

            return $return_data;

        } catch (\Throwable $th) {
            dd($th);
            return $return_data;
        }    
    }

      public function formatDeliveryDate($dateString)
    {
        // Parse the given date string
        $date = Carbon::createFromFormat('M-d-Y', $dateString);

        // Format the date
        $formattedDate = $date->format('d M, l');

        return 'Delivery by ' . $formattedDate;
    }
}




