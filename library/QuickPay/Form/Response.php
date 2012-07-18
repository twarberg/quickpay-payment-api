<?php

namespace QuickPay\Form;

class Response
{

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
        foreach($this->_response as $key => $value) {
            if($key != 'md5check') {
                $md5string .= $value;
            }
        }
        return $this->_response['md5check'] == md5($md5string . $md5check);
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