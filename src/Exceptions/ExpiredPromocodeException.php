<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/21/18
 * Time: 5:01 PM
 */

namespace DuongTD\Promocodes\Exceptions;

use Exception;

class ExpiredPromocodeException extends Exception
{
    protected $message = 'Promocode has been expired!';
}
