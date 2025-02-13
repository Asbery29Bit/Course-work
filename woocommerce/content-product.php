<?php 
$output ='';
$args = [    
    'status'            => [ 'pending', 'private', 'publish' ],
    'type'              => array_merge( array_keys( wc_get_product_types() ) ),
    'parent'            => null,
    'sku'               => '',
    'category'          => [],
    'tag'               => [],
    'limit'             => -1,
    'offset'            => null,
    'page'              => 1,
    'include'           => [],
    'exclude'           => [],
    'orderby'           => 'date',
    'order'             => 'DESC',
    'return'            => 'objects',
    'paginate'          => false,
    'shipping_class'    => [],
];

// Array of product objects
$products = wc_get_products( $args );
$categories_put = '';
$proguct_tags = '';
// Loop through list of products
foreach ( $products as $product ) {
    // Collect product variables
    $product_id   = $product->get_id();
    $product_name = $product->get_name();
    $product_price = $product->get_price();
    $product_regular_price = $product->get_regular_price();
    $product_image = wp_get_attachment_image_url( $product->get_image_id() );
    $product_category = $product->get_category_ids();
    $product_amount = get_post_meta( $product_id, '_number_field1', true );
    $product_height = get_post_meta( $product_id, '_number_field2', true );
    $product_degree = get_post_meta( $product_id, '_number_field3', true );
    $product_popularity = get_post_meta( $product_id, '_number_field5', true );
    $product_color_flower = str_replace( "\xc2\xa0", ' ', get_post_meta( $product_id, '_textarea1', true ) );
    $product_color_list = str_replace( "\xc2\xa0", ' ', get_post_meta( $product_id, '_textarea2', true ) );
    $product_light_sun = get_post_meta( $product_id, '_checkbox1', true );
    $product_light_halfshadow = get_post_meta( $product_id, '_checkbox2', true );
    $product_light_shadow = get_post_meta( $product_id, '_checkbox3', true );
    $product_href = get_permalink( $product_id );
    $product_name = ( str_replace( "\xc2\xa0", ' ', $product_name ) );
    if( $product_popularity == '' ){
        $product_popularity = 0;
    }
    if ( $product_light_sun == 'yes' ){
        $product_light = 'Солнце';
    }
    if ( $product_light_halfshadow == 'yes' ){
        $product_light = 'Полутень';
    }
    if ( $product_light_shadow == 'yes' ){
        $product_light = 'Тень';
    }
    
    if ( $product_light_sun == 'yes' ){
        $product_light_sun = 'true';
    }else{
        $product_light_sun = 'false';
    }
    if( $product_light_shadow == 'yes' ){
        $product_light_shadow = 'true';
    }else{
        $product_light_shadow = 'false';
    }
    if( $product_light_halfshadow == 'yes' ){
        $product_light_halfshadow = 'true';
    }else{
        $product_light_halfshadow = 'false';
    }
    $class_amount = '';
    if ( isset( $product_amount ) && $product_amount != '' ){
        if ( $product_amount <= 1000 ){
            $procent_amount = ($product_amount/1000) * 100;
        }else{
            $procent_amount = 100;
        }
        if ( $procent_amount <= 10 ){
            $class_amount = 'red';
        }
    }
    if( isset( $product_color_flower ) && $product_color_flower != '' ){
        $color_flower = '<div class="tag">' . $product_color_flower . '</div>';
        $name_color_flower =  trim( mb_strtolower( $product_color_flower ) );
        $mass_flower[ $name_color_flower ] = 1;
    }else{
        $color_flower = '';
    }
    if( isset( $product_color_list ) && $product_color_list != '' ){
        $name_color_list =  trim( mb_strtolower( $product_color_list ) );
        $mass_list[ $name_color_list ] = 1;
    }
    foreach ( $product_category as $cats ){
          $term = get_term_by( 'id', $cats, 'product_cat', 'ARRAY_A' );
          $mass_cats[] = $term[ 'name' ];
          $proguct_tags .= '<div class="tag">' . $term[ 'name' ] . '</div>';
     } 
      if ( isset( $product_price ) && $product_price != '' && isset( $product_regular_price ) && $product_regular_price != '' && $product_regular_price != $product_price){
        $price_comp = '<div class="price">' . $product_price . ' ₽</div>
        <div class="old-price">' . $product_regular_price . ' ₽</div>';
     }else{
        $price_comp = '<div class="price">' . $product_regular_price . ' ₽</div>
        <div class="old-price"></div>';
     } 
     $json_cat = json_encode( $mass_cats, JSON_UNESCAPED_UNICODE );
     $json_cat = str_replace( '"', "'", $json_cat );
    //echo 'Product ID: ' . $product_id . ' is "' . $proguct_tags . '"<br>';
     $output .= '<div class="card-outer" data-params="{\'list_filter\':{\'category\':' . $json_cat  . ',\'height\':\'' . $product_height * 1000 . '\',\'cold\':\'' . $product_degree. '\',\'flower_color\':\'' . trim( mb_strtolower( $product_color_flower ) ) . '\',\'leaf_color\':\'' . trim( mb_strtolower( $product_color_list ) ) . '\',\'sun\':\''. $product_light_sun . '\',\'shade\':\'' . $product_light_halfshadow . '\',\'shadow\':\'' . $product_light_shadow . '\', \'search\': \'' . $product_name . '\'}, \'id\': ' . $product_id . ', \'list_sort\':{\'amount\':' . $product_amount .' ,\'price\': ' . $product_price . ',\'popularity\': ' . $product_popularity .'}}">
    <div class="img-wrapper">
        <a href="' . $product_href . '" class="contents">
        <img loading="lazy" src="' . $product_image . '" alt="">
        </a>
        <div class="like-btn"></div>
        <div class="temp"><span class="icon right tempi"></span>' . $product_degree . '°C</div>
        <div class="tags">
        ' . $color_flower . '
        <div class="tag">'. $product_light . ' </div>
    </div>
    </div>
    <div class="card-inner">
        <div class="name">' . $product_name . '</div>
        <div class="card-info">
        <div class="price-row">
            ' . $price_comp . '
        </div>
        <div class="rest-cout">
           <span>Осталось ' . $product_amount . ' шт</span>
           <div class="line ' . $class_amount .'" style="--line-amount: ' . $procent_amount . '"></div>
        </div>
        <button class="in-bucket dark available"><span class="icon right card"></span>В корзину</button>
        </div>
    </div>
 </div>';
 $mass_cats = [];
     $proguct_tags = '';
}
foreach ( $mass_flower as $name => $value ){
    $folwer_list .= '<option value="' . $name . '">' . str_replace( '+', ' ', $name ). '</option>';
}
foreach ( $mass_list as $name => $value ){
    $list_list .= '<option value="' . $name . '">' . str_replace( '+', ' ', $name ). '</option>';
}
$prod_cat_args = array(
    'taxonomy'    => 'product_cat',
    'orderby'     => 'id', // здесь по какому полю сортировать
    'hide_empty'  => false, // скрывать категории без товаров или нет 
  );

