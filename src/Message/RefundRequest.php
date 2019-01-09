<?php
/**
 * First Data Payeezy Refund Request
 */

namespace Omnipay\FirstData\Message;

/**
 * First Data Payeezy Refund Request
 */
class RefundRequest extends AbstractRequest
{
    protected $action = self::TRAN_TAGGEDREFUND;

    public function getData()
    {
        $data = parent::getData();

        $this->validate('transactionReference', 'amount');

        $data['amount']            = $this->getAmount();
        $transaction_reference     = $this->getTransactionReference();
        list($auth, $tag)          = explode('::', $transaction_reference);
        $data['authorization_num'] = $auth;
        $data['transaction_tag']   = $tag;

        return $data;
    }
}
