<?php
/**
 * Payeezy Refund Request
 */

namespace Omnipay\Payeezy\Message;

/**
 * Payeezy Refund Request
 */
class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();

        $this->validate('amount', 'currency');

        $data['method'] = 'credit_card';
        $data['amount'] = $this->getAmount();
        $data['currency_code'] = $this->getCurrency();
        $data['transaction_tag'] = $this->getTransactionReference();

        return $data;
    }
}
