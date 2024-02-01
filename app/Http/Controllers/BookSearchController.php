<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\Book;

class BookSearchController extends Controller
{
    public function getBooks()
    {
        $books = Book::all();

        return response()->json($books);
    }
    public function search($id)
    {
        $result = Book::find($id);

        return response()->json($result);
    }


}
