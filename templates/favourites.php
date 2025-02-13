<?php
/*
Template Name: Избранное
*/
get_header();
 if ( isset( $_COOKIE[ 'yellow-like' ] ) && $_COOKIE[ 'yellow-like' ] != '' ){
    $massive = html_entity_decode( $_COOKIE[ 'yellow-like' ] );
    $json = preg_replace( '/\\\/', '', $_COOKIE[ 'yellow-like' ] );
    $json = json_decode( $json );
    $array = (array) $json;
    if( empty( $array )){ 
        echo '<div class="empty-shopping-cart">
        <div class="empty-shopping-cart-heading">
            В избранном пока пусто
        </div>
        <div class="empty-shopping-cart-text">
            Загляните на главную, чтобы выбрать товары или найдите нужное в поиске
        </div>
        <div>
        <a href="/">
            <button class="empty-shopping-cart-button-child">
                Перейти на главную
                <img src="../wp-content/uploads/2024/05/up-arrow-to-the-right.svg" alt="up-arrow-to-the-right" class="up-arrow-to-the-right">
            </button>
        </a>
        </div>
    </div></div>';
        get_footer();
        exit;
    }
    $output = '';
    foreach ( $array as $id => $count ){
        $product = wc_get_product( $id );
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
}else{
    echo '<div class="empty-shopping-cart">
    <div class="empty-shopping-cart-heading">
        В избранном пока пусто
    </div>
    <div class="empty-shopping-cart-text">
        Загляните на главную, чтобы выбрать товары или найдите нужное в поиске
    </div>
    <div>
    <a href="/">
        <button class="empty-shopping-cart-button-child">
            Перейти на главную
            <img src="../wp-content/uploads/2024/05/up-arrow-to-the-right.svg" alt="up-arrow-to-the-right" class="up-arrow-to-the-right">
        </button>
    </a>
    </div>
</div></div>';
    get_footer();
    exit;
}
?>
<main>
            <div class="cards-outer">
                <div class="cards-inner list-filtered">
                <?php 
                 echo $output;
                ?>
                </div>
            </div>
        </main>
        </div>
<?php get_footer() ?>