$(document).ready(function () {
  // let alert = $(".js-alert", ".js-basket");
  // function removeCart(e) {
  //   let cart_params = {};
  //   if (getCookie("yellow-cart") != undefined) {
  //     cart_params = json_from_params(getCookie("yellow-cart"));
  //   }
  //   let _this;
  //   let target = $(e.target);
  //   if (target.hasClass('in-bucket')) {
  //     _this = target;
  //   } else {
  //     _this = target.closest('.in-bucket');
  //   }
  //   if (_this.closest(".card-outer").data("params") != undefined) {
  //     _this.empty();
  //     _this.removeClass("purchased");
  //     _this.addClass("available");
  //     _this.html(`<span class="icon right card"></span>В корзину`);
  //     _this.off('click');
  //     _this.on('click', (e) => { addCart(e) });
  //     let params = json_from_params(
  //       _this.closest(".card-outer").data("params")
  //     );
  //     if (params.id in cart_params) {
  //       let new_params = remove(cart_params, params.id);
  //       //  console.log(new_params);
  //       setCookie("yellow-cart", JSON.stringify(new_params));
  //       alert.trigger('removea');
  //     }
  //   }
  // }

  // function addCart(e) {
  //   e.preventDefault();
  //   let cart_params = {};
  //   if (getCookie("yellow-cart") != undefined) {
  //     cart_params = json_from_params(getCookie("yellow-cart"));
  //   }
  //   let _this;
  //   let target = $(e.target);
  //   if (target.hasClass('in-bucket')) {
  //     _this = target;
  //   } else {
  //     _this = target.closest('.in-bucket');
  //   }
  //   if (_this.closest(".card-outer").data("params") != undefined) {
  //     _this.empty();
  //     _this.removeClass("available");
  //     _this.off('click');
  //     _this.on('click', (e) => { removeCart(e) });
  //     _this.addClass("purchased");
  //     _this.text("Добавлено");
  //     let params = json_from_params(
  //       _this.closest(".card-outer").data("params")
  //     );
  //     if (!(params.id in cart_params)) {
  //       cart_params[params.id] = 1;
  //       setCookie("yellow-cart", JSON.stringify(cart_params));
  //       alert.trigger('add');
  //     }
  //   }
  // }


  // let start_params = {};
  // if (getCookie("yellow-cart") != undefined) {
  //   start_params = json_from_params(getCookie("yellow-cart"));
  // }
  // if (!$.isEmptyObject(start_params)) {
  //   $(".card-outer").each(function (index, element) {
  //     let _element = $(element);
  //     if (_element.data("params") != undefined) {
  //       let params = json_from_params(_element.data("params"));
  //       if (params.id in start_params) {
  //         let btn = $("button.in-bucket", _element);
  //         btn.empty();
  //         btn.removeClass("available");
  //         btn.on('click', (e) => { removeCart(e) });
  //         btn.addClass("purchased");
  //         btn.text("Добавлено");
  //       }
  //     }
  //   });
  // }
  // $("button.in-bucket.available").on("click", (e) => { addCart(e) });
  let cart_alert = $(".js-alert", ".js-basket");
  $("button.in-bucket.available").each( ( i, element ) => {
    new cartItem( {
      obj: $( element ),
      alert_obj: cart_alert,
      cookie_name: 'yellow-cart',
    } );
  });
  let like_alert = $(".js-alert", ".favourites");
  $(".like-btn").each( ( i, element ) => {
    new likeItem( {
      obj: $( element ),
      alert_obj: like_alert,
      cookie_name: 'yellow-like'
    } );
  });

});

class addItem {
  constructor(params) {
    this.obj = params.obj;
    // this.type = params.type;
    this.alert_obj = params.alert_obj;
    this.cookie_name = params.cookie_name;
    this.start_params = json_from_params(getCookie(this.cookie_name)) == undefined ? {} : json_from_params(getCookie(this.cookie_name));

    this.obj.one('click', (e) => { this.add(e) });
  }

