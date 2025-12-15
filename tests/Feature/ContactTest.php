<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_contact_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('ppdb.contact.index'))
            ->assertStatus(200)
            ->assertSee('Data Kontak');
    }

    public function test_can_view_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('ppdb.contact.create'))
            ->assertStatus(200)
            ->assertSee('Informasi Kontak');
    }

    public function test_can_create_contact()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Volt::test('create-contact-form')
            ->set('kategori', 'Sosmed')
            ->set('label', 'Instagram')
            ->set('value', 'https://instagram.com/pkbm')
            ->set('type', 'link')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('ppdb.contact.index')); // Create usually redirects

        $this->assertDatabaseHas('contacts', [
            'kategori' => 'Sosmed',
            'label' => 'Instagram',
            'value' => 'https://instagram.com/pkbm',
            'type' => 'link',
        ]);
    }

    public function test_can_view_edit_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::create([
            'kategori' => 'Old Cat',
            'label' => 'Old Label',
            'value' => 'Old Value',
            'type' => 'text',
        ]);

        $this->get(route('ppdb.contact.edit', ['id' => $contact->id]))
            ->assertStatus(200)
            ->assertSee('Informasi Kontak');
    }

    public function test_can_update_contact_stay_on_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::create([
            'kategori' => 'Old Cat',
            'label' => 'Old Label',
            'value' => 'Old Value',
            'type' => 'text',
        ]);

        Volt::test('edit-contact-form', ['id' => $contact->id])
            ->set('label', 'New Label')
            ->call('save')
            ->assertHasNoErrors()
            ->assertNoRedirect() // Should stay on page
            ->assertDispatched('contact-updated'); // Should show success modal

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'label' => 'New Label',
        ]);
    }

    public function test_can_delete_contact()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::create([
            'kategori' => 'To Delete',
            'label' => 'Delete Me',
            'value' => 'Delete Value',
            'type' => 'text',
        ]);

        Volt::test('contact-table')
            ->call('confim', $contact->id) 
            ->call('delete'); 

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
}
