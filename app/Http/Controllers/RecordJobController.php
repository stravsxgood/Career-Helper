<?php

namespace App\Http\Controllers;

use App\Models\RecordJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecordJobController extends Controller
{
    /**
     * Aturan validasi bersama untuk Create & Update.
     */
    private const VALIDATION_RULES = [
        'applied_at' => ['required', 'date'],
        'platform' => ['required', 'string', 'max:100'],
        'company_name' => ['required', 'string', 'max:255'],
        'position' => ['nullable', 'string', 'max:255'],
        'status' => ['nullable', 'in:Applied,Interview,Testing,Accepted,Rejected'],
        'salary' => ['nullable', 'numeric', 'min:0'],
        'job_url' => ['nullable', 'url', 'max:255'],
        'notes' => ['nullable', 'string'],
    ];

    /**
     * Menampilkan daftar riwayat lamaran kerja dengan filter & search.
     */
    public function index(Request $request): View
    {
        $jobs = RecordJob::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest('applied_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('recordjob.index', compact('jobs'));
    }

    /**
     * Menampilkan form pembuatan lamaran baru.
     */
    public function create(): View
    {
        return view('recordjob.create');
    }

    /**
     * Menyimpan data lamaran baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->sanitizeInput($request);

        $validated = $request->validate(self::VALIDATION_RULES);

        RecordJob::create($validated);

        return redirect()
            ->route('recordjob.index')
            ->with('success', 'Data lamaran berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail lamaran tertentu.
     */
    public function show(RecordJob $recordJob): View
    {
        return view('recordjob.show', [
            'job' => $recordJob,
        ]);
    }

    /**
     * Menampilkan form edit lamaran.
     */
    public function edit(RecordJob $recordJob): View
    {
        return view('recordjob.form', [
            'job' => $recordJob,
            'isEdit' => true,
        ]);
    }

    /**
     * Memperbarui data lamaran kerja di database.
     */
    public function update(Request $request, RecordJob $recordJob): RedirectResponse
    {
        $this->sanitizeInput($request);

        $validated = $request->validate(self::VALIDATION_RULES);

        $recordJob->update($validated);

        return redirect()
            ->route('recordjob.index')
            ->with('success', 'Data lamaran berhasil diperbarui!');
    }

    /**
     * Menghapus data lamaran dari database.
     */
    public function destroy(RecordJob $recordJob): RedirectResponse
    {
        $recordJob->delete();

        return redirect()
            ->route('recordjob.index')
            ->with('success', 'Data lamaran berhasil dihapus!');
    }

    /**
     * Helper sanitasi input request (Salary & Job URL).
     */
    private function sanitizeInput(Request $request): void
    {
        $merges = [];

        // 1. Bersihkan format numeric salary (hapus 'Rp', titik, spasi)
        if ($request->filled('salary')) {
            $cleanSalary = preg_replace('/[^0-9]/', '', (string) $request->salary);
            $merges['salary'] = $cleanSalary !== '' ? $cleanSalary : null;
        } elseif ($request->has('salary')) {
            $merges['salary'] = null;
        }

        // 2. Tambahkan prefix https:// otomatis jika URL tidak memiliki protokol
        if ($request->filled('job_url')) {
            $url = (string) $request->job_url;
            if (! preg_match('~^(?:f|ht)tps?://~i', $url)) {
                $url = 'https://'.$url;
            }
            $merges['job_url'] = $url;
        }

        if (! empty($merges)) {
            $request->merge($merges);
        }
    }
}
