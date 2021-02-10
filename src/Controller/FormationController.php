<?php
/** Controller permettant les traitements des formations */

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Employe;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * Méthode accèdant à la consultation de l'ensemble des formations présentes sur l'application
     * 
     * @Route("/", name="formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * Méthode permettant de créer une formation
     * 
     * @Route("/new", name="formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();
            $this->addFlash('reussie', 'La formation a bien été créée !');
            return $this->redirectToRoute('formation_index');
        }
        //$this->addFlash('echoue', 'La formation n\'a pas bien été créée !');
        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de faire un focus sur une formation
     * 
     * @Route("/{id}", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * Méthode permettant de modifier une formation
     * 
     * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('reussie', 'La formation a bien été modifiée !');
            return $this->redirectToRoute('formation_index');
        }
        //$this->addFlash('echoue', 'La formation n\'a pas bien été éditée !');
        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de supprimer une formation 
     *
     * @Route("/{id}", name="formation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
            $this->addFlash('reussie', 'La formation a bien été supprimée !');
        }

        return $this->redirectToRoute('formation_index');
    }

}
