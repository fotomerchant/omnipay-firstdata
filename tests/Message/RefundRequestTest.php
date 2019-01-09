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
            'transactionReference' => '2316606482',
        ]);

        $data = $request->getData();
        $this->assertEquals('credit_card', $data['method']);
        $this->assertEquals('12.00', $data['amount']);
        $this->assertEquals('USD', $data['currency_code']);
        $this->assertEquals('2316606482', $data['transaction_tag']);
    }
}
