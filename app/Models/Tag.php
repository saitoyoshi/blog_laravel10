<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name'];
    use HasFactory;
    public function posts(): BelongsToMany {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
