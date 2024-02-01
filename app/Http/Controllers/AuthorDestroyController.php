<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Section;


class AuthorDestroyController extends Controller
{
    /**
     * Удаление секции (Soft Delete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $authorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, int $authorId)
    {
        $author = Author::withTrashed()->find($authorId);

        if ($author) {
            // Проверяем, была ли секция уже удалена
            if ($author->trashed()) {
                return response()->json(['message' => 'Автор уже удалён'], 200);
            }

            // Удаляем секцию (Soft Delete)
            $author->delete();

            return response()->json(['message' => 'Автор успешно удалён'], 200);
        } else {
            return response()->json(['message' => 'Автор не найден'], 404);
        }
    }
}
