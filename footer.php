<?php do_action('before_the_footer')?>
<footer id="footer">
	<p class="copyright"><?php echo get_bloginfo(); ?> | All Rights Reserved © <?php echo date( "Y" ); ?></p>
	<?php // the_phone(); ?>
	<?php the_social_media(); ?>
</footer>
<?php wp_footer(); ?>

</main>
</body>
</html>

