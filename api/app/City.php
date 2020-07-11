<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * City belongsTo State
     *
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::belongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
