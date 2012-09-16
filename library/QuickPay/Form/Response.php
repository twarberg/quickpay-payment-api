<?php

namespace QuickPay\Form;

/**
 * QuickPay Form Response
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

    public function __construct($post) {
        $this->_response = $this->_parsePost($post);
    }

    public function get($key) {
    	return $this->_response[$key];
    }


    public function isSuccess() {
        return $this->_response['qpstat'] == '000';
    }

    public function isValid($md5check) {
        $md5string = '';
        foreach(static::$__md5checkFields as $key) {
            if(array_key_exists($key, $this->_response)) {
                $md5string .= $this->_response[$key];
            }
        }
        return strcmp($this->_response['md5check'],md5($md5string . $md5check)) === 0;
    }

    protected function _parsePost($post) {
        return array(
            'msgtype' => isset($post['msgtype']) ? $post['msgtype'] : null,
            'ordernumber' => isset($post['ordernumber']) ? $post['ordernumber'] : null,
            'amount' => isset($post['amount']) ? $post['amount'] : null,
            'currency' => isset($post['currency']) ? $post['currency'] : null,
            'time' => isset($post['time']) ? $post['time'] : null,
            'state' => isset($post['state']) ? $post['state'] : null,
            'qpstat' => isset($post['qpstat']) ? $post['qpstat'] : null,
            'qpstatmsg' => isset($post['qpstatmsg']) ? $post['qpstatmsg'] : null,
            'chstat' => isset($post['chstat']) ? $post['chstat'] : null,
            'chstatmsg' => isset($post['chstatmsg']) ? $post['chstatmsg'] : null,
            'merchant' => isset($post['merchant']) ? $post['merchant'] : null,
            'merchantemail' => isset($post['merchantemail']) ? $post['merchantemail'] : null,
            'transaction' => isset($post['transaction']) ? $post['transaction'] : null,
            'cardtype' => isset($post['cardtype']) ? $post['cardtype'] : null,
            'cardnumber' => isset($post['cardnumber']) ? $post['cardnumber'] : null,
            'cardhash' => isset($post['cardhash']) ? $post['cardhash'] : null,
            'cardexpire' => isset($post['cardexpire']) ? $post['cardexpire'] : null,
            'splitpayment' => isset($post['splitpayment']) ? $post['splitpayment'] : null,
            'fraudprobability' => isset($post['fraudprobability']) ? $post['fraudprobability'] : null,
            'fraudremarks' => isset($post['fraudremarks']) ? $post['fraudremarks'] : null,
            'fraudreport' => isset($post['fraudreport']) ? $post['fraudreport'] : null,
            'fee' => isset($post['fee']) ? $post['fee'] : null,
            'md5check' => isset($post['md5check']) ? $post['md5check'] : null,
        );
    }
}