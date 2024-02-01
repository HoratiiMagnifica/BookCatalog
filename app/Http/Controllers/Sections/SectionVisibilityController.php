<?php
namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SectionVisibilityController extends Controller
{
    /**
     * Обновление статуса видимости секции.
     *
     * @param Request $request
     * @param int $sectionId
     * @return JsonResponse
     */
    public function toggleVisibility(Request $request, $id): JsonResponse
    {
        $section = Section::findOrFail($id);
        $section->update(['visible' => $request->visible]);

        return response()->json($section);
    }
}
