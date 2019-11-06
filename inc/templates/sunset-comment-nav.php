<nav class="comment-navigation" role="navigation" >
	<div class="row">
		<div class="col-xs-12 col-sm-6 text-left">
			<div class="post-link-nav">
				<span class="sunset-icon sunset-chevron-left"></span>
				<?php previous_comments_link( esc_html__( 'Older comments', 'sunsettheme' ) ); ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 text-right">
			<div class="post-link-nav">
				<?php next_comments_link( esc_html__( 'Newer comments', 'sunsettheme' ) ); ?>
				<span class="sunset-icon sunset-chevron-right"></span>
			</div>
		</div>
	</div><!-- .row -->
</nav>