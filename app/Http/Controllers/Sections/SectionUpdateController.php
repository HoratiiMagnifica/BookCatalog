<?php

namespace App\Http\Controllers\Sections;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Section;


class SectionUpdateController extends Controller
{
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {

        $section = Section::findOrFail($id);

        // Создание новой секции
        $section->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json($section);
    }
}
