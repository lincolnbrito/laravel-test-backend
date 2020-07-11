<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * State hasMany City
     *
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::hasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
