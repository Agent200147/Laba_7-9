<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\User;
use App\Form\AddNewsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RegistrationFormType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, AuthenticationUtils $authenticationUtils): Response
    {

        $repository = $doctrine->getRepository(News::class);
        $news = $repository->findAll();
        $user = new User();
        $form_r = $this->createForm(RegistrationFormType::class, $user);
        $form_r->handleRequest($request);

        if ($form_r->isSubmitted() && $form_r->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form_r->get('plainPassword')->getData()
                )
            );
            $roles = [
            'ROLE_USER'
        ];
            $user->setRoles($roles);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirect('/#');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('index/index.html.twig', [
            'news' => $news,
            'registrationForm' => $form_r->createView(),
            'last_username' => $lastUsername, 'error' => $error,
        ]);
    }


    #[Route('/AddNews', name: 'AddNews')]
    public function AddNews(ManagerRegistry $doctrine, Request $request): Response
    {
        $new = new News();
        $form = $this->createForm(AddNewsType::class, $new);

        // $form->handleRequest($request);
        // $UserRepository = $doctrine->getRepository(User::class);
        // $user = $UserRepository->find($id);

        // if ($form->isSubmitted() && $form->isValid()) {

        //     $date = new \DateTime('@'.strtotime('now'));
        //     $new->setDateLoad($date);
        //     $new->setViewsNum(0);
        //     $new->setUser($user);  

        //     $manager = $doctrine->getManager();
        //     $manager->persist($new);
        //     $manager->flush();
        //     $status = "saved";
        // }

        // else{
        //     $status = "invalid";
        // }
        // $array = ['status' => "status"];
        return new Response(json_encode(array('status'=>$status)));;
    }



}
