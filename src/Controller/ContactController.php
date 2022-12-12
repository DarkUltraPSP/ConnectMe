<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Group;
use App\Form\ContactType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    #[Route('/list', name: 'app_contact_list')]
    public function list(ManagerRegistry $doctrine): Response
    {
        // get contact list from database
        $contactList = $doctrine->getRepository(Contact::class)->findAll();

        return $this->render('Contact/list.html.twig', [
            'title' => 'Liste',
            'contactList' => $contactList,
        ]);
    }

    #[Route('/add', name: 'app_contact_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $contact = $request->request->all();
        $entityManager = $doctrine->getManager();
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success', "Contact ajouté");
            return $this->redirectToRoute('app_contact_list');
        }

        return $this->render('Contact/add.html.twig', [
            'title' => 'Ajouter un contact',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_contact_edit')]
    public function edit(Contact $contact = null, ManagerRegistry $doctrine): Response
    {
        $groups = $doctrine->getRepository(Group::class)->findAll();
        return $this->render('Contact/edit.html.twig', [
            'title' => 'Editer un contact',
            'contact' => $contact,
            'groups' => $groups,
        ]);
    }

    #[Route('/update/{id}', name: 'app_contact_update')]
    public function update(Contact $contact = null, Request $request, ManagerRegistry $doctrine): RedirectResponse
    {
        if ($contact) {
            $contact->setLname($request->request->get('lname'));
            $contact->setFname($request->request->get('fname'));
            $contact->setTel($request->request->get('tel'));
            $contact->setMail($request->request->get('email'));

            $manager = $doctrine->getManager();
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', "Contact modifié");
        }
        else {
            $this->addFlash('error', "Contact inexistant");
        }

        return $this->redirectToRoute("app_contact_list");
    }
    
    #[Route('/delete/{id}', name: 'app_contact_delete')]
    public function delete(Contact $contact = null, ManagerRegistry $doctrine): RedirectResponse
    {
        if ($contact) {
            $manager = $doctrine->getManager();
            $manager->remove($contact);
            $manager->flush();

            $this->addFlash('success', "Contact supprimé");
        }
        else {
            $this->addFlash('error', "Contact inexistant");
        }

        return $this->redirectToRoute("app_contact_list");
    }

    #[Route('/card/{id}', name: 'app_contact_card')]
    public function card(Contact $contact = null, ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Contact::class);
        $contact = $repo->find(['id' => $contact->getId()]);

        return $this->render('Contact/card.html.twig', [
            'title' => 'Profil',
            'contact' => $contact,
        ]);
    }
}
