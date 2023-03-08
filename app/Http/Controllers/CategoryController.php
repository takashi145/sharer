<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->orderBy('updated_at', 'desc')->paginate(10);
        return Inertia::render('Category/Index', [
            'categories' => CategoryResource::collection($categories),
        ]);
    }
}
