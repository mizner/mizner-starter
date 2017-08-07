<?php get_template_part( 'components/custom-header' ); ?>
<article class="post" <?php blog_schema() ?>>
    <div class="container">
            <div itemprop="text" class="the-content"><?php the_content(); ?></div>
    </div>
</article>