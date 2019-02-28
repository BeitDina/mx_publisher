<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: admin_file_manage.php,v 1.9 2008/07/15 22:07:04 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, FlorinCB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) || !defined( 'IN_ADMIN' ) )
{
	die("Hacking attempt");
}

class publisher_file_manage extends publisher_admin
{
	function main( $module_id = false )
	{
		$action = $module_id;
		global $mx_user, $db, $images, $template, $template, $lang, $phpEx, $publisher_functions, $publisher_cache, $publisher_config, $phpbb_root_path, $module_root_path, $mx_root_path, $mx_request_vars, $portal_config;

		$mode = ( isset( $_REQUEST['mode'] ) ) ? htmlspecialchars( $_REQUEST['mode'] ) : '';
		$cat_id = ( isset( $_REQUEST['cat_id'] ) ) ? intval( $_REQUEST['cat_id'] ) : 0;
		$cat_id_other = ( isset( $_REQUEST['cat_id_other'] ) ) ? intval( $_REQUEST['cat_id_other'] ) : 0;
		
		// Requests
		$action = $mx_request_vars->variable('action', '');
		$cat_id = $mx_request_vars->variable('cat_id', 0);
		$file_id = $mx_request_vars->variable('file_id', 0);
		
		if ($mx_request_vars->is_set_post('add'))
		{
			$action = 'add';
		}
	
		// Here we set the main switches to use within the ACP
		$this->page_title = $mx_user->lang['ACP_EDIT_ITEMS'];
		$this->tpl_name = 'pub_admin_files_list';
		
		//if (!extension_loaded("tokenizer")) print "tokenizer extension not loaded!";
		
		switch ($action)
		{
			case 'new_item';
				$this->page_title = $mx_user->lang['ACP_NEW_ITEM'];
				$this->tpl_name = 'pub_admin_files_new';
				$admin_controller->new_download();
			break;

			case 'copy_new';
				$this->page_title = $mx_user->lang['ACP_NEW_FILE'];
				$this->tpl_name = 'pub_admin_files_new_copy';
				$admin_controller->copy_new();
			break;

			case 'edit';
				$this->page_title = $mx_user->lang['ACP_EDIT_ITEMS'];
				$this->tpl_name = 'pub_admin_files_edit';
				$admin_controller->edit();
			break;

			case 'add_new';
				$admin_controller->add_new();
			break;

			case 'update';
				$admin_controller->update();
			break;

			case 'delete';
				$admin_controller->delete();
			break;
		}
				
			$template->assign_vars( array(
				'L_DELETE' => $lang['Delete'],
				'L_DO_FILE' => $lang['Delfiles'],
				'L_DO_CAT' => $lang['Do_cat'],
				'L_MOVE_TO' => $lang['Move_to'],
				'L_SELECT_CAT' => $lang['Select_a_Category'],
				'L_DELETE' => $lang['Delete'],
				'L_MOVE' => $lang['Move']
			));

		$template->pparse( 'admin' );

		$this->_publisher();
		$publisher_cache->unload();
	}
}
?>