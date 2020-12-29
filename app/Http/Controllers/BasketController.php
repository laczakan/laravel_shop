<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketProduct;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BasketController extends Controller
{
    public function show()
    {
        $total = 0;
        $basket = Basket::where('user_id', Auth::id())->first();

        if ($basket) {
            $basket_products = $basket->basketProducts;

            // Calculate total amount in basket.
            $total = $basket_products->sum(function (BasketProduct $product) {
                $price = $product->product->price;
                return $price->multiply($product->quantity)->getAmount();
            });
        }

        return view('basket.show')
            ->with('basket', $basket)
            // Function money to convert in GBP
            ->with('total', money($total, 'GBP'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'min:0'],

        ]);

        $basket = Basket::firstOrCreate(['user_id' => Auth::id()]);

        BasketProduct::updateOrCreate(
            [
                'basket_id' => $basket->id,
                'product_id' => $request->input('product_id')
            ],
            [
                'quantity' => $request->input('quantity')
            ]
        );

        return redirect('/basket')->with('success', 'product added');
    }


    public function update(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'min:0'],

        ]);

        $basket = Basket::where('user_id', Auth::id())->first();

        BasketProduct::updateOrCreate(
            [
                'basket_id' => $basket->id,
                'product_id' => $request->input('product_id')
            ],
            [
                'quantity' => $request->input('quantity')
            ]
        );
        return redirect('/basket')->with('success', 'product updated');
    }

    public function destroy(Request $request, int $product)
    {
        $basket = Basket::where('user_id', Auth::id())->first();

        $basketProduct = $basket->basketProducts()->where('product_id', $product)->first();

        if ($basketProduct) {
            $basketProduct->delete();
        }
        if(!$basket->basketProducts()->count()){
            $basket->delete();
        }
        return redirect('/basket')->with('success', 'product deleted from basket');
    }

    public function showAddress()
    {
        $total = 0;
        $basket = Basket::where('user_id', Auth::id())->first();

        if ($basket) {
            $basket_products = $basket->basketProducts;

            $total = $basket_products->sum(function (BasketProduct $product) {
                $price = $product->product->price;
                return $price->multiply($product->quantity)->getAmount();
            });

            return view('basket.checkout')
                ->with('basket', $basket)
                ->with('total', money($total, 'GBP'));
        }
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:32'],
            'address' => ['required'],
            'info' => [''],

        ]);

        $total = 0;
        $basket = Basket::where('user_id', Auth::id())->first();

        if ($basket) {

            $basket_products = $basket->basketProducts;

            $total = $basket_products->sum(function (BasketProduct $product) {
                $price = $product->product->price;
                return $price->multiply($product->quantity)->getAmount();
            });

            DB::transaction(function () use ($request, $total, $basket) {
                $order = new Order;
                $order->user_id = Auth::id();
                $order->name = $request->input('name');
                $order->address = $request->input('address');
                $order->info = $request->input('info');
                $order->total = money($total, 'GBP');
                $order->save();

                foreach ($basket->basketProducts as $basketProduct) {

                    $details = new OrderDetails;
                    $details->order_id = $order->id;
                    $details->product_id = $basketProduct->product_id;
                    $details->quantity = $basketProduct->quantity;
                    $details->price = $basketProduct->product->price->getAmount();
                    $details->save();

                    $product = $basketProduct->product;

                    $product->quantity -= $basketProduct->quantity;
                    $product->save();



                    $basketProduct->delete();
                }

                $basket->delete();
            });
        }
        return redirect('users/' . Auth::id())->with('success', 'Order completed!');
    }
}
