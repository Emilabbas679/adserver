<?php
/**
 * Groups configuration for default Minify implementation.
 */

 /**
  * You may wish to use the Minify URI Builder app to suggest
  * changes. http://yourdomain/min/builder/.
  **/
 $min_documentRoot_assets = "$min_documentRoot/theme/frontend/apanel/style/default/";

return [
    'apanelGlobalcss' => [
         $min_documentRoot.'/theme/frontend/apanel/style/global_assets/css/icons/icomoon/styles.min.css',
         $min_documentRoot.'/theme/frontend/apanel/style/global_assets/css/icons/fontawesome/styles.min.css',
         $min_documentRoot_assets.'assets/css/bootstrap.min.css',
         $min_documentRoot_assets.'assets/css/bootstrap_limitless.min.css',
         $min_documentRoot_assets.'assets/css/layout.min.css',
         $min_documentRoot_assets.'assets/css/components.min.css',
         $min_documentRoot_assets.'assets/css/colors.min.css',
         $min_documentRoot_assets.'assets/css/xeto.css',
         $min_documentRoot_assets.'assets/css/chosen.min.css',
         $min_documentRoot_assets.'assets/css/serkan.min.css',

         $min_documentRoot.'/theme/frontend/apanel/style/thickbox/thickbox.css',
    ],

    'apanelGlobaljs' => [
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/main/jquery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/main/bootstrap.bundle.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/styling/uniform.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/styling/switchery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/styling/switch.min.js',

        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/tags/tagsinput.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/inputs/inputmask.js',

        //$min_documentRoot . '/theme/frontend/apanel/style/global_assets/js/plugins/forms/tags/tokenfield.min.js',
        //$min_documentRoot . '/theme/frontend/apanel/style/global_assets/js/plugins/forms/tags/tokenfield.min.js',
        //$min_documentRoot . '/theme/frontend/apanel/style/global_assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js',
        //$min_documentRoot . '/theme/frontend/apanel/style/global_assets/js/plugins/ui/prism.min.js',
        $min_documentRoot_assets.'assets/js/notification.js',
        $min_documentRoot_assets.'assets/js/jspdf.min.js',
        $min_documentRoot_assets.'assets/js/jspdf.plugin.autotable.js',
        $min_documentRoot_assets.'assets/js/Roboto-Regular-normal.js',
        $min_documentRoot_assets.'assets/js/Roboto-Bold-bold.js',
        $min_documentRoot_assets.'assets/js/invoice.pdf.js',

    ],

    'datatables' => [
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/tables/datatables/datatables.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/tables/datatables/extensions/col_reorder.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/tables/datatables/extensions/select.min.js',

        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/selects/select2.min.js',

        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js',

        $min_documentRoot_assets.'assets/js/datatables.js',
        $min_documentRoot_assets.'assets/js/form_select2.js',
    ],

    'charts' => [
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/visualization/d3/d3.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/visualization/d3/d3_tooltip.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/visualization/d3/d3_tooltip.js',
        $min_documentRoot_assets.'assets/js/charts.js',
        //$min_documentRoot_assets . 'assets/js/chart/dashboard_bars.js',
    ],

    'validation' => [
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/validation/validate.min.js',
    ],

    'loginjs' => [
         $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/styling/uniform.min.js',
         $min_documentRoot_assets.'assets/js/login.js',
         $min_documentRoot_assets.'assets/js/app.js',
    ],

    'apanelGlobalapp' => [
         $min_documentRoot_assets.'assets/js/app.js',
    ],

    'coreadsgarden' => [
         $min_documentRoot.'/static/jscript/common.js',
         $min_documentRoot.'/static/jscript/main.js',
         $min_documentRoot.'/static/jscript/ajax.js',
         $min_documentRoot.'/static/jscript/thickbox/thickbox.js',
    ],

    'footerScripts' => [
        $min_documentRoot_assets.'assets/js/chosen.jquery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot_assets.'assets/js/sapp.js',
    ],

    'sTatistics' => [
        $min_documentRoot_assets.'assets/js/chosen.jquery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot_assets.'assets/js/statistics/app.js',
    ],

    'websiteStats' => [
        $min_documentRoot_assets.'assets/js/chosen.jquery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot_assets.'assets/js/statistics/wapp.js',
    ],

    'geoStats' => [
        $min_documentRoot_assets.'assets/js/chosen.jquery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot_assets.'assets/js/statistics/gapp.js',
    ],

    'demogStats' => [
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot_assets.'assets/js/statistics/demog.js',
    ],

    'techStats' => [
        $min_documentRoot_assets.'assets/js/chosen.jquery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot_assets.'assets/js/statistics/tech.js',
    ],

    'pubStats' => [
        $min_documentRoot_assets.'assets/js/chosen.jquery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot_assets.'assets/js/statistics/publisher_index.js',
    ],

    'cFormatStats' => [
        $min_documentRoot_assets.'assets/js/chosen.jquery.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/loaders/blockui.min.js',
        $min_documentRoot_assets.'assets/js/statistics/format.js',
    ],

    'dateTime' => [
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/ui/moment/moment.min.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/pickers/daterangepicker.js',
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/pickers/anytime.min.js',
        $min_documentRoot_assets.'assets/js/timedate.js',
    ],

    'ckeditor' => [
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/editors/ckeditor/ckeditor.js',
    ],

    'duallistbox' => [
        $min_documentRoot.'/theme/frontend/apanel/style/global_assets/js/plugins/forms/inputs/duallistbox/duallistbox.min.js',
    ],

    'smartcss' => [
         $min_documentRoot.'/theme/frontend/smart/style/default/css/style-l.css',
    ],

    'Jquery' => [
         $min_documentRoot.'/static/jscript/jquery/jquery.js',
         $min_documentRoot.'/static/jscript/jquery/ui.js',
    ],
    'CoreJs' => [
         $min_documentRoot.'/static/jscript/common.js',
         $min_documentRoot.'/static/jscript/main.js',
         $min_documentRoot.'/static/jscript/ajax.js',
         $min_documentRoot.'/static/jscript/thickbox/thickbox.js',
    ],
];
