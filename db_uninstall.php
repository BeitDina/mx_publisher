<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: db_uninstall.php,v 1.16 2008/06/03 20:21:56 jonohlsson Exp $
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

// For compatibility with core 2.7.+
define( 'MXBB_27x', file_exists( $mx_root_path . 'mx_login.php' ) );

if ( MXBB_27x )
{
	include_once( $mx_root_path . 'publisher/controller/publisher/core/functions_mx.' . $phpEx );
}

$sql = array(
		"DROP TABLE " . $mx_table_prefix . "pub_articles ",
		"DROP TABLE " . $mx_table_prefix . "pub_cat ",
		"DROP TABLE " . $mx_table_prefix . "pub_auth ",
		"DROP TABLE " . $mx_table_prefix . "pub_comments ",
		"DROP TABLE " . $mx_table_prefix . "pub_config ",
		"DROP TABLE " . $mx_table_prefix . "pub_custom ",
		"DROP TABLE " . $mx_table_prefix . "pub_customdata ",
		"DROP TABLE " . $mx_table_prefix . "pub_articlesacces_info ",
		"DROP TABLE " . $mx_table_prefix . "pub_filesacces_info ",
		"DROP TABLE " . $mx_table_prefix . "pub_license ",
		"DROP TABLE " . $mx_table_prefix . "pub_types ",
		//"DROP TABLE " . $mx_table_prefix . "pub_wordlist ",
		//"DROP TABLE " . $mx_table_prefix . "pub_results ",
		//"DROP TABLE " . $mx_table_prefix . "pub_wordmatch ",
		"DROP TABLE " . $mx_table_prefix . "pub_votes ",
		"DROP TABLE " . $mx_table_prefix . "pub_mirrors ",
		"DROP TABLE " . $mx_table_prefix . "pub_files "
	);

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . mx_do_install_upgrade( $sql ) . "</span></td></tr>";
echo "</table><br />";

?>