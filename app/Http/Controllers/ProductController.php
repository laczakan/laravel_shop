<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $users = User::all();

        return view('products.index')
            ->with('products', $products)
            ->with('categories', $categories)
            ->with('users', $users);
    }


    // Add product form
    public function create()
    {
        $categories = Category::all();

        return view('products.create')
            ->with('categories', $categories);
    }

    // Save product to database
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:products,name', 'min:3', 'max:32'],
            'category_id' => ['required', 'exists:categories,id'],
            'quantity' => ['required', 'integer'],
            'price' => ['required'],
            'image' => ['image', 'nullable', 'max:1999'],
            'description' => ['max:5000'],
        ]);

        if ($request->hasFile('image')) {

            $extention = $request->file('image')->getClientOriginalExtension();

            $fileNameToStore = uniqid() . '.' . $extention;

            $path = $request->file('image')->storeAs('public/upload/products', $fileNameToStore);
        } else {
            $fileNameToStore = null;
        }


        $product = new Product;
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->quantity = $request->input('quantity');
        $product->price = $request->input('price');
        $product->updated_at = null;
        $product->image = $fileNameToStore;
        $product->description = $request->input('description');
        $product->save();

        return redirect('users/' . Auth::id(). '/products')->with('success', 'New Product added.');

    }

    public function show(Product $product)
    {
        $categories = Category::all();

        return view('products.show')
            ->with('product', $product)
            ->with('categories', $categories);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit')
            ->with('product', $product)
            ->with('categories', $categories);
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:32'],
            'category_id' => ['required', 'exists:categories,id'],
            'quantity' => ['required', 'integer'],
            'price' => ['required'],
            'image' => ['image', 'nullable', 'max:1999'],
            'description' => ['max:5000'],
        ]);

        if ($request->hasFile('image')) {

            $extention = $request->file('image')->getClientOriginalExtension();

            $fileNameToStore = uniqid() . '.' . $extention;

            $path = $request->file('image')->storeAs('public/upload/products', $fileNameToStore);

            if ($product->image) {
                unlink('storage/upload/products/' . $product->image);
            }
            $product->image = $fileNameToStore;
        }

        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->quantity = $request->input('quantity');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        return redirect('users/' . Auth::id(). '/products')->with('success', 'Product updated.');
    }
}
