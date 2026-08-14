<?php

namespace App\Http\Controllers;

use App\Models\AiAnalyses;
use App\Models\RecordJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama dengan ringkasan metrik dan grafik real-time.
     */
    public function index(Request $request): View
    {
        return view('dashboard', [
            'metrics' => $this->calculateMetrics(),
            'statusDistribution' => $this->getStatusDistribution(),
            'monthlyTrend' => $this->getMonthlyTrend(),
            'upcomingInterviews' => $this->getUpcomingInterviews(),
            'recentApplications' => $this->getRecentApplications(),
            'latestAnalysis' => $this->getLatestAnalysis(),
        ]);
    }

    /**
     * Menghitung ringkasan statistik lamaran kerja.
     *
     * @return array<string, int>
     */
    private function calculateMetrics(): array
    {
        $totalApplications = RecordJob::count();
        $thisWeekCount = RecordJob::where('applied_at', '>=', Carbon::now()->startOfWeek())->count();
        $totalAnalyses = AiAnalyses::count();

        // Agregasi jumlah status dalam 1 query
        $statusCounts = RecordJob::query()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        $interviewCount = (int) ($statusCounts['Interview'] ?? 0);
        $testingCount = (int) ($statusCounts['Testing'] ?? 0);
        $acceptedCount = (int) ($statusCounts['Accepted'] ?? 0);
        $rejectedCount = (int) ($statusCounts['Rejected'] ?? 0);
        $appliedCount = (int) ($statusCounts['Applied'] ?? 0);

        $acceptanceRate = $totalApplications > 0 ? (int) round(($acceptedCount / $totalApplications) * 100) : 0;
        $interviewRate = $totalApplications > 0 ? (int) round(($interviewCount / $totalApplications) * 100) : 0;

        return [
            'total_applications' => $totalApplications,
            'this_week_applications' => $thisWeekCount,
            'interview_count' => $interviewCount,
            'testing_count' => $testingCount,
            'accepted_count' => $acceptedCount,
            'rejected_count' => $rejectedCount,
            'applied_count' => $appliedCount,
            'total_analyses' => $totalAnalyses,
            'acceptance_rate' => $acceptanceRate,
            'interview_rate' => $interviewRate,
        ];
    }

    /**
     * Mengambil distribusi status lamaran untuk chart donat.
     *
     * @return array{labels: array<int, string>, data: array<int, int>, percentages: array<string, int>, counts: array<string, int>, total: int}
     */
    private function getStatusDistribution(): array
    {
        $statuses = ['Applied', 'Interview', 'Testing', 'Accepted', 'Rejected'];

        $rawCounts = RecordJob::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $total = array_sum($rawCounts);
        $counts = [];
        $percentages = [];
        $data = [];

        foreach ($statuses as $status) {
            $count = (int) ($rawCounts[$status] ?? 0);
            $counts[$status] = $count;
            $percentages[$status] = $total > 0 ? (int) round(($count / $total) * 100) : 0;
            $data[] = $count;
        }

        return [
            'labels' => $statuses,
            'data' => $data,
            'percentages' => $percentages,
            'counts' => $counts,
            'total' => $total,
        ];
    }

    /**
     * Mengambil tren lamaran dan interview 6 bulan terakhir.
     *
     * @return array{labels: array<int, string>, applications: array<int, int>, interviews: array<int, int>}
     */
    private function getMonthlyTrend(): array
    {
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();
        $jobs = RecordJob::where('applied_at', '>=', $startDate)->get(['applied_at', 'status']);

        $labels = [];
        $applicationsData = [];
        $interviewsData = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $monthKey = $monthDate->format('Y-m');

            $labels[] = $monthDate->format('M');

            $monthJobs = $jobs->filter(fn ($job) => $job->applied_at && $job->applied_at->format('Y-m') === $monthKey);
            $applicationsData[] = $monthJobs->count();
            $interviewsData[] = $monthJobs->where('status', 'Interview')->count();
        }

        return [
            'labels' => $labels,
            'applications' => $applicationsData,
            'interviews' => $interviewsData,
        ];
    }

    /**
     * Mengambil daftar interview dan assessment mendatang.
     *
     * @return Collection<int, RecordJob>
     */
    private function getUpcomingInterviews(): Collection
    {
        return RecordJob::whereIn('status', ['Interview', 'Testing'])
            ->latest('applied_at')
            ->latest('id')
            ->take(4)
            ->get();
    }

    /**
     * Mengambil riwayat lamaran terbaru.
     *
     * @return Collection<int, RecordJob>
     */
    private function getRecentApplications(): Collection
    {
        return RecordJob::latest('applied_at')
            ->latest('id')
            ->take(5)
            ->get();
    }

    /**
     * Mengambil data analisis AI terakhir.
     */
    private function getLatestAnalysis(): ?AiAnalyses
    {
        return AiAnalyses::latest('created_at')->first();
    }
}
