<?php

namespace Tests\Feature;

use App\Models\Pendaftar;
use App\Models\User;
use App\Models\Program;
use App\Models\DataPpdb;
use App\Models\Ppdb;
use App\Enums\DataPpdbType;
use Livewire\Volt\Volt;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class PendaftarManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_pendaftar_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('ppdb.pendaftar.index'));
        $response->assertStatus(200);
        $response->assertSeeLivewire('pendaftar-table');
    }

    public function test_can_see_pendaftar_in_table()
    {
        $program = Program::factory()->create();
        $pendaftar = Pendaftar::factory()->create([
            'program_id' => $program->id,
            'name' => 'Test Pendaftar',
            'email' => 'test@example.com'
        ]);

        Volt::test('pendaftar-table')
            ->assertSee('Test Pendaftar')
            ->assertSee('test@example.com');
    }

    public function test_can_search_pendaftar()
    {
        $program = Program::factory()->create();
        Pendaftar::factory()->create([
            'program_id' => $program->id,
            'name' => 'Search Target',
            'email' => 'search@example.com'
        ]);
        
        Pendaftar::factory()->create([
            'program_id' => $program->id,
            'name' => 'Other Person',
            'email' => 'other@example.com'
        ]);

        Volt::test('pendaftar-table')
            ->set('search', 'Target')
            ->assertSee('Search Target')
            ->assertDontSee('Other Person');
    }

    public function test_can_delete_pendaftar()
    {
        $program = Program::factory()->create();
        $pendaftar = Pendaftar::factory()->create([
            'program_id' => $program->id,
        ]);

        Volt::test('pendaftar-table')
            ->call('confirmDelete', $pendaftar->id)
            ->call('delete');

        $this->assertDatabaseMissing('pendaftars', ['id' => $pendaftar->id]);
    }

    public function test_can_render_edit_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create();
        $pendaftar = Pendaftar::factory()->create([
            'program_id' => $program->id,
        ]);

        $response = $this->get(route('ppdb.pendaftar.edit', ['id' => $pendaftar->id]));
        $response->assertStatus(200);
        $response->assertSeeLivewire('pendaftar-form-edit');
    }

    public function test_can_update_pendaftar_core_fields()
    {
        $program = Program::factory()->create();
        $pendaftar = Pendaftar::factory()->create([
            'program_id' => $program->id,
            'name' => 'Old Name',
        ]);

        Volt::test('pendaftar-form-edit', ['id' => $pendaftar->id])
            ->set('name', 'Updated Name')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('pendaftars', [
            'id' => $pendaftar->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_can_update_pendaftar_dynamic_fields()
    {
        // Setup Metadata for Label/Type
        $ppdb = Ppdb::factory()->create(); // Although not directly linked, factory might use it
        $dataPpdb = DataPpdb::factory()->create([
            'ppdb_id' => $ppdb->id,
            'nama' => 'Hobi',
            'jenis' => DataPpdbType::TEXT
        ]);
        $key = \Illuminate\Support\Str::slug('Hobi', '_');

        $program = Program::factory()->create();
        $pendaftar = Pendaftar::factory()->create([
            'program_id' => $program->id,
            'extra_attributes' => [$key => 'Old Hobby']
        ]);

        Volt::test('pendaftar-form-edit', ['id' => $pendaftar->id])
            ->set("extra_attributes.$key", 'New Hobby')
            ->call('save')
            ->assertHasNoErrors();

        $pendaftar->refresh();
        $this->assertEquals('New Hobby', $pendaftar->extra_attributes->$key);
    }
}