$woo_categories = get_categories( $prod_cat_args );
//print_r( $woo_categories );
  foreach ( $woo_categories as $woo_cat ) {
      $woo_cat_id = $woo_cat->term_id; //category ID
      $woo_cat_name = $woo_cat->name; //category name
      $woo_cat_slug = $woo_cat->slug;
      $woo_cat_parent = $woo_cat->parent;
      $woo_cat_count = $woo_cat->count; 
      $woo_cat_href = 'http://elovpark.ru/product/?category='. $woo_cat_slug;
      if( $woo_cat_parent != 0){
        foreach ( $massive as $id => $value ){
            if ( isset( $value[ 'childs' ][ $woo_cat_parent ] )){
                $massive[ $id ][ 'childs' ][ $woo_cat_parent ][ 'mini_childs' ][ $woo_cat_id ] = [
                    'name'    => $woo_cat_name,
                    'image'   => $image,
                    'href'    => $woo_cat_href
                ];
            }elseif( isset( $massive[ $woo_cat_parent ][ 'name' ] ) ){
                $massive[ $woo_cat_parent ][ 'childs' ][ $woo_cat_id ] = [
                    'name'    => $woo_cat_name,
                    'image'   => $image,
                    'href'    => $woo_cat_href
               ];
            }
        }
      }else{
         if( $woo_cat_id != 16 && $woo_cat_id != 29 && $woo_cat_id != 18 ){
              $massive[ $woo_cat_id ] = [
                   'name'    => $woo_cat_name,
                   'href'    => $woo_cat_href  
              ];
         }    
      }
  }

  $output_cat .= 
  '
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
  <div class="drop-inner category-inner">'; 
  foreach ( $massive as $elements ) {
    if( isset( $elements[ 'childs' ] ) && $elements[ 'childs' ] != '' ) {
        $output_cat .= '<div class="drop-item category-item contains">
            <div class="drop-item-name category-item-name">'.$elements[ 'name' ].'</div>
            <div class="drop-submenu category-submenu">';
        foreach ( $elements[ 'childs' ] as $child ){
            if( isset( $child[ 'mini_childs' ] ) && $child[ 'mini_childs' ] != '' ){
                $output_cat .= '<div class="drop-item category-item contains open">
                <div class="drop-item-name category-item-name"><label class="radio-label">
                <input class="filter-element-category" type="radio" value="'.$child[ 'name' ].'" name="category">
                <span class="radio-title">'.$child[ 'name' ].'</span>
        </label></div>
                <div class="drop-submenu category-submenu">';
            }else{
                $output_cat .= '<div class="drop-item category-item open">
                <div class="drop-item-name category-item-name"><label class="radio-label">
                <input class="filter-element-category" type="radio" value="'.$child[ 'name' ].'" name="category">
                <span class="radio-title">'.$child[ 'name' ].'</span>
        </label></div>';
            }
            if( isset( $child[ 'mini_childs' ] ) && $child[ 'mini_childs' ] != '' ){
                foreach ( $child[ 'mini_childs' ] as $mini_child ){
                    $output_cat.= '<label class="radio-label">
                    <input class="filter-element-category" type="radio" value="' . $mini_child[ 'name' ]. '" name="category">
                    <span class="radio-title">' . $mini_child[ 'name' ]. '</span>
                </label>';
                }
               $output_cat .= '
            </div>
            </div>';
            }
            if( isset( $child[ 'mini_childs' ] ) && $child[ 'mini_childs' ] != '' ){
                $output_cat .= '</div></div>';  
            }else{
                $output_cat .= '</div>';  
            } 
        }
    }
  }
  //var_dump( $massive );
  $output_cat .= '</div>';
