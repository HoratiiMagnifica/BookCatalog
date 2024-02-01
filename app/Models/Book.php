<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'publication_year', 'description', 'cover_image', 'content', 'visible', 'author_id', 'section_id', 'user_id']; // Другие поля по необходимости

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Другие отношения и методы по необходимости
}
