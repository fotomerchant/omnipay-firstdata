<?php
/**
 * Payeezy Authorize Request
 */

namespace Omnipay\Payeezy\Message;

/**
 * Payeezy Authorize Request
 */
class AuthorizeRequest extends PurchaseRequest
{
    protected $action = self::TRAN_PREAUTH;
}
