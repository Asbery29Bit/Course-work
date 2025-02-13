let url;
class Filter {
	static items = [];
	static filter_legend = {
		'height': 'between',
		'cold': 'between',
		'flower_color': 'select',
		'leaf_color': 'select',
		'category': 'radio',
		'sun': 'checkbox',
		'shade': 'checkbox',
		'shadow': 'checkbox',
		'search': 'search'
	};
	static popup = 
	$( `
		<div class="filter-popup">
			<button class="dark filter-popup-btn">Применить</button>
		</div>
	` );
	static filters = {};
	constructor ( params )
	{
		// Filter.filters = {};
		this.obj = params.obj;
		this.submit_btn = $( '.submit-btn', this.obj );
		this.submit_btn.on( 'click', () => {
			this.change_inputs();
			this.filter_update();
		 } );
		this.reset_btn = $( '.reset-btn', this.obj );
		this.reset_btn.on( 'click', () => {
			// Filter.filters = {};
			this.reset_inputs();
			this.change_inputs();
			this.filter_update();
		} );
		this.change_inputs();
		this.filter_update();
		// search_init();
	
	
		$( '.filter-element-category', '.category' ).on( 'click.filter', ( e ) => {
			this.radio_change( $( e.target ).closest( $( '.category.filter-element' ) ) );
		} );
		$( '.between input',  this.obj ).on( 'change.filter', ( e ) => {
			// console.log('1234567');
			this.between_change( $( e.target ) );
		} );
		$( '.select select',  this.obj ).on( 'change.filter', ( e ) => {
			this.select_change( $( e.target ) );
		} );
		$( '.checkbox input',  this.obj ).on( 'change.filter', ( e ) => {
			this.checkbox_change( $( e.target ) );
		} );

		this.inputPopupInit( $( '.between.height input.start',  this.obj ) );
		this.inputPopupInit( $( '.between.height input.end',  this.obj ) );
		this.inputPopupInit( $( '.between.cold input.start',  this.obj ) );
		this.inputPopupInit( $( '.between.cold input.end',  this.obj ) );
	}

	reset_inputs ()
	{
		let radio_parent = $( '.category.radio', this.obj );
		radio_parent.prop( 'value', 'Все товары' );
		radio_parent.find( '.filter-element-category:checked' ).prop( 'checked', false );
		radio_parent.find( '.filter-element-category[value="Все товары"]' ).prop( 'checked', true );
		radio_parent.trigger( 'change' );
		$( 'input[type="number"]', this.obj ).prop( 'value', '' );
		$( 'input[type="number"]', this.obj ).trigger( 'change' );
		$( 'input[type="checkbox"]', this.obj ).prop( 'checked', true );
		$( 'input[type="checkbox"]', this.obj ).trigger( 'change' );
		$( 'select', this.obj ).prop( 'value', '' );
		$( 'select', this.obj ).trigger( 'change' );
	}
	change_inputs ()
	{
		// console.log($( '.category.filter-element', this.obj ));
		this.radio_change( $( '.category.filter-element', this.obj ), false );
		this.between_change( $( '.between.height input.start',  this.obj ), false );
		this.between_change( $( '.between.height input.end',  this.obj ), false );
		this.between_change( $( '.between.cold input.start',  this.obj ), false );
		this.between_change( $( '.between.cold input.end',  this.obj ), false );
		this.select_change( $( '.select.flower_color select',  this.obj ), false );
		this.select_change( $( '.select.leaf_color select',  this.obj ), false );
		this.checkbox_change( $( '.checkbox input.sun',  this.obj ), false );
		this.checkbox_change( $( '.checkbox input.shade',  this.obj ), false );
		this.checkbox_change( $( '.checkbox input.shadow',  this.obj ), false );
	}

