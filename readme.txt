=== Annotation ===
Contributors: borgboy
Tags: annotate,tooltip,jquery,ui,themes
Requires at least: 3.0.1
Tested up to: 3.5.1
Stable tag: 0.5.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
The Annotation WP plugin provides a user friendly shortcode wrapper for the jQuery UI ToolTip Widget as well as the standard UI themes.  Default functionality is provided out-of-the-box for those who require simple, yet aestechtically pleasing tooltips.  For those who need more control over the look-and-feel of the tooltip, advanced customization directives are available.  Customizations can also be applied independently to each annotation. Both text and images can be used for anchors and HTML can be used freely in content.

== Installation ==
1) Install the latest version of Annotation under the Plugin section of the Admin area
   or
1a) Download the latest annotation.zip file from http://wordpress.org/plugins/annotation/
1b) Unzip the contents to your site's wp-contents/plugins directory

2) Activate the plugin from the Plugin section of the Admin area

== Documentation ==
Annotation mark-up can take two forms differing only in content declaration.

     [annotate id="" text="" img="" content="" theme="" style=""]

or, more elegantly,

     [annotate id="" text="" img="" theme="" style=""]<Content>[/annotate]

The latter should be used if HTML mark-up is included in the content.

*Id*
The id provides Annotation a mechanism to distinguish between multiple annotations in content rendering.  Without it, Annotation can not set a theme or style for the tooltip.  If included, id's should at the very least be unique enough not to conflict in a single post.  Otherwise one annotation will take precedence over the other.  If id is not provided, theme and style are ignored and content is placed inline (using the title attribute for a text anchor, alt for image anchor), with mark-up [in content ]treated as raw text.

*Content*
This is the content that will appear in the tooltip pop-up window.  It can be specified either as an attribute or between the shortcode delimiters.  It can be text, an image, or a mixture of the two.  When using... HTML is allowed, but [in this situation,] an id is required and the content should appear between shortcode delimiters.  By not doing so, the HTML will appear as raw text in the pop-up.  For simple text, do keep the content as an attribute and skip specifing an id as this will yield a small gain in performance for your website.

*Text*
The text attribute sets the text used for the anchor.  CSS properties for the text should be specified outside of the annotation shortcode directives.  Typically, the following format is followed:
     '<span style="cursor: help; text-decoration: underline;">[annotation text="archival"]</span>'
If the img attribute is provided, text is ignored.  Either text or img must be provided, otherwise the annotation is ignored.

*Image*
Images of varying sizes can be used in place of text for the anchor.  As with the text attribute, CSS can be specified outside of the annotation shortcode.  If img and text are both provided, the text attribute is ignored.  If no img or text attributes are provided, the annotation is ignored.

*Themes*
While WordPress makes avialable the majority of the jQuery UI implementation, it fails to provide any themes.  The resultant lack of these CSS files is that some of the widgets do not work as expected and/or have no default look-and-feel.  These CSS theme packages are included in the Annotation plugin for both the latest version of jQuery UI (1.10.3) and the targeted version of jQuery UI used by WordPress (1.9.2 as of this writing).  Annotation is able to choose the correct version based on the enqueued jQuery UI JavaScript.  Users should not attempt to override this behavior.  The theme defaults to cupertino when the theme attribute is not specified.

*User Themes*
Users are welcome to install their own rolled themes (http://jqueryui.com/themeroller/) under the Annotation themes directory.  Be sure to include css files for all working versions and choose the name carefully to avoid conflicts or malformed URLs.  Be aware that any updates will remove these themes, so please make back-ups as appropriate.

*Style*
xxx Keep in mind that the style attribute applies to the tooltip, not the anchor.  CSS for the anchor can be set outside of the annotation using span.  The style attribute is particularly important in that it allows you to change aspects of the container for the tooltip.  Most often, users will want to use this to set the maximum width of the tooltip or minor adjustments to the underlying theme.  Styling for the tooltip content can be accomplished using mark-up in the content.  JQuery UI elements require JSON encoded CSS which imposes some limitations on the style properties that you can specify.  Color names cannot be used.  Instead use rgb or rgba.  DOM names are not necessary, however.  See future for more details.

*Future*
JQuery UI Effects are not currently supported.  However, if there is sufficient interest in their usage, this may change. It is also expected that interest in jQuery UI themes may result in a shortcode or option to include a specific theme for use by other jQuery UI widgets.  Or, perhaps, the Annotation plugin may evolve to include all jQuery UI widgets.
Currently, a simple converter is provided for CSS text to JSON encoded CSS properties.  A full conversion utility would inevitably create code bloat for this plugin and the inherit limitations are considered trivial.  For these reasons, the gains from such a conversion utility are not deemed significant enough to warrant it's implementation.

== Frequently Asked Questions ==

= I really like the Annotation plugin, but there are some additional features I would like to see.  Where can I make requests? =

Make requests under the Support section of the Annotation plugin page under the WordPress.org website.

= I'm having problems with the plugin in my WordPress installation.  I'm ready to leave some nasty feedback.  Where can I explain my problem? =

Enter issues/bugs under the Support section of the Annotation plugin page under the WordPress.org website.

== Screenshots ==

1. Screenshot of the plugin with text anchor
2. Screenshot of the plugin with image anchor
3. Screenshot of the plugin with le-frog and cupertino themes

== Changelog ==

= 0.5 =
* Official release!

