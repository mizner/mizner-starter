<form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text">Search for:</span>
		<input type="search" placeholder="<?php echo esc_attr( 'Search…', 'presentation' ); ?>" name="s"
		       id="search-input" value="<?php echo esc_attr( get_search_query() ); ?>"/>
	</label>
	<?php
	/*
	<button class="screen-reader-text" type="submit" id="search-submit" value="Search"/>
		<i class="fa fa-search" aria-hidden="true"></i>
	</button>
	*/
	?>
</form>