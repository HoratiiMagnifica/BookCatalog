<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Contracts\Support\Jsonable;

class LatestBookController extends Controller
{
    public function latest()
    {
        $latestBooks = Book::latest()->with('author')->paginate(5);

        return response()->json($latestBooks);
    }
}
