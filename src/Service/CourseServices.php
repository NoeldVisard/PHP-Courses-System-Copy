<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\CourseBlock;
use Doctrine\ORM\EntityManagerInterface;

class CourseServices extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public function getAllCourses()
    {
        return $this->entityManager->getRepository(Course::class)->findAll();
    }

    public function getCourseBlocksByCourseId(int $courseId)
    {
        return $this->entityManager->getRepository(CourseBlock::class)->findAllByCourseId($courseId);
    }
}