<?php

namespace App\Controller;

use App\Service\CommentServices;
use App\Service\CourseServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

class CoursesController extends AbstractController
{
    #[Route('/courses', name: 'app_courses')]
    public function index(CourseServices $courseServices): Response
    {
        $courses = $courseServices->getAllCourses();
        return $this->render('courses/index.html.twig', [
            'controller_name' => 'CoursesController',
            'courses' => $courses,
        ]);
    }

    #[Route('/courses/{courseId}', methods:['GET'], name: 'app_course')]
    public function getCourse(CourseServices $courseServices, CommentServices $commentServices, int $courseId): Response
    {
        $courseBlocks = $courseServices->getCourseBlocksByCourseId($courseId);
//        $courseBlocks[0]["comments"] = $commentServices->getAllCommentsByCourseId($courseId);
        $commentsArr = $commentServices->getAllCommentsByCourseId($courseId);
        foreach ($commentsArr as $commentsObj) {
            $courseBlocks[0]["comments"][] = $commentsObj->getComment();
        }
//        var_dump($courseBlocks[0]["comments"]);
//        exit;
        return new JsonResponse($courseBlocks);
    }

    #[Route('/courses/add-comment', methods: ['POST'], name: 'app_add_comment')]
    public function addComment(CommentServices $commentServices)
    {
        $comment = $_POST["comment"];
        $courseId = (int) $_POST["course"];
        $newComment = $commentServices->addComment($courseId, $comment, $this->getUser()->getId());
//        return new JsonResponse(array('id' => $newComment->getId(), 'comment' => $newComment->getComment()));
        return $this->redirect('http://127.0.0.1:8000/courses/');
    }
}
