<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author_id',
        'publisher_id',
        'category_id',
        'publication_year',
        'description',
        'quantity',
        'available',
        'cover_image'
    ];

    protected $casts = [
        'publication_year' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }
}