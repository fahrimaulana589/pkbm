<?php

namespace Tests\Feature;

use App\Models\DataPpdb;
use App\Models\Pendaftar;
use App\Models\Ppdb;
use App\Models\Program;
use App\Enums\DataPpdbType;
use App\Enums\PendaftarStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PendaftarRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_renders_correctly()
    {
        // Arrange
        $ppdb = Ppdb::factory()->create(['status' => 'open']);
        $program = Program::factory()->create();

        // Act & Assert
        Volt::test('landing.ppdb-register-form')
            ->assertSee('Formulir Pendaftaran')
            ->assertSee($ppdb->name);
    }

    public function test_registration_success_with_dynamic_attributes()
    {
        // Arrange
        $ppdb = Ppdb::factory()->create(['status' => 'open']);
        $program = Program::factory()->create();
        
        // Dynamic Attribute
        $attr = DataPpdb::factory()->create([
            'ppdb_id' => $ppdb->id,
            'nama' => 'Ukuran Baju',
            'jenis' => DataPpdbType::TEXT,
            'status' => 'active'
        ]);

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Test No. 1',
            'birth_place' => 'Jakarta',
            'birth_date' => '2005-01-01',
            'program_id' => $program->id,
            'extra_attributes' => [
                'ukuran_baju' => 'XL'
            ]
        ];

        // Act
        Volt::test('landing.ppdb-register-form')
            ->set('name', $data['name'])
            ->set('email', $data['email'])
            ->set('phone', $data['phone'])
            ->set('address', $data['address'])
            ->set('birth_place', $data['birth_place'])
            ->set('birth_date', $data['birth_date'])
            ->set('program_id', $data['program_id'])
            ->set('extra_attributes.ukuran_baju', $data['extra_attributes']['ukuran_baju'])
            ->call('save')
            ->assertRedirect(route('ppdb.check'));

        // Assert
        $this->assertDatabaseHas('pendaftars', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'ppdb_id' => $ppdb->id,
            'program_id' => $program->id,
            'status' => PendaftarStatus::TERDAFTAR,
        ]);

        $pendaftar = Pendaftar::where('email', 'john@example.com')->first();
        $this->assertNotNull($pendaftar->code);
        $this->assertEquals('XL', $pendaftar->extra_attributes->ukuran_baju);
    }

    public function test_registration_validation_required_fields()
    {
         $ppdb = Ppdb::factory()->create(['status' => 'open']);
         
         Volt::test('landing.ppdb-register-form')
            ->call('save')
            ->assertHasErrors(['name', 'email', 'phone', 'address', 'program_id']);
    }

    public function test_registration_fails_when_no_active_ppdb()
    {
        // Ensure no active PPDB
        Ppdb::query()->update(['status' => 'closed']);

        Volt::test('landing.ppdb-register-form')
            ->assertSee('Pendaftaran Ditutup')
            ->assertDontSee('Formulir Pendaftaran');
    }
}
