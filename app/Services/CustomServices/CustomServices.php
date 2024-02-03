<?php

namespace App\Services\CustomServices;

class CustomServices
{

    /**
     * Send OTP Via bulk SMS Service
     */


    public function sendVertificationCode($phone, $code)
    {
        $url = "http://new.bulksmsbd.com/api/smsapi";
        $api_key = "nRBVBp6X5fRViec286zz";
        $senderid = "8809601004407";
        $number = "{$phone}";
        $message = "Your OTP for OneFish App by ARITS Limited is {$code}";

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
    //Paginator for Elastic Search
    public function paginationFrom($pageNo, $perPage)
    {
        $from = 0;
        if (isset($pageNo)) {
            if ($pageNo == 1 || $pageNo == 0) {
                $from = 0;
            } elseif ($pageNo > 1) {
                $from = ($pageNo * $perPage - $perPage);
            }
        } else {
            $from = 0;
        }
        return $from;
    }
    // pagination methods
    public function paginationsAction($request,$page_no=null){
        // Check if Pagination is enabled
        if(!(int)$page_no){
            $params = $request->all();
            if(isset($params['start']) && isset($params['size'])){
                // if((int) $params['size'] > 100){
                //     $start = $params['start'];
                //     $size = 100;
                // }else{
                //     $start = $params['start'];
                //     $size = $params['size'];
                // }
                $start = $params['start'];
                $size = $params['size'];
            }else{
                $start = 0;
                // Pagination Per Page from .env
                $size = config('globalvariables.paginator_per_page');;
            }
        }else{
            //  Check if infinite scrolling is enabled
            if (!((string) (int) $page_no == $page_no)) {
                return GenericResponses::error("Data Not Found");
            }
            // Per page List Number form .env
            $size = config('globalvariables.paginator_per_page');
            if (isset($page_no)) {
                if ($page_no == 1 || $page_no == 0) {
                    $start = 0;
                } elseif ($page_no > 1) {
                    $start = ($page_no * $size - $size);
                }
            } else {
                $start = 0;
            }
        }
        $values = [
            "start" => $start,
            "size" => $size,
        ];
        return $values;
    }

    //Results format for Elastic Search
    public function formatResultsForES($data)
    {
        $result = [];
        foreach ($data as $key => $value) {
            array_push($result, $data[$key]['_source']);
        }
        return $result;
    }

    /*=============================================
  * Call External Webservices using CURL
  *
  * @param $requestURL, $header -> (OPTIONAL)
  * @return json
  #=============================================*/
    public function curlRequest($requestURL, $headers = array())
    {
        $getData = curl_init($requestURL);
        curl_setopt($getData, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($getData, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($getData, CURLOPT_SSL_VERIFYHOST, false);
        if (count($headers) != 0) {
            curl_setopt($getData, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($getData);
        return json_decode($response);
    }


    /*=============================================
    * Remove Duplicates from Array of Objects
    *
    * @param $requestURL, $header -> (OPTIONAL)
    * @return json
    #=============================================*/
    function removeDuplicateObjects($array, $keep_key_assoc = false)
    {
        $duplicate_keys = array();
        $tmp = array();

        foreach ($array as $key => $val) {
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;

            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);
    }
}
