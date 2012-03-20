<?php if (!defined('PmWiki')) exit();
/* PmWiki Choice skin
 *
 * Examples at: http://pmwiki.com/Cookbook/Choice and http://solidgone.org/Skins/
 * Copyright (c) 2009 David Gilbert
 * Modifications (c) 2012 Tamara Temple
 * This work is licensed under a Creative Commons Attribution-Share Alike 3.0 United States License.
 * Please retain the links in the footer.
 * http://creativecommons.org/licenses/by-sa/3.0/us/
 */

/*
 * CHANGES by Tamara Temple <tamara@tamaratemple.com>
 *
 * Electrify color css by making the template invoke a php file for
 * setting the various colour themes for the skin. Also set default
 * accent colour in wikistyle so it can be used in wiki pages easily.
 *
 * Also add the ability to set a cookie to store the desired skin
 * theme and skin colour.
 */


global $FmtPV;
$FmtPV['$SkinName'] = '"Choice"';
$FmtPV['$SkinVersion'] = '"2.0"';

require_once('colordefinitions.inc.php');

global $PageLogoUrl, $PageLogoUrlHeight, $PageLogoUrlWidth, $HTMLStylesFmt ,$SkinTheme,$SkinColor;
if (!empty($PageLogoUrl)) {
  dg_SetLogoHeightWidth(15, 16);
  $HTMLStylesFmt['choice'] .=
    '#head .sitetitle a{height:' .$PageLogoUrlHeight .'; background: url(' .$PageLogoUrl .') no-repeat left top} '.
    '#head .sitetitle a, #head .sitetag{padding-left: ' .$PageLogoUrlWidth .'} ';
}

// retrieve the list of color schemes by listing the keys of the $ChoiceSkinDefinedColors
$SkinColor = dg_SetSkinColor($ChoiceSkinDefaultColor, array_keys($ChoiceSkinDefinedColors)); 
$SkinTheme = 'class=\''.tt_SetSkinTheme($ChoiceSkinDefaultTheme, array_keys($ChoiceSkinDefinedThemes)).'\'';

// Set a wiki style so users can use the accent colour chosen. This is
// used by surrounding the text in question with %accentcolor% ... %% 
global $WikiStyle;
$WikiStyle['accentcolor']['color'] = $SkinColor;

// ----------------------------------------
// - Standard Skin Setup
// ----------------------------------------
$FmtPV['$WikiTitle'] = '$GLOBALS["WikiTitle"]';
$FmtPV['$WikiTag'] = '$GLOBALS["WikiTag"]';

// Move any (:noleft:) or SetTmplDisplay('PageLeftFmt', 0); directives to variables for access in jScript.
$FmtPV['$RightColumn'] = "\$GLOBALS['TmplDisplay']['PageRightFmt']";
Markup('noright', 'directives',  '/\\(:noright:\\)/ei', "SetTmplDisplay('PageRightFmt',0)");
$FmtPV['$ActionBar'] = "\$GLOBALS['TmplDisplay']['PageActionFmt']";
Markup('noaction', 'directives',  '/\\(:noaction:\\)/ei', "SetTmplDisplay('PageActionFmt',0)");
$FmtPV['$TabsBar'] = "\$GLOBALS['TmplDisplay']['PageTabsFmt']";
Markup('notabs', 'directives',  '/\\(:notabs:\\)/ei', "SetTmplDisplay('PageTabsFmt',0)");
$FmtPV['$SearchBar'] = "\$GLOBALS['TmplDisplay']['PageSearchFmt']";
Markup('nosearch', 'directives',  '/\\(:nosearch:\\)/ei', "SetTmplDisplay('PageSearchFmt',0)");
$FmtPV['$TitleGroup'] = "\$GLOBALS['TmplDisplay']['PageTitleGroupFmt']";
Markup('notitlegroup', 'directives',  '/\\(:notitlegroup:\\)/ei', "SetTmplDisplay('PageTitleGroupFmt',0)");
Markup('fieldset', 'inline', '/\\(:fieldset:\\)/i', "<fieldset>");
Markup('fieldsetend', 'inline', '/\\(:fieldsetend:\\)/i', "</fieldset>");

