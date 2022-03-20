<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Product extends Controller
{

    /**
     * @var ProductService
     */
    protected $productService;

    /**
     * ProductController Constructor
     *
     * @param ProductService $productService
     *
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * List products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->productService->getAll($request->all())
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Store product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data["image"] = $request->image;
        }

        try {
            $result = [
                'status' => 200,
                'data' => $this->productService->store($data)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display product.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->productService->getById($id)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Update product.
     *
     * @param Request $request
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data["image"] = $request->image;
        }

        try {
            $result = [
                'status' => 200,
                'data' => $this->productService->update($data, $id)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Destroy product.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->productService->deleteById($id)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Product image
     *
     * @param $name
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function image($name)
    {
        return Storage::response(env('APP_UPLOAD_PATH', 'uploads') . DIRECTORY_SEPARATOR . $name);
    }
}
