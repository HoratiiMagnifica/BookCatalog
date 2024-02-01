<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorIdController extends Controller
{
    public function getId($id)
    {
        $author = Author::findOrFail($id);

        return response()->json($author);
    }
}
