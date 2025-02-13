<?php 
add_action( 'wp_enqueue_scripts', 'add_scripys_and_styles' );
add_action( 'after_setup_theme', 'add_woocommerce_support' );
add_action( 'after_setup_theme', 'add_feauters' );
add_action( 'after_setup_theme', 'add_menu' );
add_filter( 'wp_nav_menu', 'custom_nav_menu', 10, 2 );
add_action( 'woocommerce_product_options_general_product_data', 'art_woo_add_custom_fields' );
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );
add_action( 'woocommerce_process_product_meta', 'art_woo_custom_fields_save', 10 );
add_filter('wpcf7_autop_or_not', '__return_false');
remove_action( 'wpcf7_init', 'wpcf7_add_form_tag_submit' );
add_action( 'wpcf7_init', 'my_add_form_tag_submit', 10, 0 );
add_filter('wpcf7_form_elements', function($content) {
 preg_match_all('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', $content,$matches);
    foreach($matches[2] as $match):
        $content = str_replace(trim($match),trim(preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $match)),$content);
    endforeach;
$content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
$content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
$content = str_replace( '<span class="wpcf7-form-control-wrap" data-name="contactEmail">', '', $content );
$content = str_replace( '</span>', '', $content );
  // Убрать атрибуты size, rows, cols
  $content = preg_replace('/(size|rows|cols)="\d+"/i', '', $content);

  return $content;
});
add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );
function wp_head_wpaction0() {
     if ( is_shop() ) { ?>
         <title>Магазин</title>
     <?php }
 }
 add_action( 'wp_head', 'wp_head_wpaction0', 0 );

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_widget', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
remove_filter( 'comment_text', 'wpautop' );
//robots.txt
add_action( 'do_robotstxt', 'my_robotstxt' );
function my_robotstxt(){
                $lines = [
                               'User-agent: *',
                               'Disallow: /wp-admin/',
                               'Allow: /',
                               'Sitemap: https://elovpark.ru/sitemap.xml',
                ];
                echo implode( "\r\n", $lines );
                die; // обрываем работу PHP
}

function my_add_form_tag_submit() {
    wpcf7_add_form_tag( 'submit', 'my_submit_form_tag_handler' );
}

