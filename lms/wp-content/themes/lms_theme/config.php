<?php
// These constants are being deprecated in favor of LMS_THEME_ASSETS_URI and LMS_THEME_INC.
// define("CSS",get_template_directory_uri()."/assets/css/");
// define("JS",get_template_directory_uri()."/assets/js/");
// define("IMG",get_template_directory_uri()."/assets/img/");

// INC is used in functions.php for including files from the inc directory using include_once(INC . '/path/to/file.php');
// LMS_THEME_INC is the preferred constant for this, defined in functions.php.
// For now, we keep INC defined here to avoid breaking existing include_once calls
// until they can be updated to use LMS_THEME_INC.
define("INC",get_template_directory()."/inc/");

?>