<?php
/**
 *
 * @package copim
 */
if (! defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

function copim_setup()
{
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]
    );

}
add_action('after_setup_theme', 'copim_setup');

// REMOVE ADMIN / EDITOR MENU ITEMS
function copim_setup_editor_capabilities()
{
    $role = get_role('editor');
    if ($role && ! $role->has_cap('edit_theme_options')) {
        $role->add_cap('edit_theme_options');
    }
}
add_action('after_switch_theme', 'copim_setup_editor_capabilities');

function restrict_admin_menus_for_editors()
{
    if (! current_user_can('administrator')) {
        // Appearance > Menus only
        global $submenu;
        if (isset($submenu['themes.php'])) {
            foreach ($submenu['themes.php'] as $index => $item) {
                $slug = $item[2];
                if ($slug !== 'nav-menus.php') {
                    unset($submenu['themes.php'][$index]);
                }
            }
        }

        // Hide entire Tools menu
        remove_menu_page('tools.php');

        // Hide Ajax Load More
        remove_menu_page('ajax-load-more');
    }
}
add_action('admin_menu', 'restrict_admin_menus_for_editors', 999);

// Register menus
register_nav_menus(
    [
        'header-menu' => esc_html__('Header Menu', 'copim'),
        'footer-menu-1' => esc_html__('Footer Menu 1', 'copim'),
        'footer-menu-2' => esc_html__('Footer Menu 2', 'copim'),
        'footer-menu-credits' => esc_html__('Footer Menu Credits', 'copim'),
    ]
);

/**
 * Custom Walker Nav Menu With Icons - Add div around main nav so it can form a mega menu and add icons
 */
class Custom_Walker_Nav_Menu_With_Icons extends Walker_Nav_Menu
{
    /**
     * Maximum allowed depth - theme supports 2 levels maximum
     * Level 0: Main navigation
     * Level 1: Dropdown submenu
     */
    private const MAX_DEPTH = 2;

    /**
     * Track if we're in a valid menu level
     */
    private $current_depth = 0;

    /**
     * Add wrapper before submenu with error handling
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        // Validate output parameter
        if (! is_string($output)) {
            $output = '';
        }

        // Validate and sanitize depth
        $depth = $this->validate_depth($depth);

        // Depth is now controlled by the walk() method override

        // Generate indentation safely
        $indent = str_repeat("\t", $depth);
        $submenu_class = ($depth === 0) ? 'sub-menu' : 'sub-sub-menu';

        $output .= "\n$indent<ul class=\"$submenu_class\">\n";

        // Only add wrapper to top-level submenus (depth 0 = main nav, depth 1 = dropdown)
        if ($depth === 0) {
            $output .= "$indent\t<div class=\"sub-menu-inner\">\n";
        }
    }

    /**
     * Close the submenu wrapper with error handling
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        // Validate output parameter
        if (! is_string($output)) {
            $output = '';
        }

        // Validate and sanitize depth
        $depth = $this->validate_depth($depth);

        // Generate indentation safely
        $indent = str_repeat("\t", $depth);

        if ($depth === 0) {
            $output .= "$indent\t</div>\n";
        }

        $output .= "$indent</ul>\n";
    }

    /**
     * Add icons to top-level items with children and comprehensive error handling
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Validate output parameter
        if (! is_string($output)) {
            $output = '';
        }

        // Validate item parameter
        if (! $this->validate_menu_item($item)) {
            return; // Skip invalid items
        }

        // Validate and sanitize depth
        $depth = $this->validate_depth($depth);

        // Depth is now controlled by the walk() method override

        // Set up the base list item classes with validation
        $classes = $this->get_safe_classes($item);
        $class_names = join(' ', array_filter($classes));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        // Build the <a> tag with safe attribute handling
        $attributes = $this->build_safe_attributes($item);
        $attributes .= ' class="menu-link"';

        // Get safe title with fallback
        $title = $this->get_safe_title($item, $args, $depth);

        $item_output = '<a' . $attributes . '>';
        $item_output .= $title;

        // Append icons ONLY to top-level items with children (with validation)
        if ($this->should_show_icons($args, $depth, $item)) {
            $item_output .= $this->get_icon_markup();
        }

        $item_output .= '</a>';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $args, $depth);
    }

    /**
     * Validate and sanitize depth parameter
     */
    private function validate_depth($depth)
    {
        // Ensure depth is numeric
        if (! is_numeric($depth)) {
            $depth = 0;
        }

        // Convert to integer
        $depth = (int) $depth;

        // Ensure depth is within safe bounds
        if ($depth < 0) {
            $depth = 0;
        } elseif ($depth > self::MAX_DEPTH) {
            $depth = self::MAX_DEPTH;
        }

        return $depth;
    }

