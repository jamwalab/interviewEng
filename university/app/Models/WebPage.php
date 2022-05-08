<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'universities_id',
        'url'
    ];

    public function universities() {
        return $this->belongsTo(Universities::class);
    }
}
