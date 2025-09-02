# Copim Pub WordPress Theme v1.0.0

[![WordPress](https://img.shields.io/badge/WordPress-6.8+-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-green.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-GPL%20v3%20or%20later-green.svg)](https://www.gnu.org/licenses/gpl-3.0.html)

A modern, accessible WordPress theme designed specifically for academic publishers, research institutions, and scholarly content creators. Built with Secure Custom Fields (SCF) for flexible content management, featuring a custom author post type for detailed contributor information and support for multiple authors, Ajax Load More functionality for seamless content pagination, customizable citations and licenses, and plugin support for footnotes, tables, and Mastodon feed. 

## Features

- **Academic-Focused Design**: Clean typography and responsive layout optimized for scholarly content
- **Flexible Content Management**: Secure Custom Fields integration for custom post types and fields
- **Author Management**: Dedicated author post type with detailed contributor information and support for multiple post authors
- **Smart Pagination**: Ajax Load More functionality for seamless content browsing
- **Multiple Page Templates**: 5 specialized templates for different content types
- **Customizable Citations & Licenses**: Built-in support for academic attribution and licensing
- **Plugin Integration**: Optional support for footnotes, tables, and Mastodon feed

## Requirements (Verified on the following configuration)

- **WordPress**: 6.8
- **PHP**: 8.2
- **MySQL / MariaDB**: 8.0
- **Web Server**: Nginx / Apache


## 📦 Plugin Dependencies

### Essential (Required)
- **[Secure Custom Fields (SCF)](https://wordpress.org/plugins/secure-custom-fields/)** - Core theme functionality depends on this plugin
- **[Ajax Load More](https://wordpress.org/plugins/ajax-load-more/)** - Required for post pagination functionality
- **[Classic Editor](https://wordpress.org/plugins/classic-editor/)** - Removes block editor functionality

### Optional (Enhanced Features)
- **[ACF: Better Search](https://wordpress.org/plugins/acf-better-search/)** - Required for full content search functionality (without it, only article titles are searched)
- **[Easy Footnotes](https://wordpress.org/plugins/easy-footnotes/)** - Enables article footnote functionality
- **[TablePress](https://wordpress.org/plugins/tablepress/)** - Enables table shortcodes
- **[Include Mastodon Feed](https://wordpress.org/plugins/include-mastodon-feed/)** - Enables homepage Mastodon feed section

## 🚀 Installation

### Prerequisites
1. Have WordPress installed and configured
2. Access to WordPress admin panel

### Step-by-Step Installation
1. **Install Theme**: Upload and activate the `copim_pub` theme
2. **Install Required Plugins**:
   - Secure Custom Fields (SCF)
   - Ajax Load More
   - Classic Editor
3. **Install Optional Plugins**: Add enhanced functionality as needed
4. **Import SCF Configuration**: Import `/resources/includes/scf-fields.json` into SCF plugin
5. **Setup Ajax Load More Template**: Copy `/resources/includes/default.php` to `/wp-content/uploads/alm_templates/default.php` (The ALM template must exist in both locations for proper functionality)
6. **Add Content**: Create posts, pages, categories and authors using the provided templates
7. **Configure Menus**: Set up header, footer, and social menus


## Site Structure

### Content Types
- **Posts**: Multiple authors, related posts, customizable license and citation, with optional plugin support for footnotes and tables
- **Pages**: Available in 5 template designs
- **Categories**: Used to organize posts with dedicated category homepages
- **Tags**: Standard WordPress functionality for informal post taxonomy
- **Authors**: Custom post type for author names, biographies, and links

### Page Templates
1. **Default Template**: Basic page template
2. **Homepage**: Features modules for header, posts, pages, page slider, and Mastodon feed
3. **Hub Page**: Functions as a hub page for pages and selected posts (key reads)
4. **Category Page**: A category homepage for specific category posts
5. **All Posts**: Displays all category posts in date order, grouped by year

### Menu Structure
- **Header Menu**: Two levels of navigation
- **Footer Menus 1, 2, Credits**: One level of navigation
- **Footer Social Menu**: Features online services including Mastodon, Bluesky, and LinkedIn

### Example Site Structure
```
Homepage (Homepage template)
├── About (Hub-page template)
│   ├── About Us (Default template)
│   ├── Team (Default template)
│   ├── Privacy Policy (Default template)
├── Groups (Hub-page template)
│   ├── Group 1 (Category template)
│   │   ├── Category Posts
│   │   └── Category Pages (Default template)
│   └── Group 2 (Category template)
│       ├── Category Posts
│       └── Category Pages (Default template)
│   └── Etc.
├── All Posts (All Posts template)
└── Contact (Default template)
```

## 🎨 Customization

### Typography
The theme loads fonts directly from Google Fonts in `header.php`:
- **[Source Serif 4](https://fonts.google.com/specimen/Source+Serif+4)**: `--font-primary: 'Source Serif 4', serif;`
- **[Inter](https://fonts.google.com/specimen/Inter)**: `--font-secondary: 'Inter', sans-serif;`
- **[Source Code Pro](https://fonts.google.com/specimen/Source+Code+Pro)**: `--font-mono: 'Source Code Pro', monospace;`

### Styling
The theme stylesheet `/resources/css/main.min.css` contains CSS variables for:
- Fonts and font sizes
- Line heights and spacing
- Colors and brand elements
- Layout and container settings

### Icons
The theme loads `/resources/img/icons.svg` containing *selected* icons from:
- **[Phosphor Icons](https://github.com/phosphor-icons/homepage)**
- **[Academicons](https://github.com/jpswalsh/academicons)**

## 📝 Changelog

### Version 1.0.0
- Initial release

## 📄 License

This theme is licensed under the [GNU GPL-3.0 license](https://www.gnu.org/licenses/gpl-3.0.html).

---

**Note**: This theme is designed for academic and scholarly content. For commercial use, please ensure compliance with all applicable licenses and terms of service for included fonts, icons, and other resources.
