<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/users', name: 'users')]
    public function users(UserRepository $userRepository)
    {
        $users = $userRepository->findAllWithDeliveryData();

        return $this->render('users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/edit/user/{id}', name: 'edit_user')]
    public function editUser(Request $request, User $user, UserRepository $userRepository): Response
    {
        $d = $userRepository->findUserWithDeliveryData($user);
        $form = $this->createForm(UserType::class, $d);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {;
            $this->entityManager->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->render('edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/user/{id}', name: 'delete_user')]
    public function deleteUser(User $user): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if (!$user) {
            return $this->redirectToRoute('users');
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('users');
    }

    #[Route('/add/user', name: 'add_user')]
    public function addUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users');
        }

        return $this->render('add_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
