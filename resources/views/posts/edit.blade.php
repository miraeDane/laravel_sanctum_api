@extends('mainLayout')

@section('page-title', 'Edit Post')

@section('page-content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Edit Post</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('posts.update', $post) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Content</label>
                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="5" required>{{ old('body', $post->body) }}</textarea>
                    @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update Post</button>
            </form>
        </div>
    </div>
</div>
@endsection