<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    
    public function index() {
        return response()->json([
            'success' => true,
            'data' => Product::all(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0.01', 
            'quantidade' => 'required|integer|min:1', 
        ]);

        $product = Product::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $product,
        ], 201);
    }

    public function show($id) {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function update(Request $request, $id) {
        
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }
    
        
        $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'preco' => 'sometimes|required|numeric|min:0.01', 
            'quantidade' => 'sometimes|required|integer|min:1', 
        ]);
    
       
        $product->update($request->only(['nome', 'preco', 'quantidade']));
    
      
        return response()->json([
            'success' => true,
            'data' => $product,
        ], 200);
    }

    public function destroy($id) {
        
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
    
        
        $product->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ], 204);
    }
    
}
