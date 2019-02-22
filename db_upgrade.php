<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: db_upgrade.php,v 1.37 2011/12/07 18:08:01 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, FlorinCB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

define( 'IN_PORTAL', true );
if ( !defined( 'IN_ADMIN' ) )
{
	$mx_root_path = './../../';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include( $mx_root_path . 'common.' . $phpEx );
	// Start session management
	$mx_user->init($user_ip, PAGE_INDEX);

	if ( !$userdata['session_logged_in'] )
	{
		die( "Hacking attempt(1)" );
	}

	if ( $userdata['user_level'] != ADMIN )
	{
		die( "Hacking attempt(2)" );
	}
	// End session management
}

$mx_module_version = '0.3.0-alpha';
$mx_module_copy = 'MX Projecs Module based on original phpBB <i>pafileDB</i> MOD by Mohd/Jon Ohlsson/Orynider</a> based on <a href="http://www.phparena.net/" target="_blank">PHP Arena, FlorinCB</a> :: Adapted for MX-Publisher by [FlorinCB] <a href="http://mxpcms.sf.net/" target="_blank">The MX-Publisher Development Team</a>';

// For compatibility with core 2.7.+
define( 'MXBB_27x', file_exists( $mx_root_path . 'mx_login.php' ) );

if ( MXBB_27x )
{
	include_once($mx_root_path . 'publisher/controller/publisher/core/functions_mx.' . $phpEx );
}

$sql = array();
// Precheck

if($result = $db->field_exists('config_name', $mx_table_prefix . "pub_config"))
//if ( $result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "pub_config" ) )
{
	// Upgrade checks
	$upgrade_100 = 0; // mxp 2.8 branch ->
	
	$message = "<b>Upgrading!</b><br/><br/>";
	
	// validate before 1.0.0
	if(!$result = $db->field_exists('is_dynamic', $mx_table_prefix . "pub_config"))
	//if ( !$result = $db->sql_query( "SELECT is_dynamic from " . $mx_table_prefix . "pub_config" ) )
	{
		$upgrade_100= 1;
		$message .= "<b>Upgrading v. 1.0.0...ok</b><br/><br/>";
	}
	else
	{
		$message .= "<b>Validating v. 1.0.0...ok</b><br/><br/>";
	}
	
	if ( $upgrade_100 == 1 )
	{
		// Upgrade the config table to avoid duplicate entries
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pub_config ADD `is_dynamic` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pub_config ADD KEY `is_dynamic` (`is_dynamic`)";
	}
	else
	{
		$message .= "<b>Nothing to upgrade...</b><br/><br/>";
	}
	
	if ( !MXBB_27x )
	{
		$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";
	}

	$message .= mx_do_install_upgrade( $sql );
	$message .= "<b>...Now upgraded to v. $mx_module_version :-)</b><br/><br/>";

	//
	// Empty module cache
	//
	include_once( $mx_root_path . 'includes/mx_functions_tools.' . $phpEx );
	$module_cache = new module_cache($mx_root_path . 'publisher/controller/publisher/');
	$module_cache->tidy();
	$module_cache->save();
}
else
{
	// If not installed
	$message = "<b>Module not installed...and thus cannot be upgraded ;)</b><br/><br/>";
}

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>