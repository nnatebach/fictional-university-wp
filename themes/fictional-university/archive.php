<?php
  get_header();
  pageBanner(array(
    // in this array we do not want to echo anything, we just want to return a value
    "title" => get_the_archive_title(),
    "subtitle" => get_the_archive_description()
  ));
?>

<div class="container container--narrow page-section">
  <?php
    while (have_posts()) { 
      the_post(); ?>
      <div class="post-item">
        <h2 class="headline headline--medium headline-post-title"><a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
        <!-- the following is just for styling and design purposes -->
        <div class="metabox">
          <!-- <p>Posted by Nathan on 19.10.2021 in News.</p> -->
          <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time("F j, Y"); ?> in <?php echo get_the_category_list(", "); ?></p>
        </div>
        <div class="generic-content">
          <?php the_excerpt(); ?>
          <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;.</a></p>
        </div>
      </div>
    <?php }
    echo paginate_links();
  ?>
</div>

<?php
  get_footer();
?>