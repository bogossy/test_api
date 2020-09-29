<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     */
    public function index(Request $request)
    {
        // Nettoyage de tous les messages FlashBag
        $flashBag = $request->getSession()->getFlashBag();
        foreach ($flashBag->keys() as $type) {
            $flashBag->set($type, array());
        }
        // liste des evenements
        $event = $this->getDoctrine()->getRepository(Evenement::class)
            ->findBy([],['id' => 'desc']);
        // Nous créons Evenement
        $evenements = new Evenement();
        // Nous créons le formulaire
        $form = $this->createForm(EvenementType::class, $evenements);


        if($request->isMethod('POST')){

            // Récupération des objets saisies
            $form->handleRequest($request);
            //vérification du formulaire envoyé
            if($form->isSubmitted() && ctype_digit($evenements->getCapaciteaccueil())
                                    && Date($evenements->getDatedebut()) && Date($evenements->getDatefin())){
                    //il a bien été envoyé
                $evenements->setDatecreation(new \DateTime('now'));
                $evenements->setStatus('En cours');
                    //on va instancie doctrine
                    $doctrine=$this->getDoctrine()->getManager();
                    $doctrine->persist($evenements);
                    //Ajout dans la bdd
                    $doctrine->flush();
                    $request->getSession()->getFlashBag()->add('notice_success', 'L\'évenement a bien été prise en compte');
                    return $this->redirectToRoute("home");
                }
                else{
                    $request->getSession()->getFlashBag()->add('notice_error', 'Impossible de créer l\'évènement, vérifier que vous avez bien rempli les champs');
                }

            }

        // nous envoyons le formulaire à la vue
        return $this->render('event/index.html.twig', [
            'event'=>$event,
            'EvenementForm' => $form->createView(),
        ]);
    }
}
