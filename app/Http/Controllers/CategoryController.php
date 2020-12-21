<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index')
            ->with('categories', $categories);
    }

    public function show(Category $category)
    {
        $products = $category->products;

        return view('categories.show')
            ->with('products', $products)
            ->with('category', $category);
    }

    // Show form to create new category (admin only)
    public function create()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect();
        } else {
            return view('categories/create');
        }
    }

    // Save new category (admin only)
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:categories,name', 'min:3', 'max:32'],
            'status' => ['required', 'in:' . join(',', Category::POSSIBLE_STATUSES)],
            'image' => ['image', 'nullable', 'max:1999'],
        ]);

        if ($request->hasFile('image')) {
            // Get just extention
            $extention = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = uniqid() . '.' . $extention;

            $request->file('image')->storeAs('public/upload/categories', $fileNameToStore);
        } else {
            $fileNameToStore = null;
        }

        $category = new Category;
        $category->name = $request->input('name');
        $category->status = $request->input('status');
        $category->updated_at = null;
        $category->image = $fileNameToStore;
        $category->save();

        return redirect('users/' . Auth::id(). '/categories')->with('success', 'New Category added succesfully!');
    }

    // Edit category form (admin only)
    public function edit(Category $category)
    {
        return view('categories.edit')
            ->with('category', $category);
    }

    // Save category to database (admin only)
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:32'],
            'status' => ['required', 'in:' . join(',', Category::POSSIBLE_STATUSES)],
            'image' => ['image', 'nullable', 'max:1999'],
        ]);

        if ($request->hasFile('image')) {
            // Get just extention
            $extention = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = uniqid() . '.' . $extention;

            $path = $request->file('image')->storeAs('public/upload/categories', $fileNameToStore);

            if ($category->image) {
                unlink('storage/upload/categories/' . $category->image);
            }
            $category->image = $fileNameToStore;
        }

        $category->name = $request->input('name');
        $category->status = $request->input('status');
        $category->save();

        return redirect('users/' . Auth::id(). '/categories')->with('success', 'Category edited succesfully!');
    }
}
