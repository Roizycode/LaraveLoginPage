<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Management - QuizMaster</title>
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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Quiz Management</h1>
                        <p class="text-gray-600 mt-2">Create, manage, and monitor your quizzes</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('quizzes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Create New Quiz
                        </a>
                        <a href="{{ route('questions.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-question-circle mr-2"></i>Add Question
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search quizzes..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quiz Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($quizzes as $quiz)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <!-- Quiz Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $quiz->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($quiz->description, 100) }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    @if($quiz->status === 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Published
                                        </span>
                                    @elseif($quiz->status === 'draft')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Draft
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Archived
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Quiz Details -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-user mr-2"></i>
                                    <span>{{ $quiz->instructor->name }}</span>
                                </div>
                                @if($quiz->category)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-tag mr-2" style="color: {{ $quiz->category->color }}"></i>
                                        <span>{{ $quiz->category->name }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-question-circle mr-2"></i>
                                    <span>{{ $quiz->total_questions }} questions</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-star mr-2"></i>
                                    <span>{{ $quiz->total_points }} points</span>
                                </div>
                                @if($quiz->time_limit)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span>{{ $quiz->time_limit }} minutes</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Quiz Stats -->
                            @if($quiz->attempts->count() > 0)
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Attempts:</span>
                                            <span class="font-semibold">{{ $quiz->attempts->count() }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Avg Score:</span>
                                            <span class="font-semibold">{{ number_format($quiz->attempts->avg('percentage'), 1) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('quizzes.show', $quiz) }}" 
                                   class="flex-1 bg-blue-600 text-white text-center px-3 py-2 rounded-md hover:bg-blue-700 transition-colors text-sm">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                @if(Auth::user()->isAdmin() || $quiz->instructor_id === Auth::id())
                                    <a href="{{ route('quizzes.edit', $quiz) }}" 
                                       class="flex-1 bg-yellow-600 text-white text-center px-3 py-2 rounded-md hover:bg-yellow-700 transition-colors text-sm">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                @endif
                                @if($quiz->status === 'published' && Auth::user()->isStudent())
                                    <a href="{{ route('quizzes.start', $quiz) }}" 
                                       class="flex-1 bg-green-600 text-white text-center px-3 py-2 rounded-md hover:bg-green-700 transition-colors text-sm">
                                        <i class="fas fa-play mr-1"></i>Start
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-question-circle text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No quizzes found</h3>
                        <p class="text-gray-600 mb-6">Get started by creating your first quiz</p>
                        <a href="{{ route('quizzes.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Create Quiz
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($quizzes->hasPages())
                <div class="mt-8">
                    {{ $quizzes->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Display success/error messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3B82F6'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#EF4444'
            });
        @endif
    </script>
</body>
</html>