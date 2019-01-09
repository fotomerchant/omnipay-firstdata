<?php
/**
 * Payeezy Void Request
 */

namespace Omnipay\Payeezy\Message;

/**
 * Payeezy Void Request
 */
class VoidRequest extends RefundRequest
{
    protected $action = self::TRAN_TAGGEDVOID;
}
