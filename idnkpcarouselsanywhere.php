<?php

use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductPresenter;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

if (!defined('_PS_VERSION_')) {
    exit;
}
include_once __DIR__ .'/vendor/autoload.php';

class IdnkPCarouselsanywhere extends Module implements WidgetInterface
{
    public const IDNK_HOOK_AVALAIBLE = [
        'Display Home' => 'displayHome',
        'Display Home 2' => 'displayHome2',
        'Display Top' => 'displayTopColumn',
        'Right column' => 'displayRightColumn',
        'Left column' => 'displayLeftColumn',
        'Wrapper top' => 'displayWrapperTop',
        'Wrapper bottom' => 'displayWrapperBottom',
        'Footer product' => 'displayFooterProduct',
        'Product extra content' => 'displayProductExtraContent',
        'Product additional info' => 'displayProductAdditionalInfo',
        'Footer' => 'displayFooter',
        'Header' => 'displayHeader',
        'Before footer' => 'displayFooterBefore',
        'Shopping cart' => 'displayShoppingCart',
        'Order details' => 'displayOrderDetail',
    ];

    public const IDNK_ORDER_BY = [
        'Name' => 'name',
        'Position in category' => 'position',
        'Price' => 'price',
        'Date add' => 'date_add',
        'Date update' => 'date_upd',
    ];

    private string $templateFile;

    public function __construct()
    {
        $this->name = 'idnkpcarouselsanywhere';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Idnk Soft';
        $this->need_instance = 0;

        $tabNames = [];
        foreach (Language::getLanguages() as $lang) {
            $tabNames[$lang['locale']] = $this->trans('Product Category Carousel', [], 'Modules.IdnkPCarouselsanywhere.Admin', $lang['locale']);
        }
        $this->tabs = [
            [
                'route_name' => 'idnkpcarousel_carousel_index',
                'class_name' => 'AdminCarouselController',
                'visible' => true,
                'name' => $tabNames,
                'parent_class_name' => 'AdminParentThemes',
                'wording' => $this->trans('Carousel list', [], 'Modules.IdnkPCarouselsanywhere.Admin'),
                'wording_domain' => 'Modules.IdnkPCarouselsanywhere.Admin',
            ],
        ];

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Idnk Soft - products carousels', [], 'Modules.IdnkPCarouselsanywhere.Admin');
        $this->description = $this->trans('Create simple products carousels', [], 'Modules.IdnkPCarouselsanywhere.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.8', 'max' => _PS_VERSION_];
        $this->templateFile = 'module:idnkpcarouselsanywhere/views/templates/hook/idnkpcarouselsanywhere.tpl';
    }

    public function install(): bool
    {
        include __DIR__ . '/sql/install.php';
        Configuration::updateValue('IDNK_ENABLE_SLICK', false);
        return parent::install() && $this->registerHook('displayHeader');
    }

    public function uninstall(): bool
    {
        include __DIR__ . '/sql/uninstall.php';
        Configuration::deleteByName('IDNK_ENABLE_SLICK');
        return parent::uninstall();
    }

    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm(): string
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ?: 0;

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitIdnkPCarouselsanywhereConf';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$this->getConfigForm()]);
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm(): array
    {
        return [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->trans('Enable Slider library (model)', [], 'Modules.IdnkPCarouselsanywhere.Admin'),
                        'name' => 'IDNK_ENABLE_SLICK',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'idnk_enable_true_slick',
                                'value' => true,
                                'label' => $this->trans('Yes',[],'Modules.IdnkPCarouselsanywhere.Admin')
                            ],
                            [
                                'id' => 'idnk_enable_false_slick',
                                'value' => false,
                                'label' => $this->trans('No',[],'Modules.IdnkPCarouselsanywhere.Admin')
                            ]
                        ],
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    protected function getConfigFormValues(): array
    {
        return ['IDNK_ENABLE_SLICK' => Configuration::get('IDNK_ENABLE_SLICK', null, null, null, false),];

    }

    protected function postProcess(): string
    {
        $confirmations = '';
        if (Tools::isSubmit('submitIdnkPCarouselsanywhereConf')) {
            Configuration::updateValue('IDNK_ENABLE_SLICK', Tools::getValue('IDNK_ENABLE_SLICK'));
            $confirmations = $this->displayConfirmation($this->l('Successful update.'));
        }

        return $confirmations . $this->renderForm();
    }

    public function getContent(): string
    {
        if ((Tools::isSubmit('submitIdnkPCarouselsanywhereConf'))) {
            return $this->postProcess();
        }

        return $this->renderForm();
    }

