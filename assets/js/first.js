$(document).ready(function () {
     $('.slider-inner').slick({
         dots: true,
         infinite: true,
         arrows: false,
     });
     $('.reviews-inner').slick({
         infinite: true,
     });
     var lastWidth = $(window).width();
     setProps({ width: $(window).width() });
     $(":root").css('--main-width', $(window).width() + 'px');
     $(window).resize(function () {
         if (!isZooming()) {
             let width = $(window).width();
             if (width != lastWidth) {
                 setProps({ width: width });
                 lastWidth = width;
             }
         }
     });
 
     $( '.onclick' ).each(function ( index, element ) {
         $( element ).on( 'click', ( e ) => {
             $( this ).toggleClass( 'clicked' );
         } )
     });
 
     let categories_outer = $( '.categories-outer' );
     let nav_row = $( '.nav-row', categories_outer );
     let categories_inner = $( '.categories-inner', categories_outer );
 
     $( '.nav', nav_row ).on( 'click', ( e ) => {
         _this = $( e.target );
         let name = _this.data( 'name' );
         if ( name != undefined ) {
             $( '.active', nav_row ).removeClass( 'active' );
             _this.addClass( 'active' );
             categories_inner.removeClass( 'active' );
             categories_inner.each( function ( index, category ) {
                 let _category = $( category );
                 if ( _category.data( 'name' ) == name ) {
                     _category.addClass( 'active' );
                 }
             });
         }
     } );
 
     let cur_nav = $( '.active', nav_row );
     let cur_name = cur_nav.data( 'name' );
     categories_inner.removeClass( 'active' );
         categories_inner.each( function ( index, category ) {
             let _category = $( category );
             if ( _category.data( 'name' ) == cur_name ) {
                 _category.addClass( 'active' );
             }
         });
 });