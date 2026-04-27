<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Archive extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'archives';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'category',
    ];


}
