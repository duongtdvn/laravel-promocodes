<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/21/18
 * Time: 7:11 AM
 */

namespace DuongTD\Promocodes\Exceptions;

use Exception;

class InvalidPromocodeException extends Exception
{
    protected $message = 'Invalid promotion code was passed.';

    protected $code = 404;
}