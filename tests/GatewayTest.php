<?php

namespace Omnipay\Payeezy;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var  Gateway */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setApiKey('y6pWAJNyJyjGv66IsVuWnklkKUPFbb0a');
        $this->gateway->setApiSecret('86fbae7030253af3cd15faef2a1f4b67353e41fb6799f576b5093ae52901e6f7');
        $this->gateway->setMerchantToken('fdoa-a480ce8951daa73262734cf102641994c1e55e7cdf4c02b6');
    }

    public function testProperties()
    {
        $this->assertEquals('y6pWAJNyJyjGv66IsVuWnklkKUPFbb0a', $this->gateway->getApiKey());
        $this->assertEquals('86fbae7030253af3cd15faef2a1f4b67353e41fb6799f576b5093ae52901e6f7', $this->gateway->getApiSecret());
        $this->assertEquals('fdoa-a480ce8951daa73262734cf102641994c1e55e7cdf4c02b6', $this->gateway->getMerchantToken());
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase([
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => '1',
            'tokenCardHolderName' => '1',
            'tokenCardType' => '1',
            'tokenCardExpiry' => '1',
            'tokenCardCvv' => '1',
        ])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }

//    public function testRefundSuccess()
//    {
//        $this->setMockHttpResponse('PurchaseSuccess.txt');
//
//        $response = $this->gateway->authorize($this->options)->send();
//
//        $this->assertTrue($response->isSuccessful());
//        $this->assertFalse($response->isRedirect());
//        $this->assertEquals('ET181147::28513493', $response->getTransactionReference());
//    }
}
