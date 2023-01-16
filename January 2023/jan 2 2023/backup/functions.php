<?php
define('THEME_PATH', get_template_directory());
define('THEME_URL', get_template_directory_uri());

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
 * Debug Helper
 */
if (!function_exists('pre')) {
    function pre($data, $die = 0) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($die)
            die;
    }
}

add_action('wp_head', 'cf_preload_fonts', 0);
function cf_preload_fonts() { ?>
    <link rel="preload" as="font" href="<?php echo home_url() ?>/wp-content/themes/kingdomvision/fonts/SterlingDisplay-Roman.woff" crossorigin />
    <?php
}

function theme_files() {
	// Theme Files
	wp_register_style( 'theme-style', get_stylesheet_uri(), false, null);
	wp_enqueue_style( 'theme-style');
	wp_register_style( 'theme-styler', get_stylesheet_directory_uri().'/css/responsive.css', false, null);
	wp_enqueue_style( 'theme-styler');
	wp_register_style( 'font-css', get_stylesheet_directory_uri().'/css/fonts.css', false, null);
	wp_enqueue_style( 'font-css');
	
	
	// Swiper Slider Files
	wp_register_style( 'swiper', get_stylesheet_directory_uri().'/swiper/swiper-bundle.min.css', false, '2.2.1' );
	wp_enqueue_style( 'swiper');	
	wp_register_script( 'swiper', get_stylesheet_directory_uri().'/swiper/swiper-bundle.min.js', array( 'jquery' ), '2.2.1', true );
	wp_enqueue_script( 'swiper' );

	// Slick Slider Files
	wp_register_style( 'slick', get_stylesheet_directory_uri().'/slick/slick.css', false, '2.2.1' );
	wp_enqueue_style( 'slick');	
	wp_register_script( 'slick', get_stylesheet_directory_uri().'/slick/slick.js', array( 'jquery' ), '2.2.1', true );
	wp_enqueue_script( 'slick' );

	// Owl Carousel Files
	wp_register_style( 'owl', get_stylesheet_directory_uri().'/owl-carousel/owl.css', false, '2.2.1' );
	wp_enqueue_style( 'owl');	
	wp_register_script( 'owl', get_stylesheet_directory_uri().'/owl-carousel/owl.js', array( 'jquery' ), '2.2.1', true );
	wp_enqueue_script( 'owl' );

	//Kv Script
    wp_register_script('kv-script', get_template_directory_uri() . '/kv-script.js', array('jquery'), null, true);
    wp_enqueue_script('kv-script');
	wp_localize_script( 'kv-script', 'kv_script',
		array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		)
	);

    // Fancybox
    wp_register_style('fancybox', get_stylesheet_directory_uri() . '/fancybox/jquery.fancybox.min.css', false);
    wp_enqueue_style('fancybox');
    wp_register_script('fancybox', get_stylesheet_directory_uri() . '/fancybox/jquery.fancybox.min.js', array('jquery'), '3.1.6', true);
    wp_enqueue_script('fancybox');
	
	
	// Font Awesome
	wp_register_script( 'fontawesome', '//kit.fontawesome.com/b69272743e.js', true );
	wp_enqueue_script( 'fontawesome' );
}
add_action( 'wp_enqueue_scripts', 'theme_files' );

// Enable Classic Editor
add_filter('use_block_editor_for_post', '__return_false', 10);

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );

// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

// Theme Options
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}


