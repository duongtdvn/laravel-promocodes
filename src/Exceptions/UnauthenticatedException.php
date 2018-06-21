<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/21/18
 * Time: 7:14 AM
 */

namespace DuongTD\Promocodes\Exceptions;

use Exception;

class UnauthenticatedException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'User is not authenticated, and can not use promotion code.';
    /**
     * @var int
     */
    protected $code = 401;
}