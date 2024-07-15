@extends('mainLayout')

@section('page-title', 'Home')

@section('page-content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col">
            <h1>Welcome, {{ Auth::user()->name }}</h1>
        </div>
        <div class="col-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <h2>Latest Posts</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            @foreach($posts as $post)
                <div class="card mb-3">
                    <div class="card-body d-flex">
                        <div class="user-profile mr-3">
                            <img src="https://via.placeholder.com/50" alt="User Profile Picture" class="rounded-circle">
                        </div>
                        <div class="post-content w-100">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title mb-1">{{ $post->user->name }}</h5>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="card-text">{{ $post->title }}</p>
                            <p class="card-text">{{ Str::limit($post->body, 150) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-primary">Read More</a>
                                <small class="text-muted">{{ $post->comments->count() }} comments</small>
                            </div>

                            @if(Auth::id() === $post->user_id)
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if($posts->isEmpty())
                <div class="alert alert-info">
                    No posts available. <a href="{{ route('posts.create') }}">Create a new post</a>.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection