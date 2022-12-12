<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Group;
use App\Form\GroupeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group')]
class GroupController extends AbstractController
{
    #[Route('/list', name: 'app_group_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $groupList = $doctrine->getRepository(Group::class)->findAll();

        return $this->render('group/list.html.twig', [
            'title' => 'Liste de groupe',
            'groupList' => $groupList
        ]);
    }

    #[Route('/add', name: 'app_group_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $group = new Group();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(GroupeType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();

            $entityManager->persist($group);
            $entityManager->flush();

            return $this->redirectToRoute('app_group_list');
        }

        return $this->render('group/add.html.twig', [
            'title' => 'Ajouter un groupe',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show/{id}', name: 'app_group_show')]
    public function show(ManagerRegistry $doctrine, Group $group = null): Response
    {
        $groupList = $doctrine->getRepository(Contact::class);
        $groupList = $groupList->findBy(["groupe" => $group->getId()]);
        return $this->render('group/show.html.twig', [
            'title' => 'Afficher un groupe',
            'groupList' => $groupList,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_group_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, Group $group = null): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(GroupeType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_group_list');
        }

        return $this->render('group/add.html.twig', [
            'title' => 'Ajouter un groupe',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_group_delete')]
    public function delete(ManagerRegistry $doctrine, Group $group = null): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($group);
        $entityManager->flush();

        return $this->redirectToRoute('app_group_list');
    }
}
