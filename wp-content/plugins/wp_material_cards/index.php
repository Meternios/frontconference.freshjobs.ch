<?php
/**
* Plugin Name: Material Cards
* Plugin URI: https://github.com/Meternios/frontconference.freshjobs.ch
* Description: Plugin that creates a custom Post Type Cards with Material Design
* Version: 1.2
* Author: Florian Hitz
* Author URI: https://github.com/Meternios
**/

/**
 * Define Plugin Path 
 **/
define( 'MATERIAL_CARDS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MATERIAL_CARDS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Handle Admin Page
 **/
add_action( 'admin_menu', 'material_cards_admin_menu' );
function material_cards_admin_menu() {
	add_menu_page( 'Material_Cards-Plugin', 'Material Cards', 'manage_options', 'material_cards-admin-page', 'material_cards_admin_page', 'dashicons-admin-page', 6  );
}

function material_cards_admin_page(){
	include MATERIAL_CARDS_PLUGIN_PATH.'admin/material_cards-admin-page.php';
	wp_enqueue_style( 'admin-style', MATERIAL_CARDS_PLUGIN_URL.'css/admin-style.css', array(), '1.0.0' );
}

add_action( 'admin_print_scripts-post.php', 'portfolio_admin_script', 11 );

function portfolio_admin_script() {
    global $post_type;
    if( 'cards' == $post_type )
    wp_enqueue_style( 'admin-style', MATERIAL_CARDS_PLUGIN_URL.'css/admin-style.css', array(), '1.0.0' );
}

/**
 * Prepare Scripts and Styles to be enqueued
 **/
add_action( 'wp_enqueue_scripts', 'material_cards_wp_enqueue_scripts' );
function material_cards_wp_enqueue_scripts() {
	wp_register_style( 'material-card-main-style', MATERIAL_CARDS_PLUGIN_URL.'css/main-style.css', array(), '1.0.0' );
	wp_register_script( 'material-card-main-script', MATERIAL_CARDS_PLUGIN_URL.'js/main.js', array(), '1.0.0' );
}

/**
 * Add Custom Post Type Cards and create Taxonomy
 **/
add_action( 'init', 'material_cards_add_post_type' );
function material_cards_add_post_type() {
	// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Cards', 'Post Type General Name', 'material_cards' ),
		'singular_name'       => _x( 'Card', 'Post Type Singular Name', 'material_cards' ),
		'menu_name'           => __( 'Cards', 'material_cards' ),
		'parent_item_colon'   => __( 'Parent Card', 'material_cards' ),
		'all_items'           => __( 'All Cards', 'material_cards' ),
		'view_item'           => __( 'View Card', 'material_cards' ),
		'add_new_item'        => __( 'Add New Card', 'material_cards' ),
		'add_new'             => __( 'Add New', 'material_cards' ),
		'edit_item'           => __( 'Edit Card', 'material_cards' ),
		'update_item'         => __( 'Update Card', 'material_cards' ),
		'search_items'        => __( 'Search Card', 'material_cards' ),
		'not_found'           => __( 'Not Found', 'material_cards' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'material_cards' ),
	);
		
	// Set other options for Custom Post Type 
	$args = array(
		'label'               => __( 'Cards', 'material_cards' ),
		'description'         => __( 'Custom Post Type Cards', 'material_cards' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions'),
		// Assign custom taxonomy
		'taxonomies'          => array( 'card_category' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
	);
		
	// Registering your Custom Post Type
	register_post_type( 'cards', $args );

	$labels_taxonomy = array(
		'name' => _x( 'Types', 'Card category' ),
		'singular_name' => _x( 'Type', 'Card category' ),
		'search_items' =>  __( 'Search Card category' ),
		'all_items' => __( 'All Card categories' ),
		'parent_item' => __( 'Parent Card category' ),
		'parent_item_colon' => __( 'Parent Card category:' ),
		'edit_item' => __( 'Edit Card category' ), 
		'update_item' => __( 'Update Card category' ),
		'add_new_item' => __( 'Add New Card category' ),
		'new_item_name' => __( 'New Card category Name' ),
		'menu_name' => __( 'Card Categories' ),
	); 	
	 
	register_taxonomy('card_category',array('cards'), array(
		'hierarchical' => true,
		'labels' => $labels_taxonomy,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'card_categories' ),
	));
}

/**
 * Insert Taxonomy on Plugin activation
 **/
register_activation_hook( __FILE__, 'material_cards_install' );
function material_cards_install() {
	material_cards_add_post_type();
	wp_insert_term(
		'Fun Card',
		'card_category',
		array(
			'slug' => 'fun-card',
		)
	);
	wp_insert_term(
		'Job Card',
		'card_category',
		array(
			'slug' => 'job-card',
		)
	);
}

/**
 * Generate Shortcode for Displaying Cards
 **/
function material_cards_grid_function() {
	// Enqueue Styles and Script if shortcode is present
	wp_enqueue_style( 'material-card-main-style' );
	wp_enqueue_script( 'material-card-main-script' );
	
	// Array used to store all Posts from fun-card and job-card and alternate it
	$allCardsTogether = [];
	$html = '';

	$allFunCards = get_posts(array(
		'post_type' => 'cards',
		'post__in' => $allCardsTogether,
		'orderby' => 'rand',
		'posts_per_page' => '-1',
		'tax_query' => array(
			array(
				'taxonomy' => 'card_category',
				'field' => 'slug',
				'terms' => 'job-card'
			)
		),
		'fields' => 'ids'
	));
	$allJobCards = get_posts(array(
		'post_type' => 'cards',
		'post__in' => $allCardsTogether,
		'orderby' => 'rand',
		'posts_per_page' => '-1',
		'tax_query' => array(
			array(
				'taxonomy' => 'card_category',
				'field' => 'slug',
				'terms' => 'fun-card'
			)
		),
		'fields' => 'ids'
	));
	if (count($allFunCards) >= count($allJobCards)) {
	
		$count = count($allFunCards);
	
	} else {
		$count = count($allJobCards);
	
	}
	
	// Alternate job-card and fun-card
	for ($i = 0; $i < $count; $i++) {
		$allCardsTogether[] = $allFunCards[$i];
		$allCardsTogether[] = $allJobCards[$i];
	}
	
	$wp_query = new WP_Query(array(
		'post_type' => 'cards',
		'post__in' => $allCardsTogether,
		'orderby' => 'post__in'
	));
	
	if ($wp_query -> have_posts()){
		$html .= '<div class="material_cards-container">';
		while( $wp_query->have_posts() ) {
			$wp_query->the_post();
			$current_terms = wp_get_post_terms( get_the_ID(), 'card_category', array("fields" => "all") );
			$classes = ['material-card'];
			$post_meta = get_post_meta(get_the_ID());

			if( $current_terms[0]->slug === "fun-card" ){
				$classes[] = "fun-card";

				$html .= '<div class="'.implode(" ", $classes).'">
					<div class="card-header">'.$post_meta['material_cards-fun-topic'][0].'</div>
					<div class="card-content"><img src="'.get_the_post_thumbnail_url( get_the_ID(),'thumbnail' ).'"></div>
					<div class="card-footer">'.get_the_content().'</div>
				</div>';
			}else if( $current_terms[0]->slug === "job-card" ){
				$classes[] = "job-card";

				$html .= '<div class="'.implode(" ", $classes).'">
					<div class="card-header">'.get_the_title().'</div>
					<div class="card-content">'.$post_meta['material_cards-job-company'][0].'</div>
					<div class="card-footer"><img src="'.get_the_post_thumbnail_url( get_the_ID(),'thumbnail' ).'"><span>'.$post_meta['material_cards-job-url'][0].'</span></div>
				</div>';
			}else{
				$classes[] = "error-card";
			}
		}
		$html .= '</div>';
	}
	wp_reset_postdata();

	return $html;
}
add_shortcode( 'material_cards_grid', 'material_cards_grid_function' );

/**
 * Add Custom Meta Box to Custom Post Type Backend
 **/
function material_cards_custom_meta_box_markup($object)
{
	// Prevent Attacks
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>
        <div class="material_cards-custom-meta-box">
			<fieldset>
			<legend><?php _e('Job Card','material_cards'); ?></legend>
				<label for="material_cards-job-company"><? _e('Company','material_cards') ?></label>
				<input name="material_cards-job-company" type="text" value="<?php echo get_post_meta($object->ID, "material_cards-job-company", true); ?>">
				<br>
				<label for="material_cards-job-url"><? _e('Freshjob Url','material_cards') ?></label>
				<input name="material_cards-job-url" type="text" value="<?php echo get_post_meta($object->ID, "material_cards-job-url", true); ?>">
			</fieldset>
			<fieldset>
				<legend><?php _e('Fun Card','material_cards'); ?></legend>
				<label for="material_cards-fun-topic"><? _e('Topic','material_cards') ?></label>
				<input name="material_cards-fun-topic" type="text" value="<?php echo get_post_meta($object->ID, "material_cards-fun-topic", true); ?>">
			</fieldset>
        </div>
    <?php  
}

function material_cards_add_custom_meta_box()
{
    add_meta_box("material_cards-meta-box", "Material Cards Meta Box", "material_cards_custom_meta_box_markup", "cards", "normal", "high", null);
}

add_action("add_meta_boxes", "material_cards_add_custom_meta_box");

/**
 * Safe Custom Meta Box Data
 **/
function material_cards_save_custom_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "cards";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["material_cards-job-company"]))
    {
        $meta_box_text_value = $_POST["material_cards-job-company"];
    }   
	update_post_meta($post_id, "material_cards-job-company", $meta_box_text_value);
	
	if(isset($_POST["material_cards-job-url"]))
    {
        $meta_box_text_value = $_POST["material_cards-job-url"];
    }   
	update_post_meta($post_id, "material_cards-job-url", $meta_box_text_value);
	
	if(isset($_POST["material_cards-fun-topic"]))
    {
        $meta_box_text_value = $_POST["material_cards-fun-topic"];
    }   
    update_post_meta($post_id, "material_cards-fun-topic", $meta_box_text_value);
}

add_action("save_post", "material_cards_save_custom_meta_box", 10, 3);