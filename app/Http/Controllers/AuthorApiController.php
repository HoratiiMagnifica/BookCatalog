<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorApiController extends Controller
{
    public function Index()
    {
        $authors = Author::all();
        return response()->json($authors);
    }
}
