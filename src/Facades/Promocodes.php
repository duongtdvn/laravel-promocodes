<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/20/18
 * Time: 5:36 PM
 */

namespace DuongTD\Promocodes\Facades;

use Illuminate\Support\Facades\Facade;

class Promocodes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'promocodes';
    }
}