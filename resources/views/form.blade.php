<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
<section class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
    <section class="left"><a href="{{ route('dashboard') }}">Home</a></section><br/>
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Register</h1>
    <p class="text-gray-600 mb-6 italic">All fields are required.</p>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST" id="registerForm" class="space-y-4">
        @csrf

        <!-- Name field with length validation -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   placeholder="e.g. John Doe (min. 2 characters)"
                   required
                   minlength="2"
                   class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
            <div id="nameFeedback">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p id="nameLengthError" class="mt-1 text-sm text-red-600 hidden">Name must be at least 2 characters</p>
            </div>
        </div>

        <!-- Email field -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username"
                   placeholder="e.g. john@example.com"
                   required
                   class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
            @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password field with length validation -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" id="password" name="password" autocomplete="new-password"
                   placeholder="Minimum 12 characters, at least one uppercase, one digit, and one special character"
                   required
                   minlength="12"
                   class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
            <div id="passwordFeedback">
                @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p id="passwordLengthError" class="mt-1 text-sm text-red-600 hidden">Password must be at least 12 characters</p>
            </div>
        </div>

        <!-- Confirm Password field -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   required
                   minlength="12"
                   class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password_confirmation') border-red-500 @enderror">
            <div id="confirmPasswordFeedback">
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
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');
        const submitButton = document.getElementById('submitButton');
        const nameInput = document.getElementById('name');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const nameLengthError = document.getElementById('nameLengthError');
        const passwordLengthError = document.getElementById('passwordLengthError');
        const passwordMatchError = document.getElementById('passwordMatchError');
        const inputs = Array.from(form.querySelectorAll('input[required]'));

        function checkNameLength() {
            const name = nameInput.value;

            // Show error if name is too short and not empty
            if (name && name.length < 2) {
                nameLengthError.classList.remove('hidden');
                return false;
            } else {
                nameLengthError.classList.add('hidden');
                return true;
            }
        }

        function checkPasswordLength() {
            const password = passwordInput.value;

            // Show error if password is too short and not empty
            if (password && password.length < 12) {
                passwordLengthError.classList.remove('hidden');
                return false;
            } else {
                passwordLengthError.classList.add('hidden');
                return true;
            }
        }

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

            // Check field requirements
            const nameValid = checkNameLength();
            const passwordValid = checkPasswordLength();
            const passwordsMatch = checkPasswordMatch();

            // Update button state
            if (allFilled && nameValid && passwordValid && passwordsMatch) {
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

        // Special validation for specific fields
        nameInput.addEventListener('input', function() {
            checkNameLength();
            validateForm();
        });

        passwordInput.addEventListener('input', function() {
            checkPasswordLength();
            checkPasswordMatch();
            validateForm();
        });

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