// Register Sidebar
add_action( 'widgets_init', 'kv_widgets_init' );
function kv_widgets_init() {
	$sidebar_attr = array(
		'name' 			=> '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	);	
	$sidebar_id = 0;
	$gdl_sidebar = array("Footer 1", "Footer 2", "Footer 3", "Footer 4",);
	foreach( $gdl_sidebar as $sidebar_name ){
		$sidebar_attr['name'] = $sidebar_name;
		$sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++ ;
		register_sidebar($sidebar_attr);
	}
}

// Register Navigation
function register_menu() {
	register_nav_menu('main-menu',__( 'Main Menu' ));
}
add_action( 'init', 'register_menu' );

// Image Crop
function codex_post_size_crop() {
	add_image_size("packages_image", 300, 200, true);
}
add_action("init", "codex_post_size_crop");

// Featured Image Function
add_theme_support( 'post-thumbnails' );

// Woocommerce Support
add_theme_support('woocommerce');

// Allow SVG Upload
function my_theme_custom_upload_mimes( $existing_mimes ) {
$existing_mimes['svg'] = 'image/svg+xml';
// Return the array back to the function with our added mime type.
return $existing_mimes;
}
add_filter( 'mime_types', 'my_theme_custom_upload_mimes' );

function my_custom_mime_types( $mimes ) {
 
// New allowed mime types.
$mimes['svg'] = 'image/svg+xml';
$mimes['svgz'] = 'image/svg+xml';
$mimes['doc'] = 'application/msword';
 
// Optional. Remove a mime type.
unset( $mimes['exe'] );
 
return $mimes;
}
add_filter( 'upload_mimes', 'my_custom_mime_types' );

//GRAVITY FORM TWO COLUMN FIELDS
// Splitting the Columns
function gform_column_splits($content, $field, $value, $lead_id, $form_id) {
 if(IS_ADMIN) return $content; // only modify HTML on the front end

 $form = RGFormsModel::get_form_meta($form_id, true);
 $form_class = isset($form['cssClass']) ? $form['cssClass'] : '';
 $form_classes = preg_split('/[\n\r\t ]+/', $form_class, -1, PREG_SPLIT_NO_EMPTY);
 $fields_class = isset($field['cssClass']) ? $field['cssClass'] : '';
 $field_classes = preg_split('/[\n\r\t ]+/', $fields_class, -1, PREG_SPLIT_NO_EMPTY);
 
 // multi-column form functionality
 if($field['type'] == 'section') {

  // check for the presence of multi-column form classes
  $form_class_matches = array_intersect($form_classes, array('two-column', 'three-column'));

  // check for the presence of section break column classes
  $field_class_matches = array_intersect($field_classes, array('gform_column'));

  // if field is a column break in a multi-column form, perform the list split
  if(!empty($form_class_matches) && !empty($field_class_matches)) { // make sure to target only multi-column forms

   // retrieve the form's field list classes for consistency
   $ul_classes = GFCommon::get_ul_classes($form).' '.$field['cssClass'];

   // close current field's li and ul and begin a new list with the same form field list classes
   return '</li></ul><ul class="'.$ul_classes.'"><li class="gfield gsection empty">';

  }
 }

 return $content;
}
add_filter('gform_field_content', 'gform_column_splits', 10, 5);

//Custom Post Types
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'products',
    array(
        'labels' => array(
        'name' => __( 'Products' ),
        'singular_name' => __( 'Products' )
      ),
	  'supports' => array(
      'title',
	  'thumbnail'
    ),
      'public' => true,
      'has_archive' => true,
      'menu_icon' => 'dashicons-products',
      'rewrite' => array( 'slug' => 'product' )
    )
  );
}

//Home Slider
add_shortcode('home_slider', 'codex_home_slider');
function codex_home_slider() {
	ob_start();
	$slider_content = get_field('slider_content', 'option');
?>
    <div class="swiper home-slider">
    	<div class="swiper-wrapper">
				<?php foreach( $slider_content as $slider_content ) {
					$slider_image = $slider_content['slider_image'];
					$heading = $slider_content['heading'];
					$content = $slider_content['content'];
					$link_1 = $slider_content['link_1'];
					$link_2 = $slider_content['link_2'];
				?>
			    	<div class="swiper-slide">
			    		<div class="hs-slide" style="background: url(<?php echo $slider_image; ?>) no-repeat center;">
			    			<div class="container">
					    		<div class="hs-content">
					    			<h3><?php echo $heading; ?></h3>
					    			<p><?php echo $content; ?></p>
					    			<div class="slider-links">
						    			<?php
											if($link_1) {
											   $link_url = $link_1['url'];
											   $link_title = $link_1['title'];
											   $link_target = $link_1['target'] ? $link_1['target'] : '_self' ;
											   echo '<a href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</a>';
											}
											if($link_2) {
											   $link_url = $link_2['url'];
											   $link_title = $link_2['title'];
											   $link_target = $link_2['target'] ? $link_1['target'] : '_self' ;
											   echo '<a href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</a>';
											}
										?>
								    </div>
					    		</div>
				    		</div>
			    		</div>
			    	</div>
		    <?php } ?>
    	</div>
    	<div class="swiper-pagination ls-bullets"></div>
   </div>
<?php
  return ''.ob_get_clean();	
}


