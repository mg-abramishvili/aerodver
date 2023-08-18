<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function cartData()
    {
        return session()->get('cart');
    }

    public function add($id, Request $request)
    {
        $product = Product::find($id);

        $cart = session()->get('cart', []);

        $cartItem = array_search($id, array_column($cart, 'id'));

        if($cartItem && $cart[$cartItem]) {
            $cart[$cartItem]['quantity']++;
        } else {
            $cart[] = [
                "id" => $product->id,
                "name" => $product->name,
                "name_eng" => $product->name_eng,
                "quantity" => 1,
                "price_rub" => $product->price_rub,
                "price_usd" => $product->price_usd,
            ];
        }
          
        session()->put('cart', $cart);

        return redirect()->route('cart');
    }

    public function update(Request $request)
    {
        $cart = $request->cart;

        session()->put('cart', $cart);
    }

    public function delete($id, Request $request)
    {
        $cart = session()->get('cart');

        $cartItem = array_search($id, array_column($cart, 'id'));

        if($cart[$cartItem])
        {
            unset($cart[$cartItem]);

            session()->put('cart', $cart);
        }
    }
}
