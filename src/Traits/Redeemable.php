<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/20/18
 * Time: 5:48 PM
 */

namespace DuongTD\Promocodes\Traits;

use DuongTD\Promocodes\Exceptions\AlreadyUsedException;
use DuongTD\Promocodes\Exceptions\ExpiredPromocodeException;
use DuongTD\Promocodes\Exceptions\InvalidPromocodeException;
use DuongTD\Promocodes\Models\Promocode;
use DuongTD\Promocodes\Promocodes;

trait Redeemable
{
    /**
     * Get the promocodes that are related to user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promocodes()
    {
        return $this->belongsToMany(Promocode::class, config('promocodes.relation_table'))->withPivot('used_at');
    }

    /**
     * @param string $code
     * @param callable|null $callback
     * @return bool|Promocode
     * @throws AlreadyUsedException
     * @throws InvalidPromocodeException
     * @throws ExpiredPromocodeException
     */
    public function applyCode(string $code, callable $callback = null)
    {
        $promocode = (new Promocodes())->apply($code);

        if (is_null($callback)) {
            return $promocode;
        }

        call_user_func($callback, $promocode);

        return $callback($promocode);
    }

    /**
     * @param $code
     * @param null $callback
     * @return bool|Promocode
     * @throws AlreadyUsedException
     * @throws InvalidPromocodeException
     * @throws ExpiredPromocodeException
     */
    public function redeemCode($code, $callback = null)
    {
        return $this->applyCode($code, $callback);
    }
}
