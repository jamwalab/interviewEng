<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universities extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'state-province',
        'alpha_two_code'
    ];

    public function domains() {
        return $this->hasMany(Domains::class);
    }

    public function webPage() {
        return $this->hasMany(WebPage::class);
    }
}
