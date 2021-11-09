<?php

// create custom event

function university_post_types() {
  // Campus Post Type
	register_post_type("campus", array(
    "show_in_rest" => true,
    "supports" => array("title", "editor", "excerpt"),
    "rewrite" => array("slug" => "campuses"),
    "has_archive" => true,
		"public" => true,
		"labels" => array(
			"name" => "Campuses",
      // change "Add New Post" to "Add New Event" in WP "Events" page.
      "add_new_item" => "Add New Campus",
      // change "Edit Post" to "Edit Event" in WP "Events" page.
      "edit_item" => "Edit Campus",
      // change "Events" to "All Events" in WP "Events" page.
      "all_items" => "All Campuses",
      "singular_name" => "Campus"
		),
		"menu_icon" => "dashicons-location-alt"
	));

  // Event Post Type
	register_post_type("event", array(
    "show_in_rest" => true,
    "supports" => array("title", "editor", "excerpt"),
    "rewrite" => array("slug" => "events"),
    "has_archive" => true,
		"public" => true,
		"labels" => array(
			"name" => "Events",
      // change "Add New Post" to "Add New Event" in WP "Events" page.
      "add_new_item" => "Add New Event",
      // change "Edit Post" to "Edit Event" in WP "Events" page.
      "edit_item" => "Edit Event",
      // change "Events" to "All Events" in WP "Events" page.
      "all_items" => "All Events",
      "singular_name" => "Event"
		),
		"menu_icon" => "dashicons-calendar"
	));

  // Program Post Type
	register_post_type("program", array(
    "show_in_rest" => true,
    "supports" => array("title", "editor"),
    "rewrite" => array("slug" => "programs"),
    "has_archive" => true,
		"public" => true,
		"labels" => array(
			"name" => "Programs",
      // change "Add New Post" to "Add New Program" in WP "Programs" page.
      "add_new_item" => "Add New Program",
      // change "Edit Post" to "Edit Program" in WP "Programs" page.
      "edit_item" => "Edit Program",
      // change "Programs" to "All Programs" in WP "Programs" page.
      "all_items" => "All Programs",
      "singular_name" => "Program"
		),
		"menu_icon" => "dashicons-awards"
	));

  // Professor Post Type
	register_post_type("professor", array(
    "show_in_rest" => true,
    "supports" => array("title", "editor", "thumbnail"),
		"public" => true,
		"labels" => array(
			"name" => "Professors",
      // change "Add New Post" to "Add New Professor" in WP "Professors" page.
      "add_new_item" => "Add New Professor",
      // change "Edit Post" to "Edit Professor" in WP "Professors" page.
      "edit_item" => "Edit Professor",
      // change "Professors" to "All Professors" in WP "Professors" page.
      "all_items" => "All Professors",
      "singular_name" => "Professor"
		),
		"menu_icon" => "dashicons-welcome-learn-more"
	));
}

add_action("init", "university_post_types");