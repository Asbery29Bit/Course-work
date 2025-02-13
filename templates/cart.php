<?php
/*
Template Name: Корзина
*/
get_header();
//print_r( count( $_COOKIE[ 'yellow-cart' ] ) );
if ( isset( $_COOKIE[ 'yellow-cart' ] ) && $_COOKIE[ 'yellow-cart' ] != '' ){
    $massive = html_entity_decode( $_COOKIE[ 'yellow-cart' ] );
    $json = preg_replace( '/\\\/', '', $_COOKIE[ 'yellow-cart' ] );
    $json = json_decode( $json );
    $array = (array) $json;
    if( empty($array )){ 
        echo '<div class="empty-shopping-cart">
        <div class="empty-shopping-cart-heading">
            В корзине пока пусто
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
    $output = [];
    $left_cart = '';
    $right_cart = '';
    foreach ( $array as $id => $count ){
        $product = wc_get_product( $id );
        $product_name = str_replace( "\xc2\xa0", ' ', $product->get_name() );
        $product_price = $product->get_price();
        $product_regular_price = $product->get_regular_price();
        if ( $product_price == '' ){
            $product_price = $product_regular_price;
        }
        $product_image = wp_get_attachment_image_url( $product->get_image_id() );
        $left_cart .= '<div class="cart" data-params="{\'price\': \'' . $product_price . '\', \'id\': ' . $id . '}">
        <div class="cart-info-outer">
            <div class="cart-img-wrapper"><img src="' . $product_image . '" alt="" class="src"></div>
            <div class="cart-info-inner">
                <span class="title">' . $product_name . '</span>
                <span class="price"></span>
            </div>
        </div>
        <div class="cart-roller">
            <div class="cart-plus">+</div>
            <input type="number" class="cart-input" value="' . $count . '">
            <div class="cart-minus">-</div>
        </div>
    </div>';
        $right_cart .= '<div class="cart-short-row" id="' . $id . '">
        <span class="title">' . $product_name . '</span>
        <span class="price"></span>
    </div>';
    }
    $output[ 'left-cart' ] = $left_cart;
    $output[ 'right_cart' ] = $right_cart;    
}else{
    echo '<div class="empty-shopping-cart">
    <div class="empty-shopping-cart-heading">
        В корзине пока пусто
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
            <h1>Корзина</h1>
            <div class="carts-inner">
                <div class="carts-left">
                    <?php if ( isset( $output[ 'left-cart' ] ) && $output[ 'left-cart' ] != '' ){ echo $output[ 'left-cart' ]; } ?>
                </div>
                <div class="carts-right">
                    <h2>Ваша корзина</h2>
                    <div class="cart-short">
                        <?php if ( isset( $output[ 'right_cart' ] ) && $output[ 'right_cart' ] != '' ){ echo $output[ 'right_cart' ]; }?>
                    </div>
                    <div class="sum">
                        <span class="title">Итого</span>
                        <span class="price">0 ₽</span>
                    </div>
                    <a href="http://elovpark.ru/order/" class="contents">
                    <button class="dark cart-btn">Перейти к оформлению</button>
                    </a>
                </div>
            </div>
        </main>
    </div>
<?php get_footer() ?>