	filter_update () 
	{
		history.replaceState(null, '', 	url.href);
		Filter.items.forEach( item => {
			item.dom.removeClass( 'hidden' );
			if ( item.filter_code != undefined && typeof item.filter_code === 'object' && !$.isEmptyObject( item.filter_code ) ) {
				for( let item_filter_key in item.filter_code ) 
				{
					if ( Filter.filters[ item_filter_key ] != undefined ) {
						switch ( Filter.filter_legend[ item_filter_key ] ) {
							case 'between':
								if ( ( Filter.filters[ item_filter_key ].start != undefined && Filter.filters[ item_filter_key ].start != '' ) && ( Filter.filters[ item_filter_key ].end != undefined && Filter.filters[ item_filter_key ].end != '' ) ) {
									if ( Number( item.filter_code[ item_filter_key ] ) < Filter.filters[ item_filter_key ].start || Number( item.filter_code[ item_filter_key ] ) > Filter.filters[ item_filter_key ].end ) {
										item.dom.addClass( 'hidden' );
									}
								} 
								else if ( Filter.filters[ item_filter_key ].end != undefined && Filter.filters[ item_filter_key ].end != '' ) {
									if ( Number( item.filter_code[ item_filter_key ] ) > Filter.filters[ item_filter_key ].end ) {
										item.dom.addClass( 'hidden' );
									}
								}
								else if ( Filter.filters[ item_filter_key ].start != undefined && Filter.filters[ item_filter_key ].start != '' ) {
									if ( Number( item.filter_code[ item_filter_key ] ) < Filter.filters[ item_filter_key ].start ) {
										item.dom.addClass( 'hidden' );
									}
								}
								break;
							case 'select':
								if ( Filter.filters[ item_filter_key ] != undefined && Filter.filters[ item_filter_key ] != '' ) {
									if ( item.filter_code[ item_filter_key ] == undefined || item.filter_code[ item_filter_key ] != Filter.filters[ item_filter_key ] ) {
										item.dom.addClass( 'hidden' );
									}
								}
								break;
							case 'radio':
								if ( Filter.filters[ item_filter_key ] != undefined && Filter.filters[ item_filter_key ] != '' && Array.isArray( item.filter_code[ item_filter_key ] ) && item.filter_code[ item_filter_key ].length != 0 ) {
									if ( !item.filter_code[ item_filter_key ].includes( Filter.filters[ item_filter_key ] ) ) {
										item.dom.addClass( 'hidden' );
									}
								}
								break;
							case 'checkbox':
								let check_hide = true;
								if ( Filter.filters.sun == true ) {
									if ( item.filter_code.sun == 'true' ) {
										check_hide = false;
									}
								}
								if ( Filter.filters.shade == true ) {
									if ( item.filter_code.shade == 'true' ) {
										check_hide = false;
									}
								}
								if ( Filter.filters.shadow == true ) {
									if ( item.filter_code.shadow == 'true' ) {
										check_hide = false;
									}
								}
								if ( Filter.filters.shade == true && Filter.filters.sun == true && Filter.filters.shadow == true ) {
									check_hide = false;
								}
								if ( check_hide ) {
									item.dom.addClass( 'hidden' );
								}
								break;
							case 'search':
								if ( !( Filter.filters[ 'search' ] != undefined && item.filter_code.search != undefined && item.filter_code.search.toLowerCase().startsWith( Filter.filters[ 'search' ].toLowerCase() ) ) ) {
									item.dom.addClass( 'hidden' );
								}
								break;
						}
					}
				}
			} else {
				item.dom.addClass( 'hidden' );
			}
		});
	}
	radio_change ( obj, update=true )
	{
		let name = obj.data( 'filter_name' );
		// console.log(obj.find( '.filter-element-category:checked' ));
		if ( obj.find( '.filter-element-category:checked' ).length == 0 ) return false;
		let value = obj.find( '.filter-element-category:checked' )[ 0 ].value;
		// console.log(obj, name, value);
		// console.log(value == 'Все товары');
		if ( value == 'Все товары' )  {
			// console.log(name);
			let new_filters = remove( Filter.filters, name );
			Filter.filters = new_filters;	
			url.searchParams.delete(name);
		} else {
			Filter.filters[ name ] = value;
			if (value != undefined && value != '') url.searchParams.set(name, value);
		}
		// history.replaceState(null, '', url);
		if ( update ) this.filter_update();
	}
	between_change ( obj, update=true )
	{
		let name = $( obj.closest( '.between' ) ).data( 'filter_name' );
		let value = Number( obj[0].value );
		if ( Filter.filters[ name ] == undefined ) Filter.filters[ name ] = {};
		Filter.filters[ name ][ obj.data( 'between' ) ] = value;
		// console.log(value)
		// if (value != undefined && value != '') url.searchParams.set( name + '_' + obj.data( 'between' ) , value);
		// history.replaceState(null, '', url);
		if ( update ) this.filter_update();
	}
	select_change ( obj, update=true )
	{
		let name = obj.data( 'filter_name' );
		let value = obj[0].value;
		Filter.filters[ name ] = value;
		// if (value != undefined && value != '') url.searchParams.set(name, value);
		// history.replaceState(null, '', url);
		if ( update ) this.filter_update();
	}
	checkbox_change ( obj, update=true )
	{
		let name = obj.data( 'filter_name' );
		// console.log(obj);
		let value = obj[0].checked;
		Filter.filters[ name ] = value;
		// if ( value == true ) {
		// 	url.searchParams.delete( name );
		// } else {
		// 	url.searchParams.set(name, value);
		// }
		// history.replaceState(null, '', url);
		if ( update ) this.filter_update();
	}

