<?php
declare(strict_types=1);

namespace IdnkSoft\Back\IdnkpCarousel\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use PrestaShop\PrestaShop\Adapter\Entity\Db;

class CarouselRepository extends EntityRepository
{
    public const TABLE_NAME = 'idnk_carousel';
    public const TABLE_NAME_LANG = 'idnk_carousel_lang';
    public const TABLE_NAME_CAT = 'idnk_carousel_category_association';
    public const TABLE_NAME_WITH_PREFIX = _DB_PREFIX_ . self::TABLE_NAME;
    public const TABLE_NAME_LANG_WITH_PREFIX = _DB_PREFIX_ . self::TABLE_NAME_LANG;
    private $db;

    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class)
    {
        $this->setDb(DB::getInstance());
        parent::__construct($em, $class);
    }

    /**
     * @param string $hookname
     * @param int $langId
     *
     * @return array
     */
    public function getCarousels($hookName, $langId)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.carouselLangs', 'cl')
            ->addSelect('cl')
        ;

        if (0 !== $langId) {
            $qb
                ->andWhere('cl.lang = :langId')
                ->setParameter('langId', $langId)
            ;
        }
        $qb
            ->andWhere('c.hook = :hookName')
            ->setParameter('hookName', $hookName)
        ;

        $carousels = $qb->getQuery()->getResult();

        return $carousels;
    }

    /**
     * @param int $carouselId
     * @return array
     */
    public function getCarouselCategories(int $carouselId): array
    {
        $categories = [];
        $categories = $this->getDb()->executeS('SELECT id_category FROM '._DB_PREFIX_.self::TABLE_NAME_CAT.' WHERE id_carousel = '.$carouselId.'');
        return $categories;
    }

    /**
     * @param int $carouselId
     * @param int $categoryId
     * @return bool
     */
    public function getCarouselCategoryById(int $carouselId, int $categoryId): bool
    {
        $category = $this->getDb()->getValue('SELECT id_category FROM '._DB_PREFIX_.self::TABLE_NAME_CAT.' WHERE id_carousel = '.$carouselId.' AND id_category = '.$categoryId.'');
        if ($category) {
            return true;
        }

        return false;
    }

    /**
     * @param int $carouselId
     * @param int $categoryId
     * @return boolean
     */
    public function addCarouselCategory(int $carouselId, int $categoryId): bool
    {
        $result = $this->getDb()->insert(self::TABLE_NAME_CAT, [
            'id_category' => (int) $categoryId,
            'id_carousel' => (int) $carouselId
        ]);
        return $result;
    }

    /**
     * @param int $carouselId
     */
    public function removeCarouselCategories(int $carouselId)
    {
        $this->getDb()->delete(self::TABLE_NAME_CAT, 'id_carousel = '.$carouselId.'');
    }

    /**
     * @param int $carouselId
     * @param int $categoryId
     */
    public function removeCarouselCategory(int $carouselId, int $categoryId)
    {
        $this->getDb()->delete(self::TABLE_NAME_CAT, 'id_carousel = '.$carouselId.' AND id_category = '.$categoryId.'');
    }


    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db): void
    {
        $this->db = $db;
    }


}