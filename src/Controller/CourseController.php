<?php

namespace App\Controller;

use App\Entity\Course;
use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseController
 * @package App\Controller
 * @Route("/courses", name="course_")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        return $this->json([
            'data' => $courses
        ]);
    }

    /**
     * @Route("/{courseId}", name="show", methods={"GET"})
     * @param int $courseId
     * @return JsonResponse
     */
    public function show(int $courseId): JsonResponse
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($courseId);

        return $this->json([
            'data' => $course
        ]);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $course = new Course();
        $course->setName($data['name']);
        $course->setDescription($data['description']);
        $course->setSlug($data['slug']);
        $course->setCreatedAt(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));
        $course->setUpdatedAt(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();

        $doctrine->persist($course);
        $doctrine->flush();

        return $this->json([
            'msg' => 'Curso criado com sucesso!'
        ]);
    }

    /**
     * @Route("/{courseId}", name="update", methods={"PUT", "PATCH"})
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(int $courseId, Request $request): JsonResponse
    {
        $data = $request->request->all();
        $doctrine = $this->getDoctrine();

        $course = $doctrine->getRepository(Course::class)->find($courseId);

        if ($request->request->has($data['name']))
            $course->setName($data['name']);

        if ($request->request->has($data['description']))
            $course->setDescription($data['description']);

        if ($request->request->has($data['slug']))
            $course->setSlug($data['slug']);

        $course->setUpdatedAt(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'msg' => 'Curso atualizado com sucesso!'
        ]);
    }

    /**
     * @Route("/{courseId}", name="delete", methods={"DELETE"})
     * @param int $courseId
     * @return JsonResponse
     */
    public function delete(int $courseId): JsonResponse
    {
        $doctrine = $this->getDoctrine();
        $course = $doctrine->getRepository(Course::class)->find($courseId);

        $manager = $doctrine->getManager();
        $manager->remove($course);
        $manager->flush();

        return $this->json([
            'msg' => 'Curso removido com sucesso!'
        ]);
    }
}
