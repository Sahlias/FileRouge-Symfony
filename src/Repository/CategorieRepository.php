<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }


    // fonction qui Recherche l'ID d'une catégorie en fonction de son libellé.
    public function findCategoryIdByLibelle($libelle)
    {
        // Utilisation du QueryBuilder pour créer une requête SQL
        return $this->createQueryBuilder('categorie') // Alias de la table 'Categorie' nommé aussi 'categorie'
            ->select('categorie.id') //Sélectionne uniquement la colonne 'id', equivaut à : SELECT id from categorie
            ->where('categorie.libelle = :libelle') // condition where, equivaut à : where libelle = :libelle(parametre/valeur)
            ->setParameter('libelle', $libelle)  // Lie la valeur du libellé ($libelle) au paramètre :libelle('libelle')
            ->getQuery() // Obtient l'objet de requête
            ->getSingleScalarResult(); // Exécute la requête et récupère un seul résultat scalaire (l'ID)
    }




//    /**
//     * @return Categorie[] Returns an array of Categorie objects
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

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
