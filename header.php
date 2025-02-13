<?php 
/* $prod_cat_args = array(
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
      $woo_cat_href = 'http://elovpark.ru/product/?category='. $woo_cat_slug;
      if( $woo_cat_parent != 0){
         $massive[ $woo_cat_parent ][ 'childs' ][ $woo_cat_id ] = [
              'name'    => $woo_cat_name,
              'image'   => $image,
              'href'    => $woo_cat_href
         ];
      }else{
         if( $woo_cat_id != 16 && $woo_cat_id != 29 && $woo_cat_id != 18 ){
              $massive[ $woo_cat_id ] = [
                   'name'    => $woo_cat_name,
                   'href'    => $woo_cat_href  
              ];
         }    
      }
  }
  $output_cat .= ''; 
  foreach ( $massive as $elements ) {
    if( isset( $elements[ 'childs' ] ) && $elements[ 'childs' ] != '' ) {
        $output_cat .= '<div class="drop-categories-item">'.$elements[ 'name' ].'</div>';
        foreach ( $elements[ 'childs' ] as $child ){
            $output_cat .= '<div class="drop-categories-item">'. $child[ 'name' ]. '</div>';
        }
    }
  } */
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
      $woo_cat_href = 'http://elovpark.ru/product/?category='. $woo_cat_name;
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

  $output_cat .= '<div class="drop-inner drop-categories-inner">'; 
  foreach ( $massive as $elements ) {
    if( isset( $elements[ 'childs' ] ) && $elements[ 'childs' ] != '' ) {
        $output_cat .= '<div class="drop-item drop-categories-item contains first-drop">
            <div class="drop-item-name drop-categories-item-name">'.$elements[ 'name' ].'</div>
            <div class="drop-submenu drop-categories-submenu">';
        foreach ( $elements[ 'childs' ] as $child ){
            if( isset( $child[ 'mini_childs' ] ) && $child[ 'mini_childs' ] != '' ){
                $output_cat .= '<div class="drop-item drop-categories-item contains open second-drop">
                <div class="drop-item-name drop-categories-item-name"><a href="' . $child[ 'href' ] . '">'.$child[ 'name' ].'</a></div>
                <div class="drop-submenu drop-categories-submenu">';
            }else{
                $output_cat .= '<div class="drop-item drop-categories-item open second-drop">
                <div class="drop-item-name drop-categories-item-name"><a href="' . $child[ 'href' ] . '">'.$child[ 'name' ].'</a></div>';
            }
            if( isset( $child[ 'mini_childs' ] ) && $child[ 'mini_childs' ] != '' ){
                foreach ( $child[ 'mini_childs' ] as $mini_child ){
                    $output_cat.= '<a href="' . $mini_child[ 'href' ] . '" class="third-drop">'.$mini_child[ 'name' ].'</a>';
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="yandex-verification" content="0b58e3d6033c5847">
    <?php wp_head(); ?>
    <title>    <?php if( is_404() ){
        echo 'Ошибка 404';
    }else{
        the_title();
    }
    $nonactive = false;
    ?></title>
    <script src='https://salebot.pro/js/salebot.js?v=1' charset='utf-8'></script>
<script>
  SaleBotPro.init({
    onlineChatId: '3092'
  });
</script>
</head>

<body>
    <div class="burger-fade burger-close" data-params="{'target':'drop-categories'}"></div>
    <div class="burger menu hidden burger-close" data-params="{'target':'menu'}">
        <div class="menu-outer">
            <div class="menu-close-outer">
                <img src="/wp-content/uploads/2024/05/close.svg" class="menu-close burger-close" alt="close" data-params="{'target':'menu'}">
            </div>
            <div class="menu-inner">
                <div class="menu-item location underline">
                    <div>
                        <img src="/wp-content/uploads/2024/05/Marker.svg" alt="Marker">
                    </div>
                    <div class="menu-header-push-marker">
                        <a href="https://yandex.ru/maps/?um=constructor%3Ae986f1bb986e53caa0420aea730ef6a4e9216e3650d3c689987b008f9c8bf27a&source=constructorLink" target="_blank" style="color: #3A6431;">Иркутск</a>
                    </div>
                </div>
                    
                <ul class="menu-nav-outer">
                    <?php 
                                    $args = [
                                        'theme_location'  => 'mobile',
                                        'container'       => false,
                                        'menu_class'    => '',
                                        'menu_id'       => '',
                                        'items_wrap' => '%3$s',
                                    ];
                                    wp_nav_menu($args);
                    ?>
                </ul>
                <a href="/cart/" class="js-basket menu-item menu-basket">
                    <div class="js-alert menu-alert" data-params="{'cookie_name':'yellow-cart'}"></div>
                        <div class="menu-basket-img">
                            <img src="/wp-content/uploads/2024/05/Basket.svg" alt="Basket">
                        </div>
                    <div class="menu-basket-text">
                        Корзина
                    </div>
                </a>
                
                <a href="/favourites/" class="js-basket menu-item menu-basket">
                    <div class="menu-item menu-favourites">
                        <div class="js-alert menu-alert" data-params="{'cookie_name':'yellow-like'}"></div>
                        <div class="menu-favourites-img">
                            <img src="/wp-content/uploads/2024/05/Heart.svg" alt="Basket">
                        </div>
                        <div class="menu-favourites-text">
                            Избранное
                        </div>
                    </div>
                </a>
                <div class="menu-header-push-phone">
                    <div class="burger menu-phone menu-phone-small hidden">
                        <div class="header-surqle">
                            <img src="/wp-content/uploads/2024/05/Phone.svg" alt="Phone" style="width: 45%;">
                        </div>
                        <a href="https://taplink.cc/elovpark"
                        target="_blank" class="header-text-phone">+7 (3952) 57-77-00</a>
                    </div>
                    <div class="menu-header-surqle">
                        <img src="/wp-content/uploads/2024/05/Phone.svg" alt="Phone" style="width: 50%">
                    </div>
                    <a href="https://taplink.cc/elovpark"
                            target="_blank" class="menu-header-text-phone">+7 (3952) 57-77-00</a>
                    <div class="header-phone-btn burger-btn" data-params="{'target':'menu-phone-small'}" style="display: none;">
                        <svg width="14" height="9" viewBox="0 0 14 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="menu-item menu-social">
                    <a class="contents" href="https://api.whatsapp.com/send?phone=79643577700&amp;text=" target="_blank">
                        <img src="../wp-content/uploads/2024/06/ws-1.svg" alt="ws">
                    </a>
                    <a class="contents" href="viber://chat?number=%2B89643577700/" target="_blank">
                        <img src="../wp-content/uploads/2024/06/viber.svg" alt="viber">
                    </a>
                    <a class="contents" href="https://t.me/ElovPark_bot" target="_blank">
                        <img src="../wp-content/uploads/2024/06/tg-1.svg" alt="tg">
                    </a>
                    <a class="contents" href="https://vk.com/write-226021160" target="_blank">
                        <img src="../wp-content/uploads/2024/06/vk-1.svg" alt="vk">
                    </a>
                    <a class="contents" href="https://ok.ru/group/70000006413774" target="_blank">
                        <img src="../wp-content/uploads/2024/06/ok-1.svg" alt="ok">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-row">
        <div class="header">
            <div class="header-logo">
                <a href="<?= home_url();?>">
                    <?php the_custom_logo(); ?>
                </a>
                <img src="/wp-content/uploads/2024/05/Header-left-menu.svg" alt="Header-left-menu" class="header-content-left-menu burger-btn" data-params="{'target':'menu'}">
            </div>
            <div class="header-content-center">
                <?php 
                $args = [
                    'menu'              => '', // ID, имя или ярлык меню
                    'menu_class'        => 'menu', // класс элемента <ul>
                    'menu_id'           => '', // id элемента <ul>
                    'container'         => false, // тег контейнера или false, если контейнер не нужен
                    'container_class'   => '', // класс контейнера
                    'container_id'      => '', // id контейнера
                    'fallback_cb'       => 'wp_page_menu', // колбэк функция, если меню не существует
                    'before'            => '', // текст (или HTML) перед <a
                    'after'             => '', // текст после </a>
                    'link_before'       => '<div class="header-text-center">', // текст перед текстом ссылки
                    'link_after'        => '</div>', // текст после текста ссылки
                    'echo'              => true, // вывести или вернуть
                    'depth'             => 0, // количество уровней вложенности
                    'walker'            => '', // объект Walker
                    'theme_location'    => 'top', // область меню
                    'items_wrap'        => '%3$s',
                    'item_spacing'      => 'preserve'
                ];
                wp_nav_menu($args);
                ?>
            </div>
            <div class="header-content-right">
                <div class="header-content-right-child">
                    <div class="burger menu-phone menu-phone-big hidden">
                        <div class="header-surqle">
                            <img src="/wp-content/uploads/2024/05/Phone.svg" alt="Phone" style="width: 45%;">
                        </div>
                        <a href="#" class="header-text-phone">+7 964 357-77-00</a>
                    </div>
                    <div class="header-surqle">
                        <img src="/wp-content/uploads/2024/05/Phone.svg" alt="Phone" style="width: 45%;">
                    </div>
                    <div class="header-push-phone">
                        <a  href="https://taplink.cc/elovpark"
                            target="_blank"
                            class="header-text-phone">+7 (3952) 57-77-00</a>
                    </div>
                    <div class="header-phone-btn header-phone-btn-big-screen burger-btn" data-params="{'target':'menu-phone-big'}">
                        <svg width="14" height="9" viewBox="0 0 14 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="header-content-right-child header-push-right">
                    <div>
                        <img src="/wp-content/uploads/2024/05/Marker.svg" alt="Marker">
                    </div>
                    <div class="header-push-marker">
                        <a href="https://yandex.ru/maps/?um=constructor%3Ae986f1bb986e53caa0420aea730ef6a4e9216e3650d3c689987b008f9c8bf27a&source=constructorLink" target="_blank"
                            style="color: #3A6431;">Иркутск</a>
                    </div>
                </div>
                <div>
                    <div class="header-content-right-menu">
                        <img src="/wp-content/uploads/2024/05/Header-menu.svg" alt="Header-menu" class="burger-btn" data-params="{'target':'menu'}">
                    </div>
                </div>
            </div>
            <div class="header-messenger">
                <div>
                    <a href="https://api.whatsapp.com/send?phone=79643577700&text=" target="_blank">
                        <img src="../wp-content/uploads/2024/06/ws-1.svg" alt="ws" class="header-messenger-img">
                    </a>
                </div>
                <div>
                    <a href="viber://chat?number=%2B89643577700/" target="_blank">
                        <img src="../wp-content/uploads/2024/06/viber.svg" alt="viber" class="header-messenger-img">
                    </a>
                </div>
                <div>
                    <a href="https://t.me/ElovPark_bot" target="_blank">
                        <img src="../wp-content/uploads/2024/06/tg-1.svg" alt="tg" class="header-messenger-img">
                    </a>
                </div>
                <div>
                    <a href="https://vk.com/write-226021160" target="_blank">
                        <img src="../wp-content/uploads/2024/06/vk-1.svg" alt="vk" class="header-messenger-img">
                    </a>
                </div>
                <div>
                    <a href="https://ok.ru/group/70000006413774" target="_blank">
                        <img src="../wp-content/uploads/2024/06/ok-1.svg" alt="ok" class="header-messenger-img">
                    </a>
                </div>
            </div>
        </div>
        <div class="search-content">
            <div class="search-line">
                <div class="requests">
                    <div class="drop-categories burger hidden">
                        <div class="menu-close-outer">
                            <img src="/wp-content/uploads/2024/05/close.svg" class="menu-close burger-close" alt="close" data-params="{'target':'drop-categories'}">
                        </div>
                        <h2 class="h-line">Категории</h2>
                        <div class="drop-categories-inner">
                            <?php echo $output_cat; ?>
                        </div>
                    </div>
                    <button class="requests-btn burger-btn" data-params="{'target':'drop-categories'}">
                        Все категории<span class="icon triangle left"></span>
                    </button>
                    <div class="vertical">
                        <div class="search-outer">
                            <input class="search" type="search" placeholder="Напишите ваш запрос" data-params="{'target_url':'/products','searchParam_name':'search','button_class':'search-button','suggestions_url':'/wp-content/themes/yellow-park/modules/json_products_urls.php'}">
                            <div class="suggestions">

                            </div>
                        </div>  
                    </div>
                </div>
                <div class="search-button">
                    <img src="/wp-content/uploads/2024/05/Serch.svg" alt="Serch" class="serch-img">
                </div>
            </div>
            <div class="js-basket basket basket-push-left">
                <a href="/cart/">   
                    <div class="js-alert alert" data-params="{'cookie_name':'yellow-cart'}"></div>
                    <div class="basket-img">
                        <img src="/wp-content/uploads/2024/05/Basket.svg" alt="Basket">
                    </div>
                    <div class="basket-text">
                        Корзина
                    </div>
                </a>
            </div>

            <div class="favourites favourites-push-left">
                <a href="favourites">
                    <div class="js-alert alert" data-params="{'cookie_name':'yellow-like'}"></div>
                    <div class="favourites-img">
                        <img src="/wp-content/uploads/2024/05/Heart.svg" alt="Basket">
                    </div>
                    <div class="favourites-text">
                        Избранное
                    </div>
                </a>
            </div>
        </div> 
        <?php  if( !isset( $_GET[ 'const' ] ) ){
            $_GET[ 'const' ] = 'false';
            $active = '<div class="categories-button" data-value="Саженцы">';
        }elseif( $_GET[ 'const' ] == 'Seedlings' ){
            $active = '<div class="categories-button" data-value="Саженцы">';
        }else{
            $active = '<div class="categories-button data-value="Саженцы"">';
        }?>       
        <div class="categories-choosing">
        <a href="/products/?category=Декоративные культуры" class="contents">
            <?php echo $active ?>
                <div>
                    <img src="/wp-content/uploads/2024/05/Seedlings-1.svg" alt="Seedlings" class="Seedlings">
                </div>
                <div>
                    Саженцы
                </div>
            </div>
            </a>
            <?php  if( $_GET[ 'const' ]  == 'Design' ){
            $active = '<div class="categories-button">';
        }else{
            $active = '<div class="categories-button">';

        }?>     
                    <a href="https://land38.ru/" class="contents">
            <?php echo $active ?>

                <div>
                    <img src="/wp-content/uploads/2024/05/Mountains.svg" alt="Mountains" class="Mountains"> 
                </div>
                <div>
                </div>
                <div>
                    Ландшафтный дизайн 
                </div>
            </div>
    </a>
            <?php  if( $_GET[ 'const' ]  == 'Garden' ){
            $active = '<div class="categories-button" style="min-width: 110px">';
        }else{
            $active = '<div class="categories-button" style="min-width: 110px">';
        }?>     
            <a href="/products/?const=Garden" class="contents">
                <?php echo $active ?>
                <div class="categories-button-twoimg">
                    <img src="/wp-content/uploads/2024/05/Seedling.svg" alt="Seedling" class="Seedling">
                    <img src="/wp-content/uploads/2024/05/Spade.svg" alt="Spade" class="Spade">
                </div>
                <div>
                    Товары по уходу за садом 
                </div>
            </div> </a>
            <?php  if( $_GET[ 'const' ]  == 'Seeds' ){
            $active = '<div class="categories-button" data-value="Семена">';
        }else{
            $active = '<div class="categories-button" data-value="Семена">';
        }?>     
        <a href="/products/?category=Семена" class="contents">
            <?php echo $active ?>
                <div>
                    <img src="/wp-content/uploads/2024/05/Seeds.svg" alt="Seeds" class="Seeds">
                </div>
                <div>
                    Семена 
                </div>
            </div>
            </a>
        </div>
        <?php
        if($_SERVER["REQUEST_URI"] != "/"){
            echo '<div class="back">';
            echo '<span class="icon left arrow-left-thin"></span>';
            if(function_exists('bcn_display'))
            {
                bcn_display();
            }   
            echo '</div>';
        }
?>