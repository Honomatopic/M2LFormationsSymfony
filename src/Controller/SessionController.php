<?php
/** Controller indispensable pour les traitements des sessions de formation */

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Employe;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{
    /**
     * Méthode qui permet de consulter la liste des sessions existantes
     * 
     * @Route("/", name="session_index", methods={"GET"})
     */
    public function index(SessionRepository $sessionRepository): Response
    {
        $session = new Session();
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->getSessionFindAll(),
        ]);
    }

    /**
     * Méthode permettant de créer une session de formation
     * 
     * @Route("/new", name="session_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();
            $this->addFlash('reussie', 'La session a bien été créée !');
            return $this->redirectToRoute('session_index');
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de consulter une session de formation
     * 
     * @Route("/{id}", name="session_show", methods={"GET"})
     */
    public function show(Session $session, SessionRepository $sessionRepository): Response
    {

        return $this->render('session/show.html.twig', [
            'session' => $sessionRepository->getSessionFindById($session),
        ]);
    }

    /**
     * Méthode permettant de modifier d'une session de formation
     * 
     * @Route("/{id}/edit", name="session_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Session $session): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('reussie', 'La session a bien été modifiée !');
            return $this->redirectToRoute('session_index');
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de supprimer une session de formation
     * 
     * @Route("/{id}", name="session_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Session $session): Response
    {
        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($session);
            $entityManager->flush();
        }
        $this->addFlash('reussie', 'La session a bien été supprimée !');
        return $this->redirectToRoute('session_index');
    }

    /**
     * Méthode permettant de s'inscrire à une session de formation
     * 
     * @Route("/register/{id}/{session}", name="session_register")
     */
    public function register(Employe $employe, Session $session): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session->addInscrit($this->getUser());
        $entityManager->flush();
        $this->addFlash('reussie', 'Vous etes bien inscris !');
        return $this->redirectToRoute('employe_register', array('id'=>$employe->getId()));
    }

    /**
     * Méthode permettant de se désinscrire à une session
     * 
     * @Route("/unregister/{id}/{session}", name="session_unregister", methods={"GET","POST"})
     */
    public function unregister(Employe $employe, Session $session): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session->removeInscrit($this->getUser());
        $entityManager->flush();
        $this->addFlash('reussie', 'Vous etes bien désinscris !');
        return $this->redirectToRoute('employe_register', array('id'=>$employe->getId()));
    }

    /**
     * Méthode générant le pdf d'une session de formation
     * 
     * @Route("/thepdf/{id}", name="session_pdf", methods={"GET"})
     */
    public function pdf(Session $session, SessionRepository $sessionRepository)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Calibri');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('session/mypdf.html.twig', [
            'title' => "Voici le PDF de la session",
            'session' => $sessionRepository->getSessionFindById($session),
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($sessionRepository->getSessionFindById($session)['id']." - ".$sessionRepository->getSessionFindById($session)['intitule'].".pdf", [
            "Attachment" => false
        ]);
    }

}
