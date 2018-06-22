<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/20/18
 * Time: 5:40 PM
 */

namespace DuongTD\Promocodes\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'reward', 'data', 'is_disposable', 'expired_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'reward' => 'float',
        'data' => 'json',
        'is_disposable' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'expired_at'];

    /**
     * Promocode constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('promocodes.table', 'promocodes');
    }

    /**
     * Get the users who is related promocode.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('promocodes.user_model'), config('promocodes.relation_table'))->withPivot('used_at');
    }

    /**
     * Query builder to find promocode using code.
     *
     * @param $query
     * @param $code
     *
     * @return mixed
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    /**
     * Query builder to get disposable codes.
     *
     * @param $query
     * @return mixed
     */
    public function scopeIsDisposable($query)
    {
        return $query->where('is_disposable', true);
    }

    /**
     * Query builder to get non-disposable codes.
     *
     * @param $query
     * @return mixed
     */
    public function scopeIsNotDisposable($query)
    {
        return $query->where('is_disposable', false);
    }

    /**
     * Query builder to get expired promotion codes.
     *
     * @param $query
     * @return mixed
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expired_at')->whereDate('expired_at', '<=', Carbon::now());
    }

    /**
     * Check if code is disposable (ont-time).
     *
     * @return bool
     */
    public function isDisposable()
    {
        return $this->is_disposable;
    }

    /**
     * Check if code is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expired_at ? Carbon::now()->gte($this->expired_at) : false;
    }
}
