<?php
/**
 * Payeezy Purchase Request
 */
namespace Omnipay\Payeezy\Message;

/**
 * Payeezy Purchase Request
 *
 * ### Example
 *
 * <code>
 * // Create a gateway for the Payeezy Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Payeezy');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'gatewayId' => '12341234',
 *     'password'  => 'thisISmyPASSWORD',
 *     'testMode'  => true, // Or false when you are ready for live transactions
 * ));
 *
 * // Create a credit card object
 * $card = new CreditCard(array(
 *     'firstName'            => 'Example',
 *     'lastName'             => 'Customer',
 *     'number'               => '4222222222222222',
 *     'expiryMonth'          => '01',
 *     'expiryYear'           => '2020',
 *     'cvv'                  => '123',
 *     'email'                => 'customer@example.com',
 *     'billingAddress1'      => '1 Scrubby Creek Road',
 *     'billingCountry'       => 'AU',
 *     'billingCity'          => 'Scrubby Creek',
 *     'billingPostcode'      => '4999',
 *     'billingState'         => 'QLD',
 * ));
 *
 * // Do a purchase transaction on the gateway
 * $transaction = $gateway->purchase(array(
 *     'description'              => 'Your order for widgets',
 *     'amount'                   => '10.00',
 *     'transactionId'            => 12345,
 *     'clientIp'                 => $_SERVER['REMOTE_ADDR'],
 *     'card'                     => $card,
 * ));
 *
 * // USE A TRANS-ARMOR TOKEN TO PROCESS A PURCHASE:
 *
 * // Create a credit card object
 * $card = new CreditCard(array(
 *     'firstName'            => 'Example',
 *     'lastName'             => 'Customer',
 *     'expiryMonth'          => '01',
 *     'expiryYear'           => '2020',
 * ));
 *
 * // Do a purchase transaction on the gateway
 * $transaction = $gateway->purchase(array(
 *     'description'              => 'Your order for widgets',
 *     'amount'                   => '10.00',
 *     'cardReference'            => $yourStoredToken,
 *     'clientIp'                 => $_SERVER['REMOTE_ADDR'],
 *     'card'                     => $card,
 *     'tokenCardType'              => 'visa', // MUST BE VALID CONST FROM \omnipay\common\CreditCard
 * ));
 *
 * $response = $transaction->send();
 *
 * if ($response->isSuccessful()) {
 *     echo "Purchase transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();

        $this->validate('amount', 'currency', 'merchantReference');

        $data['transaction_type'] = 'purchase';
        $data['merchant_ref'] = $this->getMerchantReference();
        $data['method'] = 'token';
        $data['currency_code'] = $this->getCurrency();
        $data['amount'] = str_replace('.', '', $this->getAmount()); // needs to be in cents

        /*
         * Bank Response Codes:
         *
         * Reference: https://support.payeezy.com/hc/en-us/articles/203730509-First-Data-Global-Gateway-e4-Bank-Response-Codes
         * Format: 5XXX00
         * Sample Amount: 530200 // Insufficient funds
         *
         * Gateway Response Codes:
         *
         * Reference: https://support.payeezy.com/hc/en-us/articles/203730499-eCommerce-Response-Codes-ETG-e4-Transaction-Gateway-Codes-
         * Format: 5000XX
         * Sample Amount: 500008 // CVV2/CID/CVC2 Data not verified
         *
         * CVV Response Codes:
         *
         * Reference: https://support.payeezy.com/hc/en-us/articles/204504185-How-to-test-CVD-CVV-CVV2-functionality
         */

        // $data['amount'] = "500008"; // Gateway Response: CVV2/CID/CVC2 Data not verified
        // $data['amount'] = "530200"; // Bank Response: Insufficient funds

        if ($token = $this->getToken()) {
            $this->validate('tokenCardType', 'tokenCardHolderName', 'tokenCardExpiry', 'tokenCardCvv');

            $data['token'] = [
                'token_type' => 'FDToken',
                'token_data' => [
                    'type' => $this->getTokenCardType(),
                    'value' => $token,
                    'cardholder_name' => $this->getTokenCardHolderName(),
                    'exp_date' => $this->getTokenCardExpiry(),
                    'cvv' => $this->getTokenCardCvv(),
                ],
            ];
        }

        return $data;
    }

    /**
     * @return string|null
     */
    public function getTokenCardType()
    {
        return $this->getParameter('tokenCardType');
    }

    /**
     * @param string|null $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setTokenCardType($value)
    {
        return $this->setParameter('tokenCardType', $value);
    }

    /**
     * @return string|null
     */
    public function getTokenCardHolderName()
    {
        return $this->getParameter('tokenCardHolderName');
    }

    /**
     * @param string|null $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setTokenCardHolderName($value)
    {
        return $this->setParameter('tokenCardHolderName', $value);
    }

    /**
     * @return string|null
     */
    public function getTokenCardExpiry()
    {
        return $this->getParameter('tokenCardExpiry');
    }

    /**
     * @param string|null $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setTokenCardExpiry($value)
    {
        return $this->setParameter('tokenCardExpiry', $value);
    }

    /**
     * @return string|null
     */
    public function getTokenCardCvv()
    {
        return $this->getParameter('tokenCardCvv');
    }

    /**
     * @param string|null $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setTokenCardCvv($value)
    {
        return $this->setParameter('tokenCardCvv', $value);
    }

    /**
     * Get Merchant Reference
     *
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->getParameter('merchantReference');
    }

    /**
     * Set Merchant Reference
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setMerchantReference($value)
    {
        return $this->setParameter('merchantReference', $value);
    }
}
