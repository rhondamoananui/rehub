<article class="rething_item small_post">
    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
        <figure>
            <?php rehub_formats_icons('full'); ?>
            <?php echo getPostLikeLink( get_the_ID() );?>
            <a href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
        </figure>                                     
    <?php } ?>
    <div class="wrap_thing">
        <div class="top">
            <?php $category = get_the_category(get_the_ID());  ?>
            <?php if ($category) {$first_cat = $category[0]->term_id; meta_small( false, $first_cat, false, false );} ?>
        </div>
        <div class="hover_anons">
            <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
            <div class="post-meta"> <?php meta_small( true, false, true, false ); ?> </div>
            <?php rehub_format_score('small') ?>
            <p><?php kama_excerpt('maxchar=320'); ?></p>
        </div>
        <?php rehub_create_btn('yes') ;?>
    </div>
</article>