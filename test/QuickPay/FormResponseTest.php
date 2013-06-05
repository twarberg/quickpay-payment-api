<?php

require_once 'config.php';
require_once 'QuickPay/Form/Response.php';

class FormResponseTest extends PHPUnit_Framework_TestCase
{
	public function testAuthorizeDankort()
	{
		$post = array(
			'msgtype'=>'authorize',
			'ordernumber'=>'1370422967',
			'amount'=>'123',
			'currency'=>'DKK',
			'time'=>'2013-06-05T09:03:14+00:00',
			'state'=>'1',
			'qpstat'=>'000',
			'qpstatmsg'=>'OK',
			'chstat'=>'000',
			'chstatmsg'=>'OK',
			'merchant'=>'Merchant #1',
			'merchantemail'=>'merchant1@pil.dk',
			'transaction'=>'30192',
			'cardtype'=>'dankort',
			'cardnumber'=>'XXXXXXXXXXXX9999',
			'cardhash'=>'',
			'splitpayment'=>'1',
			'acquirer' => 'nets',
			'fraudprobability'=>'medium',
			'fraudremarks'=>'',
			'fraudreport'=>'',
			'fee'=>'0',
			'md5check'=>'2648243046d9192821f18e344b42f827'
			);

		$response = new QuickPay\Form\Response($post);

		$this->assertTrue($response->isValid('test'));
	}

	public function testAuthorizeInt()
	{
		$post = array(
			'msgtype'=>'authorize',
			'ordernumber'=>'1370423115',
			'amount'=>'123',
			'currency'=>'DKK',
			'time'=>'2013-06-05T09:05:55+00:00',
			'state'=>'1',
			'qpstat'=>'000',
			'qpstatmsg'=>'OK',
			'chstat'=>'000',
			'chstatmsg'=>'OK',
			'merchant'=>'Merchant #1',
			'merchantemail'=>'merchant1@pil.dk',
			'transaction'=>'30200',
			'cardtype'=>'mastercard-dk',
			'cardnumber'=>'XXXXXXXXXXXX9999',
			'cardhash'=>'',
			'splitpayment'=>'',
			'acquirer' => 'nets',
			'fraudprobability'=>'',
			'fraudremarks'=>'',
			'fraudreport'=>'',
			'fee'=>'0',
			'md5check'=>'875924946fa6763d7cfffcbc16635228'
			);

		$response = new QuickPay\Form\Response($post);

		$this->assertTrue($response->isValid('test'));
	}

	public function testSubscribeDankort()
	{
		$post = array(
			'msgtype'=>'subscribe',
			'ordernumber'=>'1370423411',
			'amount'=>'0',
			'currency'=>'DKK',
			'time'=>'2013-06-05T09:10:34+00:00',
			'state'=>'9',
			'qpstat'=>'000',
			'qpstatmsg'=>'OK',
			'chstat'=>'000',
			'chstatmsg'=>'OK',
			'merchant'=>'Merchant #1',
			'merchantemail'=>'merchant1@pil.dk',
			'transaction'=>'30210',
			'cardtype'=>'dankort',
			'cardnumber'=>'XXXXXXXXXXXX9999',
			'cardhash'=>'',
			'cardexpire'=>'1312',
			'splitpayment'=>'1',
			'acquirer'=>'nets',
			'fraudprobability'=>'medium',
			'fraudremarks'=>'',
			'fraudreport'=>'',
			'fee'=>'0',
			'md5check'=>'35f4f76e1c9f60ad5a566aea4dc02c6b'
			);
		$response = new QuickPay\Form\Response($post);

		$this->assertTrue($response->isValid('test'));
	}

	public function testSubscribeInt()
	{
		$post = array(
			'msgtype'=>'subscribe',
			'ordernumber'=>'1370423315',
			'amount'=>'0',
			'currency'=>'DKK',
			'time'=>'2013-06-05T09:08:59+00:00',
			'state'=>'9',
			'qpstat'=>'000',
			'qpstatmsg'=>'OK',
			'chstat'=>'000',
			'chstatmsg'=>'OK',
			'merchant'=>'Merchant #1',
			'merchantemail'=>'merchant1@pil.dk',
			'transaction'=>'30202',
			'cardtype'=>'mastercard-dk',
			'cardnumber'=>'XXXXXXXXXXXX9999',
			'cardhash'=>'',
			'cardexpire'=>'1312',
			'splitpayment'=>'',
			'acquirer' => 'nets',
			'fraudprobability'=>'',
			'fraudremarks'=>'',
			'fraudreport'=>'',
			'fee'=>'0',
			'md5check'=>'451c540ee054acb7c50aaa692367e47e'
			);
		$response = new QuickPay\Form\Response($post);
		$this->assertTrue($response->isValid('test'));
	}
}