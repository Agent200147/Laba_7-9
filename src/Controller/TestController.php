<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\RedirectResponse;


class TestController extends AbstractController
{
    /**
     * @Route("/ttt", name="testt")
     */

    public function ttt(): Response
    {
        $userFirstName = "Никита";

        return $this->render('testt/index.html.twig', [
   
            'user_first_name' => $userFirstName,
        ]);
    }
}
