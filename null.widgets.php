<?php

function NullWidgetArea($id) {
    echo _NullWidgetArea($id);
}

// Capturing output of 'echo':
// http://www.tequilafish.com/2009/02/10/php-how-to-capture-output-of-echo-into-a-local-variable/
function _NullWidgetArea($id) {
    ob_start();
    dynamic_sidebar($id);
    $sidebar = ob_get_contents();
    ob_end_clean();
    return $sidebar;
}
?>