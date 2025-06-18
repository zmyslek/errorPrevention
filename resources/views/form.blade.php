<!-- resources/views/form.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf

        <label for="name">Name:</label><br />
        <input type="text" id="name" name="name" value="{{ old('name') }}" />
        @error('name')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br />

        <label for="email">Email:</label><br />
        <input type="email" id="email" name="email" value="{{ old('email') }}" />
        @error('email')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br />

        <label for="password">Password:</label><br />
        <input type="password" id="password" name="password" />
        @error('password')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br />

        <button type="submit">Register</button>
    </form>
</body>
</html>
