<?php
namespace Omnipay\Payeezy\Message;

/**
 * Class RefundRequest
 */
class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();

        $this->validate('amount', 'currency', 'merchantReference');

        $data['transaction_type'] = 'refund';
        $data['merchant_ref'] = $this->getMerchantReference();
        $data['method'] = 'token';
        $data['currency_code'] = $this->getCurrency();
        $data['amount'] = str_replace('.', '', $this->getAmount()); // needs to be in cents

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
