<?php
/**
 * Payeezy Capture Request
 */

namespace Omnipay\Payeezy\Message;

/**
 * Payeezy Capture Request
 */
class CaptureRequest extends RefundRequest
{
    protected $action = self::TRAN_TAGGEDPREAUTHCOMPLETE;
}
