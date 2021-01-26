<?php
/** Controller permettant les traitements des prestataires */

namespace App\Controller;

use App\Entity\Prestataire;
use App\Form\PrestataireType;
use App\Repository\PrestataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prestataire")
 */
class PrestataireController extends AbstractController
{
    /**
     * Méthode permettant d'afficher la liste des prestataires
     * 
     * @Route("/", name="prestataire_index", methods={"GET"})
     */
    public function index(PrestataireRepository $prestataireRepository): Response
    {
        return $this->render('prestataire/index.html.twig', [
            'prestataires' => $prestataireRepository->findAll(),
        ]);
    }

    /**
     * Méthode permettant de créer un nouveau prestataire
     * 
     * @Route("/new", name="prestataire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $prestataire = new Prestataire();
        $form = $this->createForm(PrestataireType::class, $prestataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prestataire);
            $entityManager->flush();
            $this->addFlash('reussie', 'Le prestataire a bien été crée !');
            return $this->redirectToRoute('prestataire_index');
        }
        //$this->addFlash('echoue', 'Le prestataire n\'a pas bien été crée !');
        return $this->render('prestataire/new.html.twig', [
            'prestataire' => $prestataire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de consulter un prestataire
     * 
     * @Route("/{id}", name="prestataire_show", methods={"GET"})
     */
    public function show(Prestataire $prestataire): Response
    {
        return $this->render('prestataire/show.html.twig', [
            'prestataire' => $prestataire,
        ]);
    }

    /**
     * Méthode permettant de modifier un prestataire
     * 
     * @Route("/{id}/edit", name="prestataire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Prestataire $prestataire): Response
    {
        $form = $this->createForm(PrestataireType::class, $prestataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('reussie', 'Le prestataire a bien été modifié !');
            return $this->redirectToRoute('prestataire_index');
        }
        //$this->addFlash('echoue', 'Le prestataire n\'a pas bien été édité !');
        return $this->render('prestataire/edit.html.twig', [
            'prestataire' => $prestataire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de supprimer un prestataire
     * 
     * @Route("/{id}", name="prestataire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Prestataire $prestataire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestataire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prestataire);
            $entityManager->flush();
            $this->addFlash('reussie', 'Le prestataire a bien été supprimé !');
        }

        return $this->redirectToRoute('prestataire_index');
    }
}
