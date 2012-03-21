<?php

require_once 'config.php';
require_once 'QuickPay/PaymentAPI/Request/Authorize.php';
require_once 'QuickPay/PaymentAPI/Request/Capture.php';
require_once 'QuickPay/PaymentAPI/Request/Cancel.php';
require_once 'QuickPay/PaymentAPI/Request/Refund.php';
require_once 'QuickPay/PaymentAPI/Request/Subscribe.php';
require_once 'QuickPay/PaymentAPI/Request/Recurring.php';

class PaymentAPITest extends PHPUnit_Framework_TestCase
{
    protected function stdAuthorize() {
        $auth = new \QuickPay\PaymentAPI\Request\Authorize(QuickPayID,MD5Check,APIURL);
        $response = $auth->setAPIKey('G358rd247Eu6L979jY3U66Ng741n5FbPqkehIK8lmD4HfXtTwQ8233BcpaRW8y6x')
            ->setOrderNumber('A'.time())
            ->setAmount(234)
            ->setCurrency('DKK')
            ->setCardnumber(CREDITCARD)
            ->setExpirationDate(EXPIRE)
            ->setCVD(CVD)
            ->setCardtypeLock('dankort')
            ->setTestmode(true)
            ->send();

        $this->assertEquals(true, $response->isValid());
        $this->assertEquals(true,$response->isSuccess());
        return $response;
    }

    protected function stdSubscribe() {
        $auth = new \QuickPay\PaymentAPI\Request\Subscribe(QuickPayID,MD5Check,APIURL);
        $response = $auth->setAPIKey('G358rd247Eu6L979jY3U66Ng741n5FbPqkehIK8lmD4HfXtTwQ8233BcpaRW8y6x')
            ->setOrderNumber('S'.time())
            ->setCurrency('DKK')
            ->setCardnumber(4571999999999999)
            ->setExpirationDate(1212)
            ->setCVD(123)
            ->setCardtypeLock('dankort')
            ->setDescription('interFace API Client test')
            ->setTestmode(true)
            ->send();

        $this->assertEquals(true, $response->isValid());
        $this->assertEquals(true,$response->isSuccess());
        return $response;
    }

    protected function stdCapture() {
        $auth = $this->stdAuthorize();
        $capture = new \QuickPay\PaymentAPI\Request\Capture(QuickPayID,MD5Check,APIURL);
        $response = $capture->setAPIKey('G358rd247Eu6L979jY3U66Ng741n5FbPqkehIK8lmD4HfXtTwQ8233BcpaRW8y6x')
            ->setTransaction($auth->get('transaction'))
            ->setAmount(234)
            ->setCurrency('DKK')
            ->send();

        $this->assertEquals(true, $response->isValid());
        $this->assertEquals(true,$response->isSuccess());
        return $response;
    }

    public function testCapture() {
        $this->stdCapture();
    }

    public function testCancel() {
        $auth = $this->stdAuthorize();
        $cancel = new \QuickPay\PaymentAPI\Request\Cancel(QuickPayID,MD5Check,APIURL);
        $response = $cancel->setAPIKey('G358rd247Eu6L979jY3U66Ng741n5FbPqkehIK8lmD4HfXtTwQ8233BcpaRW8y6x')
            ->setTransaction($auth->get('transaction'))
            ->send();

        $this->assertEquals(true, $response->isValid());
        $this->assertEquals(true,$response->isSuccess());
    }

    public function testRefund() {
        $capture = $this->stdCapture();
        $refund = new \QuickPay\PaymentAPI\Request\Refund(QuickPayID,MD5Check,APIURL);
        $response = $refund->setAPIKey('G358rd247Eu6L979jY3U66Ng741n5FbPqkehIK8lmD4HfXtTwQ8233BcpaRW8y6x')
            ->setTransaction($capture->get('transaction'))
            ->setAmount(234)
            ->send();

        $this->assertEquals(true, $response->isValid());
        $this->assertEquals(true,$response->isSuccess());
    }

    public function testRecurring() {
        $subscribe = $this->stdSubscribe();
        $recurring =new \QuickPay\PaymentAPI\Request\Recurring(QuickPayID,MD5Check,APIURL);
        $response = $recurring->setAPIKey('G358rd247Eu6L979jY3U66Ng741n5FbPqkehIK8lmD4HfXtTwQ8233BcpaRW8y6x')
            ->setTransaction($subscribe->get('transaction'))
            ->setOrderNumber('R'.time())
            ->setAmount(234)
            ->setCurrency('DKK')
            ->setAutoCapture(true)
            ->send();

        $this->assertEquals(true, $response->isValid());
        $this->assertEquals(true,$response->isSuccess());
    }
}
