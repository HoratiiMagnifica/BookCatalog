<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;

class SectionListController extends Controller
{
    public function index()
    {
        return view('sections');
    }
}
