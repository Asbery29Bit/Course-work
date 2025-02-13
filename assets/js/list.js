class openableList
{
	constructor ( params )
	{
		this.obj = $( params.obj );
		this.init();
	}

	init ()
	{
		this.obj.on( 'click', ( event ) => {
			// event.stopPropagation();
			this.open({
				'obj': $( event.target )
			});
		});
		this.obj.on( 'transitionend', ( event ) => {
			if ( $( event.target ).hasClass( 'drop-item' ) || $( event.target ).hasClass( 'drop' ) ) {
				event.target.style.setProperty( '--element-openheight', 'auto' );
			}
		});		
		
		let items = $( '.drop-item', this.obj );
        // console.log(items);
		for ( let i = 0; i < items.length; i++ ) 
		{
			$( items[ i ] ).removeClass( 'open' );
			this.calc({
				'item': $( items[ i ] )
			});
            if ( $( items[ i ] ).find( 'input[type="radio"]:checked ' ).length !== 0 ) {
                this.open({
                    'obj': $( items[ i ] ).find( '.drop-item-name' )
                });
            }
		}
		$( '.drop-inner', this.obj )[ 0 ].style.setProperty( '--element-closeheight', 0 + 'px' );
	}
	
	open ( params )
	{
        // console.log(params);
		if ( params.obj.hasClass( 'drop-item-name' ) || ( params.obj.hasClass( 'filter-element-category' ) && params.obj.closest( '.drop-item-name' ).length != 0 ) ) {
			let item = params.obj.closest( '.drop-item' );
			this.calc({
				'item': item
			});

			if ( item.hasClass( 'open' ) ) {
				item.removeClass( 'open' );
			}
			else {
				item.addClass( 'open' );
			}
		}
		else if ( params.obj.hasClass( 'drop-header' ) ) {
			let inner = $( '.drop-inner' );
			let items = inner.children( '.drop-item' );
			let inner_height = 0;
			items.each( ( i, e ) => {
				inner_height += this.calc({
					'item': $( e )
				});
			} );
			inner[ 0 ].style.setProperty( '--element-openheight', inner_height + 'px' );
			inner.height();
			let menu = $( params.obj ).closest( '.drop' );
			if ( menu.length == 1 ) {
				if ( menu.hasClass( 'open' ) ) {
					menu.removeClass( 'open' );
				}
				else {
					menu.addClass( 'open' );

				}
			}		
		}
	}
	
	calc ( params )
	{
		let name = params.item.children( '.drop-item-name' );
		let submenu = params.item.children( '.drop-submenu' );
		let name_height = 0;
		let submenu_height = 0;

		if ( name.length > 0 ) {
			name_height = name.outerHeight();
		}
		if ( submenu.length > 0 ) {
			submenu_height = submenu.outerHeight();
		}
		params.item[ 0 ].style.setProperty('--element-openheight', ( name_height + submenu_height ) + 'px');
		params.item[ 0 ].style.setProperty('--element-closeheight', ( name_height ) + 'px');
		params.item.outerHeight();
		if ( params.item.hasClass( 'open' ) ) return name_height + submenu_height;
		return name_height;
	}
	
}
$( document ).ready( function () {
	// $( '.category-inner' ).each( function () {
	// 	new openableList({
	// 		'obj': this
	// 	});
	// });
});