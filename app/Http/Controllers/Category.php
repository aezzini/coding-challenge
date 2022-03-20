<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;

class Category extends Controller
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * CategoryController Constructor
     *
     * @param CategoryService $categoryService
     *
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * List categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->categoryService->getAll($request->all())
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
     * Store category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->categoryService->store($request->all())
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
     * Display category.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->categoryService->getById($id)
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
     * Update category.
     *
     * @param Request $request
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->categoryService->update($request->all(), $id),
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
     * Destroy category.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->categoryService->deleteById($id)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
}
