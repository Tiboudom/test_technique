<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use App\Entity\Project;
use App\Form\Type\TaskType;
use App\Form\Type\ProjectType;

class TaskController extends AbstractController
{
    public function newTaskForm(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Project::class);
        $projects = $repository->findAll();
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, array('project' => $projects));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_page');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function deleteTask(Request $request): RedirectResponse
    {
        $taskId = $request->attributes->filter('task_id', false, FILTER_SANITIZE_NUMBER_INT);
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $task = $repository->find($taskId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('task_page');
    }

    public function invoiceTask(Request $request): JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];    
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        
        $taskId = $request->request->get('task_id');
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $task = $repository->find($taskId);
        $task->setInvoiced(1-$task->getInvoiced());
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        $jsonContent = $serializer->serialize($task->getInvoiced(), 'json');

        return new JsonResponse($jsonContent);
    }

    public function doneTask(Request $request): JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];    
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        
        $taskId = $request->request->get('task_id');
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $task = $repository->find($taskId);
        $task->setDone(1-$task->getDone());
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        $jsonContent = $serializer->serialize($task->getDone(), 'json');

        return new JsonResponse($jsonContent);
    }

    public function getTaskFilter(Request $request): Response
    {
        $data = $request->request->get('search');
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $task = $repository->findWithFilter($data);
        $done = count($repository->getAllFilterTaskDone($data));
        
        return $this->render('task/index.html.twig', ['list' => $task, 'done'=> $done]);
    }

    public function getTaskStats(Request $request): Response
    {
        $taskId = $request->attributes->filter('task_id', false, FILTER_SANITIZE_NUMBER_INT);
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $task = $repository->find($taskId);

        return $this->render('task/stats.html.twig', ['task' => $task]);
    }

    public function task(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $list = $repository->findAll();
        $done = count($repository->getAllTaskDone());

        return $this->render('task/index.html.twig', ['list' => $list, 'done'=> $done]);
    }
}