//Customize Your Piece Carousel
add_shortcode('customize_your_piece', 'codex_customize_your_piece');
function codex_customize_your_piece() {
	ob_start();
	$pieces = get_field('customize_your_piece', 'option');
?>
<div class="cyp-wrapper">
    <div class="cyp-image">
		<div class="swiper cyp-slider">
			<div class="swiper-wrapper">
			<?php foreach( $pieces as $piece ) { ?>
				<div class="swiper-slide">
					<div class="cyp-slide">
						<?= wp_get_attachment_image($piece['image'], 'full'); ?>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
    <div class="cyp-content">
	<?php foreach( $pieces as $piece ) { ?>
		<div class="cyp-row cyp-hide">
			<h3><?= $piece['heading']; ?></h3>
			<p><?= $piece['sub_content']; ?></p>
			<a href="<?= home_url('/start-customizing/'); ?>">Customize now!</a>
		</div>
	<?php } ?>
		<div class="swiper-nav">
			<div class="swiper-right-carousel">
			  <i class="fa fa-arrow-left"></i>
			</div>
			<div class="swiper-left-carousel">
			  <i class="fa fa-arrow-right"></i>
			</div>
		</div>
	</div>
</div>

   
<?php
  return ''.ob_get_clean();	
}

add_filter( 'gform_pre_render_2', 'kv_gform_pre_render_2' );
function kv_gform_pre_render_2( $form ) {
	// 
	// pre( $_POST );
	// pre( $_FILES );
	
	if( !isset($_POST) || empty(@$_POST['input_3']) )
		return $form;
	
	$fullname = $_POST['input_3'];
	$phone = $_POST['input_4'];
	$email = $_POST['input_5'];
	$state = $_POST['input_6_4'];
	$country = $_POST['input_6_6'];
	$instagram = $_POST['input_7'];
	$category_name = wp_strip_all_tags( @$_POST['input_12'] );
	$category = ( @$_POST['input_12'] );
	$desc = $_POST['input_16'];

	$material = $_POST['input_27'];
	$gem = $_POST['input_28'];
	$length = $_POST['input_29'];
	$thickness = $_POST['input_30'];
	$imageUrl = @$_POST['input_62'];

	foreach( $form['fields'] as &$field )  {

		if( $field->id == 53 && ( empty($field->content) || $imageUrl ) ) {
			if( $imageUrl ) {
				$b = $imageUrl;
			}
			else {
				$a = new GF_Field_FileUpload();
				$b = $imageUrl = $a->get_single_file_value($form['id'], 'input_15');
			}
			$field->content = sprintf('<img src="%s">', ($b ? $b : '') );
		}
		else if( $field->id == 54 ) {
			$field->content = wp_unslash($category);
			$field->content = str_replace($category_name, "<span>{$category_name}</span>", $field->content);
		}

		switch ( $field->id ) {
			case '35':
				$defaultValue = $desc;
				break;
			case '55':
				$defaultValue = $material;
				break;
			case '56':
				$defaultValue = $gem;
				break;
			case '57':
				$defaultValue = $length;
				break;
			case '58':
				$defaultValue = $thickness;
				break;
				
			case 46:
				$defaultValue = $fullname;
				break;
			case '47':
				$defaultValue = $phone;
				break;
			case '48':
				$defaultValue = $email;
				break;
			case '49':
				$defaultValue = $country;
				break;
			case '50':
				$defaultValue = $state;
				break;
			case '51':
				$defaultValue = $instagram;
				break;
			case '62':
				$defaultValue = $imageUrl;
				break;
			default:
				$defaultValue = $field->defaultValue;
		}
		// End Switch Case

		$field->defaultValue = $defaultValue;
	}

	return $form;
}

// add_action( 'gform_after_submission_2', 'kv_gform_after_submission_2', 10, 2 );
function kv_gform_after_submission_2( $entry, $form ) {
 
	if( !isset($_POST) || empty(@$_POST['gform_uploaded_files']) )
		return;
	
	// pre($_POST);
	// pre($entry);
 
	// $gfUploadedFile = $_POST['gform_uploaded_files'];
	// $gfUploadedFile = json_decode( stripslashes($gfUploadedFile) );
	if( isset($_POST['input_16']) ) {
		// $form['id']
		$time            = current_time( 'mysql' );
		$y               = substr( $time, 0, 4 );
		$m               = substr( $time, 5, 2 );
		$gf_upload_path = GFFormsModel::get_upload_path( $form['id'] );
		// $gf_upload_path = trailingslashit( $gf_upload_path ) . "/$y/$m/";
		$gf_upload_path = $gf_upload_path . "/$y/$m/";
		$gf_upload_path = $gf_upload_path . basename(rgar( $entry, '62' ));

		if( file_exists($gf_upload_path) ) {
			unlink($gf_upload_path);
		}
		
	}

}

//Product Carousel
add_shortcode('product_carousel', 'codex_product_carousel');
function codex_product_carousel() {
	ob_start();
	wp_reset_postdata();
?>
    <div class="product-slider">
		<?php
			$arg = array(
				'post_type' => 'products',
				'posts_per_page' => -1,	
			);
			$po = new WP_Query($arg);
		?>
		<?php if ($po->have_posts() ): ?>        
		<?php while ( $po->have_posts() ) : ?>
        <?php $po->the_post(); ?> 		
			<div class="item">
		       <div class="product-slide">
				 <a class="product-img" href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), '' );?></a>
				 <a class="product-fav" href="javascript:;" data-prodid="<?= get_the_ID(); ?>"></a>
			   </div>
            </div>
