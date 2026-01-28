<?php
/*
* Redirect to blog listing page
* home.php does not support a gutenberg block base layouts, so that we are redirecting to a custom page template.
* @package Royal_Holidays_Adventures
*/

wp_safe_redirect( home_url( '/travel-blogs/' ), 301 );
exit;
