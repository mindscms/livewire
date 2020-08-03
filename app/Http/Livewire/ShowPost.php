<?php

namespace App\Http\Livewire;

use App\Post;
use Livewire\Component;

class ShowPost extends Component
{

    public $post_id;
    public $post;
    public $title;
    public $category;
    public $user;
    public $body;
    public $image;

    public function mount()
    {

        $this->post_id = request()->post_id;
        $this->post = Post::with(['user', 'category'])->whereId($this->post_id)->first();
        $this->title = $this->post->title;
        $this->body = $this->post->body;
        $this->category = $this->post->category->name;
        $this->user = $this->post->user->name;
        $this->image = $this->post->image;
    }


    public function render()
    {
        return view('livewire.show-post', [
            'post' => $this->post
        ]);
    }

    public function return_to_posts()
    {
        return redirect()->to('livewire/posts');
    }
}
