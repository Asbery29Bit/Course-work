<?php 
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
$urls = new Json_products_urls_v1();
$products = $urls->getProductsUrl();
echo str_replace( '"', "'", json_encode( $products, JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT ) );
class Json_products_urls_v1 
{
     function __construct() {
     }

     function getProductsUrl(){
          $output = [];
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
          $products = wc_get_products( $args );
          foreach ( $products as $product ) {
               $product_id   = $product->get_id();
               $product_name = $product->get_name();
               $product_href = get_permalink( $product_id );
               $output[ $product_name ] = urldecode( $product_href );
          }
          return $output;
     }
}
?>