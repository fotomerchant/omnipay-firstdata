<?php
/**
 * First Data Payeezy Void Request
 */

namespace Omnipay\Payeezy\Message;

/**
 * First Data Payeezy Void Request
 */
class VoidRequest extends RefundRequest
{
    protected $action = self::TRAN_TAGGEDVOID;
}
