<?php

namespace Omnipay\Payeezy\Message;

use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    public function testRefundSuccess()
    {
        $request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(
            array(
                'amount' => '12.00',
                'transactionReference' => '9999::DATADATADATA',
            )
        );

        $data = $request->getData();
        $this->assertEquals('9999', $data['authorization_num']);
        $this->assertEquals('DATADATADATA', $data['transaction_tag']);
        $this->assertEquals('12.00', $data['amount']);
    }
}
