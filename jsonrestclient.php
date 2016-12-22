<?php

/* * *****************************************************************************
 * File Name: jsonrestclient.php
 * Project: JSON REST API
 * Author: Matt Nutsch
 * Date Created: Oct 5, 2016[1:54:21 PM]
 * Description: This code connects to a server and POSTs a JSON string.
 * Notes: 
 * **************************************************************************** */


//==================================================================== BEGIN PHP

$jsonStr = '{"invoiceNumber":"123456","invoiceSubTotal":"123.00","salesTax":"12.30","invoiceTotal":"135.30"}';

function post_to_url($url, $data) {
    $fields = '';
    foreach ($data as $key => $value) {
        $fields .= $key . '=' . $value . '&';
    }
    rtrim($fields, '&');

    $post = curl_init();

    curl_setopt($post, CURLOPT_URL, $url);
    curl_setopt($post, CURLOPT_POST, count($data));
    curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($post, CURLOPT_FOLLOWLOCATION, TRUE);

    //set port, may be unnecessary
    curl_setopt($post, CURLOPT_PORT, 443);
  
    // Blindly accept the certificate
    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
  
    //set user agent, may be unnecessary
    curl_setopt($post, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); // set browser/user agent    

    $result = curl_exec($post);

    curl_close($post);
    return $result;
}

$data = array(
    "connectionid" => "123456",
    "json_value" => $jsonStr
);

$surl = 'http://www.myserver.com/jsonrestserver.php';
echo post_to_url($surl, $data);


//====================================================================== END PHP
?>
