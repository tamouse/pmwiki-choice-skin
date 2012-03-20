<?php
/**
 *
 * color - provide CSS styles based on settings on query string
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2012-03-20
 * Copyright (c) 2012 
 * License: GPLv3
 */

// This is called to return the CSS styles based on the skin color given in the query string

if (!defined('PmWiki')) define('PmWiki',1); // fake the pmwiki environment for included files as this file is called outside the context of pmwiki

// Get the color definitions
require_once('colordefinitions.inc.php');

// Make sure we're returning the proper sort of file
header("Content-type: text/css");

$color = ((isset($_GET['c'])) ? $_GET['c'] : $ChoiceSkinDefaultColor);
if (!in_array($color,array_keys($ChoiceSkinDefinedColors))) $color=$ChoiceSkinDefaultColor;

// inflect the actual color
$color = $ChoiceSkinDefinedColors[$color];

include_once('color.css');



