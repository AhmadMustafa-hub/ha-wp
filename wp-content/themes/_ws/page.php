<?php
get_header(); ?>

<main id="main" class="main page">
  <?php
  if (have_posts()) :
    while (have_posts()) :
      the_post();
      the_content();
    endwhile;
  endif; ?>
</main>

<?php
get_footer(); ?>
