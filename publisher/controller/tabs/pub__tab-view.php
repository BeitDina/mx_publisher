<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: pub__tab-view.php,v 1.5 2008/06/03 20:11:20 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

define( 'IN_PORTAL', 1 );
$mx_root_path = "./../../../../../";

$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($mx_root_path . 'common.' . $phpEx);

define( 'PUB_APP', true );
define( 'MXBB_MODULE', true );
define( 'MXBB_27x', file_exists( $mx_root_path . 'mx_login.' . $phpEx ) );
$is_block = true;

//
// Page selector
//
$page_id = $mx_request_vars->request('page_id', MX_TYPE_INT, 0);

//
// Start session, user and style (template + theme) management
// - populate $userdata, $lang, $theme, $images and initiate $template.
//
$mx_user->init($user_ip, - ( 1000 + $page_id ));

//
// Load and instatiate page and block classes
//
$mx_page->init( $page_id );
$mx_block = new mx_block();

//
// Block selector
//
$block_id = $mx_request_vars->request('block_id', MX_TYPE_INT, 0);

//
// Instatiate block
//
$mx_block->init( $block_id );

//
// Extract 'what posts to view info', the cool Array ;)
//
$pub_type_select_var = $mx_block->get_parameters( 'pub_type_select' );
$pub_type_select_data = ( !empty( $pub_type_select_var ) ) ? unserialize( $pub_type_select_var ) : array();

//
// Page Auth and IP filter
//
if ( !$mx_page->auth_view && $mx_user->data['session_logged_in'] )
{
	echo('Not authorized - 1');
	return;
}
elseif ( !$mx_page->auth_view && !$mx_user->data['session_logged_in'] )
{
	echo('Not authorized - 2');
	return;
}
elseif ( !$mx_page->auth_ip )
{
	echo('Not authorized - 3');
	return;
}

//
// Page Auth and IP filter
//
if ( !( ( $mx_block->auth_view && $mx_block->show_block ) || $mx_block->auth_mod ) )
{
	echo('Not authorized - 4');
	return;
}

//
// Define $module_root_path, to be used within blocks
//
$module_root_path = $mx_root_path . $mx_block->module_root_path;

// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------
// Start
// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------

// ===================================================
// Include the common file
// ===================================================
include_once( $module_root_path . 'publisher/publisher_common.' . $phpEx );

// ===================================================
// Get mode variables, otherwise set it to the main
// ===================================================
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, 'article');
$print_version = false;
$publisher_config['reader_mode'] = false;
$publisher_config['app_mode'] = true;

// ===================================================
// Is admin?
// ===================================================
$is_admin = ( ( $mx_user->data['user_level'] == ADMIN  ) && $mx_user->data['session_logged_in'] ) ? true : 0;

// ===================================================
// if the database disabled give them a nice message
// ===================================================
if ( intval( $publisher_config['module_enable'] ) )
{
	mx_message_die( GENERAL_MESSAGE, $lang['publisher_disable'] );
}

// ===================================================
// an array of all expected actions
// ===================================================
$actions = array(
	'article' => 'article',
	'search' => 'search',
	'rate' => 'rate',
	'stats' => 'stats',
	'post_comment' => 'post_comment',
);

$publisher->module( $actions[$mode] );
$publisher->modules[$actions[$mode]]->main( $mode );

$template->assign_vars( array(
	'U_PORTAL' => $mx_root_path,
	'L_PORTAL' => "<<",
	'U_KB' => mx_append_sid( $publisher->this_mxurl() ),
	'L_KB' => $lang['KB_title']  )
);

$CONFIG['encoding'] = 'iso-8859-1';

// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// always modified
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");

header('Content-type: text/html; charset='.$CONFIG['encoding']);

$template->pparse( 'body' );
?>