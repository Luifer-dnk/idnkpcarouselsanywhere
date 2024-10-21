<?php
declare(strict_types=1);

namespace IdnkSoft\Back\IdnkpCarousel\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name=IdnkSoft\Back\IdnkpCarousel\Repository\CarouselRepository::TABLE_NAME_WITH_PREFIX)
 * @ORM\Entity(repositoryClass="IdnkSoft\Back\IdnkpCarousel\Repository\CarouselRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Carousel
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_carousel", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="IdnkSoft\Back\IdnkpCarousel\Entity\CarouselLang", cascade={"persist", "remove"}, mappedBy="carousel")
     */
    private $carouselLangs;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_product", type="integer")
     */
    private $nbProduct;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_product_to_show", type="integer")
     */

    private $nbProductToShow;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_product_to_scroll", type="integer")
     */
    private $nbProductToScroll;

    /**
     * @var bool
     *
     * @ORM\Column(name="show_arrow", type="boolean")
     */
    private $showArrow = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="show_bullet", type="boolean")
     */
    private $showBullet = false;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="hook", type="string", length=255)
     */
    private $hook;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="order_by", type="string", length=255)
     */
    private $orderBy;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="sort_order", type="string", length=255)
     */
    private $sortOrder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;

    public function __construct()
    {
        $this->carouselLangs = new ArrayCollection();
        $this->carouselCategories = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getCarouselLangs()
    {
        return $this->carouselLangs;
    }

    /**
     * @param int $langId
     * @return CarouselLang|null
     */
    public function getCarouselLangByLangId(int $langId)
    {
        foreach ($this->carouselLangs as $carouselLang) {
            if ($langId === $carouselLang->getLang()->getId()) {
                return $carouselLang;
            }
        }
        return null;
    }

    /**
     * @param CarouselLang $carouselLang
     * @return $this
     */
    public function addCarouselLang(CarouselLang $carouselLang)
    {
        $carouselLang->setCarousel($this);
        $this->carouselLangs->add($carouselLang);
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Carousel
     */
    public function setId(int $id): Carousel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Carousel
     */
    public function setPosition(int $position): Carousel
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Carousel
     */
    public function setActive(bool $active): Carousel
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbProduct(): int
    {
        return $this->nbProduct;
    }

    /**
     * @param int $nbProduct
     * @return Carousel
     */
    public function setNbProduct(int $nbProduct): Carousel
    {
        $this->nbProduct = $nbProduct;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowArrow(): bool
    {
        return $this->showArrow;
    }

    /**
     * @param bool $showArrow
     * @return Carousel
     */
    public function setShowArrow(bool $showArrow): Carousel
    {
        $this->showArrow = $showArrow;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowBullet(): bool
    {
        return $this->showBullet;
    }

    /**
     * @param bool $showBullet
     * @return Carousel
     */
    public function setShowBullet(bool $showBullet): Carousel
    {
        $this->showBullet = $showBullet;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbProductToShow(): int
    {
        return $this->nbProductToShow;
    }

    /**
     * @param int $nbProductToShow
     * @return Carousel
     */
    public function setNbProductToShow(int $nbProductToShow): Carousel
    {
        $this->nbProductToShow = $nbProductToShow;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbProductToScroll(): int
    {
        return $this->nbProductToScroll;
    }

    /**
     * @param int $nbProductToShow
     * @return Carousel
     */
    public function setNbProductToScroll(int $nbProductToScroll): Carousel
    {
        $this->nbProductToScroll = $nbProductToScroll;
        return $this;
    }

    /**
     * @return string
     */
    public function getHook(): string
    {
        return $this->hook;
    }

    /**
     * @param string $hook
     * @return Carousel
     */
    public function setHook(string $hook): Carousel
    {
        $this->hook = $hook;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     * @return Carousel
     */
    public function setOrderBy(string $orderBy): Carousel
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getSortOrder(): string
    {
        return $this->sortOrder;
    }

    /**
     * @param string $sortOrder
     * @return Carousel
     */
    public function setSortOrder(string $sortOrder): Carousel
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * @param \DateTime $dateAdd
     * @return Carousel
     */
    public function setDateAdd(\DateTime $dateAdd): Carousel
    {
        $this->dateAdd = $dateAdd;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpd(): \DateTime
    {
        return $this->dateUpd;
    }

    /**
     * @param \DateTime $dateUpd
     * @return Carousel
     */
    public function setDateUpd(\DateTime $dateUpd): Carousel
    {
        $this->dateUpd = $dateUpd;
        return $this;
    }

    /**
     * @return string
     */
    public function getCarouselTitle()
    {
        if ($this->carouselLangs->count() <= 0) {
            return '';
        }

        $carouselLang = $this->carouselLangs->first();

        return $carouselLang->getTitle();
    }

    /**
     * @return string
     */
    public function getCarouselBtnTitle()
    {
        if ($this->carouselLangs->count() <= 0) {
            return '';
        }

        $carouselLang = $this->carouselLangs->first();

        return $carouselLang->getBtnTitle();
    }

    /**
     * Now we tell doctrine that before we persist or update we call the update
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setDateUpd(new DateTime());
        if ($this->getDateAdd() == null) {
            $this->setDateAdd(new DateTime());
        }
    }
}