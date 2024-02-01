<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Models\Section;

class SectionApiEditController extends Controller
{
    public function index($id)
    {
        $section = Section::findOrFail($id);

        return response()->json($section);
    }


}
