<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;


$sticky = get_option('sticky_posts');

$args = array(
  'posts_per_page' => 4,
  'order' => 'DESC',
  'orderby' => 'date',
  'post_status' => 'publish',
  'post_type' => array( 'post', 'podcast'),
  'post__not_in' => $sticky,
);


$context['latest_content'] = Timber::get_posts($args);

// copy regular args
$sticky_args = $args;
// only show highlighted posts
$sticky_args['post__in'] = $sticky;
$sticky_args['post__not_in'] = false;


$context['highlights'] = Timber::get_posts($sticky_args);

Timber::render( array( 'page-front.twig' ), $context );