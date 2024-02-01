<?php

namespace App\Http\Controllers;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Section;


class BookUpdateController extends Controller
{
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {

        $book = Book::findOrFail($id);

        // Создание новой секции
        $book->update([
            'title' => $request->input('title'),
            'publication_year' => $request->input('publication_year'),
            'description' => $request->input('description'),
            'cover_image' => $request->input('cover_image'),
            'content' => $request->input('content'),
            'author_id' => $request->input('author_id'),
            'section_id' => $request->input('section_id'),
        ]);

        return response()->json($book);
    }
}
