<?php
  get_header();
  pageBanner(array(
    "title" => "Past Events",
    "subtitle" => "The recap of our past events"
  ));
?>
<!-- Why using "archive-event.php" template for this page? We want this to be the page for all the past events and the template for that page will fit just fine for this page as well -->


<div class="container container--narrow page-section">
  <!-- custom queries -->
  <?php
    $today = date("Ymd");
    $pastEvents = new WP_Query(array(
      // (2) ("paged", 1) is the fall back in case if WP cannot find the page number dynamically.
      // "get_query_var("paged", 1)" this tells WP to get the number of the page at the end of the URL and if there is not one then that probably means we are on the first page of the result.
      "paged" => get_query_var("paged", 1),
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
          "compare" => "<",
          "value" => $today,
          // tells WP the "value" that we are going to be comparing - not necessary but will be useful. The "type" of date is just number => numeric
          "type" => "numeric"
        )
      )
    ));
    
    // this "while" loop has to refer to the "$pastEvents" since that is where we are pulling the data from, therefore, we need to add "$pastEvents->have_posts()" and "$pastEvents->the_post()"
    while ($pastEvents->have_posts()) { 
      $pastEvents->the_post();
      get_template_part("template-parts/content", "event");
    }
    // (1) usually "paginate_links()" will work just fine for the "default URL based query", however, in this case we are working with the "custom URL based query", therefore, there is nothing to paginate for the "default URL based query" which "paginate_links()" is trying to connect to
    echo paginate_links(array(
      "total" => $pastEvents->max_num_pages
    ));
  ?>
</div>

<?php
  get_footer();
?>