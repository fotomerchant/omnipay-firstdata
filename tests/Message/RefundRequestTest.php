<?php
namespace Omnipay\Payeezy\Message;

use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    public function testRefundSuccess()
    {
        $request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());

        $request->initialize([
            'amount' => '12.00',
            'currency' => 'USD',
            'token' => '1234567890',
            'tokenCardType' => 'visa',
            'tokenCardHolderName' => 'John Smith',
            'tokenCardExpiry' => '0125',
            'merchantReference' => '019-111-123456',
        ]);

        $data = $request->getData();
        $this->assertEquals('token', $data['method']);
        $this->assertEquals('1200', $data['amount']);
        $this->assertEquals('USD', $data['currency_code']);
        $this->assertEquals('019-111-123456', $data['merchant_ref']);

        $token = $data['token'];
        $this->assertEquals('FDToken', $token['token_type']);

        $tokenData = $token['token_data'];
        $this->assertEquals('1234567890', $tokenData['value']);
        $this->assertEquals('visa', $tokenData['type']);
        $this->assertEquals('John Smith', $tokenData['cardholder_name']);
        $this->assertEquals('0125', $tokenData['exp_date']);
    }
}
