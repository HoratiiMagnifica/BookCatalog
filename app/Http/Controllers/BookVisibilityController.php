<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookVisibilityController extends Controller
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
        $book = Book::findOrFail($id);
        $book->update(['visible' => $request->visible]);

        return response()->json($book);
    }
}
