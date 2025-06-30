<?php

namespace App\Console\Commands;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Console\Command;

class PostsDeleteUnComment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:posts-delete-un-comment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yorum almamış postları siler';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::whereDoesntHave('comments')
            ->where('status', PostStatus::PUBLISHED)
            ->whereBetween('published_at', [now()->subDays(7), now()])
            ->lazy();
        foreach ($posts as $post) {
            $post->delete();
        }

        $this->info('Son 7 günde Yorum almamış postları silindi');
    }
}
