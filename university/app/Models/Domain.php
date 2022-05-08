<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'universities_id',
        'domain_name'
    ];

    public function universities() {
        return $this->belongsTo(Universities::class);
    }
}
