<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
