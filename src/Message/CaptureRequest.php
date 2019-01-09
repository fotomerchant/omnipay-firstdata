<?php
/**
 * First Data Payeezy Capture Request
 */

namespace Omnipay\Payeezy\Message;

/**
 * First Data Payeezy Capture Request
 */
class CaptureRequest extends RefundRequest
{
    protected $action = self::TRAN_TAGGEDPREAUTHCOMPLETE;
}
