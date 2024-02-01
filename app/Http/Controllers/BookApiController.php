<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookApiController extends Controller
{
    public function index($id)
    {
        $book = Book::with('author', 'section', 'user')->findOrFail($id);

        return response()->json($book);
    }
}
