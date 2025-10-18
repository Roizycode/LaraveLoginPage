<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} - QuizMaster</title>
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
            <!-- Quiz Header -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $quiz->title }}</h1>
                        <p class="text-gray-600 mb-4">{{ $quiz->description }}</p>
                        
                        <div class="flex items-center space-x-6 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <span>Created by {{ $quiz->instructor->name }}</span>
                            </div>
                            @if($quiz->category)
                                <div class="flex items-center">
                                    <i class="fas fa-tag mr-2" style="color: {{ $quiz->category->color }}"></i>
                                    <span>{{ $quiz->category->name }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>Created {{ $quiz->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        @if($quiz->status === 'published')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Published
                            </span>
                        @elseif($quiz->status === 'draft')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-edit mr-1"></i>Draft
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-archive mr-1"></i>Archived
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Quiz Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-question-circle text-blue-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-blue-600 font-medium">Questions</p>
                                <p class="text-2xl font-bold text-blue-900">{{ $quiz->total_questions }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-star text-green-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-green-600 font-medium">Total Points</p>
                                <p class="text-2xl font-bold text-green-900">{{ $quiz->total_points }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($quiz->time_limit)
                        <div class="bg-orange-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-orange-600 text-2xl mr-3"></i>
                                <div>
                                    <p class="text-sm text-orange-600 font-medium">Time Limit</p>
                                    <p class="text-2xl font-bold text-orange-900">{{ $quiz->time_limit }} min</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-play-circle text-purple-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-purple-600 font-medium">Attempts</p>
                                <p class="text-2xl font-bold text-purple-900">{{ $quiz->attempts->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quiz Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quiz Settings</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-random text-gray-600 mr-2"></i>
                            <span>{{ $quiz->randomize_questions ? 'Randomized' : 'Sequential' }} questions</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-shuffle text-gray-600 mr-2"></i>
                            <span>{{ $quiz->randomize_answers ? 'Randomized' : 'Fixed' }} answers</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-eye text-gray-600 mr-2"></i>
                            <span>{{ $quiz->show_correct_answers ? 'Shows' : 'Hides' }} correct answers</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-arrows-alt text-gray-600 mr-2"></i>
                            <span>{{ $quiz->allow_navigation ? 'Allows' : 'Restricts' }} navigation</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-expand text-gray-600 mr-2"></i>
                            <span>{{ $quiz->require_fullscreen ? 'Requires' : 'Optional' }} fullscreen</span>
                        </div>
                        @if($quiz->max_attempts)
                            <div class="flex items-center">
                                <i class="fas fa-redo text-gray-600 mr-2"></i>
                                <span>Max {{ $quiz->max_attempts }} attempts</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Attempts (if any) -->
            @if($userAttempts->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Attempts</h2>
                    <div class="space-y-4">
                        @foreach($userAttempts as $attempt)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                            <span>Attempt #{{ $loop->iteration }}</span>
                                            <span>Started: {{ $attempt->started_at->format('M d, Y H:i') }}</span>
                                            @if($attempt->completed_at)
                                                <span>Completed: {{ $attempt->completed_at->format('M d, Y H:i') }}</span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex items-center space-x-6 text-sm">
                                            <div class="flex items-center">
                                                <i class="fas fa-star mr-1"></i>
                                                <span>Score: {{ $attempt->score }}/{{ $attempt->total_points }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-percentage mr-1"></i>
                                                <span>{{ number_format($attempt->percentage, 1) }}%</span>
                                            </div>
                                            @if($attempt->time_spent)
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    <span>{{ $attempt->getTimeSpentFormatted() }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        @if($attempt->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>Completed
                                            </span>
                                        @elseif($attempt->status === 'in_progress')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-play mr-1"></i>In Progress
                                            </span>
                                        @elseif($attempt->status === 'abandoned')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-pause mr-1"></i>Abandoned
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i>Timeout
                                            </span>
                                        @endif
                                        
                                        <a href="{{ route('attempts.show', $attempt) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-eye mr-1"></i>View Details
                                        </a>
                                        
                                        @if($attempt->status === 'in_progress')
                                            <a href="{{ route('attempts.resume', $attempt) }}" 
                                               class="text-green-600 hover:text-green-800 text-sm">
                                                <i class="fas fa-play mr-1"></i>Resume
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Ready to take the quiz?</h3>
                        <p class="text-gray-600">Test your knowledge and see how you perform!</p>
                    </div>
                    
                    <div class="flex space-x-4">
                        @if(Auth::user()->isAdmin() || $quiz->instructor_id === Auth::id())
                            <a href="{{ route('quizzes.edit', $quiz) }}" 
                               class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                                <i class="fas fa-edit mr-2"></i>Edit Quiz
                            </a>
                        @endif
                        
                        @if($quiz->status === 'published')
                            @php
                                $canAttempt = $quiz->canUserAttempt(Auth::user());
                            @endphp
                            
                            @if(empty($canAttempt))
                                <a href="{{ route('quizzes.start', $quiz) }}" 
                                   class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-play mr-2"></i>Start Quiz
                                </a>
                            @else
                                <div class="text-red-600 text-sm">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    {{ implode(', ', $canAttempt) }}
                                </div>
                            @endif
                        @else
                            <div class="text-gray-500 text-sm">
                                <i class="fas fa-lock mr-1"></i>
                                Quiz is not available for taking
                            </div>
                        @endif
                    </div>
                </div>
            </div>
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

