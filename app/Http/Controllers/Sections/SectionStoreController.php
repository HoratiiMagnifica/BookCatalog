<?php

namespace App\Http\Controllers\Sections;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Section;


class SectionStoreController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Валидация данных
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        // Создание новой секции
        $section = Section::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json(['message' => 'Секция успешно добавлена', 'section' => $section], 201);
    }
}
