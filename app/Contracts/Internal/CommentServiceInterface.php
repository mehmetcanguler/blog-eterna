<?php

namespace App\Contracts\Internal;

use App\Dtos\Comments\CommentDTO;
use App\Dtos\Comments\CommentListDTO;
use App\Dtos\Comments\CommentUpdateDTO;
use App\Models\Comment;

/**
 * @extends ServiceInterface<Comment, CommentDTO, CommentUpdateDTO, CommentListDTO>
 */
interface CommentServiceInterface extends ServiceInterface
{
    public function publish(Comment $model): Comment;
    public function unPublish(Comment $model): Comment;
}
