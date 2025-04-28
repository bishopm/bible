<?php

namespace Bishopm\Bible\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verse extends Model
{
    public $table = 'verses';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}

