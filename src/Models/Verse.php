<?php

namespace Bishopm\Bible\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

