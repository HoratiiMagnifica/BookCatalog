<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorBooksController extends Controller
{
    public function getBooks($authorId)
    {
        $author = Author::findOrFail($authorId);
        $books = $author->books;

        return response()->json($books);
    }
}
