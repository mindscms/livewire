@extends('layouts.app')
@section('content')

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <b>Posts</b>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm ml-auto">Create Post</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Owner</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td><img src="{{ asset('assets/images/'.$post->image) }}" alt="{{ $post->title }}" width="100"></td>
                                    <td>
                                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="if (confirm('Are you sure?')) { document.getElementById('delete-{{ $post->id }}').submit(); } else { return false; } ">Delete</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="post" id="delete-{{ $post->id }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right">
                        {!! $posts->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
