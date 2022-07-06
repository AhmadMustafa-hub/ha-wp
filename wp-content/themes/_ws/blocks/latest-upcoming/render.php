<?php
function _ws_block_latest_upcoming($a) {
  $a['className'] = 'wp-block-ws-latest-upcoming ' . ($a['className'] ?? '');
  $postType = $a['postType'] ?? 'post';
  $numPosts = $a['numPosts'] ?? 3;
  $numPosts = isset($a['allPosts']) && $a['allPosts'] ? -1 : $numPosts;
  $taxTerms = $a['taxTerms'] ?? [];
  $horizontalScroll = isset($a['horizontalScroll']) && $a['horizontalScroll'] ? 'horizontal-scroll' : '';
  $type = $postType;
  if (strpos($a['className'], 'is-style-cards') !== false) {
    $type = 'card';
  }
  if (strpos($a['className'], 'is-style-tiles') !== false) {
    $type = 'tile';
  }
  if (strpos($a['className'], 'is-style-list') !== false) {
    $type = 'list';
  }
  ob_start(); ?>
    <div class="row <?= $type; ?>-row <?= $horizontalScroll; ?>">
      <?php
      $ps = get_posts(_ws_latest_upcoming_build_args($postType, $numPosts, $taxTerms));
      if ($postType === 'event') {
        $ps = array_filter($ps, function($v) {
          return time() <= strtotime(get_post_meta($v->ID, '_event_start_date', true));
        });
      }
      global $post;
      foreach ($ps as $i=>$post) {
        setup_postdata($post);
        get_template_part('parts/archive', $type);
      }
      wp_reset_postdata(); ?>
    </div>
  <?php
  return _ws_block_wrapping($a, ob_get_clean(), 'div');
}

function _ws_latest_upcoming_build_args($postType, $numPosts, $taxTerms) {
  global $post;
  $args = [
    'post_type' => $postType,
    'posts_per_page' => $numPosts,
    'post_status' => 'publish'
  ];
  // Tax query
  $queries = [];
  foreach ($taxTerms as $tax=>$terms) {
    array_push($queries, [
      'taxonomy' => $tax,
      'field' => 'id',
      'terms' => $terms
    ]);
  }
  if (!empty($queries)) {
    $queries['relation'] = 'OR';
    $args['tax_query'] = $queries;
  }
  // Event ordering
  if ($postType === 'event') {
    $args['meta_query'] = [
      [
        'key' => '_event_start_date',
        'value' => date('Y-m-d\TH:i:s'),
        'compare' => '>='
      ]
    ];
    $args['orderby'] = 'meta_value';
    $args['meta_key'] = '_event_start_date';
    $args['order'] = 'DESC';
  }
  return $args;
}