  add = function ( e ) {
    e.preventDefault();
  }
}
class cartItem extends addItem {
  constructor ( params )
  {
    super( params );
    if (!$.isEmptyObject(this.start_params)) {
      let _element = this.obj.closest( '.card-outer' );
      if (_element.data("params") != undefined) {
        let params = json_from_params(_element.data("params"));
        if (params.id in this.start_params) {
          this.obj.empty();
          this.obj.removeClass("available");
          this.obj.off( 'click' );
          this.obj.one('click', (e) => { this.remove(e) });
          this.obj.addClass("purchased");
          this.obj.text("Добавлено");
        }
      }
    }
  }
  add = function ( e )
  {
    e.preventDefault();
    let cart_params = {};
    if (getCookie(this.cookie_name) != undefined) {
      cart_params = json_from_params(getCookie(this.cookie_name));
    }
    if (this.obj.closest(".card-outer").data("params") != undefined) {
      this.obj.empty();
      this.obj.removeClass("available");
      this.obj.one('click', (e) => { this.remove(e) });
      this.obj.addClass("purchased");
      this.obj.text("Добавлено");
      let json_params = json_from_params(
        this.obj.closest(".card-outer").data("params")
      );
      if (!(json_params.id in cart_params)) {
        cart_params[json_params.id] = 1;
        setCookie(this.cookie_name, JSON.stringify(cart_params));
        this.alert_obj.trigger('add');
      }
    }
  }
  remove = function ( e )
  {
    let cart_params = {};
    if (getCookie(this.cookie_name) != undefined) {
      cart_params = json_from_params(getCookie(this.cookie_name));
    }

    if (this.obj.closest(".card-outer").data("params") != undefined) {
      this.obj.empty();
      this.obj.removeClass("purchased");
      this.obj.addClass("available");
      this.obj.html(`<span class="icon right card"></span>В корзину`);
      // this.obj.off('click');
      this.obj.one('click', (e) => { this.add(e) });
      let json_params = json_from_params(
        this.obj.closest(".card-outer").data("params")
      );
      if (json_params.id in cart_params) {
        let new_params = remove(cart_params, json_params.id);
        //  console.log(new_params);
        setCookie(this.cookie_name, JSON.stringify(new_params));
        this.alert_obj.trigger('removea');
      }
    }
  }
}
class likeItem extends addItem {
  constructor ( params )
  {
    super( params );
    if (!$.isEmptyObject(this.start_params)) {
      let _element = this.obj.closest( '.card-outer' );
      if (_element.data("params") != undefined) {
        let params = json_from_params(_element.data("params"));
        if (params.id in this.start_params) {
          this.obj.removeClass("available");
          this.obj.off( 'click' );
          this.obj.one('click', (e) => { this.remove(e) });
          this.obj.addClass("liked");
        }
      }
    }
  }
  add = function ( e )
  {
    e.preventDefault();
    let cart_params = {};
    if (getCookie(this.cookie_name) != undefined) {
      cart_params = json_from_params(getCookie(this.cookie_name));
    }
    if (this.obj.closest(".card-outer").data("params") != undefined) {
      this.obj.removeClass("available");
      this.obj.one('click', (e) => { this.remove(e) });
      this.obj.addClass("liked");
      let json_params = json_from_params(
        this.obj.closest(".card-outer").data("params")
      );
      if (!(json_params.id in cart_params)) {
        cart_params[json_params.id] = 1;
        setCookie(this.cookie_name, JSON.stringify(cart_params));
        this.alert_obj.trigger('add');
      }
    }
  }
  remove = function ( e )
  {
    let cart_params = {};
    if (getCookie(this.cookie_name) != undefined) {
      cart_params = json_from_params(getCookie(this.cookie_name));
    }

    if (this.obj.closest(".card-outer").data("params") != undefined) {
      this.obj.empty();
      this.obj.removeClass("liked");
      this.obj.addClass("available");
      this.obj.one('click', (e) => { this.add(e) });
      let json_params = json_from_params(
        this.obj.closest(".card-outer").data("params")
      );
      if (json_params.id in cart_params) {
        let new_params = remove(cart_params, json_params.id);
        setCookie(this.cookie_name, JSON.stringify(new_params));
        this.alert_obj.trigger('removea');
      }
    }
  }
}