?>

<!-- <div class="back"><span class="icon left arrow-left-thin"></span>Вернуться в на главную</div> -->
<div class="burger filter-modal hidden burger-close" data-params="{'target':'filter-modal'}">
    <div class="filter-modal-outer">
        <div class="menu-close-outer">
            <img src="/wp-content/uploads/2024/05/close.svg" class="menu-close burger-close" alt="close" data-params="{'target':'filter-modal'}">
        </div>
        <div class="filters-outer filter-modal-inner">
            <div class="filters-inner" data-max-width="1099">
                <fieldset class="filter-element category radio" data-filter_name="category">
                    <h2 class="underline">Категории</h2>
                    <label class="radio-label">
                    <input
                    class="filter-element-category"
                    type="radio"
                    value="Все товары"
                    name="category">
                    <span class="radio-title">Все товары</span>
                </label>
                    <?php echo $output_cat ?>
                </fieldset>
                <div class="filter-element between height" data-filter_name="height">
                    <h2>Высота растения</h2>
                    <div class="filter-element-row">
                        <input type="number" data-between="start" class="start" placeholder="от 10 см">
                        <input type="number" data-between="end" class="end" placeholder="до 2 000 см">
                    </div>
                </div>
                <div class="filter-element between cold" data-filter_name="cold">
                    <h2>Морозостойкость</h2>
                    <div class="filter-element-row">
                        <input type="number" data-between="start" class="start" placeholder="от 0°C">
                        <input type="number" data-between="end" class="end" placeholder="до 50°C">
                    </div>
                </div>
                <div class="filter-element select flower_color">
                    <h2>Цвет цветка</h2>
                    <select data-filter_name="flower_color">
                        <option value="">Не выбрано</option>
                        <?php echo $folwer_list ?>
                    </select>
                </div>
                <div class="filter-element select leaf_color">
                    <h2>Цвет листа/хвои</h2>
                    <select data-filter_name="leaf_color">
                        <option value="">Не выбрано</option>
                        <?php echo $list_list ?>
                    </select>
                </div>
                <div class="filter-element checkbox light">
                    <h2>Свет</h2>
                    <div class="checkbox-row"><input type="checkbox" data-filter_name="sun" class="sun dark" id="sun" checked> <label>Солнце</label></div>
                    <div class="checkbox-row"><input type="checkbox" data-filter_name="shade" class="shade dark" id="shade" checked> <label>Полутень</label></div>
                    <div class="checkbox-row"><input type="checkbox" data-filter_name="shadow" class="shadow dark" id="shadow" checked> <label>Тень</label></div>
                </div>
                <div class="filter-btn-row">
                    <button class="dark submit-btn">Применить</button>
                    <button class="light reset-btn">Сбросить</button>
                </div>
            </div> 
        </div>
    </div>
