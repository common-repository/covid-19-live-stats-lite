(function( $ ) {
	'use strict';
	$(document).ready(function() {

	    var dTable = $('.cod-widget-table').DataTable({
				responsive			: true,
				paging					: false,
				info						: false,
				scrollY					: '50vh',
        scrollCollapse	: false,
				scrollX					: false,
				order						: [ 1, 'desc' ],
				columnDefs			: [
        		{"className": "dt-center", "targets": [ 1, 2, 3, 4 ]}
      		],
				dom							: "lrtip"
			});

      $('#myTableSearchBox').keyup(function() {
        dTable.search($(this).val()).draw();   // this  is for customized searchbox with datatable search feature.
   });

	});

})( jQuery );
