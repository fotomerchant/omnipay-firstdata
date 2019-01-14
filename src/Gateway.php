<?php
namespace Omnipay\Payeezy;

use Omnipay\Common\AbstractGateway;

/**
 * Payeezy Gateway
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
