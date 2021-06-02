<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class HomeService
{
    private EntityManagerInterface $em;
    private PaginatorInterface $paginator;

    public function __construct(
        EntityManagerInterface $em,
        PaginatorInterface $paginator
    ) {
        $this->em = $em;
        $this->paginator = $paginator;
    }


    /**
     * @param int $page
     * @return PaginationInterface
     */
    public function getProjects(int $page): PaginationInterface
    {
        $dql = 'SELECT a FROM App\Entity\Project a';
        $query = $this->em->createQuery($dql);

        return $this->paginator->paginate(
            $query,
            $page,
            5
        );
    }
}