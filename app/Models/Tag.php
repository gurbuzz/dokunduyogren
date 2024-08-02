<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $primaryKey = 'tag_id';

    protected $fillable = [
        'page_id',
        'label',
        'position_x',
        'position_y',
        'width',
        'height',
        'translated_label',
        'translated_language',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'page_id');
    }
}

