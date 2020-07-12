<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id','hirer_type','hirer_document','hirer_email','hirer_name','property_id'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Contract belongsTo Property
     *
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::belongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
