<?php
namespace Omnipay\Payeezy\Message;

/**
 * Class PurchaseRequest
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