    /**
     * Validate menu item object
     */
    private function validate_menu_item($item)
    {
        // Check if item exists and is an object
        if (! $item || ! is_object($item)) {
            return false;
        }

        // Check for required properties
        $required_properties = [ 'ID', 'title', 'url', 'classes' ];
        foreach ($required_properties as $property) {
            if (! property_exists($item, $property)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get safe classes array with fallback
     */
    private function get_safe_classes($item)
    {
        if (! isset($item->classes) || ! is_array($item->classes)) {
            return [];
        }

        // Filter out any non-string classes
        return array_filter($item->classes, 'is_string');
    }

    /**
     * Build safe HTML attributes
     */
    private function build_safe_attributes($item)
    {
        $attributes = '';

        // Title attribute
        if (! empty($item->attr_title) && is_string($item->attr_title)) {
            $attributes .= ' title="' . esc_attr($item->attr_title) . '"';
        }

        // Target attribute
        if (! empty($item->target) && is_string($item->target)) {
            $attributes .= ' target="' . esc_attr($item->target) . '"';
        }

        // XFN attribute
        if (! empty($item->xfn) && is_string($item->xfn)) {
            $attributes .= ' rel="' . esc_attr($item->xfn) . '"';
        }

        // URL attribute
        if (! empty($item->url) && is_string($item->url)) {
            $attributes .= ' href="' . esc_url($item->url) . '"';
        }

        return $attributes;
    }

    /**
     * Get safe title with fallback
     */
    private function get_safe_title($item, $args, $depth)
    {
        // Ensure title exists and is string
        if (empty($item->title) || ! is_string($item->title)) {
            $title = 'Untitled';
        } else {
            $title = $item->title;
        }

        // Apply WordPress filters safely
        $title = apply_filters('the_title', $title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        // Ensure final title is string
        if (! is_string($title)) {
            $title = 'Untitled';
        }

        return $title;
    }

    /**
     * Determine if icons should be shown
     */
    private function should_show_icons($args, $depth, $item)
    {
        // Check if args is valid object
        if (! is_object($args)) {
            return false;
        }

        // Check if theme_location is set and matches header-menu
        if (! isset($args->theme_location) || $args->theme_location !== 'header-menu') {
            return false;
        }

        // Check if depth is 0 (top level)
        if ($depth !== 0) {
            return false;
        }

        // Check if item has classes and is array
        if (! isset($item->classes) || ! is_array($item->classes)) {
            return false;
        }

        // Check if item has children
        return in_array('menu-item-has-children', $item->classes);
    }

    /**
     * Get icon markup
     */
    private function get_icon_markup()
    {
        return '<span class="icon-wrapper menu-icon-toggle" aria-hidden="true">' .
               '<svg class="icon icon-closed"><use href="#ph--plus-bold"></use></svg>' .
               '<svg class="icon icon-open"><use href="#ph--minus-bold"></use></svg>' .
               '</span>';
    }

    /**
     * Override the walk method to enforce two-level structure
     */
    public function walk($elements, $max_depth, ...$args)
    {
        // Force maximum depth to 2 levels
        $max_depth = 2;

        // Call parent walk method with enforced depth
        return parent::walk($elements, $max_depth, ...$args);
    }
}

/* CUSTOM GRAVATAR */

function custom_comment_author_avatar($avatar, $id_or_email, $size, $default, $alt, $args)
{
    // Only modify if it's default Gravatar
    if (strpos($avatar, 'gravatar.com/avatar/') !== false && strpos($avatar, 'd=mm') !== false) {
        $name = '';

        // Get the comment author's name
        if (is_object($id_or_email) && isset($id_or_email->comment_ID)) {
            $comment = $id_or_email;
            $name = $comment->comment_author;
        } elseif (is_numeric($id_or_email)) {
            $comment = get_comment($id_or_email);
            if ($comment) {
                $name = $comment->comment_author;
            }
        } elseif (is_string($id_or_email)) {
            // Try to find comment by email
            $comments = get_comments(['author_email' => $id_or_email, 'number' => 1]);
            if ($comments) {
                $name = $comments[0]->comment_author;
            }
        }

        if (! empty($name)) {
            // Get initials (first letter of first and last name)
            $name_parts = explode(' ', $name);
            $initials = '';
            $initials .= isset($name_parts[0]) ? strtoupper(substr($name_parts[0], 0, 1)) : '';
            $initials .= isset($name_parts[count($name_parts) - 1]) ? strtoupper(substr($name_parts[count($name_parts) - 1], 0, 1)) : '';

            if (! empty($initials)) {
                // Generate consistent color based on name
                // $background_color = '#' . substr(md5($name), 0, 6);
                $text_color = '#ffffff';
                $colors = [ 'var( --brand-400 )', 'var( --brand-600 )', 'var( --warm-gray-500 )', 'var( --warm-gray-600 )', 'var( --warm-gray-800 )' ];
                $background_color = $colors[abs(crc32($name)) % count($colors)];

                // Create the avatar HTML
                $avatar = sprintf(
                    '<div class="comment-author-initials" style="width:%dpx; height:%dpx; background-color:%s; color:%s; border-radius:50%%; display:inline-flex; align-items:center; justify-content:center; ">%s</div>',
                    $size,
                    $size,
                    $background_color,
                    $text_color,
                    $initials
                );
            }
        }
    }

    return $avatar;
}
add_filter('get_avatar', 'custom_comment_author_avatar', 10, 6);

// Remove "Category:", "Tag:", etc. from archive titles
add_filter('get_the_archive_title', 'remove_archive_title_prefix');
function remove_archive_title_prefix($title)
{
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }

    return $title;
}

/* * * Responsive images  * * */

function copim_image_sizes()
{
    // Modify defaults
    update_option('thumbnail_size_w', 300);
    update_option('thumbnail_size_h', 300);
    update_option('thumbnail_crop', 1);

    update_option('medium_size_w', 600);
    update_option('medium_size_h', 0);

    update_option('large_size_w', 1200);
    update_option('large_size_h', 0);

    // Custom sizes
    add_image_size('hero', 2048, 0, false); // For 4K displays and retina screens
}
add_action('after_switch_theme', 'copim_image_sizes');

/* * * Enqueue scripts and styles * * */

function copim_enqueue_styles()
{
    wp_register_style('copim-styles', get_template_directory_uri() . '/resources/css/main.min.css', '1.0', true);
    wp_enqueue_style('copim-styles');
    // Swiper homepage
    if (is_page_template('page-home.php')) {
        wp_register_style('swiper-styles', get_template_directory_uri() . '/resources/css/swiper-bundle.min.css', '11.2.6', true);
        wp_enqueue_style('swiper-styles');
    }
}
add_action('wp_enqueue_scripts', 'copim_enqueue_styles');

function copim_enqueue_scripts()
{
    // Add JS to display years only on 'all posts' template
    if (is_page_template('page-all-posts.php')) {
        wp_enqueue_script(
            'alm-year-headings',
            get_template_directory_uri() . '/resources/js/alm-year-headings.min.js',
            ['jquery', 'ajax-load-more'],
            null,
            true
        );
    }
    // Swiper homepage
    if (is_page_template('page-home.php')) {
        wp_register_script('swiper_scripts', get_template_directory_uri() . '/resources/js/swiper-bundle.min.js', '11.2.6', true);
        wp_enqueue_script('swiper_scripts');
    }
    // Add comments if required
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    wp_register_script('copim_scripts', get_template_directory_uri() . '/resources/js/scripts.min.js', ['jquery'], '1.0', true);
    wp_enqueue_script('copim_scripts');
}
add_action('wp_enqueue_scripts', 'copim_enqueue_scripts');

/* * * ADD SVG SPRITE TO HEADER * * */
function copim_output_svg_sprite()
{
    $svg_sprite_path = get_template_directory() . '/resources/img/icons.svg';

    if (file_exists($svg_sprite_path) && is_readable($svg_sprite_path)) {
        $svg_content = file_get_contents($svg_sprite_path);

        if ($svg_content && strpos($svg_content, '<svg') !== false) {
            echo $svg_content;
        }
    }
}
add_action('wp_head', 'copim_output_svg_sprite', 1);

/* * * CHANGE DEFAULT TABLE PRESS HEADING * * */

add_filter('tablepress_print_name_html_tag', 'change_tablepress_heading_tag');
function change_tablepress_heading_tag($tag)
{
    return 'h5';
}

/* * * VIDEO EMBED RESPONSIVE RESIZE * * */

add_filter('embed_oembed_html', function ($html, $url, $attr, $post_id) {
    if (strpos($html, 'youtube.com') !== false ||
        strpos($html, 'youtu.be') !== false ||
        strpos($html, 'vimeo.com') !== false) {
        return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
    }

    return $html;
}, 10, 4);

/* * * PREPOPULATE ACF POSTS * * */

add_filter('acf/load_value/name=rte_flexible_content', 'set_default_flexible_layout', 10, 3);
function set_default_flexible_layout($value, $post_id, $field)
{
    // Only set default if no existing value
    if (! $value) {
        $value = [
            [
                'acf_fc_layout' => 'rte_content',
                'rte_content_block' => '',
            ],
        ];
    }

    return $value;
}

/* * * COMMENTS OUTPUT * * */

function custom_comment_template($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    $comment_reply_count = get_comments([
        'parent' => $comment->comment_ID,
        'count' => true,
    ]);
    ?>
    
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
  
        <div id="comment-<?php comment_ID(); ?>" class="comment-wrapper">
            <div class="comment-author vcard">

                <?php echo get_avatar($comment, $args['avatar_size']); ?>
				
				<div class="comment-meta commentmetadata">
             	  
					<cite class="comment-author-name"><h6><?php echo get_comment_author_link(); ?></h6></cite>

				   <div class="comment-date"><?php
                    // Date & Time (without link)
                    printf(
                        esc_html__('%1$s at %2$s', 'copim'),
                        get_comment_date(),
                        get_comment_time()
                    ); ?></div>
                </div>

                  	<?php  // Show "Replies (x)" only if there are replies
                    if ($comment_reply_count > 0) {
                        echo ' <div class="reply-count">' . sprintf(
                            _n('Reply (%d)', 'Replies (%d)', $comment_reply_count, 'copim'),
                            $comment_reply_count
                        ) . '</div>';
                    }
    ?>
                

            </div>
            
            <?php if ($comment->comment_approved == '0') : ?>
                <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'copim'); ?></em>
            <?php endif; ?>
            
            <div class="comment-text">
                <?php comment_text(); ?>
            </div>
            
            <div class="reply">
                <?php
                // Normal reply button (without count)
                comment_reply_link(array_merge(
                    $args,
                    [
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => __('Reply', 'copim'),
                    ]
                ));
    ?>
            </div>
        </div>
    <?php
}

/* ACF POST SUMMARIES */

function get_intro_excerpt($post_id = null, $char_limit = 120)
{
    if (! $post_id) {
        $post_id = get_the_ID();
    }

    // Get raw WYSIWYG content
    $raw_content = get_field('rte_content_introduction', $post_id);
    $raw_content = is_string($raw_content) ? wp_kses_post($raw_content) : '';

    if (! $raw_content) {
        return '';
    }

    // Strip all HTML tags (WYSIWYG formatting)
    $text_content = wp_strip_all_tags($raw_content);

    // Trim to character limit without breaking words
    if (strlen($text_content) > $char_limit) {
        $text_content = substr($text_content, 0, $char_limit);
        $text_content = preg_replace('/\s+?(\S+)?$/', '', $text_content); // don't cut mid-word
        $text_content .= '…';
    }

    return $text_content;
}

/* ACF PAGE SUMMARIES */

function get_page_excerpt($post_id = null, $char_limit = 120)
{
    if (! $post_id) {
        $post_id = get_the_ID();
    }

    // Get raw WYSIWYG content
    $raw_content = get_field('header_subtitle', $post_id);
    $raw_content = is_string($raw_content) ? wp_kses_post($raw_content) : '';

    if (! $raw_content) {
        return '';
    }

    // Strip all HTML tags (WYSIWYG formatting)
    $text_content = wp_strip_all_tags($raw_content);

    // Trim to character limit without breaking words
    if (strlen($text_content) > $char_limit) {
        $text_content = substr($text_content, 0, $char_limit);
        $text_content = preg_replace('/\s+?(\S+)?$/', '', $text_content); // don't cut mid-word
        $text_content .= '…';
    }

    return $text_content;
}






// Auto-populate author names field for searchability
add_action('acf/save_post', 'populate_author_names_field', 20);
function populate_author_names_field($post_id)
{
    if (get_post_type($post_id) !== 'post') {
        return;
    }

    $authors = get_field('post_authors', $post_id);
    if ($authors && is_array($authors)) {
        $author_names = [];
        foreach ($authors as $author) {
            if (is_object($author) && isset($author->post_title)) {
                $author_names[] = $author->post_title;
            }
        }
        $author_string = implode(', ', $author_names);

        // Update the hidden SCF field
        update_field('author_names_hidden', $author_string, $post_id);
    } else {
        // Clear the field if no authors
        update_field('author_names_hidden', '', $post_id);
    }
}

// Hide the author_names_hidden field from non-admin users and make it read-only for admins
add_filter('acf/prepare_field/name=author_names_hidden', function ($field) {
    if (! current_user_can('manage_options')) {
        return false; // hide from non-admins
    }

    // Make field read-only for admins
    $field['readonly'] = true;
    $field['disabled'] = true;

    return $field;
});

// Safe sanitization function
function safe_kses_post($content)
{
    if (is_string($content) && ! empty($content)) {
        return wp_kses_post($content);
    } elseif (is_array($content)) {
        error_log('Attempted to sanitize array with wp_kses_post: ' . print_r($content, true));

        return '';
    } else {
        return '';
    }
}

// Safe URL function
function safe_esc_url($url)
{
    if (is_string($url) && ! empty($url)) {
        return esc_url($url);
    } else {
        return '';
    }
}

// Create default menus on theme activation
function copim_create_default_menus()
{
    // Define menu configurations
    $menu_configs = [
        'header-menu' => [
            'name' => 'Header Menu',
            'items' => [
                ['title' => 'Home', 'url' => home_url('/')],
            ],
        ],
        'footer-menu-1' => [
            'name' => 'Footer Menu 1',
            'items' => [
                ['title' => 'About', 'url' => home_url('/about/')],
            ],
        ],
        'footer-menu-2' => [
            'name' => 'Footer Menu 2',
            'items' => [
                ['title' => 'Contact', 'url' => home_url('/contact/')],
            ],
        ],
        'footer-menu-credits' => [
            'name' => 'Footer Menu Credits',
            'items' => [
                ['title' => 'Privacy Policy', 'url' => home_url('/privacy-policy/')],
            ],
        ],
    ];

    // Get current theme locations
    $locations = get_theme_mod('nav_menu_locations', []);

    foreach ($menu_configs as $location => $config) {
        // Skip if location already has a menu
        if (! empty($locations[$location]) && wp_get_nav_menu_object($locations[$location])) {
            continue;
        }

        // Check if menu exists by name
        $existing_menu = get_term_by('name', $config['name'], 'nav_menu');
        if ($existing_menu) {
            // Assign existing menu to location if not already assigned
            if (empty($locations[$location])) {
                $locations[$location] = $existing_menu->term_id;
                set_theme_mod('nav_menu_locations', $locations);
            }

            continue;
        }

        // Create new menu
        $menu_id = wp_create_nav_menu($config['name']);
        if (is_wp_error($menu_id)) {
            // Log error but continue with other menus
            error_log("Copim Theme: Failed to create menu '{$config['name']}': " . $menu_id->get_error_message());

            continue;
        }

        // Add menu items
        foreach ($config['items'] as $item) {
            $menu_item_id = wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => $item['title'],
                'menu-item-url' => $item['url'],
                'menu-item-status' => 'publish',
                'menu-item-type' => 'custom',
            ]);

            // Log any errors with menu item creation
            if (is_wp_error($menu_item_id)) {
                error_log("Copim Theme: Failed to create menu item '{$item['title']}' for menu '{$config['name']}': " . $menu_item_id->get_error_message());
            }
        }

        // Assign to theme location
        $locations[$location] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

// Run only on theme activation
add_action('after_switch_theme', 'copim_create_default_menus');

// Optional: Run once on init if no menus exist (more conservative approach)
function copim_check_menus_once()
{
    // Only run this check once per session
    if (! get_transient('copim_menus_checked')) {
        $locations = get_theme_mod('nav_menu_locations', []);
        $has_menus = ! empty(array_filter($locations));

        if (! $has_menus) {
            copim_create_default_menus();
        }

        set_transient('copim_menus_checked', true, DAY_IN_SECONDS);
    }
}
add_action('init', 'copim_check_menus_once');

// Check for Theme dependencies upon activation and add notices for missing plugins
function copim_check_theme_dependency()
{
    if (! function_exists('get_field')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>';
            echo '<strong>Copim Theme:</strong> This theme requires either the Advanced or Secure Custom Fields plugin to function properly. ';
            echo '<a href="' . admin_url('plugin-install.php?s=secure+custom+fields&tab=search&type=term') . '">Install SCF or ACF now</a>';
            echo '</p></div>';
        });
    }
    if (! function_exists('ajax_load_more')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>';
            echo '<strong>Copim Theme:</strong> This theme requires the Ajax Load More plugin to function properly. ';
            echo '<a href="' . admin_url('plugin-install.php?s=ajax+load+more&tab=search&type=term') . '">Install Ajax Load More now</a>';
            echo '</p></div>';
        });
    }
    if (! file_exists(WP_PLUGIN_DIR . '/classic-editor/classic-editor.php') || ! is_plugin_active('classic-editor/classic-editor.php')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>';
            echo '<strong>Copim Theme:</strong> This theme requires the Classic Editor plugin to be installed and activated. ';
            echo '<a href="' . admin_url('plugin-install.php?s=classic+editor&tab=search&type=term') . '">Install Classic Editor now</a>';
            echo '</p></div>';
        });
    }

}
add_action('admin_init', 'copim_check_theme_dependency');

