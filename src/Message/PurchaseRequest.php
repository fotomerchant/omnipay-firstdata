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

        $this->validate('amount', 'currency');

        $data['method'] = 'token';
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();

        if ($token = $this->getToken()) {
            $this->validate('tokenCardType', 'tokenCardHolderName', 'tokenCardExpiryDate');

            $data['token'] = [
                'token_type' => 'FDToken',
                'token_data' => [
                    'type' => $this->getTokenCardType(),
                    'value' => $token,
                    'cardholder_name' => $this->getTokenCardHolderName(),
                    'exp_date' => $this->getTokenCardExpiryDate(),
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
    public function getTokenCardExpiryDate()
    {
        return $this->getParameter('tokenCardExpiryDate');
    }

    /**
     * @param string|null $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setTokenCardExpiryDate($value)
    {
        return $this->setParameter('tokenCardExpiryDate', $value);
    }
}
