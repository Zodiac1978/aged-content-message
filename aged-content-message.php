<?php
/**
 * Plugin Name: Aged Content Message
 * Text Domain: aged-content-message
 * Domain Path: /languages
 * Description: Displays a message at the top of single posts published x years ago or earlier, informing about content that may be outdated.
 * Author:      Caspar Hübinger
 * Author URI:  http://glueckpress.com/
 * Plugin URI:  //wordpress.org/plugins/aged-content-message
 * License:     GPLv2 or later
 * Version:     1.1.1
 *
 * PHP Version: 5.2
 */

/**
Copyright (C)  2014-2014 Caspar Hübinger

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

// Exit when accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Load plugin. */
function aged_content_message() {

	// Load textdomain
	aged_content_message__load_plugin_textdomain();

	// Add conditional message to content
	add_action( 'the_content', 'aged_content_message__the_content' );
}

add_action( 'plugins_loaded', 'aged_content_message' );

/**
 * Load plugin textdomain.
 *
 * @return bool
 */
function aged_content_message__load_plugin_textdomain() {

	load_plugin_textdomain(
		'aged-content-message',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}

/**
 * Conditionally add a message to content.
 *
 * @param  string  $content
 * @return string
 */
function aged_content_message__the_content( $content ) {

	// Only single posts of post format "post".
	if ( apply_filters( 'aged_content_message__the_content_condition', ! is_single() ) ) {
		return $content;
	}

	// Calculate the age in years as a float
	$years_diff = ( time() - get_the_time( 'U' ) ) / ( 60 * 60 * 24 * 365);
	$age = apply_filters( 'aged_content_message__the_content_age', floor( $years_diff ) );

	// Return original content if not too old
	if ( $years_diff < apply_filters( 'aged_content_message__the_content_min_age', 1 ) ) {
		return $content;
	}

	// Singular/plural form message.
	$msg = apply_filters(
		'aged_content_message__the_content_message',
		sprintf(
			'<div class="aged-content-message"><hr /><h5>%1$s</h5><p>%2$s</p><hr /></div>' . "\n",
			__( 'The times they are a-changin’.', 'aged-content-message' ),
			sprintf(
				_n(
					'This post seems to be older than a year—a long time on the internet. It might be outdated.',
					'This post seems to be older than %s years—a long time on the internet. It might be outdated.',
					$age, 'aged-content-message'
				), $age
			)
		)
	);

	return $msg . $content;
}