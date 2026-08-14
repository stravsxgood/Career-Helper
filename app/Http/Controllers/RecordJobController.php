<?php

namespace App\Http\Controllers;

use App\Models\RecordJob;
use Illuminate\Http\Request;

class RecordJobController extends Controller
{
    /**
     * Tampilkan daftar lamaran kerja.
     */
    public function index(Request $request)
    {
        $query = RecordJob::query();

        // 1. Logika Pencarian (Berdasarkan Company Name atau Position)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");
            });
        }

        // 2. Logika Filter Berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data dengan pagination dan pertahankan query string saat pindah halaman
        $jobs = $query->latest('applied_at')->latest('id')->paginate(10)->withQueryString();

        return view('recordjob.index', compact('jobs'));
    }

    /**
     * Tampilkan form untuk menambah lamaran baru.
     */
    public function create()
    {
        return view('recordjob.create');
    }

    /**
     * Simpan lamaran baru ke database.
     */
    public function store(Request $request)
    {
        // Clean input salary (hapus 'Rp', titik, atau spasi jika dikirim dari frontend)
        if ($request->has('salary')) {
            $request->merge([
                'salary' => preg_replace('/[^0-9]/', '', $request->salary)
            ]);
        }

        $validated = $request->validate([
            'applied_at'   => 'required|date',
            'platform'     => 'required|string|max:100',
            'company_name' => 'required|string|max:255',
            'position'     => 'nullable|string|max:255',
            'status'       => 'nullable|in:Applied,Interview,Testing,Accepted,Rejected',
            'salary'       => 'nullable|numeric|min:0',
            'job_url'      => 'nullable|url|max:255',
            'notes'        => 'nullable|string',
        ]);

        RecordJob::create($validated);

        return redirect()
            ->route('recordjob.index')
            ->with('success', 'Data lamaran berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail lamaran kerja tertentu.
     */
    public function show(RecordJob $recordJob)
    {
        return view('recordjob.show', [
            'job' => $recordJob
        ]);
    }

    /**
     * Tampilkan form untuk mengedit lamaran.
     */
    public function edit(string $id)
    {
        $job = RecordJob::findOrFail($id);

        return view('recordjob.form', [
            'job'    => $job,   // Pastikan nama key-nya 'job' (bukan 'recordjob')
            'isEdit' => true    // Wajib true
        ]);
    }

    /**
     * Perbarui data lamaran di database.
     */
    public function update(Request $request, RecordJob $recordjob)
    {
        // 1. Clean Salary (Ubah string kosong menjadi null agar lolos validasi)
        if ($request->filled('salary')) {
            $cleanSalary = preg_replace('/[^0-9]/', '', $request->salary);
            $request->merge([
                'salary' => $cleanSalary !== '' ? $cleanSalary : null
            ]);
        } else {
            $request->merge(['salary' => null]);
        }

        // 2. Clean Job URL (Otomatis tambahkan https:// jika pengguna tidak mengetiknya)
        if ($request->filled('job_url')) {
            $url = $request->job_url;
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "https://" . $url;
            }
            $request->merge(['job_url' => $url]);
        }

        // 3. Validasi Input
        $validated = $request->validate([
            'applied_at'   => 'required|date',
            'platform'     => 'required|string|max:100',
            'company_name' => 'required|string|max:255',
            'position'     => 'nullable|string|max:255',
            'status'       => 'nullable|in:Applied,Interview,Testing,Accepted,Rejected',
            'salary'       => 'nullable|numeric|min:0',
            'job_url'      => 'nullable|url|max:255',
            'notes'        => 'nullable|string',
        ]);

        // 4. Update Data ke Database
        $recordjob->update($validated);

        return redirect()
            ->route('recordjob.index')
            ->with('success', 'Data lamaran berhasil diperbarui!');
    }

    /**
     * Hapus data lamaran dari database.
     */
    public function destroy(RecordJob $recordjob)
    {
        $recordjob = RecordJob::findOrFail($recordjob->id);
        $recordjob->delete();


        return redirect()
            ->route('recordjob.index')
            ->with('success', 'Data lamaran berhasil dihapus!');
    }
}
