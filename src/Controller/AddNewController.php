<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use App\Form\AddNewsType;
class AddNewController extends AbstractController
{
    #[Route('/addNew', name: 'app_addNew')]
    public function register(ManagerRegistry $doctrine, Request $request): Response
    {
        if ($this->getUser() == null ) {
            return $this->redirectToRoute('app_index');
       }

        $new = new News();
        $form = $this->createForm(AddNewsType::class, $new);


        $form->handleRequest($request);
        $UserRepository = $doctrine->getRepository(User::class);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $new = $form->getData();
            $date = new \DateTime('@'.strtotime('now + 3 hours'));
            $new->setDateLoad($date);
            $new->setViewsNum(0);
            $new->setUser($user);  

            $manager = $doctrine->getManager();
            $manager->persist($new);
            $manager->flush();
            $status = "saved";
            return $this->redirectToRoute('app_index');
        }

        return $this->render('Forms/AddNewsForm/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