// Remove Block Editor CSS this theme uses Classic Editor only
function remove_block_editor_styles()
{
    wp_dequeue_style('wp-block-library');
    wp_deregister_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'remove_block_editor_styles', 100);



/* YOAST SEO FEATURED IMAGE FOR ACF FIELDS */
add_action('acf/save_post', 'auto_set_featured_image_from_header', 20);
function auto_set_featured_image_from_header($post_id) {
    // Only run on posts and pages
    if (!in_array(get_post_type($post_id), ['post', 'page'])) {
        return;
    }
    
    // Check if header_image field has a value
    $header_image = get_field('header_image', $post_id);
    if ($header_image && isset($header_image['ID'])) {
        // Set as featured image
        set_post_thumbnail($post_id, $header_image['ID']);
    } else {
        // Remove featured image if no header image
        delete_post_thumbnail($post_id);
    }
}



/* YOAST SEO CUSTOM VARIABLE WITH FALLBACK LOGIC - %%smart_desc%% */
// This creates a smart fallback system that Yoast's built-in %%cf_%% variables can't do
// Based on: https://gist.github.com/amboutwe/550c10ede7d065d9264930f5480ca748

// Define the custom replacement callback
function get_smart_description() {
    if (!is_singular()) {
        return '';
    }

    $post_id = get_queried_object_id();
    
    // Validate post_id
    if (!is_numeric($post_id) || $post_id <= 0) {
        return '';
    }

    // Helper to normalize any field to plain text
    $to_text = function ($val) {
        if (empty($val)) {
            return '';
        }
        
        if (is_array($val)) {
            $val = implode(' ', array_map('wp_strip_all_tags', $val));
        }
        
        $val = (string) $val;
        $val = wp_strip_all_tags($val);
        $val = sanitize_text_field($val);
        
        return trim($val);
    };

    // Get ACF field with fallback to post_meta
    $get_meta = function ($key) use ($post_id, $to_text) {
        if (empty($key) || !is_string($key)) {
            return '';
        }
        
        if (function_exists('get_field')) {
            $v = get_field($key, $post_id);
            if (!empty($v)) return $to_text($v);
        }
        $v = get_post_meta($post_id, $key, true);
        return $to_text($v);
    };

    // Priority order of fields to check
    $candidates = [
        $get_meta('rte_content_introduction'),
        $get_meta('post_excerpt'), 
        $get_meta('header_subtitle'),
        $get_meta('page_excerpt'),
        $get_meta('header_subtitle'),
        $get_meta('author_biography'),
        has_excerpt($post_id) ? get_the_excerpt($post_id) : '',
        get_post_field('post_content', $post_id),
    ];

    foreach ($candidates as $val) {
        $val = $to_text($val);
        
        if ($val !== '') {
            // Additional sanitization for meta description
            $val = wp_strip_all_tags($val);
            $val = html_entity_decode($val, ENT_QUOTES | ENT_HTML5);
            
            // Remove line breaks and normalize whitespace
            $val = preg_replace('/\s+/', ' ', $val);
            $val = trim($val);
            
            // Ensure we have content after all cleaning
            if (!empty($val)) {
                return mb_substr($val, 0, 158) . (mb_strlen($val) > 158 ? '…' : '');
            }
        }
    }

    return '';
}

// Define the action for register yoast_variable replacements
function register_smart_desc_variable() {
    if (!function_exists('wpseo_register_var_replacement')) {
        return;
    }
    
    wpseo_register_var_replacement('%%smart_desc%%', 'get_smart_description', 'advanced', 'Smart description with ACF field fallbacks');
}

// Add action
add_action('wpseo_register_extra_replacements', 'register_smart_desc_variable');


