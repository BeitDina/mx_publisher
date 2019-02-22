<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: pub_main.php,v 1.21 2008/09/21 14:25:32 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, FlorinCB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die("Hacking attempt");
}

/**
 * Enter description here...
 *
 */
class publisher_main extends publisher_public
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $action
	 */
	function main( $action  = false )
	{
		global $template, $lang, $board_config, $phpEx, $publisher_config, $debug, $phpbb_root_path;

		//
		// Assign vars
		//
		$template->assign_vars( array(
			'U_PROJECTS' => mx_append_sid( $this->this_mxurl() ),
			'PROJECTS' => $publisher_config['module_name'],
			'TREE' => $menu_output
		));

		// ===================================================
		// Show the Category for the download database index
		// ===================================================
		if ($publisher_config['use_simple_navigation'])
		{
			$this->display_categories();
		}
		else
		{
			$this->display_categories_original();
		}

		$this->display( $lang['Download'], 'pub_main_body.tpl' );
	}
}
?>