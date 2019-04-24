<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'init', array( $this, 'register_taxonomies' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles') );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts') );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles') );
    add_action( 'login_enqueue_scripts', array( $this, 'my_login_logo' ) );
    add_action( 'login_enqueue_scripts', array( $this, 'my_login_logo' ) );
    add_filter( 'login_headerurl', array( $this, 'enqueue_login_styles' ) );
    add_filter( 'login_headertitle', array( $this, 'my_login_logo_url_title' ) );
    // add_filter( 'acf/pre_save_post' , array( $this, 'contribution_pre_save_post'), 10, 1 );
    add_filter( 'registration_redirect', array( $this, 'yinz_registration_redirect' ) );
		parent::__construct();
	}

	function register_post_types() {
    //this is where you can register custom post types
    require( plugin_dir_path(__FILE__) . '/includes/cpt_podcast.php');
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
  }
  
  function enqueue_scripts() {
    wp_enqueue_script('main-script', get_template_directory_uri() . '/dist/main.js', false, false, true);
  }

  function enqueue_styles() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/dist/main.css', null, null, 'all');
  }

  function enqueue_admin_scripts() {
    wp_enqueue_script('admin-script', get_template_directory_uri() . '/dist/admin.js', false, false, true);
  }

  function enqueue_admin_styles() {
    wp_enqueue_style('admin-style', get_template_directory_uri() . '/dist/admin.css', null, null, 'all');
  }

  function enqueue_login_styles() {
    wp_enqueue_style('login-style', get_template_directory_uri() . '/dist/login.css', null, null, 'all');
  }

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
    $twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
  }
  

  function my_login_logo() { ?>
    <style type="text/css">
      body {
        background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/main-content.jpg) !important;
        background-size: cover !important;
        background-repeat: no-repeat !important;
      }

      body .login form {
        background-color: #0F2027;
      }

      #login h1 a, .login h1 a {
        background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/yinz-logo.svg);
        /* height:155px;
        width:320px; */
        background-size: contain;
        background-repeat: no-repeat;
        padding-bottom: 30px;
      }
    </style>
  <?php }


  function my_login_logo_url() {
    return home_url();
  }
  

  function my_login_logo_url_title() {
    return 'Yinz Guhyz - Home';
  }

  function contribution_pre_save_post($post_id) {
    // require( plugin_dir_path(__FILE__) . '/includes/contribute_form.php');

    // var_dump($post_id);
    // die();
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
  }
  
  
  function yinz_registration_redirect( $redirect ) {
      if( isset( $_SERVER['HTTP_REFERER'] ) && 0 != strlen( $_SERVER['HTTP_REFERER'] ) ) {
          $redirect = esc_url( $_SERVER['HTTP_REFERER'] );
      }
      return $redirect;
  }

}

new StarterSite();



