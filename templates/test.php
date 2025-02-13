<?php
/*
Template Name: Тест
*/
get_header();
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
     print_r( $cart_item );
}
?>


<?php get_footer() ?>