<?php

namespace QuickPay\PaymentAPI;

require_once('Exception.php');

/**
 * QuickPay Response
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
class Response
{

	protected static $__md5checkFields = array(
		'msgtype',
		'ordernumber',
		'amount',
		'currency',
		'time',
		'state',
		'qpstat',
		'qpstatmsg',
		'chstat',
		'chstatmsg',
		'merchant',
		'merchantemail',
		'transaction',
		'cardtype',
		'cardnumber',
		'cardhash',
		'cardexpire',
		'splitpayment',
		'fraudprobability',
		'fraudremarks',
		'fraudreport',
		'fee'
		);

    protected $_response;
    protected $_xml;
    protected $_md5check;

    /**
     * QuickPay Response abstraction
     * @param string $rawResponse QuickPay response body
     * @param string $md5check    md5sectet string
     * @throws QuickPay\PaymentAPI\Exception If unable to parse response
     */
    public function __construct($rawResponse, $md5check)
    {
        $this->_md5check = $md5check;
        try {
        	$this->_response = $this->_createResponseData(new \SimpleXMLElement($rawResponse));
        } catch (\Exception $e) {
        	throw new Exception("Error parsing response. Error: {$e->getMessage()}. Response: {$rawResponse}");
        }
    }

    /**
     * Was request successful
     * @return boolean True if success
     */
    public function isSuccess() {
        return $this->get('qpstat') === '000';
    }

    /**
     * Get error message (qpstatmsg)
     *
     * @return string Error message. Equals 'OK' if request was successful
     */
    public function getErrorMessage() {
        return $this->get('qpstatmsg');
    }

    /**
     * Get Response value
     * @param  string $key
     * @return multi
     */
    public function get($key) {
        return $this->_response[$key];
    }

    /**
     * Get response as hash array
     *
     * @return array Response hash array
     */
    public function toArray() {
        return $this->_response;
    }

    /**
     * Verify response md5check. Use this to verify response came from QuickPay
     *
     * @return boolean Verified?
     */
    public function isValid() {
        $md5string = '';
        foreach(static::$__md5checkFields as $key) {
        	if(array_key_exists($key,$this->_response)) {
                $md5string .= $this->_response[$key];
            }
        }
        return strcmp($this->_response['md5check'],md5($md5string . $this->_md5check)) === 0;
    }

    private function _createResponseData(\SimpleXMLElement $xml) {
        return array(
            'msgtype' => (string)$xml->msgtype,
            'ordernumber' => (string)$xml->ordernumber,
            'amount' => (int)$xml->amount,
            'currency' => (string)$xml->currency,
            'time' => (string)$xml->time,
            'state' => (string)$xml->state,
            'qpstat' => (string)$xml->qpstat,
            'qpstatmsg' => (string)$xml->qpstatmsg,
            'chstat' => (string)$xml->chstat,
            'chstatmsg' => (string)$xml->chstatmsg,
            'merchant' => (string)$xml->merchant,
            'merchantemail' => (string)$xml->merchantemail,
            'transaction' => (int)$xml->transaction,
            'cardtype' => (string)$xml->cardtype,
            'cardnumber' => (string)$xml->cardnumber,
            'cardhash' => (string)$xml->cardhash,
            'cardexpire' => (string)$xml->cardexpire,
            'splitpayment' => !empty($xml->splitpayment) ? (int)$xml->splitpayment : '',
            'fraudprobability' => (string)$xml->fraudprobability,
            'fraudremarks' => (string)$xml->fraudremarks,
            'fraudreport' => (string)$xml->fraudreport,
            'md5check'=> (string)$xml->md5check
        );
    }
}
