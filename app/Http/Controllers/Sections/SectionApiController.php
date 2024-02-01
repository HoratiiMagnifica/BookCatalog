<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Models\Section;

class SectionApiController extends Controller
{
    public function index()
    {
        $sections = Section::with('books.author')->get();

        return response()->json($sections);
    }


}
