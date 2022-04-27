<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Test extends AbstractController
{
    /**
     * @Route("/fj", name="test")
     */

    public function test(): Response
    {
        $userFirstName = "Никита";

        return $this->render('testt/index.html.twig', [
   
            'user_first_name' => $userFirstName,
        ]);
    }
}