<?php get_header(); ?>
<div class="content-wrapper full-section">
    <div class='product-content'>
        <div class='container'>
            <div class="slider-left">
                <div class="title" style="display:none;">
                 <?php
                 $title = get_field('title');
                 if( $title ){ ?>
                    <h2><?php echo $title['white_text']; ?><strong><?php echo $title['green_text']; ?></strong></h2>
                <?php } ?>
            </div>
            <div class="product-img">
                <?php $product_gallery = get_field('product_gallery'); ?>
                <div class="main-slide">
                    <?php foreach( $product_gallery as $image ) { ?>
                        <div class="item">
                            <img src='<?php echo $image; ?>'/>
                        </div>
                    <?php } ?>
                </div>
                <div class="slider-nav">
                    <?php foreach( $product_gallery as $image ) { ?>
                        <div class="item">
                            <img src='<?php echo $image; ?>'/>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="slider-right">
          <div class="title">
             <?php
             $title = get_field('title');
             if( $title ){ ?>
                <h2><?php echo $title['white_text']; ?><strong><?php echo $title['green_text']; ?></strong></h2>
            <?php } ?>
        </div>
        <div class="description">
            <?php the_field('description'); ?>
            <p class="label">Description</p>
        </div>
        <ul>
            <li>
                <?php the_field('material'); ?>
                <p class="label">Material</p>
            </li>
            <li>
                <?php the_field('gem'); ?>
                <p class="label">Gem</p>
            </li>
            <li>
                <?php the_field('length__thickness'); ?>
                <p class="label">Length / Thickness</p>
            </li>
            <li>
                <?php the_field('weight'); ?>
                <p class="label">Weight</p>
            </li>
        </ul>
    </div>
</div>
</div>
<div class="product-get-quote">
 <div class="container">
   <div class="post-arrows">
    <?php the_post_navigation( array(
       'prev_text'  => __( '<i class="fa-solid fa-arrow-left"></i>' ),
       'next_text'  => __( '<i class="fa-solid fa-arrow-right"></i>' ),
   ) );

    // $args = 
    // array(
    //     'post_type' => 'post',
    //     'post_status' => 'publish'
    // );
    // $count_posts =  WP_Query($args);


// $pid = $recent_post;
//     print_r($pid);
// $latest_cpt = get_posts("post_type=yourcpt&numberposts=1");
// echo $latest_cpt[0]->ID
    // $args = array(
    //     'post_type' =>get_post_type(get_the_ID()),
    //     'post_status' => 'publish',
    //     'posts_per_page' => -1,
    //     'orderby'    => 'modified',
    //     'order' => 'DESC'

    // );

        $args = array(
    'post_type' => get_post_type(get_the_ID()),
    'posts_per_page' => 1,
    'orderby'    => 'date',
    // 'order' => 'Desc',
);

$recent_post = wp_get_recent_posts($args, OBJECT);


    // $pid = $recent_post;

    // print_r($pid[0]->ID);

    if (empty(get_next_post())) {

        $args['order'] = 'DEsc';
        $recent_post = get_posts( $args );
        $pid = $recent_post ? $recent_post[0]->ID : 0;
        echo '
        <div class="nav-previous"><a href="'.get_the_permalink($pid).'" rel="next"><i class="fa-solid fa-arrow-right"></i></a></div>
        ';

    }

    if (empty(get_previous_post())) {
        $args['order'] = 'Asc';
        $recent_post = get_posts( $args );
        $pid = $recent_post ? $recent_post[0]->ID : 0;
        echo '
        <div class="nav-previous"><a href="'.get_the_permalink($pid).'" rel="next"><i class="fa-solid fa-arrow-left"></i></a></div>
        ';
    }

    ?>        
</div>
<div class="get-quote">
    <a href="<?php echo home_url(); ?>/contact">Get Quote!</a>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>