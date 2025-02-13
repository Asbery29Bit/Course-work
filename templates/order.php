<?php
/*
Template Name: Оформление заказа
*/
get_header();
if ( isset( $_COOKIE[ 'yellow-cart' ] ) && $_COOKIE[ 'yellow-cart' ] != '' ){
    $json = preg_replace( '/\\\/', '', $_COOKIE[ 'yellow-cart' ] );
    $json = json_decode( $json );
    $array = (array) $json;
    $output = [];
    $list_items = '';
    $right_cart = '';
    foreach ( $array as $id => $count ){
        $product = wc_get_product( $id );
        $product_name = $product->get_name();
        $product_price = $product->get_price();
        $product_regular_price = $product->get_regular_price();
        $product_name = ( str_replace( "\xc2\xa0", ' ', $product_name ) );
        if ( $product_price == '' ){
            $product_price = $product_regular_price;
        }
        if ( isset( $product_price ) && $product_price != '' ){
            $amount = (int)$count * (int)$product_price;
            $total_price += $amount;
        }
        $list_items .= '<div class="order-form-row" data-params="{\'id\':' . $id . ', \'amount\':' . $count . '}">
        <span class="title">' . $product_name . '</span>
        <span class="price">' . $amount .' ₽</span>
        </div>';
    }
/*     if( $total_price < 10000 ){
        $shiping = 1000;
    }else{
        $shiping = 'Бесплатно';
    } */
    $shiping = '0';
    $output[ 'list' ] = $list_items;
}
?>
        <main>
            <div class="orders-inner">
                <div class="orders-left">
                    <h1>Оформление заказа</h1>
                    <p>Заполните поля ниже что бы наш менеджер смог связаться с вами для уточнения деталей заказа</p>
                    <form action="" class="order-form info">
                        <input class="input-text" type="text" name="name" id="name" placeholder="Ваше имя" required>
                        <input class="input-text" type="tel" pattern="\+[78][0-9]{10}" name="number" id="number" placeholder="Ваш номер телефона" required>
                        <input class="input-text" type="email" name="email" id="email" placeholder="Ваша почта" required>
                        <div class="checkbox-row">
                            <input type="checkbox" name="policy" id="policy" required>
                            <label for="polciy">Нажимая кнопку «Оставить заявку», я соглашаюсь с <a href="https://elovpark.ru/privacy_policy/">политикой конфиденциальности</a></label>
                        </div>
                        <button class="dark order-btn">Заказать</button>
                    </form>
                </div>
                <div class="orders-right">
                    <form action="" class="order-form additional light">
                        <h2>Дополнения к заказу</h2>
                        <div class="order-form-row"  data-params="{'id':'help'}">
                            <div class="checkbox-row">
                                <input class="dark" type="checkbox" name="help" id="help">
                                <label for="">Помощь в посадке</label>
                            </div>
                            <span class="price">0 ₽</span>
                        </div>
                        <div class="order-form-row" data-params="{'id':'delivery'}">
                            <div class="checkbox-row">
                                <input class="dark" type="checkbox" name="delivery" id="delivery">
                                <label for="">Доставка до дома</label>
                            </div>
                            <span class="price">0 ₽</span>
                        </div>
                    </form>
                    <div class="order-form order-sum light">
                        <h2>Ваш заказ</h2>
                        <?php echo $output[ 'list' ]; ?>
                        <div class="order-form-row" data-params="{'id':'shiping', 'amount':1}">
                            <span class="title">Стоимость доставки</span>
                            <span class="price"><?php echo $shiping; ?> ₽</span>
                        </div>
                        <div class="order-form-row additional" data-params="{'id':'services', 'amount':2}">
                            <span class="title">Дополнительные услуги</span>
                            <span class="price">0 р</span>
                        </div>
                        <div class="sum">
                            <span class="title">Итого</span> 
                            <span class="price"><?php echo $total_price; ?> ₽</span>
                        </div>
                    </div>
                    <button class="dark order-btn trigger-order-form">Заказать</button>
                </div>
            </div>
        </main>
    </div>
    <?php get_footer() ?>