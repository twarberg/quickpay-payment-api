<?php

namespace QuickPay\PaymentAPI\Request;

require_once(__DIR__ . '/../Request.php');

use QuickPay\PaymentAPI;

/**
 * Authorize transaction request
 *
 * NB! authorize only allowed from a PCI certificed environment
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
class Authorize extends PaymentAPI\Request
{
    public function __construct($quickpayID, $md5check, $apiUrl = false) {
        parent::__construct($quickpayID, $md5check, $apiUrl);
        $this->_set('msgtype','authorize');
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

    public function setCardnumber($cardnumber) {
        $this->_set('cardnumber',$cardnumber);
        return $this;
    }

    public function setExpirationDate($expdate) {
        $this->_set('expirationdate', $expdate);
        return $this;
    }

    public function setCVD($cvd) {
        $this->_set('cvd',$cvd);
        return $this;
    }

    public function setCardtypeLock($cardtypelock) {
        $this->_set('cardtypelock',$cardtypelock);
        return $this;
    }

    public function setSplitpayment($split) {
        $this->_set('splitpayment',$split ? '1' : '0');
        return $this;
    }
}
