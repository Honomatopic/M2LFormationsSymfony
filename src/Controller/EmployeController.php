<?php
/** Controller des traitements des employés de l'association  */

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use App\Entity\Session AS Mysession;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/employe")
 */
class EmployeController extends AbstractController
{
    /**
     * Méthode qui consulte la liste des employés
     * 
     * @Route("/", name="employe_index", methods={"GET"})
     */
    public function index(EmployeRepository $employeRepository): Response
    {
        return $this->render('employe/index.html.twig', [
            'employes' => $employeRepository->findAll(),
        ]);
    }

    /**
     * Méthode permettant d'ajouter un nouvel employé
     * 
     * @Route("/new", name="employe_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $employe = new Employe();
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($employe, $employe->getPassword());
            $employe->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employe);
            $entityManager->flush();
            $this->addFlash('reussie', 'L\'employé a bien été crée !');
            return $this->redirectToRoute('employe_index');
        }
        //$this->addFlash('echoue', 'L\'employé n\'a pas été crée !');
        return $this->render('employe/new.html.twig', [
            'employe' => $employe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode qui consulter un employé
     * 
     * @Route("/{id}", name="employe_show", methods={"GET"})
     */
    public function show(Employe $employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe,
        ]);
    }

    /**
     * Méthode permettant de modifier un employé
     * 
     * @Route("/{id}/edit", name="employe_edit", methods={"GET","POST"})
     */
    public function edit(Employe $employe, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($employe, $employe->getPassword());
            $employe->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('reussie', 'L\'employé a bien été modifié !');
            return $this->redirectToRoute('employe_index');
        }
        //$this->addFlash('echoue', 'L\'employé n\'a pas été édité !');
        return $this->render('employe/edit.html.twig', [
            'employe' => $employe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode permettant de supprimer un employé
     * 
     * @Route("/{id}", name="employe_delete", methods={"DELETE"})
     */
    public function delete(Employe $employe, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employe);
            $entityManager->flush();
            $session = new Session();
            $session->invalidate();
            $this->addFlash('reussie', 'L\'employé a bien été supprimé !');
            return $this->redirectToRoute('login');
        }
        $this->addFlash('echoue', 'L\'employé n\'a pas été supprimé !');
        return $this->redirectToRoute('employe_index');
    }

    /**
     * Méthode qui montre les sessions inscrites d'un employé
     * 
     * @Route("/register/{id}", name="employe_register", methods={"GET"})
     */
    public function showmyregister(Employe $employe, EmployeRepository $employeRepository): Response
    {
        return $this->render('employe/registers.html.twig', [
            'sessions' => $employeRepository->getSessionWithEmploye($this->getUser()),
        ]);
    }

    /**
     * Méthode permettant du lire une session de formation inscrites par l'employé
     * 
     * @Route("/{id}/{session}", name="employe_register_session", methods={"GET"})
     */
    public function showmyregistersession(Employe $employe, Mysession $session, EmployeRepository $employeRepository): Response
    {
        return $this->render('employe/registersession.html.twig', [
            'session' => $employeRepository->getSessionFindById($session),
        ]);
    }

    /**
     * Méthode permettant de changer de rôle utilisateur
     * 
     * @Route("{id}/role", name="employe_role", methods={"GET","POST"})
     */
    public function changemyrole(Employe $employe): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $employe->addRole('ROLE_ADMIN');
        $entityManager->flush();
        return $this->redirectToRoute('employe_index');
    }
}
