$(document).ready(function () {
     let cart = new CartItems();
     $('.cart', '.carts-left').each(function (index, element) {
         new CartItem({ obj: $(this), parent: cart });
     });
     cart.updateSum();
 });
 
 class CartItems {
     constructor() {
         this.items = [];
         this.cookie = {};
         if (getCookie("yellow-cart") != undefined) {
             this.cookie = json_from_params(getCookie("yellow-cart"));
         }
         this.sum_obj = $('.sum', '.carts-right');
         this.sum_price_obj = $('.price', this.sum_obj);
     }
     updateSum() {
         let sum = 0;
         this.items.forEach(item => {
             if (item.roller.obj[0].value > 0) {
                 sum += item.price * item.roller.obj[0].value;
             }
         });
        //  if ( sum == 0 ) {
        //      $( '.carts-inner' ).remove();
        //      $( 'h1' ).text( 'Корзина пуста' );
        //  } else {
            this.sum_price_obj.text(sum + '₽');
        //  }
     }
 }
 
 class CartItem {
     constructor(params) {
         this.parent = params.parent;
         this.list_id = this.parent.items.length;
         this.parent.items.push(this);
         this.obj = params.obj;
         let json_params = json_from_params(this.obj.data('params'));
         this.id = json_params.id;
         this.price = Number(json_params.price);
         this.price_obj = $('.price', this.obj);
         this.roller =
         {
             obj: $('.cart-input', this.obj),
             plus: $('.cart-plus', this.obj),
             minus: $('.cart-minus', this.obj)
         };
         this.short_obj = $('.cart-short-row#' + this.id, '.carts-right');
         this.short_price_obj = $('.price', this.short_obj);
 
         this.firstDraw();
         this.addEventListeners();
     }
     deleteItem() {
         let cookie = remove( this.parent.cookie, this.id );
         setCookie("yellow-cart", JSON.stringify(cookie));
         this.parent.cookie = cookie;
         this.parent.updateSum();
         this.obj.remove();
         this.short_obj.remove();
         this.parent.items.splice(this.list_id, 1);
         delete this;
     }
     firstDraw() {
         if (this.id in this.parent.cookie) {
             if (Number(this.parent.cookie[this.id]) == 0) {
                 this.deleteItem();
                 return;
             }
             this.roller.obj[0].value = Number(this.parent.cookie[this.id]);
         } else {
             this.parent.cookie[this.id] = 1;
             this.roller.obj[0].value = 1;
             setCookie("yellow-cart", JSON.stringify(this.parent.cookie));
         }
         this.price_obj.text(this.price + '₽');
         this.short_price_obj.text(this.price * Number(this.roller.obj[0].value) + '₽');
     }
     addEventListeners() {
         this.roller.plus.on('click', (e) => {
             this.roller.obj[0].value = Number(this.roller.obj[0].value) + 1;
             this.parent.cookie[this.id] = Number(this.parent.cookie[this.id]) + 1;
             this.roller.obj.trigger("change");
         });
         this.roller.minus.on('click', (e) => {
             this.roller.obj[0].value = Number(this.roller.obj[0].value) - 1;
             this.parent.cookie[this.id] = Number(this.parent.cookie[this.id]) - 1;
             this.roller.obj.trigger("change");
         });
         this.roller.obj.on('change input', (e) => {
             let value = Number(this.roller.obj[0].value);
             this.parent.cookie[this.id] = value;
             if (value <= 0) {
                 this.parent.cookie[this.id] = 0;
                 this.deleteItem();
             } else {
                 this.short_price_obj.text(this.price * value + '₽');
                 this.parent.updateSum();
                 setCookie("yellow-cart", JSON.stringify(this.parent.cookie));
             }
         });
     }
 }