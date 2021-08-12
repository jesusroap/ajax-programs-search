<?php
/* Registro de scripts */
function js_css_register_aps() {

	wp_register_script('ajax-programs-search-js', esc_url(plugins_url('public/js/ajax-programs-search.js', __FILE__)));
	wp_register_style('ajax-programs-search-css', esc_url(plugins_url('public/css/ajax-programs-search.css', __FILE__)));

}
add_action('init', 'js_css_register_aps');

function draw_aps() {

	wp_enqueue_script('ajax-programs-search-js');
	wp_enqueue_style( 'ajax-programs-search-css' );
	wp_localize_script('ajax-programs-search-js', 'programs', ['adminAjax'=>admin_url('admin-ajax.php')]);	
	require_once('form-search.php');

}
add_shortcode('ajax-programs-search', 'draw_aps');
//add_filter('wp_head', 'draw_aps');

function find_program() {

	$programs_found = [];

	if (isset($_POST['query']) && ! empty($_POST['query'])) {
		$args = [
			'post_type' 		=> 'page',
			'post_status' 		=> 'publish',
			'category_name' 	=> 'programas',
			'posts_per_page'	=> 5,
			'suppress_filters' => false,
			's'					=> $_POST['query']
		];

		//$programs = get_posts($args);

		$programs = new WP_Query( $args );

		foreach($programs as $program) {
			if ($program->post_title !== null) {
				$programs_found[] = [
					'title' => $program->post_title,
					'link'	=> get_permalink($program->ID)
				];
			}			
		}
	}

	wp_send_json($programs_found);

}
add_action('wp_ajax_findProgram', 'find_program');
add_action('wp_ajax_nopriv_findProgram', 'find_program')
?>