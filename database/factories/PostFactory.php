<?php

namespace Database\Factories;

use Http;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::factory();
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(5, true),
            'status' => PostStatus::PUBLISHED,
            'author_id' => $user,
            'published_at' => now(),
            'created_by' => $user,
            'updated_by' => $user
        ];
    }
    public function configure(): static
    {
        return $this->afterCreating(function (Post $post) {
            $factory = $this;
            $coverPath = $this->downloadImage('cover');
            $post->setCoverImage(new UploadedFile(
                $coverPath,
                basename($coverPath),
                'image/jpeg',
                null,
                true
            ));

            $galleryFiles = collect(range(1, 2))->map(function ($i) use ($factory) {
                $path = $factory->downloadImage("gallery_$i");
                return new UploadedFile(
                    $path,
                    basename($path),
                    'image/jpeg',
                    null,
                    true
                );
            })->all();

            $post->setGalleryImages($galleryFiles);


            // Kategorileri ekle
            $post->categories()->sync(\App\Models\Category::factory(2)->create());
        });

    }

    public function downloadImage(string $name): string
    {
        $url = "https://picsum.photos/800/600?random=" . rand(1, 10000);
        $contents = Http::get($url)->body();

        $path = storage_path("app/public/{$name}.jpg");
        Storage::disk('public')->put("{$name}.jpg", $contents);

        return $path;
    }
}
