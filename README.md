# Aged Content Message 

Displays a message at the top of single posts published x years ago or earlier, informing about content that may be outdated.

## Description

This simple WordPress plugin displays a message in any single post that has been published x years ago from the current time or earlier. The default time to count back is 1 year, but you can [change that](//wordpress.org/plugins/aged-content-message/faq/).

### Languages

* English (en_US) _(default)_
* German (de_DE)

## Installation

If you don’t know how to install a plugin for WordPress, [here’s how](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

## Frequently Asked Questions

### My message doesn’t look like the one on the screenshot, what can I do?

That’s because the plugin cannot know about what styles would match your theme, so it doesn’t apply any by default. You can add the default styles below to the *style.css* file of your active theme ([child theme](//codex.wordpress.org/Child_Themes), preferably). If you’re not sure how to do that, you can alternatively use a plugin like [Simple Custom CSS](//wordpress.org/plugins/simple-custom-css/), or the Custom CSS module of [Jetpack](//wordpress.org/plugins/jetpack/).

```css
/* Default styles */
.aged-content-message {
	background: #f7f7f7;
	border-left: 5px solid #f39c12;
	/* Sorry, cheating here.
	   It’s Museo Slab on the screenshot. */
	font-family: "Georgia", sans-serif;
	font-size: .875rem;
	line-height: 1.5;
	margin: 1.5rem 0;
	padding: 1.5rem;
}
.aged-content-message hr {
	display: none;
}
.aged-content-message h5 {
	font-family: inherit;
	font-size: .8125rem;
	line-height: 2;
	margin: 0;
	text-transform: uppercase;
}
.aged-content-message p {
	margin-bottom: 0;
}
```

### I can’t find the settings page, where is it?

There is no settings page. You can customize the determination for post age, minimal age and, of course, the message itself via filters. Custom functions like these would go into the *functions.php* file of your active theme or—again—child theme:

```php
/* Show message for posts aged 2 years or older. */
function yourprefix_aged_content_message__the_content_min_age() {
	return 2;
}
add_action( 'aged_content_message__the_content_min_age',
	'yourprefix_aged_content_message__the_content_min_age' );

/* Modify markup and wording of message (here: matching the value of 2 years set above). */
function yourprefix_aged_content_message__the_content_message() {
	return sprintf( '<div class="aged-content-message"><h3>%1$s</h3><p><em>%2$s</em></p></div>' . "\n",
		'Heads up! Content may be outdated.',
		'This post seems to be older than 2 years. It might not as accurate as it used to be.' );
}
add_action( 'aged_content_message__the_content_message',
	'yourprefix_aged_content_message__the_content_message' );

/* Set condition for displaying message to include pages. */
function yourprefix_aged_content_message__the_content_condition() {
	return ! is_single() && ! is_page();
}
add_action( 'aged_content_message__the_content_condition',
	'yourprefix_aged_content_message__the_content_condition' );
```

### Crap, why doesn’t this plugin provide a real settings page?

Honestly, I really felt it doesn’t need one, but it might get one in the future—**if** you give it a [review with a 5 star rating](//wordpress.org/support/view/plugin-reviews/aged-content-message) and include a gentle reminder that a settings page would make you really happy. :)

## Changelog

### 1.1

* Fixed a broken link in readme.txt.

### 1.0

* Initial release.