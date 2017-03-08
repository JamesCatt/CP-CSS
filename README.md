# CP CSS
An extension for ExpressionEngine 3 that allows the user to easily add custom CSS to the Control Panel.

## Installation
1. Place the `cpcss` folder in your `/user/addons` directory.
2. Install from the Add-On Manager menu in the Control Panel.
3. Open the CP CSS settings, and either enter your custom CSS directly in the first field, or a URL to a CSS file in the second field (this will override any CSS in the first field).
4. Enjoy!

## Note on MSM use
Because MSM doesn't support separate site settings for extensions, the control panel will show the fields for each site in your installation across all site control panels. If any of your `site_id`s are greater than 10, the field labels will not display properly, but should the extension should still function properly.