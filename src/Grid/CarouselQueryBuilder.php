<?php
declare(strict_types=1);

namespace IdnkSoft\Back\IdnkpCarousel\Grid;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class CarouselQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var DoctrineSearchCriteriaApplicatorInterface
     */
    private $searchCriteriaApplicator;
    /**
     * @var int
     */
    private $languageId;

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     * @param DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator
     * @param int $languageId
     */
    public function __construct(
        Connection                                $connection,
                                                  $dbPrefix,
        DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator,
                                                  $languageId
    )
    {
        parent::__construct($connection, $dbPrefix);
        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
        $this->languageId = $languageId;
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb
            ->select('c.id_carousel, c.position, c.hook, c.active, cl.title')
            ->groupBy('c.id_carousel');
        $this->searchCriteriaApplicator
            ->applySorting($searchCriteria, $qb)
            ->applyPagination($searchCriteria, $qb);
        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters())
            ->select('COUNT(DISTINCT c.id_carousel)');
        return $qb;
    }

    /**
     * Get generic query builder.
     *
     * @param array $filters
     * @return QueryBuilder
     */
    private function getQueryBuilder(array $filters)
    {
        $allowedFilters = [
            'id_carousel',
            'title',
        ];
        $qb = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix . 'idnk_carousel', 'c')
            ->innerJoin(
                'c',
                $this->dbPrefix . 'idnk_carousel_lang',
                'cl',
                'c.id_carousel = cl.id_carousel'
            )
            ->andWhere('cl.`id_lang`= :language')
            ->setParameter('language', $this->languageId);
        foreach ($filters as $name => $value) {
            if (!in_array($name, $allowedFilters, true)) {
                continue;
            }
            if ('id_carousel' === $name) {
                $qb->andWhere('c.`id_carousel` = :' . $name);
                $qb->setParameter($name, $value);
                continue;
            }
            $qb->andWhere("$name LIKE :$name");
            $qb->setParameter($name, '%' . $value . '%');
        }
        return $qb;
    }
}