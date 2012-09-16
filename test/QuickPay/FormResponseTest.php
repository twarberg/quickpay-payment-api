<?php

require_once 'config.php';
require_once 'QuickPay/Form/Response.php';

class FormResponseTest extends PHPUnit_Framework_TestCase
{
	public function testAuthorizeDankort()
	{
		$post = array(
			'msgtype'=>'authorize',
			'ordernumber'=>'1347799460',
			'amount'=>'123',
			'currency'=>'DKK',
			'time'=>'2012-09-16T12:44:38+00:00',
			'state'=>'1',
			'qpstat'=>'000',
			'qpstatmsg'=>'OK',
			'chstat'=>'000',
			'chstatmsg'=>'OK',
			'merchant'=>'Merchant #1',
			'merchantemail'=>'merchant1@pil.dk',
			'transaction'=>'298',
			'cardtype'=>'dankort',
			'cardnumber'=>'XXXXXXXXXXXX9999',
			'cardhash'=>'',
			'splitpayment'=>'1',
			'fraudprobability'=>'medium',
			'fraudremarks'=>'',
			'fraudreport'=>'',
			'fee'=>'0',
			'md5check'=>'fcb029a27dcdf23b7c028be6526fe3ae'
			);

		$response = new QuickPay\Form\Response($post);

		$this->assertTrue($response->isValid('test'));
	}

	public function testAuthorizeInt()
	{
		$post = array(
			'msgtype'=>'authorize',
			'ordernumber'=>'1347799647',
			'amount'=>'123',
			'currency'=>'DKK',
			'time'=>'2012-09-16T12:47:45+00:00',
			'state'=>'1',
			'qpstat'=>'000',
			'qpstatmsg'=>'OK',
			'chstat'=>'000',
			'chstatmsg'=>'OK',
			'merchant'=>'Merchant #1',
			'merchantemail'=>'merchant1@pil.dk',
			'transaction'=>'299',
			'cardtype'=>'mastercard-dk',
			'cardnumber'=>'XXXXXXXXXXXX9999',
			'cardhash'=>'',
			'splitpayment'=>'',
			'fraudprobability'=>'',
			'fraudremarks'=>'',
			'fraudreport'=>'',
			'fee'=>'0',
			'md5check'=>'4610075a07129a19235d133e0240ebff'
			);

		$response = new QuickPay\Form\Response($post);

		$this->assertTrue($response->isValid('test'));
	}

	public function testSubscribeDankort()
	{
		$post = array(
			'msgtype'=>'subscribe',
			'ordernumber'=>'1347798509',
			'amount'=>'0',
			'currency'=>'DKK',
			'time'=>'2012-09-16T12:28:57+00:00',
			'state'=>'9',
			'qpstat'=>'000',
			'qpstatmsg'=>'OK',
			'chstat'=>'000',
			'chstatmsg'=>'OK',
			'merchant'=>'Merchant #1',
			'merchantemail'=>'merchant1@pil.dk',
			'transaction'=>'297',
			'cardtype'=>'mastercard-dk',
			'cardnumber'=>'XXXXXXXXXXXX9999',
			'cardhash'=>'',
			'cardexpire'=>'1212',
			'splitpayment'=>'',
			'fraudprobability'=>'',
			'fraudremarks'=>'',
			'fraudreport'=>'',
			'fee'=>'0',
			'md5check'=>'eaa6d568d825a873c3606a8a9a169cfd'
			);
		$response = new QuickPay\Form\Response($post);

		$this->assertTrue($response->isValid('test'));
	}

	public function testSubscribeInt()
	{
		$post = array(
			'msgtype'=>'subscribe',
			'ordernumber'=>'1347799730',
			'amount'=>'0',
			'currency'=>'DKK',
			'time'=>'2012-09-16T12:49:14+00:00',
			'state'=>'9',
			'qpstat'=>'000',
			'qpstatmsg'=>'OK',
			'chstat'=>'000',
			'chstatmsg'=>'OK',
			'merchant'=>'Merchant #1',
			'merchantemail'=>'merchant1@pil.dk',
			'transaction'=>'300',
			'cardtype'=>'mastercard-dk',
			'cardnumber'=>'XXXXXXXXXXXX9999',
			'cardhash'=>'',
			'cardexpire'=>'1212',
			'splitpayment'=>'',
			'fraudprobability'=>'',
			'fraudremarks'=>'',
			'fraudreport'=>'',
			'fee'=>'0',
			'md5check'=>'34b7a832cce713978e6382009b57413d'
			);
		$response = new QuickPay\Form\Response($post);
		$this->assertTrue($response->isValid('test'));
	}
}