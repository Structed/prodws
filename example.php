<?php

namespace structed\Prodws;

require_once('Prodws.php');


$mandantID = 'USERNAME';
$username = 'username';
$password = 'RatherSecurePassword';


$getProductListParameters = new GetProductListRequestParameters(
    $mandantID,
    1,
    0
);

try {
    $prodWS = new Service($username, $password);
    $response = $prodWS->getProductListImpl($getProductListParameters);
    print_r($response);
} catch (\SoapFault $soapFault) {

    $prodWS->debugPrintLastRequestResponse();

    print_r($soapFault);
}