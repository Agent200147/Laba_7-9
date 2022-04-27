<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\News;
use App\Entity\User;
use App\Entity\Comments;

use App\Form\AddNewsType;
use App\Form\AddCommentType;
use App\Form\RegistrationFormType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DetailPageController extends AbstractController
{
    #[Route('/news/{id}', name: 'app_detail_page')]
    public function index($id, ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, AuthenticationUtils $authenticationUtils): Response
    {
        $manager = $doctrine->getManager();
        $repository = $doctrine->getRepository(News::class);
        $new = $repository->find($id);

        $user_new = $new->getUser();

        if($user_new != $this->getUser() && $this->getUser() != null)
        {
            $viewsNum = $new->getViewsNum();
            $new->setViewsNum($viewsNum + 1);
            $manager->persist($new);
            $manager->flush();
        }
        


        $comments = $new->getComments();
        $count = count($comments);

        $neww = new News();
        $form = $this->createForm(AddNewsType::class, $neww);


        $form->handleRequest($request);
        $UserRepository = $doctrine->getRepository(User::class);
        $user = $UserRepository->find($id);

        if ($form->isSubmitted() && $form->isValid()) {

            $neww = $form->getData();
            $date = new \DateTime('@'.strtotime('now'));
            $neww->setDateLoad($date);
            $neww->setViewsNum(0);
            $neww->setUser($user);  

            $manager->persist($neww);
            $manager->flush();
            $status = "saved";
            return $this->redirectToRoute('app_index');
        }


        $user = new User();
        $form_r = $this->createForm(RegistrationFormType::class, $user);
        $form_r->handleRequest($request);

        if ($form_r->isSubmitted() && $form_r->isValid()) {
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
            return $this->redirect('/#');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        //Добавление комментария
        $comment = new Comments();
        $user = $this->getUser();
        $form_comment = $this->createForm(AddCommentType::class, $comment);
        $form_comment->handleRequest($request);

        if ($form_comment->isSubmitted() && $form_comment->isValid())
        {
            $date = new \DateTime('@'.strtotime('now + 3 hours'));
            $comment->setDateLoad($date);
            $comment->setUser($user);
            $comment->setNew($new);
 
            $comment->setActive(false);

            $entityManager->persist($comment);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirect('/#');

        }
        return $this->render('detail_page/index.html.twig', [
            'new' => $new,
            'comments' => $comments,
            'count' => $count,
            'form' => $form->createView(),
            'form_comment' => $form_comment->createView(),
            'form_er' => $form->getErrors(true),
            'registrationForm' => $form_r->createView(),
            'last_username' => $lastUsername, 'error' => $error,
        ]);
    }
}
