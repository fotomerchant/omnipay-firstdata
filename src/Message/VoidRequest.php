<?php
/**
 * First Data Payeezy Void Request
 */

namespace Omnipay\FirstData\Message;

/**
 * First Data Payeezy Void Request
 */
class VoidRequest extends RefundRequest
{
    protected $action = self::TRAN_TAGGEDVOID;
}
