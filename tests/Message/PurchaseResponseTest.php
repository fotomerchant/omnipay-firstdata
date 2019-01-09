<?php

namespace Omnipay\Payeezy\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    public function testPurchaseSuccess()
    {
        $response = new Response($this->getMockRequest(), json_encode(array(
            'correlation_id' => '124.4702123284223',
            'transaction_status' => 'approved',
            'validation_status' => 'success',
            'transaction_type' => 'purchase',
            'transaction_id' => 'ET178645',
            'transaction_tag' => '2316606482',
            'method' => 'token',
            'amount' => '200',
            'currency' => 'USD',
            'cvv2' => 'I',
            'token' => [
                'token_type' => 'FDToken',
                'token_data' => [
                    'type' => 'visa',
                    'cardholder_name' => 'JohnSmith',
                    'exp_date' => '1030',
                    'value' => '2537446225198291'
                ]
            ],
            'bank_resp_code' => '100',
            'bank_message' => 'Approved',
            'gateway_resp_code' => '00',
            'gateway_message' => 'Transaction Normal'
        )));

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('124.4702123284223', $response->getCorrelationId());
        $this->assertEquals('approved', $response->getTransactionStatus());
        $this->assertEquals('success', $response->getValidationStatus());
        $this->assertEquals('purchase', $response->getTransactionType());
        $this->assertEquals('ET178645', $response->getTransactionId());
        $this->assertEquals('2316606482', $response->getTransactionTag());
        $this->assertEquals('token', $response->getMethod());
        $this->assertEquals('200', $response->getAmount());
        $this->assertEquals('USD', $response->getCurrency());
        $this->assertEquals('I', $response->getCvv2());
        $this->assertEquals('100', $response->getBankResponseCode());
        $this->assertEquals('Approved', $response->getBankMessage());
        $this->assertEquals('00', $response->getGatewayResponseCode());
        $this->assertEquals('Transaction Normal', $response->getGatewayMessage());

        $token = $response->getToken();

        $this->assertEquals('FDToken', $token['token_type']);

        $tokenData = $token['token_data'];

        $this->assertEquals('visa', $tokenData['type']);
        $this->assertEquals('JohnSmith', $tokenData['cardholder_name']);
        $this->assertEquals('1030', $tokenData['exp_date']);
        $this->assertEquals('2537446225198291', $tokenData['value']);
    }

//    public function testPurchaseError()
//    {
//        $response = new Response($this->getMockRequest(), json_encode(array(
//            'amount' => 1000,
//            'exact_resp_code' => 22,
//            'exact_message' => 'Invalid Credit Card Number',
//            'reference_no' => 'abc123',
//            'authorization_num' => 'auth1234',
//            'transaction_approved' => 0,
//        )));
//
//        $this->assertFalse($response->isSuccessful());
//        $this->assertEquals('auth1234::', $response->getTransactionReference());
//        $this->assertSame('Invalid Credit Card Number', $response->getMessage());
//        $this->assertEquals('22', $response->getCode());
//    }
//
//    public function testBankError()
//    {
//        $response = new Response($this->getMockRequest(), json_encode(array(
//            'amount' => 1000,
//            'exact_resp_code' => 00,
//            'reference_no' => 'abc123',
//            'authorization_num' => '',
//            'transaction_approved' => 0,
//        )));
//
//        $this->assertFalse($response->isSuccessful());
//        $this->assertEquals('::', $response->getTransactionReference());
//        $this->assertEquals('00', $response->getCode());
//    }
}
