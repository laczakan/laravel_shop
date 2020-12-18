<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // User profile
    public function show(User $user)
    {
        $products = Product::all();
        $categories = Category::all();
        $orders = $user->orders;

        return view('users.profile')
            ->with('products', $products)
            ->with('categories', $categories)
            ->with('orders', $orders);
    }

    // User register form
    public function create()
    {
        return view('users.create');
    }

    // Save user to database
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:32'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:4', 'max:32'],
            'password_confirmation' => ['required', 'min:4', 'max:32'],
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->created_at = null;
        $user->save();

        return redirect('/auth/login')->with('success', 'New User registered. You can login now!');
    }

    public function image(User $user)
    {
        return view('users.image');
    }

    // Save user image in database
    public function storeImage(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'image' => ['image', 'nullable', 'max:1999']]);

        if ($user->image) {
            unlink('storage/upload/users/' . $user->image);
        }
        if ($request->hasFile('image')) {

            $extention = $request->file('image')->getClientOriginalExtension();

            $fileNameToStore = uniqid() . '.' . $extention;

            $path = $request->file('image')->storeAs('public/upload/users', $fileNameToStore);
        } else {
            $fileNameToStore = null;
        }


        $user->image = $fileNameToStore;
        $user->update();

        return redirect('users/' . Auth::id())->with('success', 'Image changed.');
    }

    // Delete user image
    public function deleteImage()
    {
        $user = Auth::user();

        if ($user->image) {
            unlink('storage/upload/users/' . $user->image);

            $user->image = null;
            $user->update();
        }

        return redirect('users/' . Auth::id())->with('success', 'Image deleted');
    }

    // Show table in profile
    public function showCategories(User $user)
    {
        $categories = Category::all();
        $orders = $user->orders;

        return view('users.showcategories')
            ->with('categories', $categories)
            ->with('orders', $orders);
    }

    // Show table in profile
    public function showProducts(User $user)
    {
        $products = Product::all();
        $categories = Category::all();
        $orders = $user->orders;

        return view('users.showproducts')
            ->with('products', $products)
            ->with('categories', $categories)
            ->with('orders', $orders);
    }
}
