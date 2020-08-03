<?php

namespace App\Http\Livewire\Dynamic;

use App\Category;
use App\Post;
use Livewire\Component;

class Show extends Component
{

    public $post_id;
    public $post;
    public $title;
    public $body;
    public $category;
    public $user;
    public $image;


    protected $listeners = ['showPost' => 'show_post'];

    public function mount()
    {
        $this->post = Post::whereId($this->post_id)->first();
    }

    public function render()
    {


        return view('livewire.dynamic.show', [
            'post' => $this->post
        ]);
    }

    public function show_post($post)
    {
        $this->post = $post;
        $this->post_id = $this->post['id'];
        $this->title = $this->post['title'];
        $this->category = $this->post['category']['name'];
        $this->user = $this->post['user']['name'];
        $this->body = $this->post['body'];
        $this->image = $this->post['image'];
    }

}
