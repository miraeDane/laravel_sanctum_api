@extends('mainLayout')
@section('page-title', $post->title)
@section('page-content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>{{ $post->title }}</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p class="card-text">{{ $post->body }}</p>
            <p class="card-text"><small class="text-muted">Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</small></p>
        </div>
    </div>

    @can('update-post', $post)
    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary mb-2">Edit</a>
    @endcan

    @can('delete-post', $post)
    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-2" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
    @endcan

    <h3 class="mb-3">Comments ({{ $post->comments->count() }})</h3>

    @foreach($post->comments as $comment)
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">{{ $comment->body }}</p>
            <p class="card-text"><small class="text-muted">Commented by {{ $comment->user->name }} on {{ $comment->created_at->format('M d, Y') }}</small></p>
            @can('update-comment', $comment)
            <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-primary mb-2">Edit</a>
            @endcan
            @can('delete-comment', $comment)
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger mb-2" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            @endcan
        </div>
    </div>
    @endforeach

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add a comment</h5>
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="mb-3">
                    <textarea class="form-control" name="body" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>
</div>
@endsection