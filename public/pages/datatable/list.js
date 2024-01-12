/**
 * DataTables Advanced
 */

'use strict';

$(function () {
    var isRtl = $('html').attr('data-textdirection') === 'rtl';

    var dt_ajax_table = $('.datatables-ajax');
    var dataPath = dt_ajax_table.attr('data-url');
    var ajaxParams = {}; // set filter mode
    var initFeather = function () {
        feather.replace();
    }
    // console.log(dt_ajax_table);
    if (dt_ajax_table.length) {
        var dt_ajax = dt_ajax_table.dataTable({
            processing: true,
            //  dom: '<"card-header border-bottom"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            //   ajax: dataPath,
            "ajax": {
                "url": dataPath,
                "data": function (data) {
                    // console.log(data);
                    $.each(ajaxParams, function (key, value) {
                        data[key] = value;
                    });
                }
            },
            "order": [],
            columnDefs: [
                {
                    // Label
                    targets: -1,
                    orderable: false,
                    responsivePriority: 2,
                }
            ], // end columnDefs*/
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            "drawCallback": function (settings) {
                initFeather();
            },
        });
        // console.log(dt_ajax_table.length);
    }
});
