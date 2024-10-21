<?php
declare(strict_types=1);

namespace IdnkSoft\Back\IdnkpCarousel\Form;

use IdnkSoft\Back\IdnkpCarousel\Repository\CarouselRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;

class CarouselFormDataProvider implements FormDataProviderInterface
{

    /**
     * @var CarouselRepository
     */
    private $repository;

    /**
     * @param CarouselRepository $repository
     */
    public function __construct(CarouselRepository $repository)
    {
        $this->repository = $repository;
    }



    public function getData($carouselId)
    {
        $carousel = $this->repository->findOneById($carouselId);
        $carouselData['hook'] = $carousel->getHook();
        $carouselData['order_by'] = $carousel->getOrderBy();
        $carouselData['sort_order'] = $carousel->getSortOrder();
        $carouselData['nb_product'] = $carousel->getNbProduct();
        $carouselData['nb_product_to_show'] = $carousel->getNbProductToShow();
        $carouselData['nb_product_to_scroll'] = $carousel->getNbProductToScroll();
        $carouselData['show_bullet'] = $carousel->isShowBullet();
        $carouselData['show_arrow'] = $carousel->isShowArrow();
        $carouselData['active'] = $carousel->isActive();

        foreach ($carousel->getCarouselLangs() as $carouselLang) {
            $carouselData['title'][$carouselLang->getLang()->getId()] = $carouselLang->getTitle();
            $carouselData['btn_title'][$carouselLang->getLang()->getId()] = $carouselLang->getBtnTitle();
        }
        foreach ($this->repository->getCarouselCategories($carouselId) as $carouselCategory) {
            $categoryId = $carouselCategory['id_category'];
            $carouselData['categories'][$categoryId] = $categoryId;
        }
        return $carouselData;
    }

    public function getDefaultData()
    {
        return [
            'active' => 0,
            'categories' => [2],
            'show_arrow' => 1,
        ];
    }
}
