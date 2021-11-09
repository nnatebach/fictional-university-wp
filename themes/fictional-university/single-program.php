<?php get_header();

	while(have_posts()) {
		the_post();
    // since this screen does not need any custom "title" or "subtitle", we do not need to specify the array in here for "pageBanner()"
    pageBanner();
    ?>
    <div class="container container--narrow page-section">
			<div class="metabox metabox--position-up metabox--with-home-link">
			<p>
				<a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link("program"); ?>"><i class="fa fa-home" aria-hidden="true"></i>All Programs</a> 
				<span class="metabox__main"><?php the_title() ?></span>
			</p>
		</div>
		<div class="generic-content"><?php the_content(); ?></div>

    <!-- custom queries -->
    <?php
      $relatedProfessors = new WP_Query(array(
        "posts_per_page" => -1,
        "post_type" => "professor",
        "orderby" => "title",
        "order" => "ASC",
        // the array in the "meta_query" will allow us to filter things out as we wish.
        "meta_query" => array(
          array(
            "key" => "related_programs",
            "compare" => "LIKE",
            "value" => '"' . get_the_ID() . '"'
          )
        )
      ));

      if ($relatedProfessors->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium"> ' . get_the_title() . ' Professor</h2>';

        echo '<ul class="professor-cards">';
        while($relatedProfessors->have_posts()) {
          echo $relatedProfessors->the_post(); ?>
          <li class="professor-card__list-item">
            <a class="professor-card" href="<?php the_permalink(); ?>">
              <img class="professor-card__image" src="<?php the_post_thumbnail_url("professorLandscape"); ?>">
              <span class="professor-card__name"><?php the_title(); ?></span>
            </a>
          </li>
        <?php }
        echo '</ul>';
      }

      wp_reset_postdata();

      $today = date("Ymd");
      $homepageEvent = new WP_Query(array(
        "posts_per_page" => 2,
        "post_type" => "event",
        // (2) the name of the custom field that we are interested in.
        "meta_key" => "event_date",
        // (1) orderby a value of a piece of meta data, in this case is a meta of custom field. Since date is number we have "meta_value_num"
        "orderby" => "meta_value_num",
        "order" => "ASC",
        // the array in the "meta_query" will allow us to filter things out as we wish.
        "meta_query" => array(
          array(
            // "key" is the custom field
            "key" => "event_date",
            "compare" => ">=",
            "value" => $today,
            // tells WP the "value" that we are going to be comparing - not necessary but will be useful. The "type" of date is just number => numeric
            "type" => "numeric"
          ),
          array(
            "key" => "related_programs",
            "compare" => "LIKE", // "LIKE" = "contains"
            "value" => '"' . get_the_ID() . '"'
          )
        )
      ));

      if ($homepageEvent->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

        while($homepageEvent->have_posts()) {
          echo $homepageEvent->the_post();
          get_template_part("template-parts/content", "event");
        }
      }

      wp_reset_postdata();
      $relatedCampuses = get_field('related_campus');

      if ($relatedCampuses) {
        echo "<hr class='section-beak'>";
        echo '<h2 class="headline headline--medium">' . get_the_title() . ' is Available At These Campuses:</h2>';
        
        echo "<ul class='min-list link-list'>";
        foreach($relatedCampuses as $campus) {
          ?> <li><a href="<?php echo get_the_permalink($campus) ?>"><?php echo get_the_title($campus); ?></a></li> <?php
        }
        echo "</ul>";
      }

    ?>

		<?php
	};

	get_footer();
?>