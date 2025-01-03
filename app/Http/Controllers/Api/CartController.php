<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Resources\Cart\CartCollection;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(): CartCollection
    {
//        $cart = Cart::where('user_id', auth()->id())->with('products')->get()->first();
        $cart = Cart::where('user_id', auth()->id())->with('products')->first();
        return new CartCollection($cart);
    }

    public function store(StoreCartRequest $request): JsonResponse
    {
        $validated = $request->validated();
        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
        ]);
        return successResponse("Cart added successfully", $validated);
    }
    public function destroy(Cart $cart): JsonResponse
    {
        dd($cart);
        return errorResponse('Failed to delete');
    }
}
