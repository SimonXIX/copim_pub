<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package copim
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

	<?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
        ?>

		<?php the_comments_navigation(); ?>

<ol class="comment-list">
    <?php
    wp_list_comments(
        [
            'style' => 'ol',
            'short_ping' => true,
            'callback' => 'custom_comment_template',
            'reply_text' => 'Reply',
            'avatar_size' => 64,
        ]
    );
        ?>
</ol><!-- .comment-list -->

		<?php
            the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (! comments_open()) :
            ?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'copim'); ?></p>
			<?php
        endif;

    endif; // Check for have_comments().

$commenter = wp_get_current_commenter();
$req = get_option('require_name_email');
$aria_req = ($req ? " aria-required='true'" : '');

$args = [
    'title_reply' => 'Leave a comment',
    'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
    'title_reply_after' => '</h3>',

    'fields' => [
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
                    '<input id="author" name="author" type="text" placeholder="Your name" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
        'email' => '<p class="comment-form-email"><label for="email">' . __('Email') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
                    '<input id="email" name="email" type="email" placeholder="Your email address" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
    'comment_notes_after' => '<p class="comment-notes privacy-agreement">By submitting your details you agree to our <a href="/about/privacy-policy/">privacy policy</a></p>',
    ],
    'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun') . '</label> <textarea id="comment" name="comment" placeholder="Share your thoughts" cols="45" rows="8" aria-required="true"></textarea></p>',
    'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(get_permalink())) . '</p>',
    'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>.'), admin_url('profile.php'), $user_identity) . '</p>',
    'label_submit' => 'Post Comment',
];

comment_form($args);

?>

</div><!-- #comments -->

 