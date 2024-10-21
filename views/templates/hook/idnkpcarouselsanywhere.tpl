{if $carousels|count > 0}
    <div class="featured-products clearfix mt-3">
        {foreach $carousels as $carousel}
            <div class="idnkcp___header carousel__header">
                <div class="idnkpc__title"><h2>{$carousel.carousel->getCarouselTitle()}</h2></div>
                {if !empty($carousel.allProductsLink)}
                    <a class="all-product-link" href="{$carousel.allProductsLink}">
                        {$carousel.carousel->getCarouselBtnTitle()} <i class="mm-icon-fleche-lien"></i>
                    </a>
                {/if}
            </div>
            {assign var="productscount" value=$carousel.products|count}
            <div class="products products-slick spacing-md-top{if $productscount > 1} products--slickmobile{/if}">
                {foreach from=$carousel.products item="product"}
                    {include file="modules/idnkpcarouselsanywhere/views/templates/front/product-slick.tpl" product=$product}
                {/foreach}
            </div>
        {/foreach}
        {strip}
        <script>
            var slickConfig = {
                slidesToShow: {$carousel.carousel->getNbProductToShow()},
                slidesToScroll: {$carousel.carousel->getNbProductToScroll()},
                showDots: {$carousel.show_dots},
                showArrow: {$carousel.show_arrow}
            };
        </script>
        {/strip}
    </div>
{/if}
