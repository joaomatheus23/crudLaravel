<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller {
    public function index() {
        return Produto::all();
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'quantidade' => 'required',
        ]);

        $produto = Produto::create($request->all());
        return response()->json($produto, 201);
    }

    public function show($id) {
        return Produto::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $produto = Produto::findOrFail($id);
        $produto->update($request->all());
        return response()->json($produto, 200);
    }

    public function destroy($id) {
        Produto::destroy($id);
        return response()->json(null, 204);
    }
}

