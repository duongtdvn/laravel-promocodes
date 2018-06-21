<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/21/18
 * Time: 7:17 AM
 */

namespace DuongTD\Promocodes\Exceptions;

use Exception;

class AlreadyUsedException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Promotion code is already used by current user.';
    /**
     * @var int
     */
    protected $code = 403;
}