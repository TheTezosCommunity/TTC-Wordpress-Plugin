# TTC Website Plugin

The TTC Website plugin is designed specifically for the TTC website, adding customized functionalities that enhance the overall user experience and management of the site. This includes custom styles for the admin area, scripts for the front end, special handling of embed data to enhance privacy, and more.

## Features

-   Custom CSS for the admin area, specifically when managing `mec-events`.
-   Custom front-end scripts for enhanced site interaction.
-   Removal of author name and URL from embed data for privacy.
-   Custom email notifications for new user registrations, allowing only administrators to receive notifications.
-   Redirect non-administrators to the homepage upon login for a streamlined user experience.
-   Hide the WordPress admin bar for non-admin users to simplify the interface.
-   Dynamic body classes based on user login status for theme customization.
-   Custom Post Type (CPT) for showcasing Projects on Tezos.
-   Integration with Advanced Custom Fields (ACF) for easy management of project metadata, including social links.
-   Shortcode `[project-socials-icon-list]` to display a project's social links with icons.

## Installation

1. Download the plugin from the [GitHub repository](https://github.com/your-repo-link).
2. Upload the plugin files to the `/wp-content/plugins/ttc-website` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.

## Usage

After activating the plugin, it integrates seamlessly with the existing WordPress functionalities:

-   **Admin Area Customization**: Automatically applied when managing `mec-events`.
-   **Front-end Scripts**: No configuration needed; scripts are automatically enqueued.
-   **Embed Data Privacy**: Automatically removes author data from embeds.
-   **Email Notifications**: Automatically modifies behavior without needing configuration.
-   **Login Redirect & Admin Bar**: Works automatically based on user roles.
-   **Body Classes**: Added automatically based on login status.
-   **Custom Post Types**: Available in the WordPress dashboard under "Projects".

To display social icons for a project using ACF fields, insert the shortcode `[project-socials-icon-list]` into the content where you want the icons to appear.

## Customization

-   **Styling for Social Icons**: You can customize the appearance of the social icons by adding custom CSS. The plugin enqueues `css/admin-style.css` for admin styles and expects similar customizations for the front end within your theme's CSS.

## Contributing

Contributions to the TTC Website plugin are welcome. Please follow the standard GitHub pull request process to submit your changes.

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/AmazingFeature`).
3. Commit your changes (`git commit -am 'Add some AmazingFeature'`).
4. Push to the branch (`git push origin feature/AmazingFeature`).
5. Open a pull request.

## License

This plugin is licensed under the GPL-2.0 license. For more information, please visit [GNU General Public License v2.0](https://www.gnu.org/licenses/gpl-2.0.html).

## Contributor(s)

-   **TTC** - [Visit TTC](https://thetezos.com)
-   [https://purplematter.com](https://purplematter.com)
-   [opeculiar](https://twitter.com/webidente)
-   [skllzrmy.tez](https://github.com/skullzarmy/)
