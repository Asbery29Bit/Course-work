<?php 
/*
Template Name: Главная
*/
get_header() ?>
<main>
    <?php $loop = CFS()->get( 'karusel' );
        $output = '';
        foreach ( $loop as $element ){
            if( $element[ 'karusel_button_active' ] == true ){
                $karusel_href = '<a href="' . $element[ 'karusel_href' ] . '">
                <button class="dark">
                    ' . $element[ 'karusel_button' ] . ' <span class="icon arrow arrow-left-top"></span>
                </button>
                </a>';
            }else{
                $karusel_href = '';
            }
            if ( isset( $element[ 'karusel_bg' ]))
            $output .= '<div class="first">
            <div class="first-inner" style="background-image: url(' . $element[ 'karusel_bg' ] . ')">
                <h2>' . $element[ 'karusel_name' ] . '</h2>
                <p>
                    ' . $element[ 'karusel_desc' ] . '
                </p>
                    ' . $karusel_href . '
            </div>
        </div>';
        }
    
    ?>
            <section class="slider-outer">
                <div class="slider-inner">
                <?php echo $output; ?>
                </div>
            </section>
            <?php

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
       $woo_cat_href = 'http://elovpark.ru/product/?category=' . $woo_cat_name;
       $thumbnail_id = get_woocommerce_term_meta( $woo_cat_id, 'thumbnail_id', true);
       $image = wp_get_attachment_url($thumbnail_id); 
       if( $woo_cat_parent != 0){
          $massive[ $woo_cat_parent ][ 'childs' ][ $woo_cat_id ] = [
               'name'    => $woo_cat_name,
               'image'   => $image,
               'count'  => $woo_cat_count,
               'href'    => $woo_cat_href
          ];
       }else{
          if( $woo_cat_id != 16 && $woo_cat_id != 29 && $woo_cat_id != 18 && $woo_cat_id != 28){
               $massive[ $woo_cat_id ] = [
                    'name'    => $woo_cat_name,
                    'count'  => $woo_cat_count,
                    'href'    => $woo_cat_href  
               ];
          }    
       }
   }
   $out = '';
   $categor = '';  
   foreach ( $massive as $elements ) {
     if( $elements[ 'name' ] == 'Растения'){
          $out .= '<div class="nav active" data-name="' . $elements[ 'name' ] . '">' . $elements[ 'name' ] .'</div>';
          $data_inner = 'data-name="' . $elements[ 'name' ] . '"';
     }else{
        $data_inner = 'data-name="' . $elements[ 'name' ] . '"';
          $out .= '<div class="nav" data-name="' . $elements[ 'name' ] . '">' . $elements[ 'name' ] .'</div>';
     }
     $categor .='<div class="categories-inner" ' . $data_inner .'>';
     if( isset( $elements[ 'childs' ] ) && $elements[ 'childs' ] != '' ) {
          foreach ( $elements[ 'childs' ] as $child ){
                if( $child[ 'count' ] != 0 ){
                    $categor .='<div class="category-outer">
                    <a class="contents" href="' . $child[ 'href' ] . '">
                    <img src="' . $child[ 'image' ] . '" alt="">
                    <div class="category-caption">' . $child[ 'name' ] . '</div>
                    </a>
                </div>';
                }else{
                    $categor .='<div class="category-outer inactive">
                    <img src="' . $child[ 'image' ] . '" alt="">
                    <div class="category-caption">' . $child[ 'name' ] . '</div>
                </div>';
                }
          }
     }
     $categor .= '</div>';
   }
