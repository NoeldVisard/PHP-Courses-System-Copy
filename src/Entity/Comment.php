<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?int $courseId = null;

    /**
     * @param int|null $userId
     * @param string|null $comment
     * @param int|null $courseId
     */
    public function __construct(?int $userId, ?string $comment, ?int $courseId)
    {
        $this->userId = $userId;
        $this->comment = $comment;
        $this->courseId = $courseId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCourseId(): ?int
    {
        return $this->courseId;
    }

    public function setCourseId(int $courseId): self
    {
        $this->courseId = $courseId;

        return $this;
    }
}
