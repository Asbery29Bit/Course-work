class Sort 
{
    constructor ( params )
    {
        this.obj = params.obj;
        this.cards_inner = params.cards_inner;

        let sort_params = this.obj.prop( 'value' ).split( '_' );
        this.sort( { sort_by: sort_params[ 0 ], sort_to: sort_params[ 1 ] } );

        this.obj.on( 'change', () => {
            let sort_params = this.obj.prop( 'value' ).split( '_' );
            this.sort( { sort_by: sort_params[ 0 ], sort_to: sort_params[ 1 ] } );
        });
    }

    sort ( params )
    {
        let items = Filter.items;
        let sort_to = params.sort_to == 'ascending' ? false : true;
        let sort_by = params.sort_by != undefined ? params.sort_by : 'popularity';
        
        items.sort( ( a, b ) => {
            if ( a == undefined || a.sort_code == undefined ) {
                return -1;
            }
            if ( b == undefined || b.sort_code == undefined ) {
                return 1;
            }
            let sort_number = 
            {
                a: a.sort_code[ sort_by ] != undefined ? a.sort_code[ sort_by ] : 0,
                b: b.sort_code[ sort_by ] != undefined ? b.sort_code[ sort_by ] : 0,
            };

            if ( sort_to ) {
                return sort_number.b - sort_number.a;
            } else {
                return sort_number.a - sort_number.b;
            }
        } );

        items.forEach( element => {
            this.cards_inner.append( element.dom );
        });
    }
}