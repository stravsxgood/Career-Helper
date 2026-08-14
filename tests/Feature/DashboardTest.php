<?php

use App\Models\AiAnalyses;
use App\Models\RecordJob;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
    $response->assertViewIs('dashboard');
    $response->assertViewHas(['metrics', 'statusDistribution', 'monthlyTrend', 'upcomingInterviews', 'recentApplications', 'latestAnalysis']);
});

test('dashboard displays real database metrics and records', function () {
    $user = User::factory()->create(['name' => 'Qusay Developer']);
    $this->actingAs($user);

    RecordJob::create([
        'company_name' => 'Tech Corp',
        'position' => 'Senior Laravel Dev',
        'platform' => 'LinkedIn',
        'status' => 'Interview',
        'applied_at' => now(),
        'salary' => 15000000,
    ]);

    RecordJob::create([
        'company_name' => 'Digital Solutions',
        'position' => 'Fullstack Engineer',
        'platform' => 'JobStreet',
        'status' => 'Accepted',
        'applied_at' => now(),
        'salary' => 18000000,
    ]);

    AiAnalyses::create([
        'type' => 'career_analysis',
        'input_json' => ['target_role' => 'Principal Engineer'],
        'output_json' => [
            'recommended_roles' => [
                ['role' => 'Lead Backend Engineer', 'fit_score' => 92],
            ],
            'cv_feedback' => [
                'cv_score' => 88,
            ],
        ],
        'status' => 'completed',
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Tech Corp');
    $response->assertSee('Digital Solutions');
    $response->assertSee('Lead Backend Engineer');
    $response->assertSee('Senior Laravel Dev');

    $metrics = $response->viewData('metrics');
    expect($metrics['total_applications'])->toBe(2);
    expect($metrics['interview_count'])->toBe(1);
    expect($metrics['accepted_count'])->toBe(1);
    expect($metrics['total_analyses'])->toBe(1);
});

test('dashboard handles empty state without errors', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertOk();
    $metrics = $response->viewData('metrics');
    expect($metrics['total_applications'])->toBe(0);
    expect($metrics['acceptance_rate'])->toBe(0);
    expect($metrics['interview_rate'])->toBe(0);
});
