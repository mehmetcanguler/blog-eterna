<?php

namespace App\Contracts\Internal;

use App\Dtos\Posts\PostDTO;
use App\Dtos\Posts\PostListDTO;
use App\Dtos\Posts\PostUpdateDTO;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @extends ServiceInterface<Post, PostDTO, PostUpdateDTO, PostListDTO>
 */
interface PostServiceInterface extends ServiceInterface
{
    public function publish(Post $model): Post;
    public function unPublish(Post $model): Post;

}
