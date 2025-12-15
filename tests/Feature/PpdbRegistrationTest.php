<?php

namespace Tests\Feature;

use App\Enums\DataPpdbType;
use App\Models\DataPpdb;
use App\Models\Ppdb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PpdbRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_registration_form()
    {
        // Create active PPDB
        $ppdb = Ppdb::factory()->create(['status' => 'open']);
        
        // Assert component renders
        Volt::test('landing.ppdb-register-form')
            ->assertSee('Formulir Pendaftaran')
            ->assertSeeHtml('name="name"') // Standard field
            ->assertSeeHtml('name="email"')
            ->assertSeeHtml('name="address"');
    }

    public function test_renders_dynamic_fields()
    {
        $ppdb = Ppdb::factory()->create(['status' => 'open']);
        
        // Create dynamic attribute
        DataPpdb::factory()->create([
            'ppdb_id' => $ppdb->id,
            'nama' => 'Hobi',
            'jenis' => DataPpdbType::TEXT,
            'status' => 'active',
        ]);

        Volt::test('landing.ppdb-register-form')
             ->assertSee('Hobi') // Label
             ->assertSee('Hobi') // Label
             ->assertSeeHtml('name="hobi"'); // Field name is slugified

    }

    public function test_can_submit_registration()
    {
        $ppdb = Ppdb::factory()->create(['status' => 'open']);
        
        DataPpdb::factory()->create([
            'ppdb_id' => $ppdb->id,
            'nama' => 'Asal Sekolah',
            'jenis' => DataPpdbType::TEXT,
            'status' => 'active',
        ]);

        Volt::test('landing.ppdb-register-form')
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '08123456789')
            ->set('address', 'Jl. Merdeka No. 1')
            ->set('nik', '1234567890123456')
            ->set('nisn', '1234567890')
            ->set('jenis_kelamin', 'L')
            ->set('program_id', \App\Models\Program::factory()->create()->id)
            ->set('birth_place', 'Jakarta')
            ->set('birth_date', '2000-01-01')
            ->set('extra_attributes.asal_sekolah', 'SMA 1 Jakarta')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('ppdb.check'));

        $this->assertDatabaseHas('pendaftars', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            // Check JSON column? 
            // AssertDatabaseHas for JSON is tricky with standard array, 
            // but we can check if record exists.
        ]);
        
        $pendaftar = \App\Models\Pendaftar::where('email', 'john@example.com')->first();
        $this->assertEquals('SMA 1 Jakarta', $pendaftar->extra_attributes->get('asal_sekolah') ?? $pendaftar->extra_attributes['asal_sekolah']);
    }
}
