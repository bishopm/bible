<?php

namespace Bishopm\Bible\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $guarded = array('id');

    public function verses()
    {
        return $this->hasMany('Bishopm\Bible\Models\Verse');
    }
}
