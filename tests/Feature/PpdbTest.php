<?php

namespace Tests\Feature;

use App\Models\Ppdb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PpdbTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_ppdb_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('ppdb.ppdb'));

        $response->assertStatus(200);
        $response->assertSee('Data PPDB');
    }

    public function test_can_create_ppdb()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Volt::test('ppdb-form-create')
            ->set('name', 'Test PPDB')
            ->set('tahun', 2025)
            ->set('status', 'open')
            ->set('start_date', '2025-01-01')
            ->set('end_date', '2025-02-01')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('ppdb.ppdb'));

        $this->assertDatabaseHas('ppdbs', [
            'name' => 'Test PPDB',
            'tahun' => 2025,
            'status' => 'open',
        ]);
    }

    public function test_can_update_ppdb()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ppdb = Ppdb::factory()->create();

        Volt::test('ppdb-form-edit', ['id' => $ppdb->id])
            ->set('name', 'Updated PPDB Name')
            ->set('start_date', '2025-01-01')
            ->set('end_date', '2025-02-01')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('ppdb.ppdb'));

        $this->assertDatabaseHas('ppdbs', [
            'id' => $ppdb->id,
            'name' => 'Updated PPDB Name',
        ]);
    }

    public function test_can_delete_ppdb()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ppdb = Ppdb::factory()->create();

        Volt::test('ppdb-table')
            ->call('confirmDelete', $ppdb->id)
            ->call('delete')
            ->assertDispatched('delete-ppdb-confirmed');

        $this->assertDatabaseMissing('ppdbs', [
            'id' => $ppdb->id,
        ]);
    }
}
