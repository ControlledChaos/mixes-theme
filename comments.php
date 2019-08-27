<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

// Message before the comment form.
$comment_notes_before = sprintf(
	'<p class="comment-form-notes">%1s</p>',
	__( '', 'mixes-theme' )
);

// Arguments for the comment form.
$comments_args = [
	'title_reply'          => __( 'Leave a Comment', 'mixes-theme' ),
	'title_reply_to'       => __( 'Reply to %s', 'mixes-theme' ),
	'cancel_reply_link'    => __( 'Cancel reply', 'mixes-theme' ),
	'label_submit'         => __( 'Submit', 'mixes-theme' ),
	'comment_notes_before' => $comment_notes_before
];

?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$mixes_theme_comment_count = get_comments_number();
			if ( '1' === $mixes_theme_comment_count ) {
				printf(
					esc_html__( 'One Thought on &ldquo;%1$s&rdquo;', 'mixes-theme' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf(
					esc_html( _nx( '%1$s Thought on &ldquo;%2$s&rdquo;', '%1$s Thoughts on &ldquo;%2$s&rdquo;', $mixes_theme_comment_count, 'comments title', 'mixes-theme' ) ),
					number_format_i18n( $mixes_theme_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( [
				'style'      => 'ol',
				'short_ping' => true,
			] );
			?>
		</ol>

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'mixes-theme' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form( $comments_args );
	?>

</div>