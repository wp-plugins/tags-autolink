<?php
function tags_autolink($text) 
{

/*
Plugin Name: Tags Autolink 
Version: 2.1
Version description:  Wraps tags names in links. Keeps the original words case in text. Many thanks to <a href="http://www.dieterprovoost.be">Dieter Provoost</a> for the suggestions and improvements.
Plugin URI: http://www.centrostudilaruna.it/huginnemuninn/plugin-wordpress
Description: Wraps tags names in links
Author: Alberto Lombardo
Author URI: http://www.centrostudilaruna.it/huginnemuninn
Based on : Categories Autolink by myself
Copyright (c) 2007
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt

    This file is part of WordPress.
    WordPress is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* Define the $wpdb to perform queries on the WP database */
global $wpdb;
/* Wrap spaces around the text - helps with regexp? */
$text = " $text ";
/* Set exceptions; will be developed in following releases */
$exceptions = 'WHERE tag_name <> "Names"';
/* Load tags */
$tags = $wpdb->get_results("SELECT name, term_id AS identificativo FROM $wpdb->terms LEFT JOIN $wpdb->term_taxonomy USING (term_id) INNER JOIN $wpdb->term_relationships as rel USING (term_taxonomy_id) WHERE taxonomy = 'post_tag' GROUP BY rel.term_taxonomy_id");
/* Loop through links */
foreach ($tags as $tag) 
{ 
/* create tag_urls */ 
$tag_urls = get_tag_link($tag->identificativo); 
/* Replace any instance of the cat_name with the cat_name wrapped in a HREF to link_url */ 
$text = preg_replace("|(?!<[^<>]*?)(?name)\b(?!:)(?![^<>]*?>)|imsU","$1" , $text); 
} 
/* Trim extraneous spaces off and return */
 return trim( $text ); 
} 
add_filter('the_content', 'tags_autolink'); 
?>