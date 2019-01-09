<?php
/**
 * Payeezy Gateway
 */
namespace Omnipay\Payeezy;

use Omnipay\Common\AbstractGateway;

/**
 * Payeezy Gateway
 *
 * API details for the Payeezy gateway are at the links below.
 *
 * ### Example
 *
 * <code>
 *
 * // Create a gateway for the Payeezy Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Payeezy');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'apiKey'        => 'y6pWAJNyJyjGv66IsVuWnklkKUPFbb0a',
 *     'apiSecret'     => '86fbae7030253af3cd15faef2a1f4b67353e41fb6799f576b5093ae52901e6f7',
 *     'merchantToken' => 'fdoa-a480ce8951daa73262734cf102641994c1e55e7cdf4c02b6',
 *     'testMode'      => true, // Or false when you are ready for live transactions
 * ));
 *
 * // Do a purchase transaction on the gateway
 * $transaction = $gateway->purchase(array(
 *     'amount'          => '200',
 *     'currency'        => 'USD',
 *     'type'            => 'visa',
 *     'value'           => '2537446225198291', // The tokenized credit card number
 *     'cardholder_name' => 'JohnSmith',
 *     'exp_date'        => '1030',
 * ));
 *
 * // Send the request to Payeezy
 * $response = $transaction->send();
 *
 * // Verify that the response was successful
 * if ($response->isSuccessful()) {
 *     echo "Purchase transaction was successful!\n";
 *     $transactionId = $response->getTransactionId();
 *     echo "Transaction reference = " . $transactionId . "\n";
 * }
 * </code>
 *
 * ### Test Accounts
 *
 * Test accounts can be obtained here:
 * https://developer.payeezy.com/user/register
 *
 * Test credit card numbers can be found here:
 * https://support.payeezy.com/hc/en-us/articles/204504235-Using-test-credit-card-numbers
 *
 * @link https://support.payeezy.com/hc/en-us
 * @link https://provisioning.demo.globalgatewaye4.firstdata.com/signup
 * @link https://support.payeezy.com/hc/en-us/articles/204504235-Using-test-credit-card-numbers
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Payeezy';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
            'apiSecret'  => '',
            'merchantToken'  => '',
            'testMode'  => false,
        );
    }

    /**
     * Get API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set API Key
     *
     * @param string $value
     *
     * @return Gateway
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * Get API Secret
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->getParameter('apiSecret');
    }

    /**
     * Set API Secret
     *
     * @param string $value
     *
     * @return Gateway
     */
    public function setApiSecret($value)
    {
        return $this->setParameter('apiSecret', $value);
    }

    /**
     * Get Merchant Token
     *
     * @return string
     */
    public function getMerchantToken()
    {
        return $this->getParameter('merchantToken');
    }

    /**
     * Set Merchant Token
     *
     * @param string $value
     *
     * @return Gateway
     */
    public function setMerchantToken($value)
    {
        return $this->setParameter('merchantToken', $value);
    }

    /**
     * Create a purchase request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeezy\Message\PurchaseRequest', $parameters);
    }

    /**
     * Create a refund request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeezy\Message\RefundRequest', $parameters);
    }
}