<?php endwhile; ?>
<?php  endif; ?>
   </div>
<?php
	wp_reset_postdata();
	return ''.ob_get_clean();	
}


//Logo Carousel
add_shortcode('logo_carousel', 'codex_logo_carousel');
function codex_logo_carousel() {
	ob_start();
	$carousel_images = get_field('carousel_images', 'option');
?>
    <div class="logo-slider">
		<?php foreach( $carousel_images as $image ) { ?>
			<div class="item">
			    <img src='<?php echo $image; ?>'/>
			</div>
		<?php } ?>
   </div>
<?php
  return ''.ob_get_clean();	
}

//Insta Images Carousel
add_shortcode('image_carousel', 'codex_image_carousel');
function codex_image_carousel() {
	ob_start();
	$image_carousel = get_field('image_carousel', 'option');
?>
    <div class="insta-image-carousel">
    	<?php foreach( $image_carousel as $image ) { ?>
			<div class="item">
			    <img src='<?php echo $image; ?>'/>
			</div>
		<?php } ?>
   </div>
<?php
  return ''.ob_get_clean();	
}

add_action('wp_ajax_wishlist_counter', 'ajax_wishlist_counter_callback');
add_action('wp_ajax_nopriv_wishlist_counter', 'ajax_wishlist_counter_callback');
function ajax_wishlist_counter_callback() {
	//
	if( @$_POST['action'] !== 'wishlist_counter' )
		die('error');
	
	$pid = $_POST['pid'];
	$wishlist = get_post($pid);
	$counts = 0;
	if( $wishlist && $wishlist->post_type == 'products' ) {
		$counts = (int) get_post_meta($pid, 'wishlist_count', true);
		if( $_POST['type'] == 'inc' )
			$counts += 1;
		else
			$counts -= 1;
		update_post_meta($pid, 'wishlist_count', $counts);
	}
	echo $counts;
	die();
}

add_filter( 'manage_products_posts_columns', 'set_custom_edit_products_columns' );
function set_custom_edit_products_columns($columns) {
	$columns['prod_wishlist'] = __( 'Wishlist Counts', 'your_text_domain' );
	
    return $columns;
}

add_action( 'manage_products_posts_custom_column' , 'cf_manage_products_posts_custom_column', 10, 2 );
function cf_manage_products_posts_custom_column( $column, $post_id ) {
    switch ( $column ) {

        case 'prod_wishlist' :
            echo (int) get_post_meta( $post_id , 'wishlist_count' , true ); 
            break;
    }
}

//Content Slider
add_shortcode('content_slider', 'codex_content_slider');
function codex_content_slider() {
	ob_start();
	$content_slider = get_field('content_slider', 'option');
?>
    <div class="content-slider">
		<?php foreach( $content_slider as $content_slider ) {
			$image = $content_slider['image'];
			$heading = $content_slider['heading'];
			$content = $content_slider['content'];
			$link = $content_slider['link'];
		?>
		<div class="item">
			<img src='<?php echo $image; ?>'/>
			<div class="content">	
				<h3><?php echo $heading; ?></h3>
				<p><?php echo $content; ?></p>
				<?php
					if($link) {
						$link_url = $link['url'];
					    $link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self' ;
						echo '<a href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</a>';
					}
				?>
			</div>
		</div>
	<?php } ?>
   </div>
<?php
  return ''.ob_get_clean();	
}