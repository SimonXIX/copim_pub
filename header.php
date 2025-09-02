<!doctype html>
<html <?php language_attributes(); ?>>
<head>




<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,700;1,400;1,700&family=Source+Code+Pro:wght@400;700&family=Source+Serif+4:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">





	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>



<style>
	@media (min-width: 992px) {
		.icon-wrapper.burger-toggle {
			display: none;
		}
	} 
	
	.icon-wrapper.close-menu-toggle {
		display: none;
	}


	/* OVERIDE TABLEPRESS PLUGIN STYLES */

	.tablepress {
		font-family: var(--font-secondary)!important;
		font-size: var(--text-3xs)!important;
		--text-color: var(--warm-gray-800)!important;
		--head-text-color: var(--white)!important;
		--head-bg-color: var(--warm-gray-800)!important;
		--odd-text-color: var(--warm-gray-800)!important;
		--odd-bg-color: var(--white)!important;
		--even-text-color: var(--warm-gray-800)!important;
		--even-bg-color: var(--warm-gray-100)!important;
		--hover-text-color: var(--warm-gray-900)!important;
		--hover-bg-color: var(--warm-gray-100)!important;
		--border-color: transparent!important;
		--padding: .5rem!important;
		border: none!important;
		border-collapse: collapse!important;
		border-spacing: 0!important;
		margin: var(--space-2xs) 0!important;
	}

	.tablepress thead {
		font-size: var(--text-2xs)!important;
		font-weight: 700!important;
	}

	.tablepress a {
		color: var(--brand-500)!important;
	}

	span.tablepress-table-description {
		font-family: var(--font-secondary)!important;
		font-size: var(--text-3xs)!important;
		color: var(--warm-gray-800)!important;
	}

	.tablepress .column-5 {
		word-wrap: break-word!important;
		overflow-wrap: break-word!important;
		max-width: 300px!important;
	}


</style>
 



<script> // SHOW HIDE MENU ICONS
document.addEventListener("DOMContentLoaded", function () {
    const togglers = document.querySelectorAll('.menu-item-has-children > a');

    togglers.forEach(link => {
        link.addEventListener('click', function (e) {
            const parent = this.parentElement;

            parent.classList.toggle('submenu-open');
            e.preventDefault(); // prevent default link behavior if needed
        });
    });
});
</script>

 
</head>

<body <?php body_class(); ?>>
<a href="#main-content" class="skip-link">Skip to main content</a>
<?php wp_body_open(); ?>



<!-- HEADER -->
<div class="header-container-wrapper">
<header id="masthead" class="site-header container" role="banner">
  <div class="row justify-center">
  	<div class="col col-12 main-navigation-wrapper">

				<button type="button" class="icon-wrapper burger-toggle" aria-label="Toggle menu" aria-expanded="false">
						<svg class="icon header-burger-icon" aria-hidden="true"><use href="#burger-menu-circle"></use></svg>
				</button>


				<div class="nav-padding"></div><!-- Menu padding spacer -->
				
				<a href="<?php echo home_url(); ?>" aria-label="Homepage" class="header-logo" >
					<img src="<?php bloginfo('template_directory'); ?>/resources/img/copim_logo_pos.svg" width="200" alt="Homepage" title="Homepage" >
				</a>


				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Main menu">
					<?php
                    wp_nav_menu(
                        [
                            'theme_location' => 'header-menu',
                            'menu_class' => 'header-menu',
                            'walker' => new Custom_Walker_Nav_Menu_With_Icons(),
                        ]
                    );?>
				</nav><!-- #site-navigation -->


					<button type="button" title="search" class="icon-wrapper" aria-label="Toggle search" aria-expanded="false">
						<svg class="icon header-search-icon" aria-hidden="true"><use href="#magnifying-glass-circle"></use></svg>
					</button>

					<!-- Close button -->
					<button type="button" title="Close menu" class="icon-wrapper close-menu-toggle" aria-label="Close menu" aria-expanded="false">
						<svg class="icon header-search-icon" aria-hidden="true"><use href="#ph--x-circle-light"></use></svg>
					</button>

	</div><!-- / col -->
  </div><!-- / row -->
</header><!-- / header container -->
</div><!-- / header-container-wrapper -->
<div class="search-panel" id="search-panel">
	<form role="search" method="get" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
		<input type="text" name="s" id="s" placeholder="<?php echo esc_attr_x('Enter search term', 'placeholder'); ?>" value="<?php echo get_search_query(); ?>" />
			<!-- Limit to posts -->
		<input type="hidden" name="post_type" value="post" />
		<button type="submit" class="search-submit-icon" aria-label="Submit search">
		<svg class="icon header-search-icon" aria-hidden="true"><use href="#ph--magnifying-glass-light"></use></svg>
		</button>
	</form>
</div>
<div class="search-overlay"></div>
