<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription/{id}", name="inscription")
     */
    public function index($id, Request $request)
    {
        // Nettoyage de tous les messages FlashBag
        $flashBag = $request->getSession()->getFlashBag();
        foreach ($flashBag->keys() as $type) {
            $flashBag->set($type, array());
        }
        // On récupère l'évènement correspondant a l'id
        $inscription= $this->getDoctrine()->getRepository(Evenement::class)->findOneBy(['id' => $id]);
        $evenement = new Evenement();
       // $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findOneBy(['id' => $id]);
      //  $inscription = $this->getDoctrine()->getRepository(Inscription::class)->findBy([
      //      'evenement' => $evenements,
       //             ]);
        if(!$inscription){
            // Si aucun evenement n'est trouvé, nous créons une exception
            throw $this->createNotFoundException('L\'evenement n\'existe pas');
        }

        // Nous créons Inscription
        $inscriptions = new Inscription();

        // Nous créons le formulaire
        $form = $this->createForm(InscriptionType::class, $inscriptions, array('allow_extra_fields' =>true));

        if($request->isMethod('POST')){

            // Récupération des objets saisies
            $form->handleRequest($request);
            //vérification du formulaire envoyé
            if($form->isSubmitted() && ctype_digit($inscriptions->getTelephone())){

                if($request->request->get('idEvent') != null )
                {
                    $inscObject= $this->getDoctrine()->getRepository(Evenement::class)->find($request->request->get('idEvent'));

                    if(!$inscObject){
                        // Si aucun evenement n'est trouvé, nous créons une exception
                        throw $this->createNotFoundException('L\'evenement n\'existe pas');
                    }

                    //il a bien été envoyé
                    $inscriptions->setEvenement($inscObject);
                    //on va instancie doctrine
                    $doctrine=$this->getDoctrine()->getManager();
                    $doctrine->persist($inscriptions);
                    //Ajout dans la bdd
                    $doctrine->flush();
                    $request->getSession()->getFlashBag()->add('notice_success', 'L\'inscription a bien été prise en compte');
                    return $this->redirectToRoute("home");
                }
                else{
                    $request->getSession()->getFlashBag()->add('notice_error', 'Impossible de créer sans l\'évènement');
                }

            }
            else{
                $request->getSession()->getFlashBag()->add('notice_error', 'Le contact téléphonique doit être au format numérique');
            }
        }

        // Si l'evenement existe nous envoyons les données à la vue
        // nous envoyons le formulaire à la vue
        return $this->render('inscription/index.html.twig', [
            'inscription' => $inscription,
            'InscriptionForm' => $form->createView(),
            //'evenement' => $evenements,

        ]);


    }

}