// Define a link stye for new page links
global $LinkPageCreateFmt;
SDV($LinkPageCreateFmt, "<a class='createlinktext' href='\$PageUrl?action=edit'>\$LinkText</a>");


// Override pmwiki styles otherwise they will override styles declared in css
global $HTMLStylesFmt;
$HTMLStylesFmt['pmwiki'] = '';

// Add a custom page storage location
global $WikiLibDirs;
// okay, the following dot operation seems to be driving emacs PHP
// mode nuts. AH HA: Needed to put the dirname call in parens. ~tpt
$PageStorePath = (dirname(__FILE__)).'/wikilib.d/{$FullName}';
$where = count($WikiLibDirs);
if ($where>1) $where--;
array_splice($WikiLibDirs, $where, 0, array(new PageStore($PageStorePath)));

// ----------------------------------------
// - Standard Skin Functions
// ----------------------------------------
function dg_SetSkinColor($default, $valid_colors){
  global $SkinColor, $ValidSkinColors;
  if ( !is_array($ValidSkinColors) ) $ValidSkinColors = array();
  $ValidSkinColors = array_merge($ValidSkinColors, $valid_colors);

  // expand this to check for a cookie as well
  if (tt_GorC('setcolor')) {
    // color specified and want to save a cookie for the user
    $color = tt_GorC('setcolor');
    setcookie('setcolor',$color,mktime(0,0,0,1,1,2050),'/',$_SERVER['HTTP_HOST'],false,true);
  } elseif (tt_GorC('color')) {
    $color = tt_GorC('color');
  }
  if ($color && in_array($color, $ValidSkinColors) )
    $SkinColor = $color;
  elseif ( !in_array($SkinColor, $ValidSkinColors) )
    $SkinColor = $default;
  return $SkinColor;
}

// Set the skin theme either from query string or cookie or default
function tt_SetSkinTheme($default, $valid_themes) {
  global $SkinTheme, $ValidSkinThemes;
  if (!is_array($ValidSkinThemes)) $ValidSkinThemes = array();
  $ValidSkinThemes = array_merge($ValidSkinThemes, $valid_themes);
  
  // check to see if we're setting the theme
  if (tt_GorC('settheme')) {
    // theme specified, save in a cookie for user
    $theme = tt_GorC('settheme');
    setcookie('settheme',$theme,mktime(0,0,0,1,1,2050),'/',$_SERVER['HTTP_HOST'],false,true);
  } elseif (tt_GorC('theme')) {
    $theme = tt_GorC('theme');
  }
  if ($theme && in_array($theme, $ValidSkinThemes))
    $SkinTheme = $theme;
  elseif (!in_array($SkinTheme, $ValidSkinThemes))
    $SkinTheme = $default;
  return $SkinTheme;
}

// Determine logo height and width
function dg_SetLogoHeightWidth ($wPad, $hPad=0){
  global $PageLogoUrl, $PageLogoUrlHeight, $PageLogoUrlWidth;
  if (!isset($PageLogoUrlWidth) || !isset($PageLogoUrlHeight)){
    $size = @getimagesize($PageLogoUrl);
    if (!isset($PageLogoUrlWidth))  SDV($PageLogoUrlWidth, ($size ?$size[0]+$wPad :0) .'px');
    if (!isset($PageLogoUrlHeight))  SDV($PageLogoUrlHeight, ($size ?$size[1]+$hPad :0) .'px');
  }
}

// Retrieve a value from GET or COOKIE if set
function tt_GorC ($v) {
  if (isset($_GET[$v])) return $_GET[$v]; // query string overrides
					  // cookie value
  if (isset($_COOKIE[$v])) return $_COOKIE[$v];
  return FALSE;
}
