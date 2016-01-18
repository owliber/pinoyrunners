<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
	Template Name: Sidebar Frontpage
*/

?>
<div class="ui hidden divider"></div>
<div class="ui secondary segment">
	<?php echo do_shortcode('[pr_login_form]'); ?>
</div>
<div class="ui horizontal divider"> OR </div>
<div class="ui secondary segment">
	<?php echo do_shortcode('[pr_signup_form]'); ?>
</div>