	inputPopupInit ( obj )
	{
		obj.on( 'input.popup', () => {
			let pop_id = setTimeout(() => {
				obj.off( 'input.popup' );
				obj.off( 'change.popup' );
				let pos = obj.offset();
				// console.log(obj, pos);
				Filter.popup.addClass( 'active' );
				if ( window.screen.width > 1099 ) {
					Filter.popup.css( 'top', pos.top - ( obj.height() / 2 ) ).css( 'left', pos.left + obj.width() + 30 );
				} else {
					Filter.popup.css( 'top', pos.top + Filter.popup.height() + obj.height() + 15 ).css( 'left', pos.left );
				}
				Filter.popup.one( 'click.popup', () => {
					obj.trigger( 'change' );
				} )
				obj.one( 'blur.popup', () => {
					obj.trigger( 'change' );
				} );
				obj.one( 'change.popup', () => {
					Filter.popup.removeClass( 'active' );
					obj.off( 'keyup.popup' );
					this.inputPopupInit( obj );
				} );
				obj.on( 'keyup.popup', () => {
					// console.log(obj[ 0 ].value);
					if ( obj[ 0 ].value == '' || obj[ 0 ].value == '0' ) {
						obj.trigger( 'change' );
						// obj.trigger( 'change' );
					} 
				} );
			}, 100);
			obj.one( 'change.popup', () => {
				clearTimeout( pop_id );
			} );
		} );
	}
}

$( document ).ready( function () {
	url = new window.URL(document.location);
	let searchParams = Object.fromEntries(url.searchParams);
	if ( searchParams.category != undefined ) {
		Filter.filters[ 'category' ] = searchParams.category;
		$( '.categories-button[data-value="' + searchParams.category + '"]' ).addClass( 'categories-button-active' );
		$( '.filter-element-category[value="' + searchParams.category + '"]' ).prop( 'checked', true );
	}
	if ( searchParams.search != undefined ) {
		Filter.filters[ 'search' ] = searchParams.search;
	}

	Filter.url = new window.URL(document.location);

	$( '.card-outer' ).each( ( index, element ) => {
		let params = {};
		if ( $( element ).data( 'params' ) != undefined ) {
			params = json_from_params( $( element ).data( 'params' ) );
		} else {
			params = { 'list_filter': {} };
		}
		let item = 
		{
			sort_code: params[ 'list_sort' ],
			filter_code: params[ 'list_filter' ],
			dom: $( element )
		};
		Filter.items.push( item );
	});
	Filter.popup.appendTo( $( 'body' ) );

	$( '.filters-inner' ).each( ( index, element ) => {
		let _element = $( element );
		new Filter( {
			obj: _element
		});
		let min_width = _element.data( 'min-width' ) == undefined ? 0 : Number( _element.data( 'min-width' ) );
		let max_width = _element.data( 'max-width' ) == undefined ? 9999 : Number( _element.data( 'max-width' ) );
		if ( window.screen.width > min_width && window.screen.width <= max_width ) {
			if ( _element.closest( '.filter-modal' ).length != 0 ) {
				_element.closest( '.filter-modal' ).one( 'open', () => {
					// console.log('1');
					new openableList( {
						obj: _element,
					});
				});	
			} else {
				new openableList( {
					obj: _element,
				});
			}
		} else {
			$( window ).on( 'resize.list', () => {
				if ( window.screen.width > min_width && window.screen.width <= max_width ) {
					$( window ).off( 'resize.list' );
					if ( _element.closest( '.filter-modal' ).length != 0 ) {
						_element.closest( '.filter-modal' ).one( 'open', () => {
							// console.log('1');
							new openableList( {
								obj: _element,
							});
						});	
					} else {
						new openableList( {
							obj: _element,
						});
					}
				}
			});
		}
	});

	$( '.sort' ).each( ( i, element ) => {
		new Sort( {
			obj: $( element ),
			cards_inner: $( '.cards-inner' ),
		});
	});
});
