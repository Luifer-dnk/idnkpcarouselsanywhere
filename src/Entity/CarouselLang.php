<?php

declare(strict_types=1);

namespace IdnkSoft\Back\IdnkpCarousel\Entity;

use Doctrine\ORM\Mapping as ORM;
use PrestaShopBundle\Entity\Lang;

/**
 * @ORM\Table(name=IdnkSoft\Back\IdnkpCarousel\Repository\CarouselRepository::TABLE_NAME_LANG_WITH_PREFIX)
 * @ORM\Entity()
 */
class CarouselLang
{

    /**
     * @var Carousel
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="IdnkSoft\Back\IdnkpCarousel\Entity\Carousel", inversedBy="carouselLangs")
     * @ORM\JoinColumn(name="id_carousel", referencedColumnName="id_carousel", nullable=false)
     */
    private $carousel;

    /**
     * @var Lang
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="PrestaShopBundle\Entity\Lang")
     * @ORM\JoinColumn(name="id_lang", referencedColumnName="id_lang", nullable=false, onDelete="CASCADE")
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="btn_title", type="string", length=255)
     */
    private $btnTitle;


    /**
     * @return Carousel
     */
    public function getId(): Carousel
    {
        return $this->id;
    }

    /**
     * @param Carousel $id
     * @return CarouselLang
     */
    public function setId(Carousel $id): CarouselLang
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Lang
     */
    public function getLang(): Lang
    {
        return $this->lang;
    }

    /**
     * @param Lang $lang
     * @return CarouselLang
     */
    public function setLang(Lang $lang): CarouselLang
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return CarouselLang
     */
    public function setTitle(string $title): CarouselLang
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getBtnTitle(): string
    {
        return $this->btnTitle;
    }

    /**
     * @param string $btnTitle
     * @return CarouselLang
     */
    public function setBtnTitle(string $btnTitle): CarouselLang
    {
        $this->btnTitle = $btnTitle;
        return $this;
    }

    /**
     * @return Carousel
     */
    public function getCarousel(): Carousel
    {
        return $this->carousel;
    }

    /**
     * @param Carousel $carousel
     * @return CarouselLang
     */
    public function setCarousel(Carousel $carousel): CarouselLang
    {
        $this->carousel = $carousel;
        return $this;
    }
}