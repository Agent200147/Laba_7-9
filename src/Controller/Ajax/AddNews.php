<?php

use App\Entity\News;
use App\Entity\User;
use App\Form\AddNewsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AddNewsController extends AbstractController
{
    #[Route('/AddNews', name: 'AddNews')]
    public function index(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $new = new News();
        $form = $this->createForm(AddNewsType::class, $new);

        $form->handleRequest($request);
        $UserRepository = $doctrine->getRepository(User::class);
        $user = $UserRepository->find($id);

        if ($form->isSubmitted() && $form->isValid()) {

            $date = new \DateTime('@'.strtotime('now'));
            $new->setDateLoad($date);
            $new->setViewsNum(0);
            $new->setUser($user);  

            $manager = $doctrine->getManager();
            $manager->persist($new);
            $manager->flush();
            $status = "saved";
        }

        else{
            $status = "invalid";
        }
        return new JsonResponse(array('status' => $status));
    }
}