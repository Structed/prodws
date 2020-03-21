<?php

namespace structed\Prodws;

class Service extends \SoapClient {

    private function pr($var) {
        echo('<xmp>'.print_r($var, true).'</xmp>');
    }

    /**
     * Service constructor.
     *
     * @param string $username Username
     * @param string $password Password
     * @param array $options A array of config values for `SoapClient` (see PHP docs)
     * @param string $wsdl The wsdl file to use (defaults to 'https://prodws.deutschepost.de:8443/ProdWSProvider_1_1/prodws?wsdl')
     * @throws \SoapFault
     */
    public function __construct($username, $password, $options = array(), $wsdl = null) {
        $options = array_merge(array(
            'features' => 1,
            'trace' => 1,
        ), $options);

        if($wsdl === null) {
            $wsdl = 'https://prodws.deutschepost.de:8443/ProdWSProvider_1_1/prodws?wsdl';
        }

        $this->__setSoapHeaders(Array(new WsseAuthHeader($username, $password)));

        parent::__construct($wsdl, $options);
    }

    /**
     * @param GetProductListRequestParameters $requestParameters
     * @return mixed
    */
    public function getProductListImpl(GetProductListRequestParameters $requestParameters) {
        return $this->getProductList($requestParameters);
    }

    public function debugPrintLastRequestResponse() {
        echo '<div>';
        echo '<h2>Request</h2>';
        echo '<div>';
        $this->pr($this->__getLastRequestHeaders());
        $this->pr($this->__getLastRequest());
        echo '</div>';

        echo '<h2>Response</h2>';
        echo '<div>';
        $this->pr($this->__getLastResponseHeaders());
        $this->pr($this->__getLastResponse());
        echo '</div>';
        echo '</div>';
    }
}

class WsseAuthHeader extends \SoapHeader {

    private $wss_ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    private $wsp_ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText';

    function __construct($username, $password) {
        $encodedPassword = htmlspecialchars($password);

        $auth = new \stdClass();
        $auth->Username = new \SoapVar($username, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);
        $auth->Password = new \SoapVar('<ns2:Password Type="' . $this->wsp_ns . '">' . $encodedPassword .'</ns2:Password>', XSD_ANYXML);

        $username_token = new \stdClass();
        $username_token->UsernameToken = new \SoapVar($auth, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns);

        $security_sv = new \SoapVar(
            new \SoapVar($username_token, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns),
            SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'Security', $this->wss_ns);

        parent::__construct($this->wss_ns, 'Security', $security_sv, true);
    }
}

class GetProductListRequestParameters
{
    public $mandantID;
    public $dedicatedProducts;
    public $responseMode;

    /**
     * GetProductListRequest constructor.
     * @param $mandantID
     * @param $dedicatedProducts
     * @param $responseMode
     */
    public function __construct($mandantID, $dedicatedProducts, $responseMode)
    {
        $this->mandantID = $mandantID;
        $this->dedicatedProducts = $dedicatedProducts;
        $this->responseMode = $responseMode;
    }
}