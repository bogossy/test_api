<?php

namespace App\Controller;

use App\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $evenements = $this->getDoctrine()->getRepository(Evenement::class)
                                            ->findBy([],['id' => 'desc']);
        return $this->render('home/index.html.twig', [
            'home' => $evenements,
        ]);
    }
}
