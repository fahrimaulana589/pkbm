<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contact;
use Livewire\Volt\Volt;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_is_accessible()
    {
        // Create data for dynamic map test
        Contact::create([
            'kategori' => 'peta',
            'label' => 'Map',
            'value' => '<iframe src="https://www.google.com/maps/embed" width="600" height="450"></iframe>',
            'type' => \App\Enums\ContactType::MAP,
        ]);
        
        $response = $this->get('/kontak');

        $response->assertStatus(200);
        $response->assertSee('Kontak');
        $response->assertSee('Hubungi Kami');
        $response->assertSee('google.com/maps/embed'); // Verify Map from DB
    }

    public function test_contact_page_displays_contact_info()
    {
        Contact::create([
            'kategori' => 'kantor',
            'label' => 'Email',
            'value' => 'info@sekolah.com',
            'type' => \App\Enums\ContactType::EMAIL,
        ]);

        $response = $this->get('/kontak');

        $response->assertSee('Kantor');
        $response->assertSee('Email');
        $response->assertSee('info@sekolah.com');
    }
}
