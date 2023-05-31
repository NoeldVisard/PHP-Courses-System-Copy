<?php

namespace App\Service;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

class CommentServices extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public function addComment(int $courseId, string $comment, int $userId)
    {
        $newComment = new Comment($userId, $comment, $courseId);
        $this->entityManager->getRepository(Comment::class)->save($newComment, true);
        return $newComment;
    }

    public function getAllCommentsByCourseId(int $courseId): array
    {
        return $this->entityManager->getRepository(Comment::class)->findBy(['courseId' => $courseId]);
    }

}