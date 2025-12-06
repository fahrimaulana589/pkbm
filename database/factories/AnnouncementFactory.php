<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = $this->faker->sentence(4);
        $kategori = ['Umum', 'Akademik', 'Kesiswaan', 'Kepegawaian', 'Kegiatan', 'Darurat'];
        $prioritas = ['Normal', 'Tinggi', 'Penting'];
        $status = ['draft', 'dipublikasikan', 'kadaluarsa', 'terjadwal'];

        $imageFaker = new \Alirezasedghi\LaravelImageFaker\ImageFaker(new \Alirezasedghi\LaravelImageFaker\Services\LoremFlickr());
        $path = storage_path('app/public/announcements/thumbnails');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        $filename = $imageFaker->image($path, 640, 480, false);
        $thumbnail = 'announcements/thumbnails/' . $filename;

        return [
            'judul' => $judul,
            'slug' => \Illuminate\Support\Str::slug($judul),
            'isi' => $this->faker->paragraph(5),
            'kategori' => $this->faker->randomElement($kategori),
            'prioritas' => $this->faker->randomElement($prioritas),
            'status' => $this->faker->randomElement($status),
            'lampiran_file' => $this->faker->word() . '.pdf',
            'thumbnail' => $thumbnail,
            'published_at' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween('-1 month', '+1 month') : null,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'penulis_id' => User::factory(),
        ];
    }
}