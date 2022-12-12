<?php

namespace App\Controller;

use App\Entity\AddFields;
use App\Entity\Contact;
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
    public function add(Request $request, ManagerRegistry $doctrine, Contact $contact = null): Response
    {
        $field = new AddFields();
        $field->setContact($contact);
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(AddFieldsType::class, $field);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fields = $form->getData();
            $entityManager->persist($field);
            $entityManager->flush();

            $this->addFlash('success', "Champ Créé");
            return $this->redirectToRoute('app_contact_card', ['id' => $contact->getId()]);
        }

        return $this->render('add_fields/add.html.twig', [
            'title' => 'Ajouter un Champ',
            'form' => $form->createView(),
        ]);

    }

    #[Route('/edit/{id}', name: 'app_edit_fields')]
    public function edit(Request $request, ManagerRegistry $doctrine, AddFields $field = null): Response
    {
        $field->setContact($field);
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(AddFieldsType::class, $field);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fields = $form->getData();
            $entityManager->persist($field);
            $entityManager->flush();

            $this->addFlash('success', "Champ Créé");
            return $this->redirectToRoute('app_contact_card', ['id' => $field->getId()]);
        }

        return $this->render('add_fields/add.html.twig', [
            'title' => 'Ajouter un Champ',
            'form' => $form->createView(),
        ]);
    }

    // delete
    #[Route('/delete/{id}', name: 'app_delete_fields')]
    public function delete(ManagerRegistry $doctrine, AddFields $field = null): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($field);
        $entityManager->flush();

        $this->addFlash('success', "Champ Supprimé");
        return $this->redirectToRoute('app_contact_card', ['id' => $field->getContact()->getId()]);
    }
}
