<?php

namespace App\Controller;

use App\Entity\AddFields;
use App\Form\AddFieldsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/addFields')]
class AddFieldsController extends AbstractController
{
    #[Route('/add/{id}', name: 'app_add_fields')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        // $contact = $request->request->all();
        // $entityManager = $doctrine->getManager();

        $addFields = new AddFields();
        $form = $this->createForm(AddFieldsType::class, $addFields);
        $form->handleRequest($request);

        dd($form->getData());

        return $this->render('add_fields/add.html.twig', [
            'title' => 'Champs Additionel',
            'form' => $form->createView(),
        ]);
    }
}
