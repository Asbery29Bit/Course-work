<?php 
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
global $current_user;
if ( $current_user->roles[0] == 'administrator' ){
function hide_post_page_options() {
     global $wpdb;
     $load_items = [];
/*   Будущее обновление товара!!!
     $products = wc_get_products([]);
     print_r( $products ); */
     $file_mass = [
          'name'    => 'table_24_05_2024.txt'
     ];
     $file_path = $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-content/themes/yellow-park/assets/files_upload/' . $file_mass[ 'name' ];
     if ( file_exists( $file_path ) ){
          print_r( 'File founded' );
          $content = file_get_contents( $file_path );
          $elements = explode( '\t', $content );
          $load_lines = preg_split( "/[\n\r]+/u", $content );
          
          foreach ( $load_lines as $line ){
               $temp = explode( "\t", trim( $line ) );
               $len = count( $temp );
               if ( $temp[ 4 ] == 0 ){
                    $temp[ 4 ] = '';
               }
               if ( $temp[ 6 ] == 0 ){
                    $temp[ 6 ] = '';
               }
               if ( $temp[ 8 ] == 0 ){
                    $temp[ 8 ] = '';
               }
               $temp = [
                    'id' => $temp[ 13 ],
                    'name_eng'     => trim( str_replace( [ '(', ')', '\'', '’', '‘', '.'], [ '', '', '', '', '', '' ], $temp[ 0 ] ) ),
                    'category'     => $temp[ 1 ],
                    'name_rus'     => trim( str_replace( '&nbsp;', '', $temp[ 2 ] ) ),
                    'amount'     => $temp[ 3 ],
                    'razmer'       => $temp[ 4 ],
                    'height'       => str_replace( ',', '.', $temp[ 5 ] ),
                    'width'        => str_replace( ',', '.', $temp[ 6 ] ),
                    'price'        => $temp[ 7 ],
                    'flower_color' => trim( str_replace( '&nbsp;', '', $temp[ 8 ] ) ),
                    'list_color'   => $temp[ 9 ],
                    'degree'       => trim( str_replace( '°C', '', $temp[ 10 ] ) ),
                    'light'        => mb_strtolower( $temp[ 11 ] ),
                    'description'  => $temp[ 12 ]
               ];
               $load_items[] = $temp;
          }

     }else{
          print_r( 'File Not founded');
     }
     $query_images_args = array(
          'post_type'      => 'attachment',
          'post_mime_type' => 'image',
          'post_status'    => 'inherit',
          'posts_per_page' => - 1,
      );
      $query_images = new WP_Query( $query_images_args );
      $images = [];
      foreach ( $query_images->posts as $image ) {
          $images[] = wp_get_attachment_url( $image->ID );
          foreach ( $load_items as $id => $item ){
               if ( mb_strtolower ( $item[ 'name_eng' ] ) == mb_strtolower( $image->post_title ) ){
                    $item[ 'image' ] = $image->ID;
                    $load_items[ $id ] = $item;
                    $count++;
               }
          }
      }
      print_r( $count );
     //create_card_product( $load_items );  
}
function create_card_product( $params ){
     foreach ( $params as $item ){
          $post = array(
               'post_author' => 1,
               'post_content' => '',
               'post_status' => "publish",
               'post_title' => $item['name_rus'],
               'post_parent' => '',
               'post_type' => "product",
           );
          $post_id = wp_insert_post( $post );
               wp_set_object_terms( $post_id, $item[ 'category' ], 'product_cat' );
               wp_set_object_terms( $post_id, 'simple', 'product_type');       
               update_post_meta( $post_id, '_visibility', 'visible' );
               update_post_meta( $post_id, '_stock_status', 'instock');
               update_post_meta( $post_id, '_regular_price', $item[ 'price' ] );
               update_post_meta( $post_id, '_width', $item[ 'width' ] );
               update_post_meta( $post_id, '_height', $item[ 'height' ] );
               update_post_meta( $post_id, '_number_field1', $item[ 'amount' ] );
               update_post_meta( $post_id, '_number_field2', $item[ 'height' ] );
               update_post_meta( $post_id, '_number_field3', $item[ 'degree' ] );
               update_post_meta( $post_id, '_number_field4', $item[ 'width' ] );
               update_post_meta( $post_id, '_textarea1', $item[ 'flower_color' ] );
               update_post_meta( $post_id, '_textarea2', $item[ 'list_color' ] );
               update_post_meta( $post_id, '_textarea3', $item[ 'razmer' ] );
               update_post_meta( $post_id, '_textarea4', $item['description'] );
               if (  $item[ 'light' ]  == 'тень' ){
                    update_post_meta( $post_id, '_checkbox3', 'yes');
               } elseif ( $item[ 'light' ]  == 'солнце' ){
                    update_post_meta( $post_id, '_checkbox1', 'yes');
               }elseif(  $item[ 'light' ]  == 'полутень' ){
                    update_post_meta( $post_id, '_checkbox2', 'yes');
               }
          $product = wc_get_product( $post_id );
          if ( isset( $item[ 'image' ] ) && $item[ 'image' ] != '' ){
               $product->set_image_id( $item[ 'image' ] );
          }
          print_r( $item );
          $product->save();
     } 
}
function update_products(){
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
     foreach ( $products as $product ){
          $product_price = $product->get_price();
          $product_regular_price = $product->get_regular_price();
          $product->set_price( $product_regular_price );
          $product->save();
     } 
}
update_products();
//hide_post_page_options();
}
?>