@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                        Dashboard
                    </a>
                    <a href="{{ route('checkout.index') }}" class="text-dark float-end">
                        Check-out
                    </a>
                </div>

                <div class="card-body">
                    <p>Welcome, {{ $user->name }}!</p>
                    <p>You are logged in using 
                        <strong>{{ $user->check_provider() }}</strong>.
                    </p>
                </div>

                <div class="card-body">
                    <h2>Profile Information</h2>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Provider:</strong> {{ $user->check_provider() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Posts</div>
                    <div class="card-body" id="post-container">                   
                        <form action="{{ route('posts.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Post</button>
                        </form>
                        <div id="post-container">
                            @if($posts->isEmpty())
                                <p id="empty-post">No posts available.</p>
                            @endif

                            <ul id="post-list" class="list-group my-3">
                                @foreach($posts as $post)
                                    <li id="post-{{ $post->id }}" class="list-group-item shadow-sm border-0 mb-2 rounded">
                                        <p>{{ $post->content }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small>By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</small>
                                            @if ($post->user_id === auth()->id())
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!window.Echo) {
        console.error('Echo belum siap');
        return;
    }

    const list = document.getElementById('post-list');

    window.Echo.channel('post')

        .listen('.create', (e) => {
            const post = e.post;

            if (document.getElementById(`post-${post.id}`)) return;

            const empty = document.getElementById('empty-post');
            if (empty) empty.remove();

            const item = document.createElement('li');
            item.className = 'list-group-item shadow-sm border-0 mb-2 rounded';
            item.id = `post-${post.id}`;

            item.innerHTML = `
                <h5 class="fw-bold mb-1">${post.title}</h5>
                <p class="mb-2 text-muted">${post.content}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-secondary">
                        By ${post.user?.name ?? 'Unknown'} • just now
                    </small>
                </div>
            `;

            item.classList.add('post-highlight');

            list.prepend(item);

            setTimeout(() => {
                item.classList.remove('post-highlight');
            }, 2000);
        })

        .listen('.delete', (e) => {
            const item = document.getElementById(`post-${e.post.id}`);

            if (!item) return;

            item.style.transition = 'all 0.3s ease';
            item.style.opacity = '0';

            setTimeout(() => {
                item.remove();

                if (list.children.length === 0) {
                    const empty = document.createElement('p');
                    empty.id = 'empty-post';
                    empty.textContent = 'No posts available.';
                    list.parentElement.prepend(empty);
                }

            }, 300);
        });
});
</script>
@endpush

@push('styles')
<style>
.post-highlight {
    background: linear-gradient(90deg, #e7f3ff, #ffffff);
    transition: all 0.5s ease;
}
</style>
@endpush