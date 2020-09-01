<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\API\ApiError;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return response()->json($this->product->paginate(5));
    }

    public function show(Product $id)
    {
        $product = $this->product->find($id);

        if (!$product) return response()->json(ApiError::errorMessage('Produto não encontrado!', 4040), 404);

        $data = ['data' => $product];

        return response()->json($data);
    }

    public function store(Request $request)
    {

        try {
            $productData = $request->All();
            $this->product->create($productData);

            $return = ['data' => ['msg' => 'Produto criado com sucesso!']];
            return response()->json($return, 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010), 500);
            };
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar a operaçao', 1010), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $productData = $request->All();
            $product =  $this->product->find($id);
            $product->update($productData);

            $return = ['data' => ['msg' => 'Produto atualizado com sucesso!']];
            return response()->json($return, 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1011), 500);
            };
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar a operaçao', 1011), 500);
        }
    }

    public function delete(Product $id)
    {
        try {
            $id->delete();

            return response()->json(['data' => ['msg' => 'Produto: ' . $id->name . ' removido com sucesso!']], 200);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1012), 500);
            };
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar a operaçao de remover', 1012), 500);
        }
    }
}
