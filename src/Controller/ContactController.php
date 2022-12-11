<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'title' => 'Welcome !',
        ]);
    }

    #[Route('/contact/list', name: 'app_contact_list')]
    public function list(ManagerRegistry $doctrine): Response
    {
        // get contact list from database
        $contactList = $doctrine->getRepository(Contact::class)->findAll();

        return $this->render('Contact/list.html.twig', [
            'title' => 'Liste',
            'contactList' => $contactList,
        ]);
    }

    #[Route('/contact/add', name: 'app_contact_add')]
    public function add(): Response
    {
        return $this->render('Contact/add.html.twig', [
            'title' => 'Ajouter un contact',
        ]);
    }

    #[Route('/contact/edit/{id}', name: 'app_contact_edit')]
    public function edit(Contact $contact = null, ManagerRegistry $doctrine): Response
    {
        return $this->render('Contact/edit.html.twig', [
            'title' => 'Editer un contact',
            'contact' => $contact,
        ]);
    }

    #[Route('/contact/update/{id}', name: 'app_contact_update')]
    public function update(Contact $contact = null, Request $request, ManagerRegistry $doctrine): RedirectResponse
    {
        if ($contact) {
            $contact->setLname($request->request->get('lname'));
            $contact->setFname($request->request->get('fname'));
            $contact->setTel($request->request->get('tel'));
            $contact->setMail($request->request->get('email'));
            $contact->setidGroup($request->request->get('idGroup'));

            $manager = $doctrine->getManager();
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', "Contact modifié");
        }
        else {
            $this->addFlash('error', "Contact inexistant");
        }

        return $this->redirectToRoute("list");
    }
    
    #[Route('/contact/delete/{id}', name: 'app_contact_delete')]
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

        return $this->redirectToRoute("list");
    }

    #[Route('/contact/add/sender', name: 'app_contact_sender')]
    public function sender(Request $request, ManagerRegistry $doctrine): RedirectResponse
    {
        // dd($request->request->all());
        $contact = $request->request->all();
        $entityManager = $doctrine->getManager();
        $contact = new Contact(null, $contact['lname'], $contact['fname'], $contact['tel'], $contact['email'], null, $contact['idGroup'] || null);
        $entityManager->persist($contact);
        $entityManager->flush();

        return $this->redirectToRoute("list");
    }

    #[Route('/test', name: 'test')]
    public function test(Request $request): Response
    {
        // dd($request->request->all());
        return $this->render('test/test.html.twig', [
            //Post data
            'posts' => $request->request->all(),
        ]);
    }
}
