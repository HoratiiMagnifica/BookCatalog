<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorVisibilityController extends Controller
{
    /**
     * Обновление статуса видимости секции.
     *
     * @param Request $request
     * @param int $authorId
     * @return JsonResponse
     */
    public function toggleVisibility(Request $request, $id): JsonResponse
    {
        $author = Author::findOrFail($id);
        $author->update(['visible' => $request->visible]);

        return response()->json($author);
    }
}
