<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $primaryKey = 'tag_id';

    protected $fillable = [
        'page_id', 'label_info', 'position', 'shape_type'
    ];

    protected $casts = [
        'label_info' => 'array',
        'position' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'page_id');
    }
}
