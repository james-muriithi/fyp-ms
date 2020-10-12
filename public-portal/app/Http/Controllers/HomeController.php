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

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (isset($query) && !empty($query)){
            $projects = Project::where('title', 'LIKE','%'.$query.'%' )->paginate(10);
            return view('search', compact('query', 'projects'));
        }

        return redirect()->route('index');
    }
}
