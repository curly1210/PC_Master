<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewImage extends Model
{
    //
    use HasFactory;


    protected $fillable = [
        'url',
        'review_id',
    ];


    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
