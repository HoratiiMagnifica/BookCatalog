<?php

namespace App\Http\Controllers\Sections;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Section;


class SectionDestroyController extends Controller
{
    /**
     * Удаление секции (Soft Delete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $sectionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, int $sectionId)
    {
        $section = Section::withTrashed()->find($sectionId);

        if ($section) {
            // Проверяем, была ли секция уже удалена
            if ($section->trashed()) {
                return response()->json(['message' => 'Секция уже удалена'], 200);
            }

            // Удаляем секцию (Soft Delete)
            $section->delete();

            return response()->json(['message' => 'Секция успешно удалена'], 200);
        } else {
            return response()->json(['message' => 'Секция не найдена'], 404);
        }
    }
}
