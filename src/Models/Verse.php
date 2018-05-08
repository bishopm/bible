<?php

namespace Bishopm\Bible\Models;

use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    protected $guarded = array('id');

    public function version()
    {
        return $this->belongsTo('Bishopm\Bible\Models\Version');
    }

    public function book()
    {
        return $this->belongsTo('Bishopm\Bible\Models\Book');
    }
}
