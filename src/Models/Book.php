<?php

namespace Bishopm\Bible\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public $table = 'books';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function verses(): HasMany
    {
        return $this->hasMany(Verse::class);
    }

}

