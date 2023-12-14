<?php

namespace App\Repository;

use App\Entity\Proposal;
use App\Utils\Utils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Proposal>
 *
 * @method Proposal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proposal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proposal[]    findAll()
 * @method Proposal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProposalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proposal::class);
    }

    public function findAllActiveProposal($userId) {
    $proposals = $this->createQueryBuilder('p')
        ->andWhere('p.status = :status')
        ->andWhere('p.client = :user')
        ->setParameter('status', Utils::PROPOSAL_STATUS['CREATED'])
        ->setParameter('user', $userId)
        ->orderBy('p.id', 'ASC')
        ->getQuery()
        ->getResult();

    dump($userId);

    $sortedProposals = [];
    foreach ($proposals as $proposal) {
        $prestationId = $proposal->getPrestation()->getId();
        if (!array_key_exists($prestationId, $sortedProposals)) {
            $sortedProposals[$prestationId] = [];
        }
        $sortedProposals[$prestationId][] = $proposal;
    }

    return $sortedProposals;
}

//    /**
//     * @return Proposal[] Returns an array of Proposal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Proposal
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
