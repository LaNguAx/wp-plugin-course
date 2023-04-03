<?php

/**
 * Trigger this file on Plugin uninstall
 * 
 * @package ItayPlugin
 */

if (!defined('WP_UNINSTALL_PLUGIN')) die;

// // Clear database stored data
// $books = get_posts(array('post_type' => 'book', 'numberposts' => -1));

// foreach ($books as $book) {
//   wp_delete_post($book->ID, false);
// }

// Access the database via SQL.
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book'");
// Here we are deleting everything from wp_posts where post_id is NOT found in the wp_posts. Because we already deleted the post_type posts of book, so their ID will not be found, beautiful.
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
