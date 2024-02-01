<?php

namespace App\Http\Controllers;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Section;


class BookDestroyController extends Controller
{
    /**
     * Удаление секции (Soft Delete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $authorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, int $bookId)
    {
        $book = Book::withTrashed()->find($bookId);

        if ($book) {
            // Проверяем, была ли секция уже удалена
            if ($book->trashed()) {
                return response()->json(['message' => 'Книга уже удалена'], 200);
            }

            // Удаляем секцию (Soft Delete)
            $book->delete();

            return response()->json(['message' => 'Книга успешно удалена'], 200);
        } else {
            return response()->json(['message' => 'Книга не найдена'], 404);
        }
    }
}
