<?php do_action( 'before_the_footer' ) ?>
<footer id="theFooter">
    <div class="container">
        <section class="footer-info">
            <p class="copyright"><?php echo get_bloginfo(); ?> | All Rights Reserved © <?php echo date( "Y" ); ?></p>
			<?php // the_phone(); ?>
			<?php // the_social_media(); ?>
        </section>
    </div>
</footer>
<?php do_action( 'after_the_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>

