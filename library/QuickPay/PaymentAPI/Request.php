<?php

namespace QuickPay\PaymentAPI;

require_once('Response.php');

/**
 * Base abstract class for requests. Contains common request logic
 *
 * @author Tim Warberg <tlw@interface.dk>, interFace ApS
 *
 * Copyright (C) 2012 Tim Warberg <tlw@interface.dk>, interFace ApS
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software
 * is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */
abstract class Request
{
    const API_VERSION = 7;
    const API_URL = 'https://secure.quickpay.dk/api';

    protected $_data;
    protected $_md5check;
    protected $_md5Fields = array();

    private $_curl;
    private $_url;

    /**
     * QuickPay request
     *
     * @param integer $quickpayID Merchants ID at QuickPay (QuickPayID)
     * @param string  $md5check   MD5 check key. Is found/generated inside QuickPay Manager
     * @param string $apiUrl      Optional alternate URL for QuickPay Payment API
     */
    public function __construct($quickpayID, $md5check, $apiUrl = false, $verifySSL = true) {
        $this->_url = is_string($apiUrl) ? $apiUrl : self::API_URL;
        $this->_data = $this->_createInitialData($quickpayID);
        $this->_md5check = $md5check;

        $this->_curl = curl_init();
        curl_setopt($this->_curl,CURLOPT_URL,$this->_url);
        curl_setopt($this->_curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($this->_curl,CURLOPT_FRESH_CONNECT, true);
        curl_setopt($this->_curl,CURLOPT_SSL_VERIFYPEER, $verifySSL);
        curl_setopt($this->_curl,CURLOPT_POST,true);
    }

    /**
     * Test or real live transaction?
     *
     * @param boolean $testmode True for testmode. False for production
     */
    public function setTestmode($testmode) {
        $this->_set('testmode', $testmode ? '1' : '0');
        return $this;
    }

    /**
     * Set API key. API key is generated inside QuickPay Manager.
     *
     * API key is only required if IP request is comming from isn't whitelisted in QuickPay Manager
     *
     * @param string $apikey
     */
    public function setApiKey($apikey) {
        $this->_set('apikey', $apikey);
        return $this;
    }

    /**
     * Send request to QuickPay Payment API
     *
     * @throws QuickPay\PaymentAPI\Exception If unable to parse response
     * @return Response Response from QuickPay
     */
    public function send() {
        curl_setopt($this->_curl,CURLOPT_POSTFIELDS,$this->_buildRequest());
        $r = curl_exec($this->_curl);
        return new Response($r, $this->_md5check);
    }

    /**
     * Set request data
     *
     * @param string $key
     * @param string $value
     */
    protected function _set($key, $value) {
        $this->_data[$key] = $value;
        return $this;
    }

    /**
     * Get request data
     *
     * @param  string $key
     * @return multi Value
     */
    protected function _get($key) {
        return $this->_data[$key];
    }

    /**
     * Prepare request data array
     *
     * @param  integer $quickpayID Merchant customer ID at QuickPay
     * @return array
     */
    protected function _createInitialData($quickpayID) {
        return array(
            'protocol' => self::API_VERSION,
            'channel' => 'creditcard',
            'msgtype' => null,
            'merchant' => $quickpayID,
            'ordernumber' => null,
            'amount' => null,
            'currency' => null,
            'autocapture' => '0',
            'cardnumber' => null,
            'expirationdate' => null,
            'cvd' => null,
            'mobilenumber' => null,
            'smsmessage' => null,
            'acquirers' => null,
            'cardtypelock' => null,
            'transaction' => null,
            'description' => null,
            'group' => null,
            'splitpayment' => null,
            'finalize' => null,
            'cardhash' => null,
            'testmode' => '0',
            'fraud_remote_addr' => null,
            'fraud_http_accept' => null,
            'fraud_http_accept_language' => null,
            'fraud_http_accept_encoding' => null,
            'fraud_http_accept_charset' => null,
            'fraud_http_referer' => null,
            'fraud_http_user_agent' => null,
            'apikey' => null
        );
    }

    /**
     * Build request
     *
     * @return array Request hash
     */
    protected function _buildRequest() {
        $request = array();
        $md5string = '';
        foreach($this->_data as $key => $value) {
            if($value != null) {
                $request[$key] = $value;
                $md5string .= $value;
            }
        }

        $request['md5check'] = md5($md5string . $this->_md5check);

        return $request;
    }
}
