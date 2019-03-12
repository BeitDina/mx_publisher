<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: publisher_constants.php,v 1.31 2013/06/17 15:44:18 orynider Exp $
* @copyright (c) 2002-2006 [Mohd Basri, PHP Arena, FlorinCB, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die("Hacking attempt");
}

if (!MXBB_MODULE)
{
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;

	define( 'PORTAL_URL', $server_protocol . $server_name . $server_port . $script_name . '/' );
	define( 'PHPBB_URL', PORTAL_URL );

	$mx_table_prefix = $table_prefix;
	$is_block = false; // This also makes the script work for phpBB ;)
}
if (!isset($mx_table_prefix))
{
	$mx_table_prefix = $table_prefix;
}

//$module_root_path = PORTAL_URL . $module_root_path;
//die("$module_root_path");

define('PAGE_PUBLISHER', -503);
define('PAGE_PROJECTS', -503); // If this id generates a conflict with other mods, change it ;);
define('PAGE_PROJ_DEFAULT', -503);
//define('PAGE_PROJ_DEFAULT', PAGE_PROJECTS);
define('ICONS_DIR', 'publisher/images/icons/');

// Tables
define( 'PUB_ARTICLES_TABLE', $mx_table_prefix . 'pub_articles' );
define( 'PUB_CAT_TABLE', $mx_table_prefix . 'pub_cat' );
define( 'PUB_CATEGORY_TABLE', $mx_table_prefix . 'pub_cat' );
define( 'PUB_COMMENTS_TABLE', $mx_table_prefix . 'pub_comments' );
define( 'PUB_CUSTOM_TABLE', $mx_table_prefix . 'pub_custom' );
define( 'PUB_CUSTOM_DATA_TABLE', $mx_table_prefix . 'pub_customdata' );
define( 'PUB_FILES_INFO_TABLE', $mx_table_prefix . 'pub_articlesacces_info' );
define( 'PUB_FILES_INFO_TABLE', $mx_table_prefix . 'pub_filesacces_info' );
define( 'PUB_FILES_TABLE', $mx_table_prefix . 'pub_files' );
define( 'PUB_LICENSE_TABLE', $mx_table_prefix . 'pub_license' );
define( 'PUB_CONFIG_TABLE', $mx_table_prefix . 'pub_config' );
define( 'PUB_TYPES_TABLE', $mx_table_prefix . 'pub_types' );
define( 'PUB_WORD_TABLE', $mx_table_prefix . 'pub_wordlist' );
define( 'PUB_SEARCH_TABLE', $mx_table_prefix . 'pub_results' );
define( 'PUB_MATCH_TABLE', $mx_table_prefix . 'pub_wordmatch' );
define( 'PUB_VOTES_TABLE', $mx_table_prefix . 'pub_votes' );
define( 'PUB_AUTH_ACCESS_TABLE', $mx_table_prefix . 'pub_auth' );
define( 'PUB_MIRRORS_TABLE', $mx_table_prefix . 'pub_mirrors' );

// Switches
define( 'PUBLISHER_DEBUG', 1 ); // Pafiledb Mod Debugging on
define( 'PUBLISHER_QUERY_DEBUG', 1 );
define( 'PUB_ROOT_CAT', 0 );
define( 'PUB_CAT_ALLOW_FILE', 1 );
define( 'PUB_AUTH_LIST_ALL', 0 );
define( 'PUB_AUTH_ALL', 0 );
define( 'FILE_PINNED', 1 );
define( 'ARTICLE_PINNED', 1 );
define( 'PUB_AUTH_VIEW', 1 );
define( 'PUB_AUTH_READ', 2 );
define( 'PUB_AUTH_VIEW_FILE', 3 );
define( 'PUB_AUTH_UPLOAD', 4 );
define( 'PUB_AUTH_PROJECTS', 5 );
define( 'PUB_AUTH_RATE', 6 );
define( 'PUB_AUTH_EMAIL', 7 );
define( 'PUB_AUTH_COMMENT_VIEW', 8 );
define( 'PUB_AUTH_COMMENT_POST', 9 );
define( 'PUB_AUTH_COMMENT_EDIT', 10 );
define( 'PUB_AUTH_COMMENT_DELETE', 11 );

//
// Field Types
//
@define( 'INPUT', 0 );
@define( 'TEXTAREA', 1 );
@define( 'RADIO', 2 );
@define( 'SELECT', 3 );
@define( 'SELECT_MULTIPLE', 4 );
@define( 'CHECKBOX', 5 );

@define( 'RANKS_PATH', 'images/ranks' );

//
// Generate logged in/logged out status
//
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'mybb':
		//To do: Profile oe UCP Links for each backend.
	case 'smf2':
		
		$pub_register = mx_append_sid('login.'.$phpEx.'?mode=register');
		$pub_profile = 'profile.'.$phpEx;
	break;
	
	case 'phpbb2':
		
		//To do: Check this in sessions/phpbb2 comparing to sessions/internal
		$pub_register = mx_append_sid("{$phpbb_root_path}profile.".$phpEx."?mode=register");
		$pub_profile = "{$phpbb_root_path}profile.".$phpEx;
	break;
	
	case 'olympus':
		
		//To do: Check this in sessions/phpbb2 comparing to sessions/internal
		$pub_register = mx_append_sid("{$phpbb_root_path}ucp.php?mode=register&redirect=$redirect_url");
		$pub_profile = "{$phpbb_root_path}ucp.".$phpEx;
	break;
	
	default:
	
		$pub_register = mx_append_sid("{$phpbb_root_path}ucp.php?mode=register&redirect=$redirect_url");
		$pub_profile = "{$phpbb_root_path}ucp.".$phpEx;
	break;
}
define( 'PROFILE_PATH', $pub_profile);

if ( !MXBB_MODULE || MXBB_27x )
{
	$pub_module_version = "MXPub Projects Manager v. 0.9.0";
	$pub_module_author = "Florin C Bodin";
	$pub_module_orig_author = "Mohd";
}
else
{
	$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x
	
	if (is_object($mx_page))
	{
		// -------------------------------------------------------------------------
		// Extend User Style with module lang and images
		// Usage:  $mx_user->extend(LANG, IMAGES)
		// Switches:
		// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
		// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
		// -------------------------------------------------------------------------
		
		// **********************************************************************
		// First include shared phpBB2 language file 
		// **********************************************************************
		$mx_user->set_lang($mx_user->lang, $mx_user->help, 'lang_main');
		//$mx_user->_load_lang($mx_root_path . 'includes/shared/phpbb2/', 'lang_main');
		if (defined('IN_ADMIN'))
		{
			$mx_user->set_lang($mx_user->lang, $mx_user->help, 'lang_admin');
		}
		
		if (defined('IN_ADMIN'))
		{
			$mx_user->extend(MX_LANG_ALL, MX_IMAGES_NONE, $module_root_path, true);
		}
		else
		{
			$mx_user->extend(MX_LANG_MAIN, MX_IMAGES, $module_root_path, true);
		}

		$mx_page->add_copyright( 'MX Publisher Module - Projects Manager' );
	}
}

// **********************************************************************
// If phpBB mod read language definition
// **********************************************************************
if ( !MXBB_MODULE )
{
	if ( !file_exists( $module_root_path . 'pafiledb/language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx ) )
	{
		include( $module_root_path . 'pafiledb/language/lang_english/lang_main.' . $phpEx );
	}
	else
	{
		include( $module_root_path . 'pafiledb/language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx );
	}
}
?>