<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $categories = Category::latest()->get();

        return new SuccessResource([
            'message' => 'All Category',
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request) {
         $formData = $request->validated();

        // $formData['slug'] = Str::slug($formData['name']);

        Category::create([
            'name'=>$formData['name'],
            'slug'=>Str::slug($formData['name']),
        ]);

        return (new SuccessResource(['message' => 'Successfully Category Created.']))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'No category found on this id',
                'errors' => '',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'No category found on this id',
                'errors' => '',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $category = Category::where('id',$category->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'category updated successfull',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'No category found on this id',
                'errors' => '',
            ]);
        }

        $category = Category::where('id',$category->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'category delete successfull',
        ]);

    }
}
