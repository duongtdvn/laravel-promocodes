<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/20/18
 * Time: 5:48 PM
 */

namespace DuongTD\Promocodes\Traits;

use Carbon\Carbon;
use DuongTD\Promocodes\Exceptions\AlreadyUsedException;
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
     * Apply promocode to user and get callback.
     *
     * @param string $code
     * @param null|\Closure $callback
     *
     * @return null|\DuongTD\Promocodes\Models\Promocode
     * @throws AlreadyUsedException
     * @throws InvalidPromocodeException
     */
    public function applyCode($code, $callback = null)
    {
        try {
            if ($promocode = (new Promocodes)->check($code)) {
                if ($promocode->users()->wherePivot($this->getForeignKey(), $this->id)->exists()) {
                    throw new AlreadyUsedException();
                }

                $promocode->users()->attach($this->id, [
                    'used_at' => Carbon::now(),
                ]);

                $promocode->load('users');

                if (is_callable($callback)) {
                    $callback($promocode);
                }

                return $promocode;
            }
        } catch (InvalidPromocodeException $exception) {
            //
        }
        if (is_callable($callback)) {
            $callback(null);
        }
        return null;
    }

    /**
     * Redeem promocode to user and get callback.
     *
     * @param string $code
     * @param null|\Closure $callback
     *
     * @return null|\DuongTD\Promocodes\Models\Promocode
     * @throws AlreadyUsedException
     * @throws InvalidPromocodeException
     */
    public function redeemCode($code, $callback = null)
    {
        return $this->applyCode($code, $callback);
    }
}
