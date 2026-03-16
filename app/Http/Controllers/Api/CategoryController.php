<?php

namespace App\Http\Controllers\Api;  // <-- HARUSNYA INI

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json($category);
    }
}