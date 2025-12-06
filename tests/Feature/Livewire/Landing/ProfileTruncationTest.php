<?php

namespace Tests\Feature\Livewire\Landing;

use App\Models\PkbmProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ProfileTruncationTest extends TestCase
{
    use RefreshDatabase;

    public function test_visi_is_not_truncated()
    {
        $longText = str_repeat('A very long text that should not be truncated. ', 50);
        
        PkbmProfile::create([
            'nama_pkbm' => 'Test PKBM',
            'visi' => $longText,
            'misi' => 'Short mission',
            'kata_sambutan' => 'Short welcome',
        ]);

        $component = Volt::test('landing.profile');
        
        $component->assertSee($longText);
    }

    public function test_sambutan_is_not_truncated()
    {
        $longText = str_repeat('A very long welcome message that should not be truncated. ', 50);
        
        PkbmProfile::create([
            'nama_pkbm' => 'Test PKBM',
            'visi' => 'Short vision',
            'misi' => 'Short mission',
            'kata_sambutan' => $longText,
        ]);

        $component = Volt::test('landing.hero');
        
        $component->assertSee($longText);
    }
}