</div>
        <main>
            <div class="filters-outer">
                <div class="filters-inner" data-min-width="1100">
                    <fieldset class="filter-element category radio" data-filter_name="category">
                        <h2 class="underline">Категории</h2>
                        <label class="radio-label">
                        <input
                        class="filter-element-category"
                        type="radio"
                        value="Все товары"
                        name="category">
                        <span class="radio-title">Все товары</span>
                    </label>
                        <?php echo $output_cat ?>
                    </fieldset>
                    <div class="filter-element between height" data-filter_name="height">
                        <h2>Высота растения</h2>
                        <div class="filter-element-row">
                            <input type="number" data-between="start" class="start" placeholder="от 10 см">
                            <input type="number" data-between="end" class="end" placeholder="до 2 000 см">
                        </div>
                    </div>
                    <div class="filter-element between cold" data-filter_name="cold">
                        <h2>Морозостойкость</h2>
                        <div class="filter-element-row">
                            <input type="number" data-between="start" class="start" placeholder="от 0°C">
                            <input type="number" data-between="end" class="end" placeholder="до 50°C">
                        </div>
                    </div>
                    <div class="filter-element select flower_color">
                        <h2>Цвет цветка</h2>
                        <select data-filter_name="flower_color">
                            <option value="">Не выбрано</option>
                            <?php echo $folwer_list ?>
                        </select>
                    </div>
                    <div class="filter-element select leaf_color">
                        <h2>Цвет листа/хвои</h2>
                        <select data-filter_name="leaf_color">
                            <option value="">Не выбрано</option>
                            <?php echo $list_list ?>
                        </select>
                    </div>
                    <div class="filter-element checkbox light">
                        <h2>Свет</h2>
                        <div class="checkbox-row"><input type="checkbox" data-filter_name="sun" class="sun dark" id="sun" checked> <label>Солнце</label></div>
                        <div class="checkbox-row"><input type="checkbox" data-filter_name="shade" class="shade dark" id="shade" checked> <label>Полутень</label></div>
                        <div class="checkbox-row"><input type="checkbox" data-filter_name="shadow" class="shadow dark" id="shadow" checked> <label>Тень</label></div>
                    </div>
                    <div class="filter-btn-row">
                        <button class="dark submit-btn">Применить</button>
                        <button class="light reset-btn">Сбросить</button>
                    </div>
                </div> 
            </div>
            <div class="cards-outer">
                <div class="cards-outer-row">
                    <select class="sort">
                        <option value="popularity">По популярности</option>
                        <option value="amount_descending">По количеству (По убыванию)</option>
                        <option value="amount_ascending">По количеству (По возрастанию)</option>
                        <option value="price_descending">По цене (По убыванию)</option>
                        <option value="price_ascending">По цене (По возрастанию)</option>
                    </select>
                    <button class="burger-btn filter-btn onclick" data-params="{'target':'filter-modal'}"><span class="filter-btn-title">Фильтр</span> <span class="icon right filter-icon"></span></button>
                </div>
                <div class="cards-inner list-filtered">
                <?php 
                 echo $output;
                ?>
                </div>
            </div>
        </main>
    </div>
    </div>