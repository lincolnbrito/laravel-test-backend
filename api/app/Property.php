<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $with = ['state:id,name','city:id,name'];

    protected $fillable = [
        'email', 'street', 'number', 'complement', 'neighborhood', 'state_id', 'city_id'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Property belongsTo State
     *
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::belongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Property belongsTo State
     *
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::belongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
