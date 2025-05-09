<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            ['name' => 'J.K. Rowling', 'biography' => 'British author best known for the Harry Potter series.'],
            ['name' => 'Stephen King', 'biography' => 'American author of horror, supernatural fiction, suspense, and fantasy novels.'],
            ['name' => 'George R.R. Martin', 'biography' => 'American novelist and short-story writer in the fantasy, horror, and science fiction genres.'],
            ['name' => 'Agatha Christie', 'biography' => 'English writer known for her detective novels.'],
            ['name' => 'J.R.R. Tolkien', 'biography' => 'English writer, poet, philologist, and academic, best known as the author of The Hobbit and The Lord of the Rings.'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}