?>
<?php $args = [    
    'status'            => [ 'draft', 'pending', 'private', 'publish' ],
    'type'              => array_merge( array_keys( wc_get_product_types() ) ),
    'parent'            => null,
    'sku'               => '',
    'category'          => [ 'Готовые решения' ],
    'tag'               => [],
    'limit'             => get_option( 'posts_per_page' ),  // -1 for unlimited
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
$loop = new WP_Query( array( 
    'category_name' => 'Готовые решения',
    'post_type' => 'product', 
    'posts_per_page' => 40,
    'orderby' => 'menu_order', 
    'order' => 'ASC',
    ));
    $output = '';
    if( $products != '' ){
        $output .= '<section class="ready-made">
        <h2 class="h-line">Готовые решения</h2>
        <div class="cards-inner">';
    }
    foreach ( $products as $product ) {
        $product_id   = $product->get_id();
        $product_name = $product->get_name();
        $product_light_sun = get_post_meta( $product_id, '_checkbox1', true );
        $product_image = wp_get_attachment_image_url( $product->get_image_id() );
        $product_light_shadow = get_post_meta( $product_id, '_checkbox2', true );
        $product_color_flower = get_post_meta( $product_id, '_textarea1', true );
        $product_degree = get_post_meta( $product_id, '_number_field3', true );
        $product_price = $product->get_price();
        $product_regular_price = $product->get_regular_price();
        $product_amount = get_post_meta( $product_id, '_number_field1', true );
        $product_href = get_permalink( $product_id );
        $class_amount = '';
        $product_name = ( str_replace( "\xc2\xa0", ' ', $product_name ) );
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
        if ( $product_light_sun == 'yes' ){
            $product_light = 'Солнце';
        }
        if ( $product_light_halfshadow == 'yes' ){
            $product_light = 'Полутень';
        }
        if ( $product_light_shadow == 'yes' ){
            $product_light = 'Тень';
        }
        $output.= '<div class="card-outer" data-params="{\'id\':'. $product_id . '}">
        <div class="img-wrapper">
        <a href="' . $product_href . '" class="contents">
            <img src="' . $product_image . '" alt="">
            </a>
            <div class="like-btn"></div>
            <div class="temp"><span class="icon right tempi"></span>' . $product_degree. '°C</div>
            <div class="tags">
                <div class="tag">' . $product_color_flower . '</div>
                <div class="tag">'. $product_light . ' </div>
            </div>
        </div>
        <div class="card-inner">
            <div class="name">' . $product_name . '</div>
            <div class="card-info">
            <div class="price-row">
                <div class="price">' . $product_price . ' ₽</div>
                <div class="old-price">' . $product_regular_price . ' ₽</div>
            </div>
            <div class="rest-cout">
                <span>Осталось ' . $product_amount . ' шт</span>
                <div class="line ' . $class_amount .'" style="--line-amount: ' . $procent_amount . '"></div>
            </div>
            <button class="in-bucket dark available"><span class="icon right card"></span>В корзину</button>
            </div>
        </div>
    </div>';
    }
    if( $products != '' ){
        $output .= '</div>
        </section>';
    }
?>
<section class="categories-outer">
                <h2>Выберите интересующую категорию</h2>
                <div class="nav-row">
                    <?php echo $out ?>
                </div>
                    <?php echo $categor ?>
            </section>
            <!-- <section class="articles">
                <div class="h-row">
                    <h2>Статьи</h2>
                    <button class="light see-more">Показать все <span class="icon arrow-right"></span></button>
                </div>
                <div class="articles-outer">
                    <div class="article-outer">
                        <div class="img-wrapper">
                            <img src="http://yellowpark/wp-content/uploads/2024/05/article.png" alt="">
                            <div class="tags">
                                <div class="tag">#сад</div>
                            </div>
                        </div>
                        <div class="article-inner">
                            <div class="top-row">
                                <div class="date">04 июня 2023</div>
                                <div class="views-count"><span class="icon right eye"></span>2048</div>
                            </div>
                            <div class="article-content">
                                <h3>Семена: маленькие чудеса природы</h3>
                                <p>Семена - это начало всего живого в растительном мире. Небольшие, но полные
                                    потенциала,
                                    они являются ключом</p>
                                <button class="light green right-bottom">Читать далее</button>
                            </div>
                        </div>
                    </div>
                    <div class="article-outer">
                        <div class="img-wrapper">
                            <img src="http://yellowpark/wp-content/uploads/2024/05/article.png" alt="">
                            <div class="tags">
                                <div class="tag">#сад</div>
                            </div>
                        </div>
                        <div class="article-inner">
                            <div class="top-row">
                                <div class="date">04 июня 2023</div>
                                <div class="views-count"><span class="icon right eye"></span>2048</div>
                            </div>
                            <div class="article-content">
                                <h3>Семена: маленькие чудеса природы</h3>
                                <p>Семена - это начало всего живого в растительном мире. Небольшие, но полные
                                    потенциала,
                                    они являются ключом</p>
                                <button class="light green right-bottom">Читать далее</button>
                            </div>
                        </div>
                    </div>
                    <div class="article-outer">
                        <div class="img-wrapper">
                            <img src="http://yellowpark/wp-content/uploads/2024/05/article.png" alt="">
                            <div class="tags">
                                <div class="tag">#сад</div>
                            </div>
                        </div>
                        <div class="article-inner">
                            <div class="top-row">
                                <div class="date">04 июня 2023</div>
                                <div class="views-count"><span class="icon right eye"></span>2048</div>
                            </div>
                            <div class="article-content">
                                <h3>Семена: маленькие чудеса природы</h3>
                                <p>Семена - это начало всего живого в растительном мире. Небольшие, но полные
                                    потенциала,
                                    они являются ключом</p>
                                <button class="light green right-bottom">Читать далее</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="light see-more invert">Показать все <span class="icon arrow-right"></span></button>
            </section> -->
            <?php $loop = CFS()->get( 'otzyv' );
        $output = '';
        foreach ( $loop as $element ){
            $date = str_replace( '-', '.', date( 'd-m-Y', strtotime( $element[ 'otzyv_date' ] ) ) );
            $output .='<div class="review first">
            <div class="avatar-outer">
                <img src="' . $element[ 'otzyv_photo' ] .  '" alt="" class="avatar">
            </div>
            <div class="review-inner">
                <h3>' . $element[ 'otzyv_name' ] . '</h3>
                <div class="date">' . $date . '</div>
                <p>' . $element[ 'otzyv_text' ] . '</p>
            </div>
        </div>
        ';
        }
    
    ?>
            <section class="reviews">
                <h2>Наши отзывы</h2>
                <div class="reviews-inner">
              <?php echo $output; ?>     
            </div>
            </section>
            <section class="contact-us-outer">
                <div class="contact-us-inner">
                    <h2>Не нашли нужный товар?<br>Свяжитесь с нами!</h2>
                    <p>Свяжитесь с нами и мы отвтеим на все ваши вопросы, или оставьте заявку и мы свяжимся с вами в
                        течение 10 мин.</p>
                    <?php echo do_shortcode( '[contact-form-7 id="ccd9a80" title="Contact form 1" html_class="contact-us-form"]' ) ?>
                </div>
            </section>
        </main>
    </div>

        <div class="nav-row">
            <div class="logo"></div>
            <div class="nav-item"></div>
            <div class="nav-item"></div>
            <div class="nav-item"></div>
            <div class="nav-item"></div>
            <div class="nav-item"></div>
            <div class="contact-data">
                <div class="number"></div>
                <div class="location"></div>
            </div>
        </div>
        <div class="policy-wrapper">
            <span></span>
            <span></span>
        </div>
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Abbed18edea34b41cd4a1b2e0a9ac3bcc6e1a6e56fbdb6559d810886c0bdaea87&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>

        <?php get_footer() ?>