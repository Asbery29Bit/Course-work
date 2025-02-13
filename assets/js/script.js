function remove(Object, key) {
  let outputObject = {}

  for (let inKey in Object) {
    if (key + '' !== inKey + '') {
      outputObject[inKey] = Object[inKey];
    }
  }
  return outputObject
}

function isObj(x) {
  return (typeof x === 'object' && !Array.isArray(x) && x !== null);
}
function setCookie(name, value, options = {}) {
  options = {
    path: "/",
    // при необходимости добавьте другие значения по умолчанию
    ...options,
  };

  if (options.expires instanceof Date) {
    options.expires = options.expires.toUTCString();
  }

  let updatedCookie =
    encodeURIComponent(name) + "=" + encodeURIComponent(value);

  for (let optionKey in options) {
    updatedCookie += "; " + optionKey;
    let optionValue = options[optionKey];
    if (optionValue !== true) {
      updatedCookie += "=" + optionValue;
    }
  }

  document.cookie = updatedCookie;
}

function getCookie(name) {
  let matches = document.cookie.match(
    new RegExp(
      "(?:^|; )" +
      name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") +
      "=([^;]*)"
    )
  );
  return matches ? decodeURIComponent(matches[1]) : undefined;
}
function json_from_params(str) {
  try {
    return JSON.parse(str.replaceAll("'", '"'));
  } catch (err) {
    // console.log(err, str);
    return {};
  }
}

function isObj(x) {
  return (typeof x === 'object' && !Array.isArray(x) && x !== null);
}
function setCookie(name, value, options = {}) {
  options = {
    path: "/",
    // при необходимости добавьте другие значения по умолчанию
    ...options,
  };

  if (options.expires instanceof Date) {
    options.expires = options.expires.toUTCString();
  }

  let updatedCookie =
    encodeURIComponent(name) + "=" + encodeURIComponent(value);

  for (let optionKey in options) {
    updatedCookie += "; " + optionKey;
    let optionValue = options[optionKey];
    if (optionValue !== true) {
      updatedCookie += "=" + optionValue;
    }
  }

  document.cookie = updatedCookie;
}

function getCookie(name) {
  let matches = document.cookie.match(
    new RegExp(
      "(?:^|; )" +
      name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") +
      "=([^;]*)"
    )
  );
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function deleteCookie(name) {
  document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

//for zoom detection


px_ratio = window.devicePixelRatio || window.screen.availWidth / document.documentElement.clientWidth;

function isZooming() {
  var newPx_ratio = window.devicePixelRatio || window.screen.availWidth / document.documentElement.clientWidth;
  if (newPx_ratio != px_ratio) {
    px_ratio = newPx_ratio;
    return true;
  } else {
    return false;
  }
}

var setProps = function (params) {
  if (params.width - 1218 > 0) {
    $(":root").css('--main-padding', ((params.width - 1170) / 2) + 'px');
  } else {
    $(":root").css('--main-padding', 24 + 'px');
  }
  $(":root").css('--main-width', params.width + 'px');
}

$(document).ready(function () {
  $('body').addClass('loaded');
  // let cart_params = {};
  // let alert = $(".js-alert", ".js-basket");
  // if (getCookie("yellow-cart") != undefined) {
  //   cart_params = JSON.parse(getCookie("yellow-cart").replaceAll("'", '"'));
  //   if (Object.keys(cart_params).length != 0) {
  //     alert.each((i, e) => {
  //       $(e).text(Object.keys(cart_params).length);
  //     });

  //   } else {
  //     alert.each((i, e) => {
  //       $(e).text('');
  //     });
  //   }

  // }
  // alert.on('add', (e) => {
  //   // console.log(Number($(e.target).text()) + 1)
  //   $(e.target).text(Number($(e.target).text()) + 1);
  // });
  // alert.on('removea', (e) => {
  //   let _el = $(e.target);
  //   let alertAmount = _el.text() == '' ? 0 : Number(_el.text());
  //   // console.log(_el, alertAmount)
  //   if ((alertAmount - 1) > 0) {
  //     _el.text(alertAmount - 1);
  //   } else {
  //     _el.text('');
  //   }
  // });

  $('.js-alert').each(function (index, element) {
    let _this = $(element);
    let params = json_from_params(_this.data('params'));
    let cart_params = {};
    if (getCookie(params.cookie_name) != undefined) {
      cart_params = json_from_params(getCookie(params.cookie_name));
      if (Object.keys(cart_params).length != 0) {
        _this.text(Object.keys(cart_params).length);
      } else {
        _this.text('');
      }
    }

    _this.on('add', (e) => {
      _this.text(Number(_this.text()) + 1);
    });
    _this.on('removea', (e) => {
      let alertAmount = _this.text() == '' ? 0 : Number(_this.text());
      // console.log(_this, alertAmount)
      if ((alertAmount - 1) > 0) {
        _this.text(alertAmount - 1);
      } else {
        _this.text('');
      }
    });
  });

  $('.burger-btn').on('click', (e) => {
    e.stopPropagation();
    let target = $(e.target);
    let obj;
    if (target.hasClass('burger-btn')) {
      obj = target;
    } else {
      obj = target.closest('.burger-btn')
    }
    $('.' + json_from_params(obj.data('params')).target).addClass('active').removeClass('hidden');
    $('.' + json_from_params(obj.data('params')).target).trigger('open');
  });
  $('.burger-close').on('click', (e) => {
    // e.stopPropagation();
    $('.' + json_from_params($(e.target).data('params')).target).removeClass('active').addClass('hidden');
  });
  $( '.burger-fade' ).on( 'click', () => {
      $( '.burger' ).removeClass( 'active' ).addClass( 'hidden' );
  });

  let _element = $('.drop-categories.burger');
  if (_element.length != 0) {
    _element.one('open', () => {
      new openableList({
        obj: _element,
      });
    });
  }
});
