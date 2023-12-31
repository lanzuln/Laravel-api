<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller {

    public function index() {
        $posts = Post::latest('id')->get();
        if(!$posts){
            return response()->json([
                'success' => false,
                'message' => 'No posts found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All posts',
            'data' => $posts,
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'title' => 'required|string|max:180|unique:posts',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'content' => 'required|string',
        ]);

        // return form validation error with json if error occured
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error occured',
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        $data = $validator->validated();

        // add post slug
        $data['slug'] = Str::slug($data['title']);

        // photo will upload if exist
        if (array_key_exists('photo', $data)) {
            $data['photo'] = Storage::putFile('', $data['photo']);
        }

        // store a new post
        Post::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully!',
            'data' => [],
        ], 201);
    }

    public function show(Post $post) {
        return response()->json([
            'success' => true,
            'message' => 'Post details.',
            'data' => $post,
        ]);
    }

    public function update(Request $request, $id) {
        $post_id = Post::find($id);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'title' => 'required|string|max:180',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'content' => 'required|string',
        ]);

        // return form validation error with json if error occured
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error occured',
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        $data = $validator->validated();

        // add post slug
        $data['slug'] = Str::slug($data['title']);

        // photo will upload if exist
        if (array_key_exists('photo', $data)) {
            Storage::delete($post_id->photo);
            $data['photo'] = Storage::putFile('', $data['photo']);
        }

        Post::where('id', $post_id->id)->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully!',
            'data' => [],
        ]);
    }

    /**
     * destroy
     *
     * @param  mixed Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $post_id = Post::find($id);

        Storage::delete($post_id->photo);

        Post::where('id', $post_id->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully!',
            'data' => [],
        ]);
    }
}
