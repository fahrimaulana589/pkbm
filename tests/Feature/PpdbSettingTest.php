<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PpdbSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_ppdb_settings_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/ppdb/setting')
            ->assertStatus(200)
            ->assertSee('Sambutan PPDB');
    }

    public function test_guest_cannot_access_ppdb_settings_page()
    {
        $this->get('/ppdb/setting')
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_update_ppdb_settings()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('foto.jpg');

        $component = Volt::test('ppdb.setting-form')
            ->set('ppdb_sambutan', 'Ini sambutan baru')
            ->set('ppdb_alur', 'Ini alur pendaftaran')
            ->set('ppdb_foto', $file);

        $component->call('save');

        $component->assertHasNoErrors();

        $this->assertDatabaseHas('settings', [
            'ppdb_sambutan' => 'Ini sambutan baru',
            'ppdb_alur' => 'Ini alur pendaftaran',
        ]);

        $setting = Setting::first();
        Storage::disk('public')->assertExists($setting->ppdb_foto);
    }

    public function test_public_can_view_ppdb_settings_on_landing_page()
    {
        // Must have active PPDB for Alur to show
        \App\Models\Ppdb::create([
            'tahun' => '2025',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'open',
            'name' => 'Batch 1'
        ]);

        $setting = Setting::create([
            'email_server' => 'smtp.example.com',
            'email_port' => '587',
            'email_username' => 'test',
            'email_password' => 'test',
            'ppdb_sambutan' => 'Selamat Datang di PPDB',
            'ppdb_alur' => 'Langkah 1: Daftar',
        ]);

        $this->get('/ppdb-pkbm')
            ->assertStatus(200)
            ->assertSee('Selamat Datang di PPDB')
            ->assertSee('Langkah 1: Daftar');
    }

    public function test_landing_page_shows_closed_message_when_no_active_ppdb()
    {
        // Ensure no active PPDB
        \App\Models\Ppdb::query()->update(['status' => 'closed']);

        Setting::create([
            'email_server' => 'smtp.example.com',
            'email_port' => '587',
            'email_username' => 'test',
            'email_password' => 'test',
            'ppdb_sambutan' => 'Halo',
            'ppdb_alur' => 'Alur',
        ]);

        $this->get('/ppdb-pkbm')
            ->assertSee('Pendaftaran Ditutup')
            ->assertDontSee('Langkah 1: Daftar') // Alur hidden
            ->assertDontSee('Selamat Datang'); // Sambutan hidden
    }

    public function test_register_page_shows_closed_message_when_no_active_ppdb()
    {
        // Ensure no active PPDB
        \App\Models\Ppdb::query()->update(['status' => 'closed']);

        $this->get(route('ppdb.daftar'))
            ->assertStatus(200)
            ->assertSee('Pendaftaran Ditutup');
    }
}
