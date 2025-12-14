<?php

namespace Tests\Feature;

use App\Enums\DataPpdbType;
use App\Models\DataPpdb;
use App\Models\Ppdb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class DataPpdbTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_data_ppdb_with_enum()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ppdb = Ppdb::factory()->create();

        Volt::test('data-ppdb-form-create', ['ppdbId' => $ppdb->id])
            ->set('nama', 'Test Input Text')
            ->set('jenis', DataPpdbType::TEXT) // Use Enum case
            ->set('status', 'active')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('data_ppdbs', [
            'ppdb_id' => $ppdb->id,
            'nama' => 'Test Input Text',
            'jenis' => 'text', // Stored as string value
        ]);
    }

    public function test_can_update_data_ppdb_with_enum()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ppdb = Ppdb::factory()->create();
        $dataPpdb = DataPpdb::factory()->create([
            'ppdb_id' => $ppdb->id,
            'jenis' => DataPpdbType::TEXT,
        ]);

        Volt::test('data-ppdb-form-edit', ['ppdbId' => $ppdb->id, 'id' => $dataPpdb->id])
            ->set('nama', 'Updated Input Number')
            ->set('jenis', DataPpdbType::NUMBER) // Change to Number
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('data_ppdbs', [
            'id' => $dataPpdb->id,
            'nama' => 'Updated Input Number',
            'jenis' => 'number',
        ]);
    }

    public function test_enums_are_cast_correctly_in_model()
    {
        $ppdb = Ppdb::factory()->create();
        $dataPpdb = DataPpdb::factory()->create([
            'ppdb_id' => $ppdb->id,
            'jenis' => DataPpdbType::DATE,
        ]);

        $this->assertInstanceOf(DataPpdbType::class, $dataPpdb->jenis);
        $this->assertEquals(DataPpdbType::DATE, $dataPpdb->jenis);
    }
}
