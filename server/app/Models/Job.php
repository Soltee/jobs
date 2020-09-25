<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'description', 'salary', 'apply_before', 'tags', 'created_at', 'updated',
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
