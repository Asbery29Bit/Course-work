let toNumber = function ( str )
{
    return Number( str.replace(/[^\d]/g, '') );
}
let order = 
{
    additionals: [],
    cart_price: 0,
    setCartPrice: function ()
    {
        let sum = 0;
        $( '.order-form-row', '.order-form.order-sum' ).each(function (index, element) {
            let _this = $( this );
            let price = toNumber( $( '.price', _this ).text() );
            if ( isNaN( price ) ) {
                price = 0;
            }
            sum += price;
        });
        this.cart_price = sum;
    },
    setSumObj: function ()
    {
        this.sumObj = $( '.price', '.sum' );
    },
    setAdditionalObj: function ()
    {
        let add_row = $( '.order-form-row.additional', '.order-sum' );
        this.addObj = $( '.price', add_row );
    },
    updatePrice: function ()
    {
        let add_sum = 0;
        this.additionals.forEach( el => {
            if ( el.checkbox[ 0 ].checked ) {
                add_sum += el.price;
            } 
        });
        this.addObj.text( add_sum + ' ₽' );
        let sum = 0;
        $( '.order-form-row', '.order-sum' ).each( function(index, element) {
            sum += toNumber($( '.price', element ).text());
        } );
        this.sumObj.text( sum + '₽' );
    },
};
$(document).ready(function () {
    $( '.order-btn.trigger-order-form' ).on( 'click', () => {
        $( '.order-form.info' ).trigger( 'submit' );
    } );
    order.setCartPrice();
    order.setSumObj();
    order.setAdditionalObj();
    $( '.order-form-row', '.order-form.additional' ).each(function (index, element) {
        new Additional( $( this ) );
    });
    order.updatePrice();
    $( '.order-form.info' ).on( 'submit', ( e ) => {
        e.preventDefault();
        let contactsData = new FormData(e.target);
        let contacts = {};
        contactsData.forEach((value, key) => (contacts[key] = value));
        let additional = {};
        $( '.order-form-row', '.order-form.additional' ).each(function (index, element) {
            let el = $( element );
            let params = json_from_params(el.data('params'));
            let price = toNumber( $( '.price', el ).text() );
            let amount = params.amount;
            let checked = $( 'input', el )[0].checked;
            if ( checked ) {
                additional[params.id] = price;
            }
        });
        let order = {};
        $( '.order-form-row', '.order-form.order-sum' ).each(function (index, element) {
            let el = $( element );
            let params = json_from_params(el.data('params'));
            let price = toNumber( $( '.price', el ).text() );
            let amount = params.amount;
            if ( amount != undefined ) {
                order[ params.id ] = { price: price, amount: amount };
            } else {
                order[ params.id ] = { price: price };
            }
        });
        let sum = toNumber($( '.price', '.sum' ).text());
        let res = 
        {
          contacts: contacts,
          additional: additional,
          order: order,
          sum: sum
        };
        $.ajax({
            type: "POST",
            url: '/wp-content/themes/yellow-park/modules/form_order_v1.php',
            dataType: "json",
            data: {data: JSON.stringify(res)},
            success: function() {
                deleteCookie( 'yellow-cart' );
                document.location.href = '/';
            },
            error: function(xhr, status, error) {

            }
        });
    } );
});
class Additional {
    constructor ( obj )
    {
        order.additionals.push( this );
        this.obj = obj;
        this.checkbox = $( 'input', this.obj );
        this.price = toNumber( $( '.price', this.obj ).text() );
        this.addEventListeners();
    }
    addEventListeners = function()
    {
        this.checkbox.on( 'change', () => {
            order.updatePrice();
        } );   
    }
}