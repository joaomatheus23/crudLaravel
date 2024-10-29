<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function index()
    {
        
        $cart = session()->get('cart', []);

        
        if (empty($cart)) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        
        $formattedCart = [];
        foreach ($cart as $id => $item) {
            $formattedCart[] = [
                'product_id' => $id,
                'product_name' => $item['product']->nome,
                'quantity' => $item['quantity'],
                'price' => $item['product']->preco,
                'total' => $item['quantity'] * $item['product']->preco,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $formattedCart,
        ]);
    }

   
    public function store(Request $request)
    {
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        
        $cart = session()->get('cart', []);

        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            
            $product = Product::find($productId);
            if ($product) {
                $cart[$productId] = [
                    'quantity' => $quantity,
                    'product' => $product, 
                ];
            } else {
                return response()->json(['success' => false, 'message' => 'Produto não encontrado'], 404);
            }
        }

        
        session()->put('cart', $cart);
        
        
        \Log::info('Carrinho atualizado: ', $cart);

        return response()->json([
            'success' => true,
            'data' => $cart,
        ]);
    }

    
    public function destroy($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json([
                'success' => true,
                'message' => 'Produto removido do carrinho',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produto não encontrado no carrinho',
        ], 404);
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'data' => $cart,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produto não encontrado no carrinho',
        ], 404);
    }

    
    public function checkout()
    {
        session()->forget('cart'); 
        
        return response()->json([
            'success' => true,
            'message' => 'Checkout realizado com sucesso',
        ]);
    }
}
