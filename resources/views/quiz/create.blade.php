<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz - QuizMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-600">
                            <i class="fas fa-graduation-cap mr-2"></i>QuizMaster
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Welcome, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <a href="{{ route('quizzes.list') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Create New Quiz</h1>
                        <p class="text-gray-600 mt-2">Set up your quiz with custom settings and questions</p>
                    </div>
                </div>
            </div>

            <!-- Quiz Creation Form -->
            <form method="POST" action="{{ route('quizzes.store') }}" class="space-y-8">
                @csrf
                
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Basic Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Quiz Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                                   placeholder="Enter quiz title" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                      placeholder="Enter quiz description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Category
                            </label>
                            <select id="category_id" name="category_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="access_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Access Type <span class="text-red-500">*</span>
                            </label>
                            <select id="access_type" name="access_type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('access_type') border-red-500 @enderror" required>
                                <option value="">Select access type</option>
                                <option value="public" {{ old('access_type') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ old('access_type') == 'private' ? 'selected' : '' }}>Private</option>
                                <option value="password_protected" {{ old('access_type') == 'password_protected' ? 'selected' : '' }}>Password Protected</option>
                                <option value="invitation_only" {{ old('access_type') == 'invitation_only' ? 'selected' : '' }}>Invitation Only</option>
                            </select>
                            @error('access_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="password_field" class="hidden">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password" name="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                   placeholder="Enter quiz password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Quiz Settings -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Quiz Settings</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="time_limit" class="block text-sm font-medium text-gray-700 mb-2">
                                Time Limit (minutes)
                            </label>
                            <input type="number" id="time_limit" name="time_limit" value="{{ old('time_limit') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('time_limit') border-red-500 @enderror"
                                   placeholder="Leave empty for no time limit" min="1">
                            @error('time_limit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_attempts" class="block text-sm font-medium text-gray-700 mb-2">
                                Maximum Attempts
                            </label>
                            <input type="number" id="max_attempts" name="max_attempts" value="{{ old('max_attempts') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('max_attempts') border-red-500 @enderror"
                                   placeholder="Leave empty for unlimited attempts" min="1">
                            @error('max_attempts')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date
                            </label>
                            <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                End Date
                            </label>
                            <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_date') border-red-500 @enderror">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Question Settings -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Question Settings</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="randomize_questions" name="randomize_questions" value="1" 
                                   {{ old('randomize_questions') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="randomize_questions" class="ml-2 block text-sm text-gray-900">
                                Randomize question order
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="randomize_answers" name="randomize_answers" value="1" 
                                   {{ old('randomize_answers') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="randomize_answers" class="ml-2 block text-sm text-gray-900">
                                Randomize answer choices
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="show_correct_answers" name="show_correct_answers" value="1" 
                                   {{ old('show_correct_answers', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="show_correct_answers" class="ml-2 block text-sm text-gray-900">
                                Show correct answers after completion
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="show_results_immediately" name="show_results_immediately" value="1" 
                                   {{ old('show_results_immediately', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="show_results_immediately" class="ml-2 block text-sm text-gray-900">
                                Show results immediately
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="allow_navigation" name="allow_navigation" value="1" 
                                   {{ old('allow_navigation', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="allow_navigation" class="ml-2 block text-sm text-gray-900">
                                Allow question navigation
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="require_fullscreen" name="require_fullscreen" value="1" 
                                   {{ old('require_fullscreen') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="require_fullscreen" class="ml-2 block text-sm text-gray-900">
                                Require fullscreen mode
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('quizzes.list') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Create Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show/hide password field based on access type
        document.getElementById('access_type').addEventListener('change', function() {
            const passwordField = document.getElementById('password_field');
            const passwordInput = document.getElementById('password');
            
            if (this.value === 'password_protected') {
                passwordField.classList.remove('hidden');
                passwordInput.required = true;
            } else {
                passwordField.classList.add('hidden');
                passwordInput.required = false;
                passwordInput.value = '';
            }
        });

        // Set minimum end date based on start date
        document.getElementById('start_date').addEventListener('change', function() {
            const endDateInput = document.getElementById('end_date');
            if (this.value) {
                endDateInput.min = this.value;
            }
        });

        // Display validation errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please check the form for errors and try again.',
                confirmButtonColor: '#EF4444'
            });
        @endif
    </script>
</body>
</html>