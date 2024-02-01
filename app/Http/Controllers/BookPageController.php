<?php

namespace App\Http\Controllers;

use App\Models\Book;


class BookPageController extends Controller
{
    public function show($id)
    {
        $book = Book::findOrFail($id);

        return view('books.show', compact('book'));
    }
}
