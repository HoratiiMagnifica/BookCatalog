<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Models\Section;

class SectionBookController extends Controller
{
    public function booksBySections(Section $section)
    {
        $books = $section->books;
        return response()->json($books);
    }


}
