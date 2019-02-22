<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: pub_quickdl.php,v 1.18 2008/09/21 14:25:35 orynider Exp $
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
class publisher_quickdl extends publisher_public
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $action
	 */
	function main( $action  = false )
	{
		global $template, $lang, $phpEx, $publisher_config, $userdata;
		global $mx_root_path, $module_root_path, $is_block, $publisher_quickdl, $page_id;

		// =======================================================
		// Get the id
		// =======================================================
		$pub_mapping_list = !empty($publisher_quickdl['pub_mapping']) ? unserialize( stripslashes( $publisher_quickdl['pub_mapping'] )) : array();

		//
		// Setup mappings
		//
		for ( $i = 0; $i < count( $pub_mapping_list ); $i++ )
		{
			$pub_get_dynamic[$pub_mapping_list[$i]['map_cat_id']] = $pub_mapping_list[$i]['map_dyn_id'];
			$pub_get_cat[$pub_mapping_list[$i]['map_dyn_id']] = $pub_mapping_list[$i]['map_cat_id'];
		}

		//
		// Get publisher cat id - either from cat_id (GET), mapping (GET) or default cat_id (PAR)
		//
		$pub_cat_id = isset( $_REQUEST['cat_id'] ) ? intval( $_REQUEST['cat_id'] ) : ( isset( $_REQUEST['dynamic_block'] ) && !empty( $pub_get_cat[$_REQUEST['dynamic_block']] ) ? intval( $pub_get_cat[$_REQUEST['dynamic_block']] ) : intval( $publisher_quickdl['pub_quick_cat'] ) );

		/*
		if ( isset( $_REQUEST['dynamic_block'] ) )
		{
			for ( $i = 0; $i < count( $pub_mapping_list ); $i++ )
			{
				if ( $pub_mapping_list[$i]['map_dyn_id'] == intval( $_REQUEST['dynamic_block'] ) )
				{
					if ( get_page_id( $pub_mapping_list[$i]['map_dyn_id'] ) == intval( $_REQUEST['page'] ) )
					{
						$map_cat_id = $pub_mapping_list[$i]['map_cat_id'];
					}
				}
			}
		}

		if ( empty( $map_cat_id ) )
		{
			$map_cat_id = intval( $publisher_quickdl['pub_quick_cat'] );
		}

		$pub_cat_id = isset( $_REQUEST['cat_id'] ) ? intval( $_REQUEST['cat_id'] ) : $map_cat_id;
		*/

		$start = ( isset( $_REQUEST['start'] ) ) ? intval( $_REQUEST['start'] ) : 0;

		if ( isset( $_REQUEST['sort_method'] ) )
		{
			switch ( $_REQUEST['sort_method'] )
			{
				case 'file_name':
					$sort_method = 'file_name';
					break;
				case 'file_time':
					$sort_method = 'file_time';
					break;
				case 'file_dls':
					$sort_method = 'file_dls';
					break;
				case 'file_rating':
					$sort_method = 'rating';
					break;
				case 'file_update_time':
					$sort_method = 'file_update_time';
					break;
				default:
					$sort_method = $publisher_config['sort_method'];
			}
		}
		else
		{
			$sort_method = $publisher_config['sort_method'];
		}

		if ( isset( $_REQUEST['sort_order'] ) )
		{
			switch ( $_REQUEST['sort_order'] )
			{
				case 'ASC':
					$sort_order = 'ASC';
					break;
				case 'DESC':
					$sort_order = 'DESC';
					break;
				default:
					$sort_order = $publisher_config['sort_order'];
			}
		}
		else
		{
			$sort_order = $publisher_config['sort_order'];
		}
		// =======================================================
		// If user not allowed to view file listing (read) and there is no sub Category
		// or the user is not allowed to view these category we gave him a nice message.
		// =======================================================
		$show_category = false;
		if ( isset( $this->subcat_rowset[$pub_cat_id] ) )
		{
			foreach( $this->subcat_rowset[$pub_cat_id] as $sub_cat_id => $sub_cat_row )
			{
				if ( $this->auth_user[$sub_cat_id]['auth_read'] )
				{
					$show_category = true;
					break;
				}
			}
		}

		if ( ( !$this->auth_user[$pub_cat_id]['auth_read'] ) && ( !$show_category ) )
		{
			if ( !$userdata['session_logged_in'] )
			{
				// mx_redirect(mx_append_sid($mx_root_path . "login.$phpEx?redirect=".$this->this_mxurl("actionqdl=category&cat_id=" . $cat_id), true));
			}

			$message = sprintf( $lang['Sorry_auth_view'], $this->auth_user[$pub_cat_id]['auth_read_type'] );
			mx_message_die( GENERAL_MESSAGE, $message );
		}

		if ( !isset( $this->cat_rowset[$pub_cat_id] ) )
		{
			mx_message_die( GENERAL_MESSAGE, $lang['Cat_not_exist'] );
		}

		$quickdl = $this->cat_rowset[$pub_cat_id];

		$quickdl_back = '';
		if ( $pub_cat_id != $publisher_quickdl['pub_quick_cat'] )
		{
			$quickdl_back = $lang['Quickdl_back'];
		}


		//
		// Xtra Get vars
		//
		$map_xtra = (!empty($_GET['dynamic_block']) ? '&dynamic_block=' . $_GET['dynamic_block'] : '');
		//$map_xtra = !empty( $pub_get_dynamic[$publisher_quickdl['pub_quick_cat']] ) ? '&dynamic_block=' . $pub_get_dynamic[$publisher_quickdl['pub_quick_cat']]  : '';

		$template->assign_vars( array(
			'U_PROJECTS' => mx_append_sid( $this->this_mxurl( 'actionqdl=quickdl&cat_id=' . $publisher_quickdl['pub_quick_cat'] . $map_xtra ) ),
			'PROJECTS' => $quickdl['cat_name'],
			'BACK' => $quickdl_back
		));

		$no_file_message = true;

		$filelist = false;

		if ( isset( $this->subcat_rowset[$pub_cat_id] ) )
		{
			$no_file_message = false;

			//$this->display_categories_quickdl( $pub_cat_id, $pub_get_dynamic );
			$this->display_categories_original( $pub_cat_id, 'actionqdl', 'quickdl', $map_xtra );
		}

		$this->display_items( $sort_method, $sort_order, $start, $pub_cat_id, $no_file_message );

		$this->display( $lang['Download'], 'pub_quickdl_cat_body.tpl' );
	}
}

?>