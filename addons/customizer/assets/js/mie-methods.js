$ = jQuery.noConflict();

( function( $ ) {
	"use strict";

	$(document).ready(function(){
		$(".koo-chosen").chosen({
			allow_single_deselect :true,
			width:"100%",
		});

		/* === Checkbox Multiple Control === */
		$( '.customize-control-checkbox_multiple input[type="checkbox"]' ).on(
			'change',
			function() {
				var checkbox_values = $( this ).parents( '.customize-control-checkbox_multiple' ).find( 'input[type="checkbox"]:checked' ).map(
					function() {
						return this.value;
					}
					).get().join( ',' );

				$( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
			}
		);
		 
		$.each( mieScript, function( index ) {

			var dataType = mieScript[index].type;
			var dataSlug = mieScript[index].slug;
			var dataDependsOn = mieScript[index].dependson;
			var dataCondition = mieScript[index].condition;
			var dataValue = mieScript[index].value;

			if ( dataDependsOn) {
				var dataSelector = '#customize-control-' + dataSlug;
				var dataSelectorDep = '#customize-control-' + dataDependsOn +" input";

				$(dataSelector).attr("data-depends-on",dataDependsOn).hide();
				
				if ( $(dataSelectorDep).is(":checked") ) {
					$("[data-depends-on="+dataDependsOn+"]").show();
				} else {
					$("[data-depends-on="+dataDependsOn+"]").hide();
				}

				$(dataSelectorDep).on("click",function(){
					
					if( $(dataSelectorDep).is(":checked") ){
						$("[data-depends-on="+dataDependsOn+"]").slideDown();
					} else {
						$("[data-depends-on="+dataDependsOn+"]").slideUp();
					}

				});
			}
		});

	});

} )( jQuery );