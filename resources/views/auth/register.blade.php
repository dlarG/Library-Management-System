<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraLynx - Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter-Regular', sans-serif;
            background-image: url('{{ asset('imgs/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .card-glass {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        .card-glass:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .input-icon {
            top: 50%;
            transform: translateY(-50%);
        }
        .password-toggle {
            top: 50%;
            transform: translateY(-50%);
            right: 0.75rem;
        }
        .password-strength-meter {
            height: 4px;
            transition: all 0.3s ease;
        }
        .strength-weak { background-color: #ef4444; width: 25%; }
        .strength-fair { background-color: #f59e0b; width: 50%; }
        .strength-good { background-color: #3b82f6; width: 75%; }
        .strength-strong { background-color: #10b981; width: 100%; }
        .input-error {
            border-color: #ef4444;
            animation: shake 0.5s;
        }
        .input-success {
            border-color: #10b981;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        @font-face {
            font-family: 'Inter-Regular';
            font-style: normal;
            font-weight: 400 600;
            font-display: swap;
            src: url('{{ asset('fonts/Inter-VariableFont_slnt,wght.ttf') }}') format('truetype');
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl card-glass shadow-2xl overflow-hidden border border-white border-opacity-20">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 py-8 px-10 text-center">
            <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg transform hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Join Our Library</h1>
            <p class="mt-1 text-indigo-100 opacity-90">Create your account</p>
        </div>

        <!-- Form Section -->
        <div class="px-10 py-8">
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-lg animate-fade-in">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-5" id="registerForm">
                @csrf

                <!-- Name Field (full width) -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <div class="relative">
                        <div class="absolute input-icon left-0 pl-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                            placeholder="John Doe">
                        <div id="name-error" class="text-red-500 text-xs mt-1 hidden">Please enter your full name</div>
                    </div>
                </div>

                <!-- Username and Email in one row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <div class="relative">
                            <div class="absolute input-icon left-0 pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="username" name="username" type="text" value="{{ old('username') }}" required autocomplete="username"
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                placeholder="johndoe">
                            <div id="username-error" class="text-red-500 text-xs mt-1 hidden">Username must be at least 3 characters</div>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute input-icon left-0 pl-3 text-gray-400">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                placeholder="your@email.com">
                            <div id="email-error" class="text-red-500 text-xs mt-1 hidden">Please enter a valid email address</div>
                        </div>
                    </div>
                </div>

                <!-- Password and Confirm Password in one row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute input-icon left-0 pl-3 text-gray-400">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                placeholder="••••••••">
                            <button type="button" class="absolute password-toggle text-gray-400 hover:text-gray-600" data-target="password">
                                <svg class="h-5 w-5 eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="password-strength-meter rounded-full mb-1"></div>
                            <div id="password-strength-text" class="text-xs"></div>
                            <div id="password-error" class="text-red-500 text-xs mt-1 hidden">Password must be at least 8 characters</div>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute input-icon left-0 pl-3 text-gray-400">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                placeholder="••••••••">
                            <button type="button" class="absolute password-toggle text-gray-400 hover:text-gray-600" data-target="password_confirmation">
                                <svg class="h-5 w-5 eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div id="password-match-error" class="text-red-500 text-xs mt-1 hidden">Passwords do not match</div>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                    </label>
                </div>
                <div id="terms-error" class="text-red-500 text-xs mt-1 hidden">You must agree to the terms</div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="submitBtn"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span id="btnText">Create Account</span>
                        <svg id="spinner" class="hidden w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>

    

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200 transform hover:-translate-y-0.5">
                        Sign in
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-500">
                &copy; {{ date('Y') }} Library Management System. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password strength meter
            const passwordInput = document.getElementById('password');
            const passwordStrengthMeter = document.querySelector('.password-strength-meter');
            const passwordStrengthText = document.getElementById('password-strength-text');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordMatchError = document.getElementById('password-match-error');
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Password toggle visibility
            document.querySelectorAll('.password-toggle').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('.eye-icon');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.innerHTML = '<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />';
                    } else {
                        input.type = 'password';
                        icon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />';
                    }
                });
            });

            // Check password strength
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Check password length
                if (password.length >= 8) strength++;
                if (password.length >= 12) strength++;
                
                // Check for mixed case
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                
                // Check for numbers
                if (/\d/.test(password)) strength++;
                
                // Check for special chars
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                
                // Update strength meter
                let strengthClass = '';
                let strengthMessage = '';
                
                if (password.length === 0) {
                    strengthClass = '';
                    strengthMessage = '';
                } else if (strength <= 2) {
                    strengthClass = 'strength-weak';
                    strengthMessage = 'Weak password';
                } else if (strength === 3) {
                    strengthClass = 'strength-fair';
                    strengthMessage = 'Fair password';
                } else if (strength === 4) {
                    strengthClass = 'strength-good';
                    strengthMessage = 'Good password';
                } else {
                    strengthClass = 'strength-strong';
                    strengthMessage = 'Strong password';
                }
                
                passwordStrengthMeter.className = `password-strength-meter rounded-full mb-1 ${strengthClass}`;
                passwordStrengthText.textContent = strengthMessage;
                passwordStrengthText.className = 'text-xs ' + 
                    (strength <= 2 ? 'text-red-500' : 
                     strength === 3 ? 'text-yellow-500' : 
                     strength === 4 ? 'text-blue-500' : 'text-green-500');
            });

            // Check password match
            passwordConfirmationInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirmPassword = this.value;
                
                if (confirmPassword.length === 0) {
                    passwordMatchError.classList.add('hidden');
                    this.classList.remove('input-error', 'input-success');
                } else if (password !== confirmPassword) {
                    passwordMatchError.classList.remove('hidden');
                    this.classList.add('input-error');
                    this.classList.remove('input-success');
                } else {
                    passwordMatchError.classList.add('hidden');
                    this.classList.remove('input-error');
                    this.classList.add('input-success');
                }
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Validate name
                const nameInput = document.getElementById('name');
                if (nameInput.value.trim().length < 2) {
                    document.getElementById('name-error').classList.remove('hidden');
                    nameInput.classList.add('input-error');
                    isValid = false;
                } else {
                    document.getElementById('name-error').classList.add('hidden');
                    nameInput.classList.remove('input-error');
                }
                
                // Validate username
                const usernameInput = document.getElementById('username');
                if (usernameInput.value.trim().length < 3) {
                    document.getElementById('username-error').classList.remove('hidden');
                    usernameInput.classList.add('input-error');
                    isValid = false;
                } else {
                    document.getElementById('username-error').classList.add('hidden');
                    usernameInput.classList.remove('input-error');
                }
                
                // Validate email
                const emailInput = document.getElementById('email');
                if (!emailRegex.test(emailInput.value)) {
                    document.getElementById('email-error').classList.remove('hidden');
                    emailInput.classList.add('input-error');
                    isValid = false;
                } else {
                    document.getElementById('email-error').classList.add('hidden');
                    emailInput.classList.remove('input-error');
                }
                
                // Validate password
                if (passwordInput.value.length < 8) {
                    document.getElementById('password-error').classList.remove('hidden');
                    passwordInput.classList.add('input-error');
                    isValid = false;
                } else {
                    document.getElementById('password-error').classList.add('hidden');
                    passwordInput.classList.remove('input-error');
                }
                
                // Validate password match
                if (passwordInput.value !== passwordConfirmationInput.value) {
                    passwordMatchError.classList.remove('hidden');
                    passwordConfirmationInput.classList.add('input-error');
                    isValid = false;
                } else {
                    passwordMatchError.classList.add('hidden');
                    passwordConfirmationInput.classList.remove('input-error');
                }
                
                // Validate terms
                const termsCheckbox = document.getElementById('terms');
                if (!termsCheckbox.checked) {
                    document.getElementById('terms-error').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('terms-error').classList.add('hidden');
                }
                
                if (!isValid) {
                    e.preventDefault();
                } else {
                    // Show loading state
                    submitBtn.disabled = true;
                    btnText.classList.add('hidden');
                    spinner.classList.remove('hidden');
                }
            });

            // Real-time validation as user types
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.id === 'name' && this.value.trim().length >= 2) {
                        document.getElementById('name-error').classList.add('hidden');
                        this.classList.remove('input-error');
                    }
                    if (this.id === 'username' && this.value.trim().length >= 3) {
                        document.getElementById('username-error').classList.add('hidden');
                        this.classList.remove('input-error');
                    }
                    if (this.id === 'email' && emailRegex.test(this.value)) {
                        document.getElementById('email-error').classList.add('hidden');
                        this.classList.remove('input-error');
                    }
                    if (this.id === 'password' && this.value.length >= 8) {
                        document.getElementById('password-error').classList.add('hidden');
                        this.classList.remove('input-error');
                    }
                });
            });
        });
    </script>
</body>
</html>