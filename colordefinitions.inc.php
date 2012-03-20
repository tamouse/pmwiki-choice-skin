<?php if (!defined('PmWiki')) exit(); //bail out if not inside pmwiki
/**
 *
 * colordefinitions.inc
 *
 * Author: Tamara Temple <tamara@tamaratemple.com>
 * Created: 2012-03-20
 * Copyright (c) 2012 
 * License: GPLv3
 */

// This file will be included by both skin.php and also by color.php
// to determine which colors to use based on the selected $SkinColor
// and $SkinTheme

global $ChoiceSkinDefinedColors, $ChoiceSkinDefinedThemes, $ChoiceSkinDefaultColor, $ChoiceSkinDefaultTheme;

// Defined set of theme colours. These will become the accent colours
// used on the site
$ChoiceSkinDefinedColors['blue_bold'] = '#3366CC';
$ChoiceSkinDefinedColors['blue_muted'] = '#82B0BF';
$ChoiceSkinDefinedColors['green_bold'] = '#6C0';
$ChoiceSkinDefinedColors['green_muted'] = '#92BF92';
$ChoiceSkinDefinedColors['orange_bold'] = '#FF9900';
$ChoiceSkinDefinedColors['orange_muted'] = '#D89C6B';
$ChoiceSkinDefinedColors['red_bold'] = 'red';
$ChoiceSkinDefinedColors['red_muted'] = 'FireBrick';
$ChoiceSkinDefinedColors['purple_bold'] = 'MediumVioletRed';
$ChoiceSkinDefinedColors['purple_muted'] = 'PaleVioletRed';

$ChoiceSkinDefaultColor = 'green_muted';

// Defined set of themes. These will become the background colours
// used on the site
$ChoiceSkinDefinedThemes['light'] = '';
$ChoiceSkinDefinedThemes['dark'] = '';

$ChoiceSkinDefaultTheme = 'light';
