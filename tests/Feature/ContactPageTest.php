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
        // Should map to /kontak via Folio
        $response = $this->get('/kontak');

        $response->assertStatus(200);
        $response->assertSee('Kontak');
        $response->assertSee('Hubungi Kami');
    }

    public function test_contact_page_displays_contact_info()
    {
        Contact::create([
            'kategori' => 'kantor',
            'label' => 'Email',
            'value' => 'info@sekolah.com',
            'type' => 'email',
        ]);

        $response = $this->get('/kontak');

        $response->assertSee('Kantor');
        $response->assertSee('Email');
        $response->assertSee('info@sekolah.com');
    }
}
