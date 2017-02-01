<article>
    <header>
        <a href="<?php the_permalink(); ?>">
            <h3><?php the_title(); ?></h3>
        </a>
    </header>
    <div class="post-meta">
		<?php the_date(); ?>
		<?php the_category(); ?>
    </div>
    <p><?php the_excerpt(); ?></p>

</article>



