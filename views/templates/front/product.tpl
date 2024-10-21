{**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *}
{$componentName = 'product-miniature'}

{block name='product_miniature_item'}
  {if $page.page_name = 'home'}
    <article class="{$componentName} js-{$componentName} col-lg-6 col-xl-4" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
  {else if $page.page_name = 'category'}
    <article class="{$componentName} js-{$componentName} col-lg-6 col-xl-3" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
  {/if}
  {if $page.page_name != 'product'}
    <div class="card outer">
      <div class="inner" style="height:100%;height:100%;">
      <div class="product-st">
      <a href="{$product.url}" class="{$componentName}__link">
        {include file='catalog/_partials/product-flags.tpl'}
        {block name='product_miniature_image'}
          <div class="{$componentName}__image-container thumbnail-container">
            {if $product.cover}
              <picture>
                {if isset($product.cover.bySize.default_md.sources.avif)}
                  <source 
                    srcset="
                      {$product.cover.bySize.default_xs.sources.avif} 120w,
                      {$product.cover.bySize.default_m.sources.avif} 200w,
                      {$product.cover.bySize.default_md.sources.avif} 320w,
                      {$product.cover.bySize.product_main.sources.avif} 720w"
                    sizes="(min-width: 1300px) 720px, (min-width: 768px) 50vw, 50vw" 
                    type="image/avif"
                  >
                {/if}

                {if isset($product.cover.bySize.default_md.sources.webp)}
                  <source 
                    srcset="
                      {$product.cover.bySize.default_xs.sources.webp} 120w,
                      {$product.cover.bySize.default_m.sources.webp} 200w,
                      {$product.cover.bySize.default_md.sources.webp} 320w,
                      {$product.cover.bySize.product_main.sources.webp} 720w"
                    sizes="(min-width: 1300px) 320px, (min-width: 768px) 120px, 50vw" 
                    type="image/webp"
                  >
                {/if}

                <img
                  class="{$componentName}__image card-img-top"
                  srcset="
                    {$product.cover.bySize.default_xs.url} 120w,
                    {$product.cover.bySize.default_m.url} 200w,
                    {$product.cover.bySize.default_md.url} 320w,
                    {$product.cover.bySize.product_main.url} 720w"
                  sizes="(min-width: 1300px) 320px, (min-width: 768px) 120px, 50vw" 
                  src="{$product.cover.bySize.default_md.url}" 
                  width="{$product.cover.bySize.default_md.width}"
                  height="{$product.cover.bySize.default_md.height}"
                  loading="lazy"
                  alt="{$product.cover.legend}"
                  title="{$product.cover.legend}"
                  data-full-size-image-url="{$product.cover.bySize.home_default.url}"
                >
                {hook h='productImageHover' id_product = $product.id_product}
              </picture>
            {else}
              <picture>
                {if isset($urls.no_picture_image.bySize.default_md.sources.avif)}
                  <source 
                    srcset="
                      {$urls.no_picture_image.bySize.default_xs.sources.avif} 120w,
                      {$urls.no_picture_image.bySize.default_m.sources.avif} 200w,
                      {$urls.no_picture_image.bySize.default_md.sources.avif} 320w,
                      {$urls.no_picture_image.bySize.product_main.sources.avif} 720w"
                    sizes="(min-width: 1300px) 720px, (min-width: 768px) 50vw, 50vw" 
                    type="image/avif"
                  >
                {/if}

                {if isset($urls.no_picture_image.bySize.default_md.sources.webp)}
                  <source 
                    srcset="
                      {$urls.no_picture_image.bySize.default_xs.sources.webp} 120w,
                      {$urls.no_picture_image.bySize.default_m.sources.webp} 200w,
                      {$urls.no_picture_image.bySize.default_md.sources.webp} 320w,
                      {$urls.no_picture_image.bySize.product_main.sources.webp} 720w"
                    sizes="(min-width: 1300px) 320px, (min-width: 768px) 120px, 50vw" 
                    type="image/webp"
                  >
                {/if}

                <img
                  class="{$componentName}__image card-img-top"
                  srcset="
                    {$urls.no_picture_image.bySize.default_xs.url} 120w,
                    {$urls.no_picture_image.bySize.default_m.url} 200w,
                    {$urls.no_picture_image.bySize.default_md.url} 320w,
                    {$urls.no_picture_image.bySize.product_main.url} 720w"
                  sizes="(min-width: 1300px) 320px, (min-width: 768px) 120px, 50vw" 
                  width="{$urls.no_picture_image.bySize.default_md.width}"
                  height="{$urls.no_picture_image.bySize.default_md.height}"
                  src="{$urls.no_picture_image.bySize.default_md.url}" 
                  loading="lazy"
                  alt="{l s='No image available' d='Shop.Theme.Catalog'}"
                  title="{l s='No image available' d='Shop.Theme.Catalog'}"
                  data-full-size-image-url="{$product.cover.bySize.home_default.url}"
                >
                {hook h='productImageHover' id_product = $product.id_product}
              </picture>
            {/if}

            {block name='quick_view_touch'}
              <button class="{$componentName}__quickview_touch btn js-quickview" data-link-action="quickview">
                  <i class="material-icons">&#xE417;</i>
              </button>
            {/block}
          </div>
        {/block}
      </a>
      </div>

      {block name='product_miniature_bottom'}
        {if $product.id_category_default == 4}
          <div class="{$componentName}__infos__top">
              {block name='product_name'}
                <a href="{$product.url}"><p class="{$componentName}__title">{$product.name}</p></a>
              {/block}
          </div>
          <!-- ADD FEATURES DESC. -->
          {block name='product_features'}
            {if $product.grouped_features}
                <div class="section-feature">
                  <section class="datasheet-product-mini">
                    <h5 class="txt-center">{l s='Data sheet' d='Shop.Theme.Catalog'}</h5>
                    <dl>
                      {foreach from=$product.grouped_features item=feature}
                        <dt class="feature-product-min">{$feature.name}</dt>
                        <dd class="feature-product-min">{$feature.value|escape:'htmlall'|nl2br nofilter}</dd>
                      {/foreach}
                    </dl>
                  </section>
                </div>
            {/if}
            {/block}
            <!-- END ADD FEATURES DESC. -->
            <!-- ADD PACK INFO CONTENT -->
            {if Pack::isPack($product.id_product)}{assign var=packItems value=Pack::getItemTable($product.id_product, Context::getContext()->language->id)}
                {if $packItems|@count > 0}
                    <div class="pack-content">
                        <h5 class="text-center title-pack"><p>{l s='Package content'}</p></h5>
                        {foreach from=$packItems item=packItem}
                            <div class="detailsPack">
                                <div class="img-pkg-content">
                                    <a href="{$link->getProductLink($packItem.id_product, $packItem.link_rewrite)|escape:'html':'UTF-8'}" class="img-pkg">
                                        <img src="{$link->getImageLink($packItem.link_rewrite, $packItem.id_image, 'cart_default')|escape:'html':'UTF-8'}" alt="{$packItem.name|escape:'html':'UTF-8'}" class="image-prod-pack">
                                    </a>
                                </div>
                                <div class="qty-pkg">
                                    {$packItem.pack_quantity} x
                                </div>
                                <div class="link-pkg">
                                    <a href="{$link->getProductLink($packItem.id_product, $packItem.link_rewrite)|escape:'html':'UTF-8'}">{$packItem.name|escape:'html':'UTF-8'}
                                    </a>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                {/if}
            {/if}
            <!-- END ADD PACK INFO CONTENT -->
            {if $product.price_amount eq "0"}
                    <span class="{$componentName}__price-free" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
                    {l s='FREE MODULE' d='Shop.Theme.Catalog'}
                    </span>
            {/if}
            <div class="add-to-cart-gh">
              <a href="https://github.com/dnkhack?tab=repositories" target="_blank" rel="noopener"><h5 class="h5-selling">{l s="DOWNLOAD FROM GITHUB" d='Shop.Theme.Catalog'}</h5></a>
            </div>
        {else}
        <div class="{$componentName}__infos card-body">
          <div class="{$componentName}__infos__top">
            {block name='product_name'}
              <a href="{$product.url}"><p class="{$componentName}__title">{$product.name}</p></a>
            {/block}
          </div>
          <!-- ADD FEATURES DESC. -->
          {block name='product_features'}
            {if $product.grouped_features}
              <section class="datasheet-product-mini">
                <h5 class="txt-center">{l s='Data sheet' d='Shop.Theme.Catalog'}</h5>
                <dl>
                  {foreach from=$product.grouped_features item=feature}
                    <dt class="feature-product-min">{$feature.name}</dt>
                    <dd class="feature-product-min">{$feature.value|escape:'htmlall'|nl2br nofilter}</dd>
                  {/foreach}
                </dl>
              </section>
            {/if}
          {/block}
          <!-- END ADD FEATURES DESC. -->
          <!-- ADD PACK INFO CONTENT -->
            {if Pack::isPack($product.id_product)}{assign var=packItems value=Pack::getItemTable($product.id_product, Context::getContext()->language->id)}
                {if $packItems|@count > 0}
                    <div class="pack-content">
                        <h5 class="text-center title-pack"><p>{l s='Package content'}</p></h5>
                        {foreach from=$packItems item=packItem}
                            <div class="detailsPack">
                                <div class="img-pkg-content">
                                    <a href="{$link->getProductLink($packItem.id_product, $packItem.link_rewrite)|escape:'html':'UTF-8'}" class="img-pkg">
                                        <img src="{$link->getImageLink($packItem.link_rewrite, $packItem.id_image, 'cart_default')|escape:'html':'UTF-8'}" alt="{$packItem.name|escape:'html':'UTF-8'}" class="image-prod-pack">
                                    </a>
                                </div>
                                <div class="qty-pkg">
                                    {$packItem.pack_quantity} x
                                </div>
                                <div class="link-pkg">
                                    <a href="{$link->getProductLink($packItem.id_product, $packItem.link_rewrite)|escape:'html':'UTF-8'}">{$packItem.name|escape:'html':'UTF-8'}
                                    </a>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                {/if}
            {/if}
          <!-- END ADD PACK INFO CONTENT -->
          <div class="{$componentName}__infos__bottom">
            {block name='product_variants'}
              <div class="{$componentName}-variants">
                {if $product.main_variants}
                  {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
                  {else}
                   <div class="variants-off">
                       <p class="no-variants">Without variants</p>
                   </div>
                {/if}
              </div>
            {/block}

            <div class="{$componentName}__prices">
              {if $product.price_amount eq "0"}
                <span class="{$componentName}__price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
                {l s='FREE MODULE' d='Shop.Theme.Catalog'}
                </span>
              {else}
                {block name='product_price'}
                  {if $product.show_price}
                    {hook h='displayProductPriceBlock' product=$product type="before_price"}

                    <span class="{$componentName}__price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
                      {capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
                      {if '' !== $smarty.capture.custom_price}
                        {$smarty.capture.custom_price nofilter}
                      {else}
                        {$product.price}
                      {/if}
                    </span>

                    {hook h='displayProductPriceBlock' product=$product type='unit_price'}

                    {hook h='displayProductPriceBlock' product=$product type='weight'}
                  {/if}
                {/block}

                {block name='product_discount_price'}
                  {if $product.show_price}
                    <div class="{$componentName}__discount-price">
                      {if $product.has_discount}
                        {hook h='displayProductPriceBlock' product=$product type="old_price"}

                        <span class="{$componentName}__regular-price" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
                      {/if}
                    </div>
                  {/if}
                {/block}
              {/if}
            </div>

            {if $product.add_to_cart_url}
              <form action="{$urls.pages.cart}" method="post" class="d-flex align-items-center mt-3">
                <input type="hidden" value="{$product.id_product}" name="id_product">
                <input type="hidden" name="token" value="{$static_token}" />
                <div class="quantity-button js-quantity-button display-ocult">
                  {include file='components/qty-input.tpl'
                    attributes=[
                      "id"=>"quantity_wanted_{$product.id_product}",
                      "value"=>"1",
                      "min"=>"{if $product.quantity_wanted}{$product.minimal_quantity}{else}1{/if}"
                    ]
                    marginHelper="mb-0"
                  }
                </div>
                <button data-button-action="add-to-cart" class="btn btn-primary ms-3 btn-center add-to-cart">
                  <i class="material-icons">&#xe854;</i>
                  <span class="">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
                </button>
              </form>
            {else}
              <a href="{$product.url}" class="btn btn-outline-primary mt-3 add-to-cart">
                {l s='See details' d='Shop.Theme.Actions'}
              </a>
            {/if}
          </div>
        </div>
      {/if}
      {/block}
      </div>
    </div>
    {else if $page.page_name == 'product'}
    <div class="card">
      <a href="{$product.url}" class="{$componentName}__link">
        {include file='catalog/_partials/product-flags.tpl'}
      </a>
      {block name='product_miniature_bottom'}
        <div class="{$componentName}__infos card-body">
          <div class="{$componentName}__infos__top">
            {block name='product_name'}
              <a href="{$product.url}"><p class="{$componentName}__title">{$product.name}</p></a>
            {/block}
          </div>

          {block name='product_description_short'}
        <div class="product__description-short rich-text">{$product.description_short nofilter}</div>
      {/block}

          <div class="{$componentName}__infos__bottom">
            {block name='product_variants'}
              <div class="{$componentName}-variants">
                {if $product.main_variants}
                  {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
                  {else}
                  <div class="variants-off">
                      <p class="no-variants">Without variants</p>
                  </div>
                {/if}
              </div>
            {/block}

            <div class="{$componentName}__prices">
              {block name='product_price'}
                {if $product.show_price}
                  {hook h='displayProductPriceBlock' product=$product type="before_price"}

                  <span class="{$componentName}__price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
                    {capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
                    {if '' !== $smarty.capture.custom_price}
                      {$smarty.capture.custom_price nofilter}
                    {else}
                      {$product.price}
                    {/if}
                  </span>

                  {hook h='displayProductPriceBlock' product=$product type='unit_price'}

                  {hook h='displayProductPriceBlock' product=$product type='weight'}
                {/if}
              {/block}

              {block name='product_discount_price'}
                {if $product.show_price}
                  <div class="{$componentName}__discount-price">
                    {if $product.has_discount}
                      {hook h='displayProductPriceBlock' product=$product type="old_price"}

                      <span class="{$componentName}__regular-price" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
                    {/if}
                  </div>
                {/if}
              {/block}
            </div>

            {if $product.add_to_cart_url}
              <form action="{$urls.pages.cart}" method="post" class="d-flex align-items-center mt-3">
                <input type="hidden" value="{$product.id_product}" name="id_product">
                <input type="hidden" name="token" value="{$static_token}" />
                <div class="quantity-button js-quantity-button display-ocult">
                  {include file='components/qty-input.tpl'
                    attributes=[
                      "id"=>"quantity_wanted_{$product.id_product}",
                      "value"=>"1",
                      "min"=>"{if $product.quantity_wanted}{$product.minimal_quantity}{else}1{/if}"
                    ]
                    marginHelper="mb-0"
                  }
                </div>
                <button data-button-action="add-to-cart" class="btn btn-primary ms-3 btn-center add-to-cart">
                  <i class="material-icons">&#xe854;</i>
                  <span class="">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
                </button>
              </form>
            {else}
              <a href="{$product.url}" class="btn btn-outline-primary mt-3 add-to-cart">
                {l s='See details' d='Shop.Theme.Actions'}
              </a>
            {/if}
          </div>
        </div>
      {/block}
    </div>
  {/if}
  </article>
{/block}
