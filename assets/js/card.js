$(document).ready(function () {
     let big_img = $( '.img-product', '.card-left' )  ;
     $( '.img-product-child', '.card-left' ).on( 'click', ( e ) => {
         big_img[0].src = e.target.src;
     } );
 });