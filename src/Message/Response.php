<?php
namespace Omnipay\Payeezy\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Payeezy Response
 */
class Response extends AbstractResponse
{
    const TRANSACTION_STATUS_APPROVED = 'approved';
    const TRANSACTION_STATUS_DECLINED = 'declined';
    const TRANSACTION_STATUS_NOT_PROCESSED = 'not processed';

    const VALIDATION_STATUS_SUCCESS = 'success';
    const VALIDATION_STATUS_FAILURE = 'failure';

    /**
     * Response constructor.
     *
     * @param RequestInterface $request
     * @param string           $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $this->data = json_decode($data, true);
    }

    /**
     * Get an item from the internal data array
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function getDataItem($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getTransactionStatus() === self::TRANSACTION_STATUS_APPROVED;
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        return $this->getTransactionTag();
    }

    /**
     * Internal Log ID
     *
     * @return string|null
     */
    public function getCorrelationId()
    {
        return $this->getDataItem('correlation_id');
    }

    /**
     * Transaction Status
     *
     * Approved = Card Approved
     * Declined = Gateway declined
     * Not Processed = For any internal errors this status is returned.
     *
     * @return string|null
     */
    public function getTransactionStatus()
    {
        return $this->getDataItem('transaction_status');
    }

    /**
     * Validation Status
     *
     * Values - “success” / ”failure”.
     * Input validation errors encountered if status returned is failure.
     *
     * @return string|null
     */
    public function getValidationStatus()
    {
        return $this->getDataItem('validation_status');
    }

    /**
     * Transaction Type
     *
     * It is the transaction_type provided in request.
     *
     * @return string|null
     */
    public function getTransactionType()
    {
        return $this->getDataItem('transaction_type');
    }

    /**
     * Transaction ID
     *
     * Needed as part of the url to process secondary transactions like capture/void/refund/recurring/split-shipment.
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return $this->getDataItem('transaction_id');
    }

    /**
     * Transaction Tag
     *
     * Needed as part of the payload to process secondary transactions like capture/void/refund/recurring/split-shipment.
     *
     * @return string|null
     */
    public function getTransactionTag()
    {
        return $this->getDataItem('transaction_tag');
    }

    /**
     * Method
     *
     * Inputted transaction method.
     *
     * @return string|null
     */
    public function getMethod()
    {
        return $this->getDataItem('method');
    }

    /**
     * Amount
     *
     * Processed Amount in cents.
     *
     * @return string|null
     */
    public function getAmount()
    {
        return $this->getDataItem('amount');
    }

    /**
     * Currency
     *
     * ISO 4217 currency span Ex: USD.
     *
     * For the list of supported currencies:
     * https://developer.payeezy.com/faqs/what-currencies-does-payeezy-support
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->getDataItem('currency');
    }

    /**
     * CVV2
     *
     * Card Verification Value (CVV2) Response Codes.
     *
     * For the full list of response codes:
     * https://developer.payeezy.com/payeezy-api/apis/post/transactions-4
     *
     * @return string|null
     */
    public function getCvv2()
    {
        return $this->getDataItem('cvv2');
    }

    /**
     * Token
     *
     * Array that holds the tokenized card information.
     *
     * @return array|null
     */
    public function getToken()
    {
        return $this->getDataItem('token');
    }

    /**
     * Bank Response Code
     *
     * Payeezy will return a standardized response code from the card issuing bank for each of your transactions.
     *
     * For the list of bank response codes returned:
     * https://developer.payeezy.com/payeezy-api/apis/post/transactions-4
     *
     * @return string|null
     */
    public function getBankResponseCode()
    {
        return $this->getDataItem('bank_resp_code');
    }

    /**
     * Bank Message
     *
     * Payeezy will return a standardized bank response for each of your transactions. Its a description / translation
     * for the 3 digit bank response code.
     *
     * For the list of bank responses returned:
     * https://developer.payeezy.com/payeezy-api/apis/post/transactions-4
     *
     * @return string|null
     */
    public function getBankMessage()
    {
        return $this->getDataItem('bank_message');
    }

    /**
     * Gateway Response Code
     *
     * Payeezy gateway Response code indicates the status of a transaction as it is sent to the financial institution
     * and returned to the client.
     *
     * Ex: The Response Code "00" (Transaction Normal) indicates that the transaction was processed normally. Any
     * response other than "00" indicates that it was not normal.
     *
     * For the list of gateway response codes returned:
     * https://developer.payeezy.com/payeezy-api/apis/post/transactions-4
     *
     * @return string|null
     */
    public function getGatewayResponseCode()
    {
        return $this->getDataItem('gateway_resp_code');
    }

    /**
     * Gateway Message
     *
     * Payeezy gateway message is a description / translation for the gateway response code.
     *
     * For the list of gateway responses returned:
     * https://developer.payeezy.com/payeezy-api/apis/post/transactions-4
     *
     * @return string|null
     */
    public function getGatewayMessage()
    {
        return $this->getDataItem('gateway_message');
    }
}
