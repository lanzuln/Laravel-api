<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $category = Category::latest('id')->get();
        return response()->json([
            'status' => true,
            'message' => "Data retrived sussessfull",
            'data' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'category created successfully',
            'data' => $category,
        ]);
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
        //
    }
}
