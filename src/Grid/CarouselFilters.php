<?php
declare(strict_types=1);

namespace IdnkSoft\Back\IdnkpCarousel\Grid;
use IdnkSoft\Back\IdnkpCarousel\Grid\CarouselGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class CarouselFilters extends Filters
{
    protected $filterId = CarouselGridDefinitionFactory::GRID_ID;

    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'id_carousel',
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }
}