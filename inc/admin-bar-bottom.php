<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

 //  Disabling standard CSS in HTML code admin bar
function my_filter_head() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'my_filter_head');

//  CSS to display the admin bar to the bottom of the page
if ( is_user_logged_in() ) {
    function true_move_admin_bar() {
        echo '
	<style type="text/css">
	html{margin-bottom:32px !important}
	* html body{margin-bottom:32px !important}
	#wpadminbar{top:auto !important;bottom:0}
	#wpadminbar .menupop .ab-sub-wrapper{bottom:32px;-moz-box-shadow:2px -2px 5px rgba(0,0,0,.2);-webkit-box-shadow:2px -2px 5px rgba(0,0,0,.2);box-shadow:2px -2px 5px rgba(0,0,0,.2)}
	@media screen and ( max-width:782px ){
		html{margin-bottom:46px !important}
		* html body{margin-bottom:46px !important}
		#wpadminbar{position:fixed}
		#wpadminbar .menupop .ab-sub-wrapper{bottom:46px}
	}
	</style>
	';
    }
//add_action( 'admin_head', 'true_move_admin_bar' ); // в админке
    add_action( 'wp_head', 'true_move_admin_bar' ); // на сайте
}