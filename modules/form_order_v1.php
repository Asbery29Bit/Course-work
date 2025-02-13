<?php
header('Content-Type: application/json; charset=utf-8');
$data = json_decode( $_POST[ 'data' ], true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
add_order( $data );
echo json_encode( "Completed" );
function add_order ( $params ){
	if ( count( $params[ 'order' ] ) > 2){
		$address = [
			'first_name' => $params[ 'contacts' ][ 'name' ],
			'address_1'  => '-',
			'phone'      => $params[ 'contacts' ][ 'number' ],
			'country'    => 'RU'
		];
	 
	
		// Начинаем с того, что создаём заказ, вполне логично
		$order = wc_create_order();
	
		$order->set_billing_email( $params[ 'contacts' ][ 'email' ]);
		// Теперь давайте разберёмся с платёжным/адресом доставки покупателя
		// И как адрес доставки
		$order->set_address( $address, 'shipping' );
		// Неплохо бы добавить пару товаров в заказ
		foreach ( $params[ 'order' ] as $id => $value ){
			if ( $id != 'shiping' && $id != 'services' ){
				$order->add_product( wc_get_product( $id ), $value[ 'amount' ] );
			}
		}
		foreach ( $params[ 'additional' ] as $method => $price){
			if ( isset( $method ) && $method == 'delivery' ){
				$item = new WC_Order_Item_Shipping();
				$item->set_method_title( "Доставка до дома" ); // название
				$item->set_method_id( "shiping" ); // указываем ID существующего способа доставки
				$item->set_total( $price ); // стоимость доставки (необязательно)
				$order->add_item( $item );		
			}
			if ( isset( $method ) && $method == 'help' ){
				$item = new WC_Order_Item_Shipping();
				$item->set_method_title( "Помощь в посадке" ); // название
				$item->set_method_id( "help" ); // указываем ID существующего способа доставки
				$item->set_total( $price ); // стоимость доставки (необязательно)
				$order->add_item( $item );		
			}
		}
		if ( isset( $params[ 'order'][ 'shiping' ] ) &&  $params[ 'order'][ 'shiping' ][ 'price' ] != 0 ){
			$item = new WC_Order_Item_Shipping();
			$item->set_method_title( "Доставка" ); // название
			$item->set_method_id( "order-shiping" ); // указываем ID существующего способа доставки
			$item->set_total( $params[ 'order'][ 'shiping' ][ 'price' ] ); // стоимость доставки (необязательно)
			$order->add_item( $item );	
		}
			// Пересчитываем заказ
			$order->calculate_totals();
		// Устанавливаем нужный нам статус
		$order->update_status( 'processing' );
	 
		// Можно добавить заметку в заказ
		$order->add_order_note( 'Заказ создан динамически.' );
		function adopt($text) {
			return '=?UTF-8?B?'.base64_encode($text).'?=';
		}
		$headers = "MIME-Version: 1.0".PHP_EOL."Content-Transfer-Encoding: utf-8;Content-Type: text/html; charset=utf-8".PHP_EOL.'From: '.adopt('***').' Reply-To:no-reply@****.ru'.PHP_EOL;
		mail('palezgood@gmail.com', 'Форма заказа товара', 'Заказ осуществлен, посмотрите в wp подробности.', $headers);
	}

}
?>