    public function renderWidget($hookName = null, array $configuration = []): string
    {
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch($this->templateFile);
    }

    /**
     * @throws Exception
     */
    public function getWidgetVariables($hookName = null, array $configuration = []): array
    {
        $repository = $this->get('idnksoft.idnkpcarousel.repository.carousel');
        $langId = $this->context->language->id;

        $allCarousels = [];

        $carousels = $repository->getCarousels($hookName, $langId);
        if (count($carousels) > 0) {
            foreach ($carousels as $carousel) {
                $carouselId = $carousel->getId();
                $categoriesId = $repository->getCarouselCategories($carouselId);
                $products = $this->getCarouselProducts($categoriesId, $carousel->getNbProduct(), $carousel->getOrderBy(), $carousel->getSortOrder());

                $allCarousels[] = [
                    'show_arrow' => $carousel->isShowArrow() ? 'true' : 'false',
                    'show_dots' => $carousel->isShowBullet() ? 'true' : 'false',
                    'carousel' => $carousel,
                    'products' => $products,
                    'allProductsLink' => $this->getAllProductLink($categoriesId),
                    'nbProductToShow' => $carousel->getNbProductToShow(),
                    'nbProductToScroll' => $carousel->getNbProductToScroll()
                ];
            }

            // Calculate the value of $slidesToShowValue after the loop
            $slidesToShowValues = array_map(function ($c) {
                return $c->getNbProductToShow();
            }, $carousels);
            $slidesToShowValue = max(1, array_product($slidesToShowValues));

            // Modify 'arrows' and 'dots' based on $showArrow and $showDots
            foreach ($carousels as $c) {
                if ($c->isShowArrow()) {
                    $c->setShowArrow(true);
                } else {
                    $c->setShowArrow(false);
                }

                if ($c->isShowBullet()) {
                    $c->setShowBullet(true);
                } else {
                    $c->setShowBullet(false);
                }
            }
        }

        return ['carousels' => $allCarousels];
    }

    /**
     * @param array $categoryIds
     * @param int $nProducts
     * @return array
     * @throws \PrestaShop\PrestaShop\Core\Product\Search\Exception\InvalidSortOrderDirectionException
     * @throws PrestaShopDatabaseException
     * @throws ReflectionException
     */
    private function getCarouselProducts(array $categoryIds, int $nProducts, $orderBy, $sortOrder): array
    {
        if ($nProducts < 0) {
            $nProducts = 8;
        }

        $translator = $this->context->getTranslator();
        $productSearchContext = new ProductSearchContext($this->context);

        // Prepare query
        $query = new ProductSearchQuery();
        $query
            ->setResultsPerPage($nProducts)
            ->setPage(1)
            ->setSortOrder(new SortOrder('product', $orderBy, $sortOrder))
        ;

        foreach ($categoryIds as $id_category) {
            $category = new Category($id_category['id_category']);
            $searchProvider = new CategoryProductSearchProvider($translator, $category);
            $result = $searchProvider->runQuery($productSearchContext, $query);
            foreach ($result->getProducts() as $product) {
                $products[] = $product;
            }
        }

        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = $presenterFactory->getPresenter();

        $products_for_template = [];

        foreach ($products as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }

        return $products_for_template;
    }

    private function getAllProductLink($categoryIds): string
    {
        if (count($categoryIds) == 1) {
            return $this->context->link->getCategoryLink($categoryIds[0]['id_category']);
        }
        return '';
    }

    public function hookDisplayHeader(): void
    {
        if (Configuration::get('IDNK_ENABLE_SLICK') == true) {
            $this->context->controller->addCSS($this->_path . 'views/css/slick.css');
            $this->context->controller->addCSS($this->_path . 'views/css/slick-theme.css');
            $this->context->controller->addCSS($this->_path . 'views/css/swiper-bundle.min.css');
            $this->context->controller->addJS($this->_path . 'views/js/slick.min.js');
            $this->context->controller->addJS($this->_path . 'views/js/slick_front.js');
            $this->context->controller->addJS($this->_path . 'views/js/swiper-bundle.min.js');
            $this->context->controller->addJS($this->_path . 'views/js/swiper01.js');
        } else if (Configuration::get('IDNK_ENABLE_SLICK') == false) {
            $this->context->controller->addCSS($this->_path . 'views/css/slick_disabled.css');
            $this->context->controller->addCSS($this->_path . 'views/css/swiper_disabled.css');
        }
    }
}