function my_submit_form_tag_handler( $tag ) : string {
    return '<button type="submit" class="wpcf7-form-control wpcf7-submit dark">Оставить заявку</button>';
}
function wp_enqueue_woocommerce_style(){
     wp_register_style( 'mytheme-woocommerce', get_template_directory_uri().'/assets/css/product_card/product_card.css' );
     wp_register_style( 'cards-list', get_template_directory_uri().'/assets/css/cards/cards-list.css' );
     wp_register_style( 'cards', get_template_directory_uri().'/assets/css/cards/cards.css' );
     

     if ( class_exists( 'woocommerce' ) && is_woocommerce() && is_shop() ) {
          wp_enqueue_style( 'cards' );
          wp_enqueue_style( 'cards-list' );
          wp_enqueue_script( 'sort', get_template_directory_uri().'/assets/js/sort.js', null, null, true);
          wp_enqueue_script( 'filter', get_template_directory_uri().'/assets/js/filter.js', null, null, true);
     }
     if ( class_exists( 'woocommerce' ) && is_product() ) {
          wp_enqueue_script( 'card', get_template_directory_uri().'/assets/js/card.js', null, null, true);
          wp_enqueue_style( 'mytheme-woocommerce' );
     }
}
function art_woo_add_custom_fields() {
     global $product, $post;
     echo '<div class="options_group">';// Группировка полей 
     woocommerce_wp_text_input( array(
          'id'                => '_number_field1',
          'label'             => __( 'Количество товара', 'woocommerce' ),
          'placeholder'       => 'Ввод чисел',
          'description'       => __( 'Вводятся только числа', 'woocommerce' ),
          'type'              => 'number',
          'custom_attributes' => array(
             'step' => 'any',
             'min'  => '0',
          ),
       ) );
       woocommerce_wp_text_input( array(
          'id'                => '_number_field2',
          'label'             => __( 'Высота растения', 'woocommerce' ),
          'placeholder'       => 'Ввод чисел',
          'description'       => __( 'Вводятся только числа', 'woocommerce' ),
          'type'              => 'number',
          'custom_attributes' => array(
             'step' => 'any',
             'min'  => '0',
          ),
       ) );
       woocommerce_wp_text_input( array(
          'id'                => '_number_field3',
          'label'             => __( 'Морозостойкость', 'woocommerce' ),
          'placeholder'       => 'Ввод чисел',
          'description'       => __( 'Вводятся только числа', 'woocommerce' ),
          'type'              => 'number',
          'custom_attributes' => array(
             'step' => 'any',
             'min'  => '0',
          ),
       ) );
       woocommerce_wp_text_input( array(
          'id'                => '_number_field4',
          'label'             => __( 'Ширина растения', 'woocommerce' ),
          'placeholder'       => 'Ввод чисел',
          'description'       => __( 'Вводятся только числа', 'woocommerce' ),
          'type'              => 'number',
          'custom_attributes' => array(
             'step' => 'any',
             'min'  => '0',
          ),
       ) );
       woocommerce_wp_text_input( array(
          'id'                => '_number_field5',
          'label'             => __( 'Популярность', 'woocommerce' ),
          'placeholder'       => 'Ввод чисел',
          'description'       => __( 'Вводятся только числа', 'woocommerce' ),
          'type'              => 'number',
          'custom_attributes' => array(
             'step' => 'any',
             'min'  => '0',
          ),
       ) );
       woocommerce_wp_textarea_input( array(
          'id'            => '_textarea1', // Идентификатор поля
          'label'         => 'Цвет цветка', // Заголовок поля
          'placeholder'   => 'Ввод текста', // Надпись внутри поля
          'class'         => 'textarea-field', // Произвольный класс поля
          'style'         => 'width: 70%; background:white', // Произвольные стили для поля
          'wrapper_class' => 'wrap-textarea', // Класс обертки поля
          'desc_tip'      => 'true', // Включение подсказки
          'description'   => 'Здесь можно что-нибудть вводить',// Описение поля
          'name'          => 'textarea-field1', // Имя поля
          'rows'          => '5', //Высота поля в строках текста.
          'col'           => '10', //Ширина поля в символах.
       ) );
       woocommerce_wp_textarea_input( array(
          'id'            => '_textarea2', // Идентификатор поля
          'label'         => 'Цвет листа/хвои', // Заголовок поля
          'placeholder'   => 'Ввод текста', // Надпись внутри поля
          'class'         => 'textarea-field', // Произвольный класс поля
          'style'         => 'width: 70%; background:white', // Произвольные стили для поля
          'wrapper_class' => 'wrap-textarea', // Класс обертки поля
          'desc_tip'      => 'true', // Включение подсказки
          'description'   => 'Здесь можно что-нибудть вводить',// Описение поля
          'name'          => 'textarea-field2', // Имя поля
          'rows'          => '5', //Высота поля в строках текста.
          'col'           => '10', //Ширина поля в символах.
       ) );
       woocommerce_wp_textarea_input( array(
          'id'            => '_textarea3', // Идентификатор поля
          'label'         => 'Размер', // Заголовок поля
          'placeholder'   => 'Ввод текста', // Надпись внутри поля
          'class'         => 'textarea-field', // Произвольный класс поля
          'style'         => 'width: 70%; background:white', // Произвольные стили для поля
          'wrapper_class' => 'wrap-textarea', // Класс обертки поля
          'desc_tip'      => 'true', // Включение подсказки
          'description'   => 'Здесь можно что-нибудть вводить',// Описение поля
          'name'          => 'textarea-field3', // Имя поля
          'rows'          => '5', //Высота поля в строках текста.
          'col'           => '10', //Ширина поля в символах.
       ) );
       woocommerce_wp_textarea_input( array(
          'id'            => '_textarea4', // Идентификатор поля
          'label'         => 'Сочетается с', // Заголовок поля
          'placeholder'   => 'Ввод текста', // Надпись внутри поля
          'class'         => 'textarea-field', // Произвольный класс поля
          'style'         => 'width: 70%; background:white', // Произвольные стили для поля
          'wrapper_class' => 'wrap-textarea', // Класс обертки поля
          'desc_tip'      => 'true', // Включение подсказки
          'description'   => 'Здесь можно что-нибудть вводить',// Описение поля
          'name'          => 'textarea-field4', // Имя поля
          'rows'          => '5', //Высота поля в строках текста.
          'col'           => '10', //Ширина поля в символах.
       ) );
       woocommerce_wp_checkbox( array(
          'id'            => '_checkbox1',
          'wrapper_class' => 'show_if_simple',
          'label'         => 'Солнце',
          'description'   => 'Свет',
       ) );
       woocommerce_wp_checkbox( array(
          'id'            => '_checkbox2',
          'wrapper_class' => 'show_if_simple',
          'label'         => 'Полутень',
          'description'   => 'Свет',
       ) );
       woocommerce_wp_checkbox( array(
          'id'            => '_checkbox3',
          'wrapper_class' => 'show_if_simple',
          'label'         => 'Тень',
          'description'   => 'Свет',
       ) );
     echo '</div>';
}

