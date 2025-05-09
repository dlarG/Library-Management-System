<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'isbn' => '9780747532743',
                'author_id' => 1,
                'publisher_id' => 1,
                'category_id' => 4,
                'publication_year' => 1997,
                'description' => 'The first novel in the Harry Potter series.',
                'quantity' => 5,
            ],
            // Add more books...
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}