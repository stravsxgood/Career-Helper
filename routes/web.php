<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\AiAnalyses;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    | Halaman yang bisa diakses tanpa login.
    |--------------------------------------------------------------------------
    */

    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('analysis', 'analysis')->name('analysis');

    Route::livewire('/career/analyze', 'analyze')
        ->name('analyze');

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    | Halaman donwload PDF,Sampah,Analisis, dan Hasil Analisis
    |--------------------------------------------------------------------------
    */

    Route::get('/career/results/{id}', function ($id) {
        $analysis = AiAnalyses::findOrFail($id);

        $result = $analysis->output_json ?? [];

        if (is_string($result)) {
            $result = json_decode($result, true) ?? [];
        }

        return view('components.result', [
            'analysis' => $analysis,
            'result' => $result,
        ]);
    })->name('result');

    Route::get('/career/history', function () {
        $analyses = AiAnalyses::where('id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pages.history', compact('analyses'));
    })->name('history');

    Route::delete('/career/history/{id}', function ($id) {
        $analysis = AiAnalyses::where('id', Auth::id())
            ->findOrFail($id);

        $analysis->delete();

        return redirect()
            ->route('history')
            ->with('status', 'History dipindah ke Sampah');
    })->name('history.destroy');

    Route::get('/career/trash', function () {
        $analyses = AiAnalyses::onlyTrashed()
            ->where('id', Auth::id())
            ->latest('deleted_at')
            ->paginate(10);

        return view('pages.trash', compact('analyses'));
    })->name('trash');

    Route::patch('/career/trash/{id}/restore', function ($id) {
        $analysis = AiAnalyses::onlyTrashed()
            ->where('id', Auth::id())
            ->findOrFail($id);

        $analysis->restore();

        return redirect()
            ->route('trash')
            ->with('status', 'History analisis berhasil dipulihkan ke History.');
    })->name('trash.restore');

    Route::delete('/career/trash/{id}/force-delete', function ($id) {
        $analysis = AiAnalyses::onlyTrashed()
            ->where('id', Auth::id())
            ->findOrFail($id);

        $analysis->forceDelete();

        return redirect()
            ->route('trash')
            ->with('status', 'History analisis berhasil dihapus permanen.');
    })->name('trash.force-delete');

    Route::get('/career/results/{id}/download', function ($id) {
        $analysis = AiAnalyses::where('id', Auth::id())
            ->findOrFail($id);

        $result = $analysis->output_json ?? [];

        if (is_string($result)) {
            $decoded = json_decode($result, true);

            $result = json_last_error() === JSON_ERROR_NONE
                ? $decoded
                : [];
        }

        if ($result instanceof \Illuminate\Support\Collection) {
            $result = $result->toArray();
        }

        $pdf = Pdf::loadView('pdf.career-report', [
            'analysis' => $analysis,
            'result' => $result,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('career-analysis-report-' . $analysis->getKey() . '.pdf');
    })->name('result.pdf');
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Halaman yang bisa diakses tanpa login.
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

require __DIR__ . '/settings.php';

require __DIR__ . '/auth.php';
