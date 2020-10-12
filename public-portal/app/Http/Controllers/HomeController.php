<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::where('status', '=', 1)->with('lecturer', 'projectStudent')->paginate(10);
        return view('welcome', compact('projects'));
    }
}
