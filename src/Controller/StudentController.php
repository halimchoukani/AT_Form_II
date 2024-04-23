<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\StudentType;
use App\Entity\Student;

class StudentController extends AbstractController
{
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    #[Route('/student', name: 'app_student')]
    public function index(Request $request)
    {


        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$student` variable has also been updated
            $student = $form->getData();
            // saving the task to the database
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($student);
            $entityManager->flush();
            //return $this->redirectToRoute('confirm');
        }
        return $this->render('student/index.html.twig', ['form' => $form->createView(),]);
    }
}
