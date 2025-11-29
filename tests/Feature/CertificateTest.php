<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_certificate_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.sertifikat.index'));

        $response->assertStatus(200);
        $response->assertSee('Sertifikat');
    }

    public function test_can_create_certificate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);
        $student = Student::factory()->create(['program_id' => $program->id]);

        Volt::test('certificate-form-create')
            ->set('student_id', $student->id)
            ->set('program_id', $program->id)
            ->set('nomor_sertifikat', 'CERT-001')
            ->set('tanggal', '2024-01-01')
            ->set('file_pdf', '/path/to/cert.pdf')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.sertifikat.index'));

        $this->assertDatabaseHas('certificates', [
            'nomor_sertifikat' => 'CERT-001',
        ]);
    }

    public function test_can_update_certificate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);
        $student = Student::factory()->create(['program_id' => $program->id]);
        $certificate = Certificate::factory()->create([
            'student_id' => $student->id,
            'program_id' => $program->id,
        ]);

        Volt::test('certificate-form-edit', ['id' => $certificate->id])
            ->set('nomor_sertifikat', 'CERT-UPDATED')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('certificate-updated');

        $this->assertDatabaseHas('certificates', [
            'id' => $certificate->id,
            'nomor_sertifikat' => 'CERT-UPDATED',
        ]);
    }

    public function test_can_delete_certificate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);
        $student = Student::factory()->create(['program_id' => $program->id]);
        $certificate = Certificate::factory()->create([
            'student_id' => $student->id,
            'program_id' => $program->id,
        ]);

        Volt::test('certificate-table')
            ->call('confirmDelete', $certificate->id)
            ->call('delete')
            ->assertDispatched('delete-certificate-confirmed');

        $this->assertDatabaseMissing('certificates', [
            'id' => $certificate->id,
        ]);
    }
}
