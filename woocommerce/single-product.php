<?php get_header(); 
the_post();
global $product;
/* do_action( 'woocommerce_before_main_content' ); */
$product_id = $product->get_id();
$product_name = $product->get_name();
$product_description = $product->get_description();
$product_price = $product->get_price();
$proguct_image =  $product->get_image_id();
$product_gallery = $product->get_gallery_image_ids();
$product_amount = get_post_meta( $post->ID, '_number_field1', true );
$product_height = get_post_meta( $post->ID, '_number_field2', true );
$product_degree = get_post_meta( $post->ID, '_number_field3', true );
$product_color_flower = get_post_meta( $post->ID, '_textarea1', true );
$product_color_list = get_post_meta( $post->ID, '_textarea2', true );
$product_light_sun = get_post_meta( $post->ID, '_checkbox1', true );
$product_light_halfshadow = get_post_meta( $post->ID, '_checkbox2', true );
$product_light_shadow = get_post_meta( $post->ID, '_checkbox3', true );
$product_name = ( str_replace( "\xc2\xa0", ' ', $product_name ) );
if ( $product_light_sun == 'yes' ){
    $product_light = 'Солнце';
}elseif( $product_light_halfshadow == 'yes' ){
    $product_light = 'Полутень';
}elseif( $product_light_shadow == 'yes' ){
    $product_light = 'Тень';
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
if(  isset( $proguct_image ) && $proguct_image != '' ){
     $proguct_image = wp_get_attachment_image_url( $proguct_image );
}else{
     $proguct_image = 'http://elovpark/wp-content/uploads/2024/05/1665597731_48-huivpizde-com-p-porno-zrelie-dami-smotryat-v-skaipe-na-chl-58.png';
}
if( !empty( $product_gallery ) && $product_gallery != '' ){
     foreach ( $product_gallery as $numb => $id ){
          $images[] = wp_get_attachment_image_url( $id );
     }
}
?>

    <section>
        <div class="card-left">
          
           <?php 
               echo ' <div class="card-left-child-top">
               <img src="' . $proguct_image . '" alt="ready-made1" class="img-product">
           </div>';
           if( !empty( $images ) && $images != '' ){
               echo '<div class="card-left-child-bot">';
               foreach ( $images as $url_image ){
                    echo '<div class="space-for-img">
                    <img src="' . $url_image . '" alt="ready-made" class="img-product-child">
                </div>';
               }
               echo '</div>';   
          }        
          ?>
        </div>

        <div class="card-right">
            <div class="card-right-top">
                <div class="card-right-child-top">
                    <div class="product-name">
                    <?php 
                    if ( isset( $product_name ) && $product_name != '' ){
                         echo $product_name;
                    }
                    ?>
                    </div>
                    <div class="product-right-content-adaptive card-outer" data-params="{'id':882}">
                        <div class="product-right-content-price">
                        <?php 
                         if ( isset( $product_price ) && $product_price != '' ){
                              echo $product_price . ' ₽';
                         }
                         ?>
                        </div>
                        <div class="product-right-content-remains">
                            Осталось <?php 
                         if ( isset( $product_amount ) && $product_amount != '' ){
                              echo $product_amount;
                         }
                         ?> шт
                        </div>
                        <div class="rest-cout">
                        <div class="line <?php echo $class_amount?>" style="--line-amount: <?php echo $procent_amount?>"></div>
                        </div>
                        <button class="in-bucket dark big-card product-right-content-button-text available">
                            <span class="icon right card"></span>
                            В корзину
                        </button>
                    </div>
                    <div class="product-about">
                        О товаре
                    </div>
                    <div class="product-about-info">
                        <div class="product-about-info-child">
                            <div>
                                <img src="http://elovpark.ru/wp-content/uploads/2024/05/Height.svg" alt="Height">
                            </div>
                            <div class="product-about-text">
                                <div class="product-about-text-color">Высота растения</div>
                                <div><?php 
                                if ( isset( $product_height ) && $product_height != '' ){
                                   echo $product_height;
                                }
                                ?> м</div> 
                            </div>
                        </div>
                        <div class="product-about-info-child">
                            <div>
                                <img src="http://elovpark.ru/wp-content/uploads/2024/05/Frost_resistance.svg" alt="Frost_resistance">
                            </div>
                            <div class="product-about-text">
                                <div class="product-about-text-color">Морозостойкость</div>
                                <div><?php 
                                if ( isset( $product_degree ) && $product_degree != '' ){
                                   echo $product_degree;
                                }
                                ?>°C</div> 
                            </div>
                         </div>
                         <div class="product-about-info-child">
                            <div>
                                <img src="http://elovpark.ru/wp-content/uploads/2024/05/Flower.svg" alt="Flower">
                            </div>
                            <div class="product-about-text">
                                <div class="product-about-text-color">Цвет цветка</div>
                                <div><?php 
                                if ( isset( $product_color_flower ) && $product_color_flower != '' ){
                                   echo $product_color_flower;
                                }
                                ?></div> 
                            </div>
                        </div>
                        <div class="product-about-info-child">
                            <div>
                                <img src="http://elovpark.ru/wp-content/uploads/2024/05/Sheet.svg" alt="Sheet">
                            </div>
                            <div class="product-about-text">
                                <div class="product-about-text-color">Цвет листа/хвои</div>
                                <div><?php 
                                if ( isset( $product_color_list ) && $product_color_list != '' ){
                                   echo $product_color_list;
                                }
                                ?></div> 
                            </div>
                        </div>
                        <div class="product-about-info-child">
                            <div>
                                <img src="http://elovpark.ru/wp-content/uploads/2024/05/Light_bulb.svg" alt="Light_bulb">
                            </div>
                            <div class="product-about-text">
                                <div class="product-about-text-color">Свет</div>
                                <div><?php 
                                if ( isset( $product_light ) && $product_light != '' ){
                                   echo $product_light;
                                }
                                ?></div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-right-content card-outer" data-params="{'id':882}">
                        <div class="product-right-content-price">
                        <?php 
                         if ( isset( $product_price ) && $product_price != '' ){
                              echo $product_price . ' ₽';
                         }
                         ?>
                        </div>
                        <div class="product-right-content-remains">
                            Осталось <?php 
                         if ( isset( $product_amount ) && $product_amount != '' ){
                              echo $product_amount;
                         }
                         ?> шт
                        </div>
                        <div class="rest-cout">
                            <div class="line <?php echo $class_amount?>" style="--line-amount: <?php echo $procent_amount?>"></div>
                        </div>
                        <button class="in-bucket dark big-card product-right-content-button-text available">
                            <span class="icon right card"></span>
                            В корзину
                        </button>
                </div>
            </div>
            <div class="card-right-child-bot">
                <hr class="line-of-separation">
                <div class="description">
                    Описание
                </div>
                <div class="text-under-description">
                <?php 
                    if ( isset( $product_description ) && $product_description != '' ){
                         echo $product_description;
                    }
                ?></div>
            </div>
        </div>
    </section>
    <div class="card-right-child-bot-adaptive">
        <hr class="line-of-separation">
        <div class="description">
            Описание
        </div>
        <div class="text-under-description">
        <?php 
            if ( isset( $product_description ) && $product_description != '' ){
                echo $product_description;
            }
        ?></div>
    </div>
    <?php 
    $args = [    
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
    ?>
<!--             <section class="ready-made">
                <h2 class="h-line">Готовые решение с этим растением</h2>
                <div class="cards-inner">
                </div>
            </section> -->
    </main>
    </div>
    </div>
    <?php get_footer();?>
