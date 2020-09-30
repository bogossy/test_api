<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Inscription;
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


            if ($request->isMethod('POST')) {

                // Récupération des objets saisies
                $form->handleRequest($request);
                //vérification du formulaire envoyé
                if (($form->isSubmitted())) {


                    //il a bien été envoyé
                    $evenements->setDatecreation(new \DateTime('now'));
                    $evenements->setStatus('En cours');
                    //on va instancie doctrine
                    $doctrine = $this->getDoctrine()->getManager();
                    $doctrine->persist($evenements);
                    //Ajout dans la bdd
                    $doctrine->flush();
                    $request->getSession()->getFlashBag()->add('notice_success', 'L\'évenement a bien été prise en compte');
                    return $this->redirectToRoute("home");

                } else {
                    $request->getSession()->getFlashBag()->add('notice_error', 'Impossible de créer l\'évènement');
                }

            }

        // nous envoyons le formulaire à la vue
        return $this->render('event/index.html.twig', [
            'event'=>$event,
            'EvenementForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modif_event/{id}", name="modif_event")
     */
    public function update(Request $request, Evenement $evenement,$id){


        // Nettoyage de tous les messages FlashBag
        $flashBag = $request->getSession()->getFlashBag();
        foreach ($flashBag->keys() as $type) {
            $flashBag->set($type, array());
        }

        // Nous créons le formulaire
        $form = $this->createForm(EvenementType::class, $evenement);

        $event = $this->getDoctrine()->getRepository(Evenement::class)
            ->findBy([],['id' => 'desc']);
        if($request->isMethod('POST')){

            // Récupération des objets saisies
            $form->handleRequest($request);
            //vérification du formulaire envoyé
            if($form->isSubmitted() && ($form->isValid())){
                //il a bien été envoyé
                $evenement->setDatecreation(new \DateTime('now'));
                $evenement->setStatus('En cours');
                //on va instancie doctrine
                $doctrine=$this->getDoctrine()->getManager();
                $doctrine->persist($evenement);
                //Ajout dans la bdd
                $doctrine->flush();
                $request->getSession()->getFlashBag()->add('notice_success', 'L\'évenement a bien été modifié');
                return $this->redirectToRoute("home");
            }
            else{
                $request->getSession()->getFlashBag()->add('notice_error', 'Impossible de modifier l\'évènement');
            }

        }
        // nous envoyons le formulaire à la vue
        return $this->render('event/index.html.twig', [
            'event'=>$event,
            'EvenementForm' => $form->createView(),
        ]);

    }

    /**
     * @Route("/delete_event/{id}", name="delete_event")
     */

            public function delete(Request $request,$id){

                // Nettoyage de tous les messages FlashBag
                $flashBag = $request->getSession()->getFlashBag();
                foreach ($flashBag->keys() as $type) {
                    $flashBag->set($type, array());
                }

                $sup_event = $this->getDoctrine()->getManager();
                $events = $sup_event->getRepository(Evenement::class)->find($id);

                if(!$events)
                    throw $this->createNotFoundException('Aucun evenement trouvé pour cet id : '.$id);

                $values = $sup_event->getRepository(Inscription::class)->findBy(array('evenement' => $id));
                foreach($values as $value)
                {
                    $events->removeInscription($value);
                    $sup_event->remove($value);
                }

                $sup_event->remove($events);
                $sup_event->flush();
                $request->getSession()->getFlashBag()->add('notice_success', 'L\'évenement a bien été Supprimé');


                return $this->redirectToRoute('home');



       }

}