function art_woo_custom_fields_save( $post_id ) {
     $product = wc_get_product( $post_id );
     $number_field = isset( $_POST['_number_field1'] ) ? sanitize_text_field( $_POST['_number_field1'] ) : '';
     $product->update_meta_data( '_number_field1', $number_field );
     $number_field = isset( $_POST['_number_field2'] ) ? sanitize_text_field( $_POST['_number_field2'] ) : '';
     $product->update_meta_data( '_number_field2', $number_field );
     $number_field = isset( $_POST['_number_field3'] ) ? sanitize_text_field( $_POST['_number_field3'] ) : '';
     $product->update_meta_data( '_number_field3', $number_field );
     $number_field = isset( $_POST['_number_field4'] ) ? sanitize_text_field( $_POST['_number_field4'] ) : '';
     $product->update_meta_data( '_number_field4', $number_field );
     $number_field = isset( $_POST['_number_field5'] ) ? sanitize_text_field( $_POST['_number_field5'] ) : '';
     $product->update_meta_data( '_number_field5', $number_field );
     $textarea_field = isset( $_POST['textarea-field1'] ) ? sanitize_text_field( $_POST['textarea-field1'] ) : '';
     $product->update_meta_data( '_textarea1', $textarea_field );
     $textarea_field = isset( $_POST['textarea-field2'] ) ? sanitize_text_field( $_POST['textarea-field2'] ) : '';
     $product->update_meta_data( '_textarea2', $textarea_field );
     $textarea_field = isset( $_POST['textarea-field3'] ) ? sanitize_text_field( $_POST['textarea-field3'] ) : '';
     $product->update_meta_data( '_textarea3', $textarea_field );
     $textarea_field = isset( $_POST['textarea-field4'] ) ? sanitize_text_field( $_POST['textarea-field4'] ) : '';
     $product->update_meta_data( '_textarea4', $textarea_field );
     $checkbox_field = isset( $_POST['_checkbox1'] ) ? 'yes' : 'no';
     $product->update_meta_data( '_checkbox1', $checkbox_field );
     $checkbox_field = isset( $_POST['_checkbox2'] ) ? 'yes' : 'no';
     $product->update_meta_data( '_checkbox2', $checkbox_field );
     $checkbox_field = isset( $_POST['_checkbox3'] ) ? 'yes' : 'no';
     $product->update_meta_data( '_checkbox3', $checkbox_field );
     $product->save();
}
function add_scripys_and_styles() {
     //Собственные скрипты
     wp_enqueue_script( 'script', get_template_directory_uri().'/assets/js/script.js', null, null, true);
     wp_enqueue_script( 'list', get_template_directory_uri().'/assets/js/list.js', null, null, true);
     if( is_page_template( 'index.php' ) ){
          wp_enqueue_style( 'slick', get_template_directory_uri().'/assets/css/slick/slick.css' );
          wp_enqueue_style( 'slick-theme', get_template_directory_uri().'/assets/css/slick/slick-theme.css' );
          wp_enqueue_style( 'cards', get_template_directory_uri().'/assets/css/cards/cards.css' );
          wp_enqueue_script( 'slick', get_template_directory_uri().'/assets/js/slick.js', null, null, true);
          wp_enqueue_script( 'first', get_template_directory_uri().'/assets/js/first.js', null, null, true);
     }
     //Стили
     wp_enqueue_script( 'add_to_cart', get_template_directory_uri().'/assets/js/add_to_cart.js', null, null, true);
     wp_enqueue_style( 'page', get_template_directory_uri().'/assets/css/page/page.css' );
     wp_enqueue_style( 'style', get_stylesheet_uri() );
     wp_enqueue_style( 'font', get_template_directory_uri().'/assets/css/font/font.css' );
     //Работа с jquery
     if( is_page_template( 'templates/cart.php' ) ){
          wp_enqueue_style( 'cards', get_template_directory_uri().'/assets/css/cart/cart.css' );
          wp_enqueue_script( 'cart', get_template_directory_uri().'/assets/js/cart.js', null, null, true);
     }


     if( is_page_template( 'templates/order.php' ) ){
          wp_enqueue_style( 'cards', get_template_directory_uri().'/assets/css/order/order.css' );
          wp_enqueue_script( 'order', get_template_directory_uri().'/assets/js/order.js', null, null, true);
     }
     if( is_page_template( 'templates/favourites.php' ) ){
          wp_enqueue_style( 'cart-css', get_template_directory_uri().'/assets/css/cart/cart.css' );
          wp_enqueue_script( 'cart', get_template_directory_uri().'/assets/js/cart.js', null, null, true);
          wp_enqueue_style( 'cards-list', get_template_directory_uri().'/assets/css/cards/cards-list.css' );
          wp_enqueue_style( 'cards', get_template_directory_uri().'/assets/css/cards/cards.css' );
     }
     wp_deregister_script('jquery-core');
     wp_deregister_script('jquery');
     wp_register_script( 'jquery-core', get_template_directory_uri().'/assets/js/jquery.js', false, null, true );
     wp_register_script( 'jquery', false, [ 'jquery-core' ], null, true );
     wp_enqueue_script( 'jquery' );
     wp_enqueue_script( 'search', get_template_directory_uri().'/assets/js/search.js', null, null, true);
}

