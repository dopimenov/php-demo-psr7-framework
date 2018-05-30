<?php

namespace App\UseCase\Post\Edit;

use App\Entity\Post\Meta;
use App\Repository\PostRepository;
use App\Repository\UnitOfWork;

class Handler
{
    private $posts;
    private $uow;

    public function __construct(PostRepository $posts, UnitOfWork $uow)
    {
        $this->posts = $posts;
        $this->uow = $uow;
    }

    public function handle(Command $command): int
    {
        $post = $this->posts->get($command->id);

        $post->edit(
            $command->title,
            $command->content,
            new Meta(
                $command->metaTitle,
                $command->metaDescription
            )
        );

        $this->posts->add($post);
        $this->uow->commit();

        return $post->getId();
    }
}
