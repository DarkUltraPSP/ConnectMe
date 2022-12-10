<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'title' => 'Welcome',
        ]);
    }

    #[Route('/contact/list', name: 'app_contact_list')]
    public function list(): Response
    {
        return $this->render('list/index.html.twig', [
            'title' => 'Liste de contacts',
        ]);
    }

    #[Route('/contact/add', name: 'app_contact_add')]
    public function add(): Response
    {
        return $this->render('add/add.html.twig', [
            'title' => 'Ajouter un contact',
        ]);
    }
}