function add_feauters() {
     add_theme_support( 'custom-logo', array(
          'flex-width'           => false,
          'width'                => 105,
          'flex-height'          => false,
          'height'               => 50,
          'header-text'          => '',
          'unlink-homepage-logo' => false,
     ) );
}
function add_woocommerce_support() {
     add_theme_support( 'woocommerce' );
}
function add_menu() {
     register_nav_menu( 'top', 'Главное меню сайта' );
     register_nav_menu( 'bottom', 'Подвальное меню' );
     register_nav_menu( 'mobile', 'Мобильное меню' );
}
function custom_nav_menu( $nav_menu, $args ) {
     // Ваш код для изменения HTML-контента навигационного меню
     if( $args->theme_location == 'top' ){
          preg_match_all( '/<a href="(.*)">/', $nav_menu, $matches );
          $nav_menu = preg_replace( '/\<li.*\>\<a/', '<a', $nav_menu );
          $nav_menu = str_replace( '</li>', '', $nav_menu );
     }
     if( $args->theme_location == 'bottom' ){
          $nav_menu = preg_replace( '/\<li.*\>\<a/', '<div class="footer-center-content"><a', $nav_menu );
          $nav_menu = str_replace( '</li>', '</div>', $nav_menu );
     }
     return $nav_menu ;
 }
 function add_menu_link_class( $atts, $item, $args ) {
     if (property_exists($args, 'link_class')) {
          $atts['class'] = $args->link_class;
     }
     return $atts;
}
add_action('admin_menu', 'custom_css_hooks');
add_action('save_post', 'save_custom_css');
add_action('wp_head','insert_custom_css');
function custom_css_hooks() {
add_meta_box('custom_css', 'Custom CSS', 'custom_css_input',
'post', 'normal', 'high');
add_meta_box('custom_css', 'Custom CSS', 'custom_css_input',
'page', 'normal', 'high');
}
function custom_css_input() {
global $post;
echo '<input type="hidden" name="custom_css_noncename" id="custom_css_noncename"
value="'.wp_create_nonce('custom-css').'" />';
echo '<textarea name="custom_css" id="custom_css" rows="5" cols="30"
style="width:100%;">'.get_post_meta($post->ID,'_custom_css',true).'</textarea>';
}
function save_custom_css($post_id) {
if (!wp_verify_nonce($_POST['custom_css_noncename'], 'custom-css')) return $post_id;
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
$custom_css = $_POST['custom_css'];
update_post_meta($post_id, '_custom_css', $custom_css);
}
function insert_custom_css() {
if (is_page() || is_single()) {
if (have_posts()) : while (have_posts()) : the_post();
echo '<style type="text/css">'.get_post_meta(get_the_ID(), '_custom_css', true).'
</style>';
endwhile; endif;
rewind_posts();
}

}
?>