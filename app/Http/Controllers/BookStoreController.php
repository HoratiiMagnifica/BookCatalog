<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;


class BookStoreController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Валидация данных
        $this->validate($request, [
            'title' => 'required|string|max:150',
            'publication_year' => 'required|integer',
            'description' => 'required|string',
            'cover_image' => 'required|string|max:500',
            'content' => 'string',
            'author_id' => 'required|integer',
            'section_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        // Создание новой секции
        $book = Book::create([
            'title' => $request->input('title'),
            'publication_year' => $request->input('publication_year'),
            'description' => $request->input('description'),
            'cover_image' => $request->input('cover_image'),
            'content' => $request->input('content'),
            'author_id' => $request->input('author_id'),
            'section_id' => $request->input('section_id'),
            'user_id' => $request->input('user_id'),
        ]);

        return response()->json(['message' => 'Книга успешно добавлена', 'book' => $book], 201);
    }
}
