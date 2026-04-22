<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'published_at',
        'is_published',
        'author_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public static function generateUniqueSlug($title){
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()){
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;

    }
}
