<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_student_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.student.index'));

        $response->assertStatus(200);
        $response->assertSee('Warga Belajar');
    }

    public function test_can_create_student()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);

        Volt::test('student-form-create')
            ->set('program_id', $program->id)
            ->set('nik', '1234567890123456')
            ->set('nisn', '1234567890')
            ->set('nama_lengkap', 'Test Student')
            ->set('jenis_kelamin', 'L')
            ->set('status', 'aktif')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.student.index'));

        $this->assertDatabaseHas('students', [
            'nama_lengkap' => 'Test Student',
            'nik' => '1234567890123456',
        ]);
    }

    public function test_can_update_student()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);
        $student = Student::factory()->create(['program_id' => $program->id]);

        Volt::test('student-form-edit', ['id' => $student->id])
            ->set('nama_lengkap', 'Updated Student Name')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('student-updated');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'nama_lengkap' => 'Updated Student Name',
        ]);
    }

    public function test_can_delete_student()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);
        $student = Student::factory()->create(['program_id' => $program->id]);

        Volt::test('student-table')
            ->call('confirmDelete', $student->id)
            ->call('delete')
            ->assertDispatched('delete-student-confirmed');

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }
}
