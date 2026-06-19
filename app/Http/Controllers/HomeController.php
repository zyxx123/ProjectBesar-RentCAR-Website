<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }
}
