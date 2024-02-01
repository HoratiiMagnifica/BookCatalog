<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Section;


class AuthorUpdateController extends Controller
{
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {

        $author = Author::findOrFail($id);

        // Создание новой секции
        $author->update([
            'full_name' => $request->input('full_name'),
            'birth_country' => $request->input('birth_country'),
            'comment' => $request->input('comment'),
            'pictureUrl' => $request->input('pictureUrl'),
        ]);

        return response()->json($author);
    }
}
