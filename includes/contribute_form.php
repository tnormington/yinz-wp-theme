<?php

// check if this is to be a new post
if( $post_id != 'new' ) {

  return $post_id;

}

// Create a new post
$post = array(
  'post_status'  => 'draft' ,
  'post_title'  => 'A title, maybe a $_POST variable' ,
  'post_type'  => 'post' ,
);  

// insert the post
$post_id = wp_insert_post( $post ); 

// return the new ID
return $post_id;