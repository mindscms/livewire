<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $posts = Post::with(['user', 'category'])->orderBy('id', 'desc')->paginate(5);
        return view('frontend.index', compact('posts'));
    }

    public function index_livewire()
    {
        return view('frontend.index_livewire');
    }

    public function create()
    {
        $categories = Category::all();
        return view('frontend.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|max:255',
            'category'      => 'required',
            'body'          => 'required',
            'image'         => 'nullable|mimes:jpg,jpeg,gif,png|max:20000',
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['title'] = $request->title;
        $data['category_id'] = $request->category;
        $data['body'] = $request->body;
        $data['user_id'] = auth()->id();

        if ($image = $request->file('image')) {
            $filename = Str::slug($request->title).'.'.$image->getClientOriginalExtension();
            $path = public_path('/assets/images/'.$filename);
            Image::make($image->getRealPath())->save($path, 100);

            $data['image'] = $filename;
        }

        Post::create($data);

        return redirect()->route('posts.index')->with([
            'message' => 'Post created successfully',
            'alert-type' => 'success'
        ]);

    }

    public function show($id)
    {
        $post = Post::with(['user', 'category'])->whereId($id)->first();
        if ($post) {
            return view('frontend.show', compact('post'));
        }

        return redirect()->route('posts.index')->with([
            'message' => 'You have not permission to continue this process',
            'alert-type' => 'danger'
        ]);
    }

    public function edit($id)
    {

        $post = Post::whereId($id)->first();
        if ($post) {
            $categories = Category::all();
            return view('frontend.edit', compact('post', 'categories'));
        }

        return redirect()->route('posts.index')->with([
            'message' => 'You have not permission to continue this process',
            'alert-type' => 'danger'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|max:255',
            'category'      => 'required',
            'body'          => 'required',
            'image'         => 'nullable|mimes:jpg,jpeg,gif,png|max:20000',
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $post = Post::whereId($id)->first();
        if ($post) {
            $data['title'] = $request->title;
            $data['category_id'] = $request->category;
            $data['body'] = $request->body;

            if ($image = $request->file('image')) {
                if (File::exists('assets/images/' . $post->image)) {
                    unlink('assets/images/' . $post->image);
                }
                $filename = Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $path = public_path('/assets/images/' . $filename);
                Image::make($image->getRealPath())->save($path, 100);

                $data['image'] = $filename;
            }

            $post->update($data);

            return redirect()->route('posts.index')->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('posts.index')->with([
            'message' => 'You have not permission to continue this process',
            'alert-type' => 'danger'
        ]);

    }

    public function destroy($id)
    {
        $post = Post::whereId($id)->first();
        if ($post) {

            if ($post->image != '') {
                if (File::exists('assets/images/' . $post->image)) {
                    unlink('assets/images/' . $post->image);
                }
            }

            $post->delete();

            return redirect()->route('posts.index')->with([
                'message' => 'Post deleted successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('posts.index')->with([
            'message' => 'You have not permission to continue this process',
            'alert-type' => 'danger'
        ]);
    }
}
