<?php
/**
 * First Data Payeezy Authorize Request
 */

namespace Omnipay\Payeezy\Message;

/**
 * First Data Payeezy Authorize Request
 */
class AuthorizeRequest extends PurchaseRequest
{
    protected $action = self::TRAN_PREAUTH;
}
