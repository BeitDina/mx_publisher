<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: app.php,v 1.36 2011/03/14 20:22:31 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, FlorinCB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

$phpEx = substr(strrchr(__FILE__, '.'), 1);

if ( !defined('PORTAL_BACKEND') && @file_exists( './viewtopic.' . $phpEx ) ) // -------------------------------------------- phpBB MOD MODE
{
	define( 'MXBB_MODULE', false );
	define( 'IN_PHPBB', true );
	define( 'IN_PORTAL', true );
	define( 'IN_PROJECTS', true );

	// When run as a phpBB mod these paths are identical ;)
	$phpbb_root_path = $module_root_path = $mx_root_path = './';
	$mx_mod_path = $phpbb_root_path . 'mx_mod/';

	//Check for cash mod
	if (file_exists($phpbb_root_path . 'includes/functions_cash.'.$phpEx))
	{
		define('IN_CASHMOD', true);
	}

	include( $phpbb_root_path . 'common.' . $phpEx );

	@ini_set( 'display_errors', '1' );
	error_reporting (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables

	include_once( $mx_mod_path . 'includes/functions_required.' . $phpEx );
	include_once( $mx_mod_path . 'includes/functions_core.' . $phpEx );

	define( 'PAGE_PROJECTS', -501 ); // If this id generates a conflict with other mods, change it ;)

	//
	// Instatiate the mx_cache class
	//
	$mx_cache = new mx_cache();

	//
	// Get MX-Publisher config settings
	//
	$portal_config = $mx_cache->obtain_mxbb_config();

	//
	// instatiate the mx_request_vars class
	//
	$mx_request_vars = new mx_request_vars();

	$is_block = false;

	if ( file_exists("./modcp.$phpEx") ) // phpBB2
	{
		define('PORTAL_BACKEND', 'phpbb2');
		$tplEx = 'tpl';

		mx_cache::load_file('bbcode');
		mx_cache::load_file('functions_post');

		// Start session management
		$userdata = session_pagestart( $user_ip, PAGE_PROJECTS );
		init_userprefs( $userdata );
		// End session management


	}
	else if ( @file_exists("./mcp.$phpEx") ) // phpBB3
	{
		define('PORTAL_BACKEND', 'phpbb3');
		$tplEx = 'html';

		//
		// Start session management
		//
		$user->session_begin();
		$userdata = $user->data;
		$user->setup();
		//
		// End session management
		//

		//
		// Get phpBB config settings
		//
		$board_config = $config;
	}
	else
	{
		die('Copy this file in phpbb_root_path were is your viewtopic.php file!!!');
	}
}
else
{
	define( 'MXBB_MODULE', true );

	if ( !function_exists( 'read_block_config' ) )
	{
		if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'PROJECTS' )
		{
		   define('MX_GZIP_DISABLED', true);
		}

		define( 'IN_PORTAL', true );
		$mx_root_path = '../../';
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		include_once( $mx_root_path . 'common.' . $phpEx );

		// Start session management
		$mx_user->init($user_ip, PAGE_INDEX);
		// End session management

		$block_id = ( !empty( $_GET['block_id'] ) ) ? $_GET['block_id'] : $_POST['id'];
		if ( empty( $block_id ) )
		{
			$sql = "SELECT * FROM " . BLOCK_TABLE . "  WHERE block_title = 'Publisher' LIMIT 1";
			if ( !$result = $db->sql_query( $sql ) )
			{
				mx_message_die( GENERAL_ERROR, "Could not query Publisher module information", "", __LINE__, __FILE__, $sql );
			}
			$row = $db->sql_fetchrow( $result );
			$block_id = $row['block_id'];
		}
		$is_block = false;
	}
	else
	{
		if( !defined('IN_PORTAL') || !is_object($mx_block))
		{
			die("Hacking attempt");
		}
		//
		// Read Block Settings (default mode)
		//
		$title = $mx_block->block_info['block_title'];
		$block_size = ( isset( $block_size ) && !empty( $block_size ) ? $block_size : '100%' );

		//Check for cash mod
		if (file_exists($phpbb_root_path . 'includes/functions_cash.'.$phpEx))
		{
			define('IN_CASHMOD', true);
		}

		$is_block = true;
		global $images;
	}
	define( 'MXBB_27x', @file_exists( $mx_root_path . 'mx_login.'.$phpEx ) );
	define( 'MXBB_28x', @file_exists( $mx_root_path . 'includes/sessions/index.htm' ) );
}

// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------
// Start
// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------

// ===================================================
// ?
// ===================================================
list($trash, $mx_script_name_temp ) = preg_split(trim('//', $board_config['server_name']), PORTAL_URL);
$mx_script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($mx_script_name_temp));

// ===================================================
// Include the common file
// ===================================================
include_once( $module_root_path . 'publisher/publisher_common.' . $phpEx );

// ===================================================
// Get action variable otherwise set it to the main
// ===================================================
$action = $mx_request_vars->request('action', MX_TYPE_NO_TAGS, 'main');

// ===================================================
// Is admin?
// ===================================================
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'phpbb2':
		$is_admin = ( ( $userdata['user_level'] == ADMIN  ) && $userdata['session_logged_in'] ) ? true : 0;
	break;
	case 'phpbb3':
	default:
		$is_admin = ( $userdata['user_type'] == USER_FOUNDER ) ? true : 0;
	break;
}

// ===================================================
// if the module is disabled give them a nice message
// ===================================================
if (!($publisher_config['enable_module'] || $mx_user->is_admin))
{
	//mx_message_die( GENERAL_MESSAGE, $lang['publisher_disable'] );
}

// ===================================================
// an array of all expected actions
// ===================================================
$actions = array(
	'article' => 'article',
	'download' => 'download',
	'category' => 'category',
	'cat' => 'category',
	'add' => 'post',
	'file' => 'file',
	'viewall' => 'viewall',
	'search' => 'search',
	'edit' => 'post',
	'license' => 'license',
	'rate' => 'rate',
	'email' => 'email',
	'stats' => 'stats',
	'toplist' => 'toplist',
	'user_upload' => 'user_upload',
	'post_comment' => 'post_comment',
	'mcp' => 'mcp',
	'ucp' => 'ucp',
	'main' => 'main' );

// ===================================================
// Lets Build the page
// ===================================================
$page_title = $lang['PROJECTS'];

if ( $action != 'PROJECTS' )
{
	if ( !$is_block )
	{
		include( $mx_root_path . 'includes/page_header.' . $phpEx );
	}
}

$publisher->module( $actions[$action] );
$publisher->modules[$actions[$action]]->main( $action );

if ( $action != 'PROJECTS' )
{
	if ( !$is_block )
	{
		include( $mx_root_path . 'includes/page_tail.' . $phpEx );
	}
}
?>