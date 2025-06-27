<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Register</h1>
    <p class="text-gray-600 mb-6 italic">All fields are required.</p>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST" id="registerForm" class="space-y-4">
        @csrf

        <!-- Name field -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   placeholder="e.g. John Doe (min. 2 characters)"
                   required
                   minlength="2"
                   class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email field -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   placeholder="e.g. john@example.com"
                   required
                   class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
            @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password field -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Minimum 6 characters"
                   required
                   minlength="6"
                   class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
            @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password field -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   required
                   minlength="6"
                   class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password_confirmation') border-red-500 @enderror">
            <div id="passwordFeedback">
                @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p id="passwordMatchError" class="mt-1 text-sm text-red-600 hidden">Passwords don't match</p>
            </div>
        </div>

        <button type="submit" id="submitButton"
                class="w-full py-2 px-4 rounded-md text-white font-medium transition-colors bg-gray-400 cursor-not-allowed">
            Register
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');
        const submitButton = document.getElementById('submitButton');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordMatchError = document.getElementById('passwordMatchError');
        const inputs = Array.from(form.querySelectorAll('input[required]'));

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Show error if both fields have values and don't match
            if (password && confirmPassword && password !== confirmPassword) {
                passwordMatchError.classList.remove('hidden');
                return false;
            } else {
                passwordMatchError.classList.add('hidden');
                return true;
            }
        }

        function validateForm() {
            let allFilled = true;

            // Check if all required fields are filled
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    allFilled = false;
                }
            });

            // Check password requirements
            const passwordsValid = checkPasswordMatch() &&
                passwordInput.value.length >= 6 &&
                passwordInput.value === confirmPasswordInput.value;

            // Update button state
            if (allFilled && passwordsValid) {
                submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitButton.classList.add('bg-green-500', 'hover:bg-green-600');
                submitButton.disabled = false;
            } else {
                submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                submitButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                submitButton.disabled = true;
            }
        }

        // Validate on any input change
        inputs.forEach(input => {
            input.addEventListener('input', validateForm);
        });

        // Special validation for password fields
        passwordInput.addEventListener('input', validateForm);
        confirmPasswordInput.addEventListener('input', function() {
            checkPasswordMatch();
            validateForm();
        });

        // Initial validation
        validateForm();
    });
</script>
</body>
</html>