<?php

use Mizner\Theme\Schema;

$schema = new Schema();

get_template_part( 'template-parts/custom-banner' ); ?>
<article class="post" <?php echo $schema->blog() ?>>
    <div class="container">
        <div itemprop="text" class="the-content"><?php the_content(); ?></div>
    </div>
</article>