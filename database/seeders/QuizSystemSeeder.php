<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Tag;
use App\Models\QuizAttempt;
use App\Models\QuestionResponse;
use App\Models\QuizSetting;
use App\Models\Announcement;
use Illuminate\Support\Facades\Hash;

class QuizSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@quizmaster.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create instructor users
        $instructor1 = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@quizmaster.com',
            'password' => Hash::make('password123'),
            'role' => 'instructor',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $instructor2 = User::create([
            'name' => 'Prof. Michael Chen',
            'email' => 'michael.chen@quizmaster.com',
            'password' => Hash::make('password123'),
            'role' => 'instructor',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create student users
        $student1 = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice.smith@quizmaster.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $student2 = User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob.wilson@quizmaster.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create categories
        $mathCategory = Category::create([
            'name' => 'Mathematics',
            'description' => 'Mathematical concepts and problem solving',
            'color' => '#3B82F6',
            'icon' => 'fas fa-calculator',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $scienceCategory = Category::create([
            'name' => 'Science',
            'description' => 'Scientific knowledge and principles',
            'color' => '#10B981',
            'icon' => 'fas fa-flask',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $historyCategory = Category::create([
            'name' => 'History',
            'description' => 'Historical events and knowledge',
            'color' => '#F59E0B',
            'icon' => 'fas fa-landmark',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $literatureCategory = Category::create([
            'name' => 'Literature',
            'description' => 'Literary works and analysis',
            'color' => '#8B5CF6',
            'icon' => 'fas fa-book',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // Create subcategories
        $algebraCategory = Category::create([
            'name' => 'Algebra',
            'description' => 'Algebraic concepts and equations',
            'color' => '#3B82F6',
            'icon' => 'fas fa-square-root-alt',
            'parent_id' => $mathCategory->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $physicsCategory = Category::create([
            'name' => 'Physics',
            'description' => 'Physical laws and principles',
            'color' => '#10B981',
            'icon' => 'fas fa-atom',
            'parent_id' => $scienceCategory->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Create tags
        $tags = [
            ['name' => 'Easy', 'color' => '#10B981'],
            ['name' => 'Medium', 'color' => '#F59E0B'],
            ['name' => 'Hard', 'color' => '#EF4444'],
            ['name' => 'Multiple Choice', 'color' => '#3B82F6'],
            ['name' => 'Problem Solving', 'color' => '#8B5CF6'],
            ['name' => 'Theory', 'color' => '#6B7280'],
            ['name' => 'Practice', 'color' => '#059669'],
        ];

        foreach ($tags as $tagData) {
            Tag::create([
                'name' => $tagData['name'],
                'color' => $tagData['color'],
                'is_active' => true,
            ]);
        }

        // Create quizzes
        $mathQuiz = Quiz::create([
            'title' => 'Basic Algebra Quiz',
            'description' => 'Test your knowledge of basic algebraic concepts',
            'instructor_id' => $instructor1->id,
            'category_id' => $algebraCategory->id,
            'status' => 'published',
            'access_type' => 'public',
            'time_limit' => 30,
            'max_attempts' => 3,
            'randomize_questions' => true,
            'randomize_answers' => true,
            'show_correct_answers' => true,
            'show_results_immediately' => true,
            'allow_navigation' => true,
            'require_fullscreen' => false,
            'start_date' => now()->subDays(1),
            'end_date' => now()->addDays(30),
        ]);

        $scienceQuiz = Quiz::create([
            'title' => 'Physics Fundamentals',
            'description' => 'Test your understanding of basic physics concepts',
            'instructor_id' => $instructor2->id,
            'category_id' => $physicsCategory->id,
            'status' => 'published',
            'access_type' => 'public',
            'time_limit' => 45,
            'max_attempts' => 2,
            'randomize_questions' => false,
            'randomize_answers' => true,
            'show_correct_answers' => true,
            'show_results_immediately' => true,
            'allow_navigation' => true,
            'require_fullscreen' => false,
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDays(15),
        ]);

        // Create quiz settings
        QuizSetting::create([
            'quiz_id' => $mathQuiz->id,
            'allow_question_review' => true,
            'show_question_numbers' => true,
            'show_progress_bar' => true,
            'allow_question_skipping' => true,
            'auto_submit_on_timeout' => true,
            'prevent_copy_paste' => false,
            'prevent_right_click' => false,
            'prevent_tab_switching' => false,
            'require_webcam' => false,
            'require_microphone' => false,
            'warning_before_timeout' => 5,
            'send_completion_email' => true,
            'send_results_email' => true,
        ]);

        QuizSetting::create([
            'quiz_id' => $scienceQuiz->id,
            'allow_question_review' => true,
            'show_question_numbers' => true,
            'show_progress_bar' => true,
            'allow_question_skipping' => false,
            'auto_submit_on_timeout' => true,
            'prevent_copy_paste' => true,
            'prevent_right_click' => true,
            'prevent_tab_switching' => true,
            'require_webcam' => false,
            'require_microphone' => false,
            'warning_before_timeout' => 10,
            'send_completion_email' => true,
            'send_results_email' => true,
        ]);

        // Create questions for math quiz
        $mathQuestions = [
            [
                'type' => 'multiple_choice_single',
                'question_text' => 'What is the value of x in the equation 2x + 5 = 15?',
                'options' => ['x = 5', 'x = 10', 'x = 7.5', 'x = 3'],
                'correct_answer' => ['x = 5'],
                'points' => 2,
                'difficulty_level' => 2,
                'explanation' => 'To solve: 2x + 5 = 15, subtract 5 from both sides: 2x = 10, then divide by 2: x = 5',
            ],
            [
                'type' => 'true_false',
                'question_text' => 'The equation x² + 4x + 4 = 0 has two distinct real roots.',
                'options' => ['True', 'False'],
                'correct_answer' => ['False'],
                'points' => 1,
                'difficulty_level' => 3,
                'explanation' => 'This is a perfect square trinomial: (x + 2)² = 0, so x = -2 is the only root (repeated).',
            ],
            [
                'type' => 'fill_blank',
                'question_text' => 'The slope of the line y = 3x + 2 is ____.',
                'options' => [],
                'correct_answer' => ['3', 'three'],
                'points' => 1,
                'difficulty_level' => 1,
                'explanation' => 'In the slope-intercept form y = mx + b, m is the slope, which is 3 in this case.',
            ],
        ];

        foreach ($mathQuestions as $questionData) {
            $question = Question::create([
                'quiz_id' => $mathQuiz->id,
                'category_id' => $algebraCategory->id,
                'created_by' => $instructor1->id,
                'type' => $questionData['type'],
                'question_text' => $questionData['question_text'],
                'options' => $questionData['options'],
                'correct_answer' => $questionData['correct_answer'],
                'explanation' => $questionData['explanation'],
                'points' => $questionData['points'],
                'difficulty_level' => $questionData['difficulty_level'],
                'is_active' => true,
            ]);

            // Attach tags
            $question->tags()->attach([1, 4]); // Easy, Multiple Choice
        }

        // Create questions for science quiz
        $scienceQuestions = [
            [
                'type' => 'multiple_choice_single',
                'question_text' => 'What is the acceleration due to gravity on Earth?',
                'options' => ['9.8 m/s²', '10 m/s²', '8.9 m/s²', '11 m/s²'],
                'correct_answer' => ['9.8 m/s²'],
                'points' => 2,
                'difficulty_level' => 1,
                'explanation' => 'The standard acceleration due to gravity on Earth is approximately 9.8 m/s².',
            ],
            [
                'type' => 'multiple_choice_multiple',
                'question_text' => 'Which of the following are examples of vector quantities?',
                'options' => ['Velocity', 'Speed', 'Force', 'Distance', 'Acceleration'],
                'correct_answer' => ['Velocity', 'Force', 'Acceleration'],
                'points' => 3,
                'difficulty_level' => 3,
                'explanation' => 'Vector quantities have both magnitude and direction. Velocity, force, and acceleration are vectors.',
            ],
            [
                'type' => 'short_answer',
                'question_text' => 'State Newton\'s first law of motion.',
                'options' => [],
                'correct_answer' => ['An object at rest stays at rest, and an object in motion stays in motion, unless acted upon by an external force.'],
                'points' => 5,
                'difficulty_level' => 2,
                'explanation' => 'This is the law of inertia, which describes the tendency of objects to resist changes in their state of motion.',
            ],
        ];

        foreach ($scienceQuestions as $questionData) {
            $question = Question::create([
                'quiz_id' => $scienceQuiz->id,
                'category_id' => $physicsCategory->id,
                'created_by' => $instructor2->id,
                'type' => $questionData['type'],
                'question_text' => $questionData['question_text'],
                'options' => $questionData['options'],
                'correct_answer' => $questionData['correct_answer'],
                'explanation' => $questionData['explanation'],
                'points' => $questionData['points'],
                'difficulty_level' => $questionData['difficulty_level'],
                'is_active' => true,
            ]);

            // Attach tags
            $question->tags()->attach([2, 4, 5]); // Medium, Multiple Choice, Problem Solving
        }

        // Update quiz totals
        $mathQuiz->update([
            'total_questions' => $mathQuiz->questions()->count(),
            'total_points' => $mathQuiz->questions()->sum('points'),
        ]);

        $scienceQuiz->update([
            'total_questions' => $scienceQuiz->questions()->count(),
            'total_points' => $scienceQuiz->questions()->sum('points'),
        ]);

        // Create sample quiz attempts
        $mathAttempt = QuizAttempt::create([
            'user_id' => $student1->id,
            'quiz_id' => $mathQuiz->id,
            'started_at' => now()->subHours(2),
            'completed_at' => now()->subHours(1),
            'status' => 'completed',
            'score' => 3,
            'total_points' => 4,
            'percentage' => 75.0,
            'time_spent' => 1800, // 30 minutes
            'questions_answered' => 3,
            'correct_answers' => 2,
            'incorrect_answers' => 1,
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);

        $scienceAttempt = QuizAttempt::create([
            'user_id' => $student2->id,
            'quiz_id' => $scienceQuiz->id,
            'started_at' => now()->subHours(1),
            'completed_at' => now()->subMinutes(30),
            'status' => 'completed',
            'score' => 8,
            'total_points' => 10,
            'percentage' => 80.0,
            'time_spent' => 2700, // 45 minutes
            'questions_answered' => 3,
            'correct_answers' => 2,
            'incorrect_answers' => 1,
            'ip_address' => '192.168.1.101',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        ]);

        // Create sample question responses
        $mathResponses = [
            ['question_id' => 1, 'answer' => 'x = 5', 'is_correct' => true, 'points_earned' => 2],
            ['question_id' => 2, 'answer' => 'False', 'is_correct' => true, 'points_earned' => 1],
            ['question_id' => 3, 'answer' => '3', 'is_correct' => false, 'points_earned' => 0],
        ];

        foreach ($mathResponses as $responseData) {
            QuestionResponse::create([
                'attempt_id' => $mathAttempt->id,
                'question_id' => $responseData['question_id'],
                'answer' => $responseData['answer'],
                'is_correct' => $responseData['is_correct'],
                'points_earned' => $responseData['points_earned'],
                'time_spent' => 600, // 10 minutes per question
                'answered_at' => now()->subHours(1),
                'is_graded' => true,
            ]);
        }

        $scienceResponses = [
            ['question_id' => 4, 'answer' => '9.8 m/s²', 'is_correct' => true, 'points_earned' => 2],
            ['question_id' => 5, 'answer' => '["Velocity", "Force", "Acceleration"]', 'is_correct' => true, 'points_earned' => 3],
            ['question_id' => 6, 'answer' => 'An object at rest stays at rest unless acted upon by an external force.', 'is_correct' => true, 'points_earned' => 3],
        ];

        foreach ($scienceResponses as $responseData) {
            QuestionResponse::create([
                'attempt_id' => $scienceAttempt->id,
                'question_id' => $responseData['question_id'],
                'answer' => $responseData['answer'],
                'is_correct' => $responseData['is_correct'],
                'points_earned' => $responseData['points_earned'],
                'time_spent' => 900, // 15 minutes per question
                'answered_at' => now()->subMinutes(30),
                'is_graded' => true,
            ]);
        }

        // Create announcements
        Announcement::create([
            'created_by' => $admin->id,
            'title' => 'Welcome to QuizMaster!',
            'content' => 'Welcome to our comprehensive online quiz system. You can now create, take, and manage quizzes with advanced features.',
            'type' => 'general',
            'priority' => 'high',
            'is_active' => true,
            'start_date' => now()->subDays(1),
            'end_date' => now()->addDays(30),
        ]);

        Announcement::create([
            'created_by' => $instructor1->id,
            'title' => 'New Math Quiz Available',
            'content' => 'A new Basic Algebra Quiz has been published. Test your knowledge of algebraic concepts!',
            'type' => 'quiz_specific',
            'quiz_id' => $mathQuiz->id,
            'priority' => 'medium',
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);

        $this->command->info('Quiz system seeded successfully!');
        $this->command->info('Admin: admin@quizmaster.com / password123');
        $this->command->info('Instructor: sarah.johnson@quizmaster.com / password123');
        $this->command->info('Student: alice.smith@quizmaster.com / password123');
    }
}