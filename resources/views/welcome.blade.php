<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome to the Laravel App</h1>

     @auth
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        <a href="#" class="navbar-item " onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
    @else
        <p><a href="{{ route('register.form') }}">Register Here</a></p>
        <p><a href="{{ route('login') }}">Login</a></p>
    @endauth
</body>
</html>
