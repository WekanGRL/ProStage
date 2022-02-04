<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    /**
     * @return Stage[] Retourne un tableau de Stages en fonction du nom d'une entreprise donnée
     */
    public function findByNomEntreprise($nom){
        return $this->createQueryBuilder('s')
                    ->join('s.entreprises','e')
                    ->andWhere('e.nom = :nomEntreprise')
                    ->setParameter('nomEntreprise', $nom)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @return Stage[] retourne un tableau de Stages en fonction du nom d'une formation donnée
     */
    public function findByNomFormation($nom){
        // Récupération du gestionnaire d'entités
        $gestionnaireEntite = $this->getEntityManager();

        // Construction de la requête
        $requete = $gestionnaireEntite->createQuery(
            "SELECT s
            FROM App\Entity\Stage s
            JOIN s.formations f
            WHERE f.nomCourt = '$nom'");
            
        return $requete->execute();
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
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
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
