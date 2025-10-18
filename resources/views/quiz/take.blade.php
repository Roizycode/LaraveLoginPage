<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taking Quiz: {{ $quiz->title }} - QuizMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Quiz Header -->
        <div class="bg-white shadow-sm border-b sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-gray-900">{{ $quiz->title }}</h1>
                        <span class="ml-4 text-sm text-gray-600">Question {{ $currentQuestionIndex + 1 }} of {{ $questions->count() }}</span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        @if($quiz->time_limit)
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-clock mr-2"></i>
                                <span id="time-remaining">{{ $attempt->getTimeRemaining() ? gmdate('H:i:s', $attempt->getTimeRemaining()) : 'No time limit' }}</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-user mr-2"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                @if($quiz->show_progress_bar)
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ (($currentQuestionIndex + 1) / $questions->count()) * 100 }}%"></div>
                    </div>
                @endif
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Question Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
                <div class="mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Question {{ $currentQuestionIndex + 1 }}</h2>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $currentQuestion->type_display }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $currentQuestion->points }} points
                            </span>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-900 text-lg leading-relaxed">{{ $currentQuestion->question_text }}</p>
                    </div>
                </div>

                <!-- Answer Form -->
                <form id="question-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $currentQuestion->id }}">
                    <input type="hidden" name="time_spent" id="time-spent" value="0">
                    
                    @if($currentQuestion->isMultipleChoice())
                        <div class="space-y-3">
                            @foreach($currentQuestion->getOptionsInOrder() as $index => $option)
                                <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="{{ $currentQuestion->type === 'multiple_choice_single' ? 'radio' : 'checkbox' }}" 
                                           name="answer" 
                                           value="{{ $option }}" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-900">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($currentQuestion->type === 'true_false')
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="answer" value="True" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-900">True</span>
                            </label>
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="answer" value="False" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-900">False</span>
                            </label>
                        </div>
                    @elseif($currentQuestion->type === 'fill_blank')
                        <div>
                            <input type="text" name="answer" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter your answer here...">
                        </div>
                    @elseif($currentQuestion->type === 'short_answer' || $currentQuestion->type === 'essay')
                        <div>
                            <textarea name="answer" rows="6" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Enter your answer here..."></textarea>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Navigation -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-3">
                        @if($currentQuestionIndex > 0 && $quiz->allow_navigation)
                            <button type="button" id="prev-question" 
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Previous
                            </button>
                        @endif
                        
                        @if($quiz->allow_question_skipping)
                            <button type="button" id="skip-question" 
                                    class="px-4 py-2 border border-yellow-300 text-yellow-700 rounded-md hover:bg-yellow-50 transition-colors">
                                <i class="fas fa-forward mr-2"></i>Skip
                            </button>
                        @endif
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" id="save-answer" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Save Answer
                        </button>
                        
                        @if($currentQuestionIndex === $questions->count() - 1)
                            <button type="button" id="complete-quiz" 
                                    class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                <i class="fas fa-check mr-2"></i>Complete Quiz
                            </button>
                        @else
                            <button type="button" id="next-question" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let timeSpent = 0;
        let timeInterval;
        let isAnswerSaved = false;

        // Start timer
        function startTimer() {
            timeInterval = setInterval(() => {
                timeSpent++;
                document.getElementById('time-spent').value = timeSpent;
            }, 1000);
        }

        // Stop timer
        function stopTimer() {
            if (timeInterval) {
                clearInterval(timeInterval);
            }
        }

        // Update time remaining display
        function updateTimeRemaining() {
            const timeRemainingElement = document.getElementById('time-remaining');
            if (!timeRemainingElement) return;

            const remaining = {{ $attempt->getTimeRemaining() ?? 'null' }};
            if (remaining && remaining > 0) {
                const hours = Math.floor(remaining / 3600);
                const minutes = Math.floor((remaining % 3600) / 60);
                const seconds = remaining % 60;
                timeRemainingElement.textContent = 
                    String(hours).padStart(2, '0') + ':' + 
                    String(minutes).padStart(2, '0') + ':' + 
                    String(seconds).padStart(2, '0');
            }
        }

        // Save answer
        function saveAnswer() {
            const form = document.getElementById('question-form');
            const formData = new FormData(form);
            
            // Get answer data for multiple choice multiple
            if ('{{ $currentQuestion->type }}' === 'multiple_choice_multiple') {
                const checkboxes = form.querySelectorAll('input[type="checkbox"]:checked');
                const answers = Array.from(checkboxes).map(cb => cb.value);
                formData.set('answer_data', JSON.stringify(answers));
            }

            fetch('{{ route("quizzes.submit-answer", ["quiz" => $quiz->id, "attempt" => $attempt->id]) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    isAnswerSaved = true;
                    Swal.fire({
                        icon: 'success',
                        title: 'Answer Saved!',
                        text: 'Your answer has been saved successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to save answer. Please try again.',
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while saving your answer.',
                    confirmButtonColor: '#EF4444'
                });
            });
        }

        // Navigate to next question
        function nextQuestion() {
            if (!isAnswerSaved) {
                Swal.fire({
                    title: 'Save Answer?',
                    text: 'You haven\'t saved your answer yet. Do you want to save it before proceeding?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3B82F6',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Save & Continue',
                    cancelButtonText: 'Continue Without Saving'
                }).then((result) => {
                    if (result.isConfirmed) {
                        saveAnswer();
                        setTimeout(() => {
                            window.location.href = '{{ route("quizzes.take", ["quiz" => $quiz->id, "attempt" => $attempt->id]) }}';
                        }, 1000);
                    } else {
                        window.location.href = '{{ route("quizzes.take", ["quiz" => $quiz->id, "attempt" => $attempt->id]) }}';
                    }
                });
            } else {
                window.location.href = '{{ route("quizzes.take", ["quiz" => $quiz->id, "attempt" => $attempt->id]) }}';
            }
        }

        // Complete quiz
        function completeQuiz() {
            Swal.fire({
                title: 'Complete Quiz?',
                text: 'Are you sure you want to complete this quiz? You won\'t be able to change your answers after submission.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Complete Quiz',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Save current answer first
                    saveAnswer();
                    
                    // Then complete the quiz
                    setTimeout(() => {
                        fetch('{{ route("quizzes.complete", ["quiz" => $quiz->id, "attempt" => $attempt->id]) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.redirected ? window.location.href = response.url : response.json())
                        .then(data => {
                            if (data && data.success) {
                                window.location.href = '{{ route("quizzes.show", $quiz->id) }}';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            window.location.href = '{{ route("quizzes.show", $quiz->id) }}';
                        });
                    }, 1000);
                }
            });
        }

        // Event listeners
        document.getElementById('save-answer').addEventListener('click', saveAnswer);
        document.getElementById('next-question').addEventListener('click', nextQuestion);
        document.getElementById('complete-quiz').addEventListener('click', completeQuiz);

        // Auto-save every 30 seconds
        setInterval(() => {
            if (!isAnswerSaved) {
                saveAnswer();
            }
        }, 30000);

        // Start timer
        startTimer();

        // Update time remaining every second
        setInterval(updateTimeRemaining, 1000);

        // Warn before page unload
        window.addEventListener('beforeunload', function(e) {
            if (!isAnswerSaved) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            }
        });

        // Check for time limit
        @if($quiz->time_limit && $attempt->getTimeRemaining())
            const timeLimit = {{ $attempt->getTimeRemaining() }};
            setTimeout(() => {
                Swal.fire({
                    title: 'Time\'s Up!',
                    text: 'The time limit for this quiz has been reached. Your quiz will be submitted automatically.',
                    icon: 'warning',
                    confirmButtonColor: '#F59E0B',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    completeQuiz();
                });
            }, timeLimit * 1000);
        @endif
    </script>
</body>
</html>

