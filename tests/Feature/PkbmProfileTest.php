<?php

namespace Tests\Feature;

use App\Models\PkbmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PkbmProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_pkbm_profile_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.pkbm-profile.index'));

        $response->assertStatus(200);
        $response->assertSee('Profil PKBM');
    }

    public function test_can_update_pkbm_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Ensure a profile exists (via seeder logic or factory)
        $profile = PkbmProfile::create([
            'nama_pkbm' => 'Old Name',
            'npsn' => '12345678',
            'alamat' => 'Jl. Lama',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Coblong',
            'desa' => 'Dago',
            'telepon' => '08123456789',
            'email' => 'old@example.com',
            'kepala_pkbm' => 'Old Head',
            'visi' => 'Old Vision',
            'misi' => 'Old Mission',
            'logo' => 'pkbm/logo/old.jpg',
        ]);

        Volt::test('pkbm-profile-form')
            ->set('nama_pkbm', 'New PKBM Name')
            ->set('npsn', '87654321')
            ->set('alamat', 'Jl. Baru')
            ->set('provinsi', 'Jawa Tengah')
            ->set('kota', 'Semarang')
            ->set('kecamatan', 'Banyumanik')
            ->set('desa', 'Srondol')
            ->set('telepon', '08987654321')
            ->set('email', 'new@example.com')
            ->set('kepala_pkbm', 'New Head')
            ->set('visi', 'New Vision')
            ->set('misi', 'New Mission')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('profile-updated');

        $this->assertDatabaseHas('pkbm_profiles', [
            'id' => $profile->id,
            'nama_pkbm' => 'New PKBM Name',
            'npsn' => '87654321',
        ]);
    }

    /**
     * Test updating PKBM profile with welcome message.
     */
    public function test_pkbm_profile_can_be_updated_with_welcome_message(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Ensure a profile exists (or create one if not)
        PkbmProfile::create([
            'nama_pkbm' => 'PKBM Initial',
            'npsn' => '00000000',
            'alamat' => 'Jl. Initial',
            'provinsi' => 'Initial',
            'kota' => 'Initial',
            'kecamatan' => 'Initial',
            'desa' => 'Initial',
            'telepon' => '00000000000',
            'email' => 'initial@example.com',
            'kepala_pkbm' => 'Initial Head',
            'visi' => 'Initial Vision',
            'misi' => 'Initial Mission',
            'logo' => 'pkbm/logo/initial.png',
        ]);

        Livewire::test('pkbm-profile-form')
            ->set('nama_pkbm', 'PKBM Test')
            ->set('npsn', '12345678')
            ->set('alamat', 'Jl. Test')
            ->set('provinsi', 'Jawa Barat')
            ->set('kota', 'Bandung')
            ->set('kecamatan', 'Cicendo')
            ->set('desa', 'Sukamulya')
            ->set('telepon', '08123456789')
            ->set('email', 'test@example.com')
            ->set('kepala_pkbm', 'Kepala Test')
            ->set('visi', 'Visi Test')
            ->set('misi', 'Misi Test')
            ->set('kata_sambutan', 'Selamat Datang di PKBM Test')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('pkbm_profiles', [
            'nama_pkbm' => 'PKBM Test',
            'kata_sambutan' => 'Selamat Datang di PKBM Test',
        ]);
    }

    public function test_can_upload_logo()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Storage::fake('public');

        $profile = PkbmProfile::create([
            'nama_pkbm' => 'PKBM Test',
            'npsn' => '12345678',
            'alamat' => 'Jl. Test',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Coblong',
            'desa' => 'Dago',
            'telepon' => '08123456789',
            'email' => 'test@example.com',
            'kepala_pkbm' => 'Test Head',
            'visi' => 'Test Vision',
            'misi' => 'Test Mission',
        ]);

        $file = UploadedFile::fake()->image('logo.png');

        Volt::test('pkbm-profile-form')
            ->set('new_logo', $file)
            ->call('save')
            ->assertHasNoErrors();

        $profile->refresh();
        $this->assertNotNull($profile->logo);
        Storage::disk('public')->assertExists($profile->logo);
    }
}
