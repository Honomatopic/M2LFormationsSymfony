<?php
/** Class permettant de faire des requêtes customisées via la class QueryBuilder sur l'objet Session */

namespace App\Repository;


use App\Entity\Employe;
use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    // /**
    //  * @return Session[] Returns an array of Session objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Session
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

   // Méthode qui affiche les informations des sessions de formations où l'employé est inscrit
   public function getSessionWithEmploye(Employe $employe)
   {
       return $this->createQueryBuilder('s')
           ->select('s.id', 'f.intitule', 'd.datedebut', 'd.datefin', 'sl.nom AS salle', 'i.nom AS nomintervenant', 'p.nom AS prestataire')
           ->join('s.formations', 'f')
           ->join('s.durees', 'd')
           ->join('s.salles', 'sl')
           ->join('s.intervenants', 'i')
           ->join('s.prestataires', 'p')
           ->where('e.id = :session')
           ->setParameter('session', $employe->getId())
           ->getQuery()
           ->getResult();
   }

   // Méthode qui affiche les informations de toutes les sessions de formation
   public function getSessionFindAll()
   {
       return $this->createQueryBuilder('s')
           ->select('s.id', 'f.intitule', 'd.datedebut', 'd.datefin', 'sl.nom AS salle', 'i.nom AS nomintervenant', 'p.nom AS prestataire')
           ->join('s.formations', 'f')
           ->join('s.durees', 'd')
           ->join('s.salles', 'sl')
           ->join('s.intervenants', 'i')
           ->join('s.prestataires', 'p')
           ->getQuery()
           ->getResult();
   }

   // Méthode qui affiche les informations d'une session de formation avec son id
   public function getSessionFindById(Session $session)
   {
       return $this->createQueryBuilder('s')
           ->select('s.id', 'f.intitule', 'd.datedebut', 'd.datefin', 'sl.nom AS salle', 'i.nom AS nomintervenant', 'p.nom AS prestataire')
           ->join('s.formations', 'f')
           ->join('s.durees', 'd')
           ->join('s.salles', 'sl')
           ->join('s.intervenants', 'i')
           ->join('s.prestataires', 'p')
           ->where('s.id = :idsession')
           ->setParameter('idsession', $session->getId())
           ->getQuery()
           ->getSingleResult();
   }


   // Méthode qui affiche les informations des sessions de formations où l'employé n'est pas inscrit
   public function getSessionWithoutEmploye(Employe $employe)
   {
       return $this->createQueryBuilder('s')
           ->select('s.id', 'f.intitule', 'd.datedebut', 'd.datefin', 'sl.nom AS salle', 'i.nom AS nomintervenant', 'p.nom AS prestataire')
           ->join('s.formations', 'f')
           ->join('s.durees', 'd')
           ->join('s.salles', 'sl')
           ->join('s.intervenants', 'i')
           ->join('s.prestataires', 'p')
           ->where('e.id != :idemploye')
           ->setParameter('idemploye', $employe->getId())
           ->getQuery()
           ->getResult();
   }
}
