<?php

namespace App\Http\Livewire\Dynamic;

use App\Post;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use withPagination;

    public $showCreateForm = false;
    public $showEditForm = false;
    public $showPost = false;

    protected $listeners = [
        'postAdded'     => 'refreshCreatePosts',
        'postUpdated'     => 'refreshUpdatedPosts',
        'postNotUpdated'     => 'refreshNotUpdatedPosts',
        'postDeleted'     => 'refreshDeletedPosts',
        'postNotDeleted'     => 'refreshNotDeletedPosts',

    ];

    public function render()
    {
        $posts = Post::with('user', 'category')->orderBy('id', 'desc')->paginate(5);
        return view('livewire.dynamic.posts', [
            'posts' => $posts
        ]);
    }


    public function create_post()
    {
        $this->showCreateForm = !$this->showCreateForm;
        $this->showEditForm = false;
        $this->showPost = false;
    }

    public function show_post($id)
    {
        $post = Post::with(['user', 'category'])->whereId($id)->first();
        if ($post) {
            $this->emit('showPost', $post);
            $this->showPost = !$this->showPost;
            $this->showCreateForm = false;
            $this->showEditForm = false;
        }
    }

    public function edit_post($id)
    {
        $post = Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            $this->emit('getPost', $post);
            $this->showEditForm = !$this->showEditForm;
            $this->showCreateForm = false;
            $this->showPost = false;
        }
    }

    public function delete_post($id)
    {
        $post = Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            if (File::exists('assets/images/'. $post->image)) {
                unlink('assets/images/'. $post->image);
            }
            $post->delete();

            $this->emit('postDeleted');
        } else {
            $this->emit('postNotDeleted');
        }
    }



    public function refreshCreatePosts($posts)
    {
        session()->flash('message', 'Post Added successfully');
        $this->showCreateForm = false;
        $this->showEditForm = false;
    }

    public function refreshUpdatedPosts($posts)
    {
        session()->flash('message', 'Post updated successfully');
        $this->showCreateForm = false;
        $this->showEditForm = false;
    }

    public function refreshNotUpdatedPosts($posts)
    {
        session()->flash('message_error', 'You can not update not yours');
        $this->showCreateForm = false;
        $this->showEditForm = false;
    }

    public function refreshDeletedPosts($posts)
    {
        session()->flash('message', 'Post deleted successfully');
        $this->showCreateForm = false;
        $this->showEditForm = false;
    }

    public function refreshNotDeletedPosts($posts)
    {
        session()->flash('message_error', 'You can not delete not yours');
        $this->showCreateForm = false;
        $this->showEditForm = false;
    }


}
