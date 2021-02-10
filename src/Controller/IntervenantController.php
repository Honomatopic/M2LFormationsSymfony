<?php
/** Controller permettant les traitements des intervenants */

namespace App\Controller;

use App\Entity\Intervenant;
use App\Form\IntervenantType;
use App\Repository\IntervenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/intervenant")
 */
class IntervenantController extends AbstractController
{
    /**
     * Méthode qui consulte la liste de intervenants
     * 
     * @Route("/", name="intervenant_index", methods={"GET"})
     */
    public function index(IntervenantRepository $intervenantRepository): Response
    {
        return $this->render('intervenant/index.html.twig', [
            'intervenants' => $intervenantRepository->findAll(),
        ]);
    }

    /**
     * Méthode permettant de créer un nouvel intervenant
     * 
     * @Route("/new", name="intervenant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $intervenant = new Intervenant();
        $form = $this->createForm(IntervenantType::class, $intervenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($intervenant);
            $entityManager->flush();
            $this->addFlash('reussie', 'L\'intervenant a bien été crée !');
            return $this->redirectToRoute('intervenant_index');
        }
        //$this->addFlash('echoue', 'L\'intervenant n\'a pas bien été crée !');
        return $this->render('intervenant/new.html.twig', [
            'intervenant' => $intervenant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode qui permet de consulter un intervenant
     * 
     * @Route("/{id}", name="intervenant_show", methods={"GET"})
     */
    public function show(Intervenant $intervenant): Response
    {
        return $this->render('intervenant/show.html.twig', [
            'intervenant' => $intervenant,
        ]);
    }

    /**
     * Méthode qui permet de modifier un intervenant
     * 
     * @Route("/{id}/edit", name="intervenant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Intervenant $intervenant): Response
    {
        $form = $this->createForm(IntervenantType::class, $intervenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('reussie', 'L\'intervenant a bien été modifié !');
            return $this->redirectToRoute('intervenant_index');
        }
        //$this->addFlash('echoue', 'L\'intervenant n\'a pas bien été édité !');
        return $this->render('intervenant/edit.html.twig', [
            'intervenant' => $intervenant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de supprimer un intervenant
     * 
     * @Route("/{id}", name="intervenant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Intervenant $intervenant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intervenant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($intervenant);
            $entityManager->flush();
            $this->addFlash('reussie', 'L\'intervenant a bien été supprimé !');
        }

        return $this->redirectToRoute('intervenant_index');
    }
}
