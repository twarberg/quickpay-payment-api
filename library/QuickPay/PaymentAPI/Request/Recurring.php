<?php

namespace QuickPay\PaymentAPI\Request;

require_once('Authorize.php');

/**
 * Create recurring transaction on Subscription
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
class Recurring extends Authorize
{
    public function __construct($quickpayID, $md5check, $apiUrl = false) {
        parent::__construct($quickpayID, $md5check, $apiUrl);
        $this->_set('msgtype','recurring');
    }

    public function setTransaction($tid) {
        $this->_set('transaction',$tid);
        return $this;
    }

    public function setOrderNumber($ordernumber) {
        $this->_set('ordernumber',$ordernumber);
        return $this;
    }

    public function setAmount($amount) {
        $this->_set('amount',$amount);
        return $this;
    }

    public function setCurrency($currency) {
        $this->_set('currency',$currency);
        return $this;
    }

    public function setAutoCapture($autocapture) {
        $this->_set('autocapture',$autocapture ? '1' : '0');
        return $this;
    }
}
