<?php

namespace App\Repository;

use App\Entity\Chambre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\PseudoTypes\False_;

/**
 * @extends ServiceEntityRepository<Chambre>
 *
 * @method Chambre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chambre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chambre[]    findAll()
 * @method Chambre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChambreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chambre::class);
    }



   /**
     * @return Chambre[] Returns an array of Chambre objects
   */
  public function findEmptyRooms()
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.etat =:libre')
           ->setParameter('libre', true)
           ->getQuery()
           ->getResult()
       ;}

        /**
     * @return Chambre[] Returns an array of Chambre objects
   */

//        public function findOneByRoom()
//    {
//        return $this->createQueryBuilder('c')
//         ->select('c', 'rc', 'r', 'u')
//         ->join('c.reservationChambres', 'rc')
//         ->join('rc.reservation', 'r')
//         ->join('r.user', 'u')
//         ->where('c.etat = :etat')
//         ->setParameter('etat', true)
//         ->getQuery()
//         ->getResult();
//    }


   /**
     * @return Chambre[] Returns an array of Chambre objects
   */

//        public function findOneByChiffre()
//    {
//        return $this->createQueryBuilder('c')
//        ->select('SUM(c.tarif) as chiffre')
//        ->leftJoin('c.reservationChambres', 'rc')
//        ->leftJoin('rc.reservation', 'r')
//         ->where('r.dateEntree <= :dateActuelle')
//         ->andWhere('r.dateSortie >= :dateActuelle')
//         ->setParameter('dateActuelle', new \DateTime())
//        ->getQuery()
//        ->getResult()
//        ;}
       
//    public function calculateChiffreDaffaires(\DateTime $startDate, \DateTime $endDate)
// {
//     $queryBuilder = $this->createQueryBuilder('c')
//         ->select('SUM(c.tarif) as chiffre')
//         ->leftJoin('c.reservationChambres', 'rc')
//         ->leftJoin('rc.reservation', 'r')
//         ->where('r.dateEntree <= :endDate')
//         ->andWhere('r.dateSortie >= :startDate')
//         ->setParameter('startDate', $startDate)
//         ->setParameter('endDate', $endDate)
//         ->getQuery();

//     return $queryBuilder->getSingleScalarResult();
// }

       
public function findcountChambre(): int
{
    return $this->createQueryBuilder('c')
        ->select('COUNT(c.id)') 
        ->getQuery()
        ->getSingleScalarResult(); 
}



//     public function findcountReservation(): int
// {
//     return $this->createQueryBuilder('rc')
//         ->select('COUNT(rc.id)') 
//         ->getQuery()
//         ->getSingleScalarResult(); 
// }

//    /**
//     * @return Chambre[] Returns an array of Chambre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($etat): ?Chambre
//    {
//        return $this->createQueryBuilder('c')
//            ->select('chambre.etat')
//            ->andWhere('chambre.etat = :occupée')
//            ->setParameter('occupée', $etat)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



    public function afficherChambreLibre($etat)
    {
        // Utilisation du QueryBuilder pour créer une requête SQL
        return $this->createQueryBuilder('chambre') // Alias de la table 'Categorie' nommé aussi 'categorie'
            ->select('chambre.etat') //Sélectionne uniquement la colonne 'etat', equivaut à : SELECT etat from chambre
            ->where('chambre.etat = :libre') // condition where, equivaut à : where libelle = :libelle(parametre/valeur)
            ->setParameter('libre', $etat)  // Lie la valeur true au paramètre :libre('libre')
            ->getQuery(); // Obtient l'objet de requête
        //->getScalarResult();
    }


    // /**
    //  * @return Chambre[] Returns an array of Chambre objects
    //  */
    // public function findEmptyRooms()
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.etat =:libre')
    //         ->setParameter('libre', true)
    //         ->getQuery()
    //         ->getResult();
    // }


 

// /**
    //  * @return Chambre[] Returns an array of Chambre objects
    //  */
 
    public function findOneByRoom()
    {
        return $this->createQueryBuilder('c')
            ->select('r', 'c', 'u')
            ->leftJoin('c.chambre', 'r')
            ->leftJoin('r.user', 'u')
            ->andWhere('c.etat = :occupee')
            ->setParameter('occupee', false)
            ->getQuery()
            ->getResult();
    }


    // public function findcountChambre(): int
    // {
    //     return $this->createQueryBuilder('c')
    //         ->select('COUNT(c.id)')
    //         ->getQuery()
    //         ->getSingleScalarResult();
    // }



    public function findcountReservation(): int
    {
        return $this->createQueryBuilder('rc')
            ->select('COUNT(rc.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
 



 
//    public function calculateChiffreDaffaires(\DateTime $startDate, \DateTime $endDate): ?float
// {
//     $queryBuilder = $this->createQueryBuilder('c')
        
//         ->select('SUM(DATE_DIFF(r.DateSortie, r.DateEntree) * c.tarif) as chiffre')
//         ->leftJoin('c.chambre', 'r')
//         ->where('r.DateEntree <= :endDate')
//         ->andWhere('r.DateSortie >= :startDate')
//         ->setParameter('startDate', $startDate)
//         ->setParameter('endDate', $endDate)
//         ->getQuery();
    
//     $result = $queryBuilder->getSingleScalarResult();

//     return (float)$result;
// }
public function calculateChiffreDaffairesByMonth(\DateTime $startDate, \DateTime $endDate): array
{
    $query = $this->createQueryBuilder('c')
        ->select('YEAR(r.DateEntree) AS annee, MONTH(r.DateEntree) AS mois, SUM(DATE_DIFF(r.DateSortie, r.DateEntree) * c.tarif) AS chiffre')
        ->leftJoin('c.chambre', 'r')
        ->where('r.DateEntree <= :endDate')
        ->andWhere('r.DateSortie >= :startDate')
        ->groupBy('annee, mois')
        ->orderBy('annee, mois')
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate)
        ->getQuery();

    return $query->getResult();
}


// public function calculateChiffreDaffairesByMonth(\DateTime $startDate, \DateTime $endDate): array
// {
//     $query = $this->createQueryBuilder('c')
//         ->select('YEAR(r.DateEntree) AS annee, MONTH(r.DateEntree) AS mois, SUM(DATEDIFF(r.DateSortie, r.DateEntree) * c.tarif) AS chiffre')
//         ->leftJoin('c.chambre', 'r')
//         ->where('r.DateEntree <= :endDate')
//         ->andWhere('r.DateSortie >= :startDate')
//         ->groupBy('annee, mois')
//         ->orderBy('annee, mois')
//         ->setParameter('startDate', $startDate)
//         ->setParameter('endDate', $endDate)
//         ->getQuery();

//     return $query->getResult();
// }
    //    /**
    //     * @return Chambre[] Returns an array of Chambre objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Chambre
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
 

//     public function calculateChiffreDaffairesByMonth(\DateTime $startDate, \DateTime $endDate): array
//     {
//         $query = $this->createQueryBuilder('c')
//             ->select('YEAR(r.DateEntree) AS annee, MONTH(r.DateEntree) AS mois, SUM(DATE_DIFF(r.DateSortie, r.DateEntree) * c.tarif) AS chiffre')
//             ->leftJoin('c.chambre', 'r')
//             ->where('r.DateEntree <= :endDate')
//             ->andWhere('r.DateSortie >= :startDate')
//             ->groupBy('annee, mois')
//             ->orderBy('annee, mois')
//             ->setParameter('startDate', $startDate)
//             ->setParameter('endDate', $endDate)
//             ->getQuery();

//         return $query->getResult();
//     }

// }
 