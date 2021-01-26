<?php
/** Controller des traitements des durées des sessions de formation */

namespace App\Controller;

use App\Entity\Duree;
use App\Form\DureeType;
use App\Repository\DureeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/duree")
 */
class DureeController extends AbstractController
{
    /**
     * Méthode permettant de consulter l'intégralité des durées inventorées
     * 
     * @Route("/", name="duree_index", methods={"GET"})
     */
    public function index(DureeRepository $dureeRepository): Response
    {
        return $this->render('duree/index.html.twig', [
            'durees' => $dureeRepository->findAll(),
        ]);
    }

    /**
     * Méthode permettant de créer une durée
     * 
     * @Route("/new", name="duree_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $duree = new Duree();
        $form = $this->createForm(DureeType::class, $duree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($duree);
            $entityManager->flush();
            $this->addFlash('reussie', 'La durée a bien été créée !');
            return $this->redirectToRoute('duree_index');
        }
        //$this->addFlash('echoue', 'La durée n\'a pas bien été créée !');
        return $this->render('duree/new.html.twig', [
            'duree' => $duree,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de faire un focus sur une durée
     * 
     * @Route("/{id}", name="duree_show", methods={"GET"})
     */
    public function show(Duree $duree): Response
    {
        return $this->render('duree/show.html.twig', [
            'duree' => $duree,
        ]);
    }

    /**
     * Méthode permettant de modifier une durée existante
     * 
     * @Route("/{id}/edit", name="duree_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Duree $duree): Response
    {
        $form = $this->createForm(DureeType::class, $duree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('reussie', 'La durée a bien été modifiée !');
            return $this->redirectToRoute('duree_index');
        }
        //$this->addFlash('echoue', 'La durée n\'a pas bien été éditée !');
        return $this->render('duree/edit.html.twig', [
            'duree' => $duree,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de supprimer une durée
     * 
     * @Route("/{id}", name="duree_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Duree $duree): Response
    {
        if ($this->isCsrfTokenValid('delete'.$duree->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($duree);
            $entityManager->flush();
            $this->addFlash('reussie', 'La durée a bien été supprimée !');
        }

        return $this->redirectToRoute('duree_index');
    }
}
