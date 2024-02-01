<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class AuthorStoreController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Валидация данных
        $this->validate($request, [
            'full_name' => 'required|string|max:150',
            'birth_country' => 'required|string|max:100',
            'comment' => 'required|string|max:500',
            'pictureUrl' => 'required|string|max:500',
        ]);

        // Создание новой секции
        $author = Author::create([
            'title' => $request->input('title'),
            'full_name' => $request->input('full_name'),
            'birth_country' => $request->input('birth_country'),
            'comment' => $request->input('comment'),
            'pictureUrl' => $request->input('pictureUrl'),
        ]);

        return response()->json(['message' => 'Автор успешно добавлен', 'author' => $author], 201);
    }
}
