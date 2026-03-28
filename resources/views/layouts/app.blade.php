<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/js/app.js'])
    <!-- Custom Styles -->
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('posts.index') }}">{{ __('Posts') }}</a>
                            </li> --}}
                            @auth
                                <li class="nav-item dropdown me-3">
                                    <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
                                        
                                        <!-- Bell Icon -->
                                        <svg width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.104-14.804A1 1 0 0 0 7 2c0 .628-.134 1.197-.356 1.715C5.4 4.68 4 6.223 4 8v3l-1 1v1h10v-1l-1-1V8c0-1.777-1.4-3.32-2.644-4.285A4.992 4.992 0 0 1 9 2a1 1 0 0 0-.896-.804z"/>
                                        </svg>

                                        <!-- Badge -->
                                        <span id="notif-count"
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                            style="display:none;">
                                            0
                                        </span>
                                    </a>

                                    <!-- Dropdown -->
                                    <ul class="dropdown-menu dropdown-menu-end" id="notif-list">
                                        <li class="dropdown-item text-muted">No notifications</li>
                                    </ul>
                                </li>
                            @endauth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!window.Echo) return;
        
            let count = 0;
        
            const badge = document.getElementById('notif-count');
            const list = document.getElementById('notif-list');
        
            window.Echo.channel('post')
                .listen('.create', (e) => {
        
                    // skip if user id == post creator
                    if (e.post.user_id === {{ auth()->id() }}) return;
        
                    count++;
        
                    badge.style.display = 'inline-block';
                    badge.innerText = count;
        
                    if (list.children.length === 1 && list.children[0].innerText === 'No notifications') {
                        list.innerHTML = '';
                    }
        
                    const item = document.createElement('li');
                    item.innerHTML = `
                        <a href="#" class="dropdown-item">
                            <strong>${e.post.title}</strong><br>
                            <small class="text-muted">New post created</small>
                        </a>
                    `;
        
                    list.prepend(item);
                })
                .listen('.delete', (e) => {
                    // skip if user id == post creator
                    if (e.post.user_id === {{ auth()->id() }}) return;
        
                    count++;
        
                    badge.style.display = 'inline-block';
                    badge.innerText = count;
        
                    if (list.children.length === 1 && list.children[0].innerText === 'No notifications') {
                        list.innerHTML = '';
                    }
        
                    const item = document.createElement('li');
                    item.innerHTML = `
                        <a href="#" class="dropdown-item">
                            <strong>${e.post.title}</strong><br>
                            <small class="text-muted">A post was deleted</small>
                        </a>
                    `;
        
                    list.prepend(item);
                });
        
            document.getElementById('notifDropdown').addEventListener('click', () => {
                count = 0;
                badge.style.display = 'none';
            });
        });
    </script>
    @stack('scripts')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>