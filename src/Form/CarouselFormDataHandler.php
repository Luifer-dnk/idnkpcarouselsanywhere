<?php
declare(strict_types=1);

namespace IdnkSoft\Back\IdnkpCarousel\Form;

use Doctrine\ORM\EntityManagerInterface;
use IdnkSoft\Back\IdnkpCarousel\Entity\Carousel;
use IdnkSoft\Back\IdnkpCarousel\Entity\CarouselLang;
use IdnkSoft\Back\IdnkpCarousel\Repository\CarouselRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;
use PrestaShopBundle\Entity\Repository\LangRepository;

class CarouselFormDataHandler implements FormDataHandlerInterface
{
    /**
     * @var CarouselRepository
     */
    private $carouselRepository;
    /**
     * @var LangRepository
     */
    private $langRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param CarouselRepository $carouselRepository
     * @param LangRepository $langRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        CarouselRepository    $carouselRepository,
        LangRepository         $langRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->carouselRepository = $carouselRepository;
        $this->langRepository = $langRepository;
        $this->entityManager = $entityManager;
    }

    public function create(array $data)
    {
        return $this->saveCarousel(0, $data);
    }

    public function update($id, array $data)
    {
        return $this->saveCarousel($id, $data);
    }

    private function saveCarousel($id, array $data)
    {
        if($id) {
            $carousel = $this->carouselRepository->findOneById($id);

            // Get original category to compare
            $originalCategories = [];
            $cats = $this->carouselRepository->getCarouselCategories($id);
            foreach ($cats as $cat) {
                $categoryId = $cat['id_category'];
                $originalCategories[$categoryId] = $categoryId;
            }

            foreach ($data['title'] as $langId => $content) {
                $btnTitle = $data['btn_title'][$langId] ?? '';
                if(empty($content)) {
                    $content = 'Carousel Title';
                }
                $carouselLang = $carousel->getCarouselLangByLangId($langId);
                if (null === $carouselLang) {
                    continue;
                }
                $carouselLang->setTitle($content);
                $carouselLang->setBtnTitle($btnTitle);
            }

            foreach ($data['categories'] as $category) {
                $category = (int)$category;

                // TODO : remove this when PrestaShop add category entity
                // update category
                $carouselCategory = $this->carouselRepository->getCarouselCategoryById($id, (int)$category);

                if (false === $carouselCategory) {
                    $this->carouselRepository->addCarouselCategory($id,(int)$category);
                }

                if (isset($originalCategories[$category])) {
                    unset($originalCategories[$category]);
                }
            }

            // Remove all unused category
            if(! empty($originalCategories)) {
                foreach($originalCategories as $originalCategory) {
                    $this->carouselRepository->removeCarouselCategory($id, (int)$originalCategory);
                }
            }
        } else {
            $carousel = new Carousel();
            foreach ($data['title'] as $langId => $langContent) {
                $btnTitle = $data['btn_title'][$langId] ?? '';
                if(empty($langContent)) {
                    $langContent = 'Carousel Title';
                }
                $lang = $this->langRepository->findOneById($langId);
                $carouselLang = new CarouselLang();
                $carouselLang
                    ->setLang($lang)
                    ->setTitle($langContent)
                    ->setBtnTitle($btnTitle);
                $carousel->addCarouselLang($carouselLang);
            }
        }

        $carousel->setPosition(0);

        if (isset($data['hook']) && is_string($data['hook'])) {
            $carousel->setHook($data['hook']);
            $idnkpCarouselModule = new \IdnkPCarouselsanywhere();
            $idnkpCarouselModule->registerHook($data['hook']);
        }
        if (isset($data['order_by']) && is_string($data['order_by'])) {
            $carousel->setOrderBy($data['order_by']);
        }
        if (isset($data['sort_order']) && is_string($data['sort_order'])) {
            $carousel->setSortOrder($data['sort_order']);
        }
        if (isset($data['nb_product']) && is_int($data['nb_product'])) {
            $carousel->setNbProduct($data['nb_product']);
        }
        if (isset($data['nb_product_to_show']) && is_int($data['nb_product_to_show'])) {
            $carousel->setNbProductToShow($data['nb_product_to_show']);
        }
        if (isset($data['nb_product_to_scroll']) && is_int($data['nb_product_to_scroll'])) {
            $carousel->setNbProductToScroll($data['nb_product_to_scroll']);
        }
        if (isset($data['show_arrow']) && is_bool($data['show_arrow'])) {
            $carousel->setShowArrow($data['show_arrow']);
        }
        if (isset($data['show_bullet']) && is_bool($data['show_bullet'])) {
            $carousel->setShowBullet($data['show_bullet']);
        }
        if (isset($data['active']) && is_bool($data['active'])) {
            $carousel->setActive($data['active']);
        }
        if(!$id) {
            $this->entityManager->persist($carousel);
        }

        $this->entityManager->flush();

        // TODO : remove this when PrestaShop add category entity
        // add category association on creation
        if (!$id) {
            foreach ($data['categories'] as $category) {
                $this->carouselRepository->addCarouselCategory($carousel->getId(),(int)$category);
            }
        }
        return $carousel->getId();
    }
}