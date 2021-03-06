<?php

// we should have "$args = NULL" since for those pages that do not need to have the array specified in the argument they will run into error "Too few arguments to function pageBanner()"
function pageBanner($args = NULL) {
	// php logic
	if (!$args["title"]) {
		$args['title'] = get_the_title();
	}
	if (!$args["subtitle"]) {
		$args['subtitle'] = get_field("page_banner_subtitle");
	}
	if (!$args["photo"]) {
		// check if an image was uploaded in the custom field
		if(get_field("page_banner_background_image")) {
			// ["sizes"] - add this because we don't want to have the original, super high resolution copy.
			// ["pageBanner"] - the image that is cropped into the page banner's size.
			$args["photo"] = get_field("page_banner_background_image")["sizes"]["pageBanner"];
		} else {
			// if none of the above exists, go with the image we've been using during the entire course
			$args["photo"] = get_theme_file_uri("/images/ocean.jpg");
		}
	}
	?>
	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?php echo $args["photo"]; ?>);"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args["title"] ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args["subtitle"] ?></p>
        </div>
      </div>
    </div>
	<?php
}

// function university_files() {
// 	wp_enqueue_script("main-university-js", get_theme_file_uri("/js/scripts-bundled.js"), NULL, microtime(), true);
// 	// get_theme_file_uri("file_directory", "dependencies[yes/NULL]", "version_number(if there is not one, then just make it up)", "load_before_closing_body_tag[true, false]")

// 	wp_enqueue_style("custom-google-font", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
// 	wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
// 	wp_enqueue_style("university_main_styles", get_stylesheet_uri(), NULL, microtime());
// }

// // replace the "version" number with the WP function "microtime()" in order to prevent the browser from auto-caching the files.

// add_action("wp_enqueue_scripts", "university_files");

function university_files() {
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=yourkeygoeshere', NULL, '1.0', true);
  wp_enqueue_script('axios', '//cdn.jsdelivr.net/npm/axios/dist/axios.min.js', NULL, '1.0', true);
  wp_enqueue_script('glidejs', '//cdn.jsdelivr.net/npm/@glidejs/glide', NULL, '1.0', true);

  wp_enqueue_script('main-university-js', get_theme_file_uri('/scripts.js'), array('jquery'), '1.0', true);
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());

	// create a relative path for the WP webpage, this will make sure that the beginning part of the URL of our WP webpage flexible so that it works regardless of the current environment.
  wp_localize_script('main-university-js', 'universityData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}

add_action('wp_enqueue_scripts', 'university_files');

function university_adjust_queries($query) {
	// manipulate archive-campus query
	if(!is_admin() AND is_post_type_archive("campus") AND $query->is_main_query()) {
		$query->set("posts_per_page", -1);
	}

	// manipulate archive-program query
	if(!is_admin() AND is_post_type_archive("program") AND $query->is_main_query()) {
		$query->set("orderby", "title");
		$query->set("order", "ASC");
		$query->set("posts_per_page", -1);
	}

	// add "$query->is_main_query()" to make sure that we are not accidentally manipulate a custom query while manipulating a default query. The method "is_main_query()" will only evaluate to "true" if the query is the default URL based query.

	// manipulate achieve-events query
	if(!is_admin() AND is_post_type_archive("event") AND $query->is_main_query()) {
		$today = date("Ymd");
		$query->set("meta_key", "event_date");
		$query->set("orderby", "meta_value_num");
		$query->set("order", "ASC");
		$query->set("meta_query", array(
			array(
				"key"=>"event_date",
				"compare"=>">=",
				"value"=>$today,
				"type"=>"numeric"
			)
		));
	}
}

add_action("pre_get_posts", "university_adjust_queries");

function universityMapKey($api) {
	$api["key"] = "AIzaSyCkRXNKO8J1nfvIVBvYEwNvc7eUt3nsS3M";
	return $api;
}

add_filter("acf/fields/google_map/api", "universityMapKey");