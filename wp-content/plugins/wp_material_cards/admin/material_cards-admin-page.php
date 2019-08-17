<?php
	/**
	 * WP_Material_Cards Admin Page
	 */
	if( current_user_can( 'edit_users' ) ) {
?>				
	<h1>Welcome</h1>
<?php    
	}
	else {  
?>
	<p> <?php __("You are not authorized to perform this operation.") ?> </p>
<?php
	}
?>