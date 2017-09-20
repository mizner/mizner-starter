<div class="container">
    <article>
        <a href="<?php the_permalink(); ?>">
            <h2><?php the_title(); ?></h2>
        </a>
        <div class="post-meta">
			<?php the_date(); ?>
			<?php the_category(); ?>
        </div>
    </article>
</div>