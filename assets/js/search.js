class Search 
{
    constructor ( params )
    {
        this.obj = params.obj;
        this.searchParam_name = params.searchParam_name;
        this.target_url = params.target_url;
        this.url = new window.URL( document.location );
        this.searchParams = Object.fromEntries( this.url.searchParams );
        this.obj.on( 'submit', () => {
            window.location.href = this.target_url + "/?search=" + this.obj[ 0 ].value;
        } );
        this.obj.on( 'keypress', ( e ) => {
            if ( e.which == 13 ) {
                this.obj.trigger( 'submit' );
            }
        } )
        
        if ( this.searchParams[ this.searchParam_name ] != undefined ) {
            this.obj[ 0 ].value = this.searchParams[ this.searchParam_name ];
        }
        if ( params.button_class != undefined ) {
            this.addButton( params );
        }
        if ( params.suggestions != undefined ) {
            this.addSuggestions( params );
        }
    }
    addButton ( params )
    {
        this.button = $( '.' + params.button_class );
        this.button.on( 'click', () => {
            this.obj.trigger( 'submit' );
        } );
    }
    addSuggestions ( params )
    {
        this.suggestions_obj = this.obj.siblings( '.suggestions' );
        if ( this.suggestions_obj.length == 0 ) return false;
        this.obj.on( 'keyup', () => {
            this.suggestions_obj.empty();
            let value = this.obj[ 0 ].value;
            if ( value.length >= 1 ) {
                for ( let name in params.list )
                {
                    if ( name.toLowerCase().startsWith( value ) ) {
                        this.suggestions_obj.append( 
                            $( '<a>', {
                                class: 'suggestion',
                                text: name,
                                href: params.list[ name ]
                            })
                        );
                    }
                }
            }
        } );
        this.obj.on( 'focus', () => {
            this.suggestions_obj.removeClass( 'hidden' );
        } )
        this.obj.on( 'blur', () => {
            this.suggestions_obj.addClass( 'hidden' );
        } )
        this.suggestions_obj.on( 'mousedown', () => {
            this.obj.off( 'blur' );
            $( 'body' ).one( 'mouseup', () => {
                this.suggestions_obj.addClass( 'hidden' );
                this.obj.on( 'blur', () => {
                    this.suggestions_obj.addClass( 'hidden' );
                } )
            } );
        } );
    }
}

$( document ).ready( function () {
    $( 'input.search' ).each( ( index, element ) => {
        let _element = $( element );
        let params = json_from_params( _element.data( 'params' ) );
        let suggestions;
        let object;
        object = new Search( {
            obj: _element,
            searchParam_name: params.searchParam_name,
            target_url: params.target_url,
            button_class: params.button_class
        });
        if ( params.suggestions_url != undefined ) {
            $.ajax({
            	type: "post",
            	url: params.suggestions_url,
            	success: function (response) {
            		suggestions = json_from_params( response );
                    object.addSuggestions( { list: suggestions } );
                    // console.log(Object.keys(suggestions).length);
            	},
            	error: function (err) {
            		console.log(err);
            	}
            });
        }
    });
});