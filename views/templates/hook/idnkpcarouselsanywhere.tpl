{if $carousels|count > 0}
    <div class="container ipce-container featured-products clearfix mt-3">
        {foreach $carousels as $carousel}
            <div class="idnkcp___header carousel__header">
                <div class="idnkpc__title"><h2>{$carousel.carousel->getCarouselTitle()}</h2></div>
                
            </div>
            {assign var="productscount" value=$carousel.products|count}
            <div class="container products products-slick spacing-md-top{if $productscount > 1} products--slickmobile{/if}">
                {foreach from=$carousel.products item="product"}
                    {include file=$product_template product=$product}
                {/foreach}
            </div>
            <div class="container footer-link-ipce">
                {if !empty($carousel.allProductsLink)}
                    <a class="all-product-link" href="{$carousel.allProductsLink}">
                        {$carousel.carousel->getCarouselBtnTitle()} <i class="mm-icon-fleche-lien"></i>
                    </a>
                {/if}
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
