<?php

namespace Tests\Feature;

use App\Models\RecordJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecordJobTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_user_dapat_melihat_halaman_index_record_job()
    {
        $response = $this->actingAs($this->user)
            ->get(route('recordjob.index'));

        $response->assertStatus(200);
        $response->assertViewIs('recordjob.index');
    }

    public function test_user_dapat_menambah_record_job_baru()
    {
        $data = [
            'company_name' => 'PT Teknologi Perkasa',
            'position' => 'Backend Developer',
            'platform' => 'LinkedIn',
            'status' => 'Applied',
            'applied_at' => '2026-08-10',
            'salary' => 'Rp 8.000.000',
            'job_url' => 'https://linkedin.com/jobs/123',
            'notes' => 'Lamaran dikirim via web',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('recordjob.store'), $data);

        $response->assertRedirect(route('recordjob.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('record_jobs', [
            'company_name' => 'PT Teknologi Perkasa',
            'salary' => 8000000,
        ]);
    }

    public function test_user_dapat_memperbarui_data_record_job()
    {
        $job = RecordJob::create([
            'company_name' => 'PT Lama Mandiri',
            'position' => 'Junior Dev',
            'platform' => 'JobStreet',
            'status' => 'Applied',
            'applied_at' => '2026-08-01',
            'salary' => 5000000,
        ]);

        $updatedData = [
            'company_name' => 'PT Lama Mandiri (Updated)',
            'position' => 'Senior Dev',
            'platform' => 'JobStreet',
            'status' => 'Interview',
            'applied_at' => '2026-08-05',
            'salary' => 'Rp 10.000.000',
            'job_url' => 'jobstreet.co.id/job/99',
            'notes' => 'Lolos tahap interview 1',
        ];

        $response = $this->actingAs($this->user)
            ->put(route('recordjob.update', $job->id), $updatedData);

        $response->assertRedirect(route('recordjob.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('record_jobs', [
            'id' => $job->id,
            'company_name' => 'PT Lama Mandiri (Updated)',
            'status' => 'Interview',
            'salary' => 10000000,
            'job_url' => 'https://jobstreet.co.id/job/99',
        ]);
    }

    public function test_user_dapat_menghapus_record_job()
    {
        $job = RecordJob::create([
            'company_name' => 'PT Hapus Sejahtera',
            'position' => 'QA Engineer',
            'platform' => 'KitaLulus',
            'status' => 'Rejected',
            'applied_at' => '2026-08-01',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('recordjob.destroy', $job->id));

        $response->assertRedirect(route('recordjob.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('record_jobs', [
            'id' => $job->id,
        ]);
    }
}
