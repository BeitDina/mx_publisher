<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: admin_article_manage.php,v 1.9 2008/07/15 22:07:04 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, FlorinCB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/


/**
*
* @Extra credits for this file
* Todd - (todd@phparena.net) - (http://www.phparena.net)
*
*/

if ( !defined( 'IN_PORTAL' ) || !defined( 'IN_ADMIN' ) )
{
	die("Hacking attempt");
}

class publisher_article_manage extends publisher_admin
{
	function main( $module_id = false )
	{
		$action = $module_id;
		global $mx_user, $db, $images, $template, $lang, $phpEx, $publisher_functions, $publisher_cache, $publisher_config, $phpbb_root_path, $module_root_path, $mx_root_path, $mx_request_vars, $portal_config;

		include_once($module_root_path . 'publisher/core/functions_field.' . $phpEx);

		$custom_field = new custom_field();
		$custom_field->init();
		include_once( $module_root_path . 'publisher/core/functions_admin.' . $phpEx );
		$publisher = new publisher_admin();
		$publisher->init();
		
		$mode = ( isset( $_REQUEST['mode'] ) ) ? htmlspecialchars( $_REQUEST['mode'] ) : '';

		$cat_id = ( isset( $_REQUEST['cat_id'] ) ) ? intval( $_REQUEST['cat_id'] ) : 0;
		$cat_id_other = ( isset( $_REQUEST['cat_id_other'] ) ) ? intval( $_REQUEST['cat_id_other'] ) : 0;
		
		// Requests
		$action = $mx_request_vars->variable('action', '');
		$cat_id = $mx_request_vars->variable('cat_id', 0);
		$art_id = $mx_request_vars->variable('art_id', 0);
		$article_id = $mx_request_vars->variable('article_id', 0);
		
		if ($mx_request_vars->is_set_post('add'))
		{
			$action = 'add';
		}
	
		// Here we set the main switches to use within the ACP
		$this->page_title = $mx_user->lang['ACP_EDIT_ITEMS'];
		$this->tpl_name = 'pub_admin_articles_list';
	
		$article_ids = ( isset( $_POST['article_ids'] ) ) ? array_map( 'intval', $_POST['article_ids'] ) : array();
		$start = ( isset( $_REQUEST['start'] ) ) ? intval( $_REQUEST['start'] ) : 0;

		$mode = ( isset( $_REQUEST['mode'] ) ) ? htmlspecialchars( $_REQUEST['mode'] ) : '';
		$mode_js = ( isset( $_REQUEST['mode_js'] ) ) ? htmlspecialchars( $_REQUEST['mode_js'] ) : '';
		$mode = ( isset( $_POST['addarticle'] ) ) ? 'add' : $mode;
		$mode = ( isset( $_POST['addfile'] ) ) ? 'add' : $mode;
		$mode = ( isset( $_POST['delete'] ) ) ? 'delete' : $mode;
		$mode = ( isset( $_POST['approve'] ) ) ? 'do_approve' : $mode;
		$mode = ( isset( $_POST['unapprove'] ) ) ? 'do_unapprove' : $mode;
		$mode = ( empty( $mode ) ) ? $mode_js : $mode;

		$mirrors = ( isset( $_POST['mirrors'] ) ) ? true : 0;

		if ( isset( $_REQUEST['sort_method'] ) )
		{
			switch ( $_REQUEST['sort_method'] )
			{
				case 'article_title':
				case 'article_name':
					$sort_method = 'article_title';
				break;
				case 'article_time':
				case 'article_date':
					$sort_method = 'article_date';
				break;
				case 'article_dls':
				case 'views':
					$sort_method = 'views';
				break;
				case 'article_rating':
					$sort_method = 'rating';
				break;
				case 'article_update_time':
					$sort_method = 'article_update_time';
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

		$s_article_actions = array( 
			'approved' => $lang['Approved_files'],
			'broken' => $lang['Broken_files'],
			'article_cat' => $lang['Articles_cat'],
			'all_article' => $lang['All_articles'],
			'maintenance' => $lang['Maintenance'] );

		switch ( $mode )
		{
			case '':
			case 'approved':
			case 'broken':
			case 'do_approve':
			case 'do_unapprove':
			case 'delete':
			case 'article_cat':
			case 'all_article':
			default:
				$template_file = 'admin/pub_admin_article.tpl';
				$l_title = $lang['Article_manage_title'];
				$l_explain = $lang['Add_article_explain']; 
				// $s_hidden_fields = '<input type="hidden" name="mode" value="add">';
			break;
			case 'add':
				$template_file = 'admin/pub_admin_article_edit.tpl';
				$l_title = $lang['Add_article'];
				$l_explain = $lang['Add_article_explain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_add">';
			break;
			case 'edit':
			case 'do_add':
				$template_file = 'admin/pub_admin_article_edit.tpl';
				$l_title = $lang['Efiletitle'];
				$l_explain = $lang['Add_article_explain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_add">';
				$s_hidden_fields .= '<input type="hidden" name="article_id" value="' . $article_id . '">';
			break;
			case 'maintenance':
				$template_file = 'admin/pub_admin_article_checker.tpl';
				$l_title = $lang['File_checker'];
				$l_explain = $lang['File_checker_explain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_maintenace">';
			break;
			case 'mirrors':
				$template_file = 'admin/pub_admin_article_mirrors.tpl';
				$l_title = $lang['Mirrors'];
				$l_explain = $lang['Mirrors_explain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="mirrors">';
				$s_hidden_fields .= '<input type="hidden" name="article_id" value="' . $article_id . '">';
			break;
		}

		if ( $mode == 'do_add' && !$article_id )
		{
			$article_id = $publisher->update_add_file();
			$custom_field->article_update_data( $article_id );
			$publisher->_publisher();
			$mode = 'edit';
			if ( !$mirrors )
			{
				$message = $lang['Fileadded'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_publisher.$phpEx?action=article_manage" ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
		}
		elseif ( $mode == 'do_add' && $article_id )
		{
			$article_id = $publisher->update_add_file( $article_id );
			$custom_field->article_update_data( $article_id );
			$publisher->_publisher();
			$mode = 'edit';
			if ( !$mirrors )
			{
				$message = $lang['Fileedited'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_publisher.$phpEx?action=article_manage" ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( "index.$phpEx?pane=right" ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
		}
		elseif ( $mode == 'delete' )
		{
			if ( is_array( $article_ids ) && !empty( $article_ids ) )
			{
				foreach( $article_ids as $temp_article_id )
				{
					$publisher->delete_files( $temp_article_id );
				}
			}
			else
			{
				$publisher->delete_files( $article_id );
			}
			$publisher->_publisher();
		}
		elseif ( $mode == 'do_maintenace' )
		{
			$publisher->article_mainenance();
		}
		elseif ( $mode == 'do_approve' || $mode == 'do_unapprove' )
		{
			if ( is_array( $article_ids ) && !empty( $article_ids ) )
			{
				foreach( $article_ids as $temp_article_id )
				{
					$publisher->article_approve( $mode, $temp_article_id );
				}
			}
			else
			{
				$publisher->article_approve( $mode, $article_id );
			}
			$publisher->_publisher();
		}

		$template->set_filenames( array( 'admin' => $template_file ) 
			);

		$template->assign_vars( array( 
				'L_ARTICLE_TITLE' => $l_title,
				'L_ARTICLE_EXPLAIN' => $l_explain,
				'L_ADD_ARTICLE' => $lang['Afiletitle'],

				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_ARTICLE_ACTION' => mx_append_sid( "admin_publisher.$phpEx?action=article_manage" ) ) 
			);

		if ( in_array( $mode, array( '', 'approved', 'broken', 'do_approve', 'do_unapprove', 'delete', 'article_cat', 'all_article' ) ) )
		{
			$mode = ( in_array( $mode, array( 'do_approve', 'do_unapprove', 'delete' ) ) ) ? '' : $mode;

			if ( $mode != 'approved' && $mode != 'broken' )
			{
				$where_sql = ( $mode == 'article_cat' ) ? "AND a1.article_category_id = '$cat_id'" : '';
				$sql = "SELECT a1.*
					FROM " . PUB_ARTICLES_TABLE . " as a1
					WHERE a1.article_approved = 1
					$where_sql
					ORDER BY article_date DESC";

				if ( $mode == '' || $mode == 'article_cat'  || $mode == 'all_article' )
				{
					if ((!$result = $db->sql_query($sql)))
					{
						mx_message_die( GENERAL_ERROR, 'Couldn\'t get article info', '', __LINE__, __ARTICLE__, $sql );
					}

					$total_files = $db->sql_numrows( $result );
				}

				if ( !( $result = $db->sql_query_limit( $sql, $publisher_config['pagination'], $start ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldn\'t get article info', '', __LINE__, __ARTICLE__, $sql );
				}
				while ( $row = $db->sql_fetchrow( $result ) )
				{
					$all_article_rowset[] = $row;
				}
			}
			
			if ( $mode == '' || $mode == 'approved' || $mode == 'broken' || $mode == 'article_art' || $mode == 'article_cat' || $mode == 'all_file' )
			{
				if ( $mode == '' )
				{
					$limit = 5;
					$temp_start = 0;
				}
				else
				{
					$limit = $publisher_config['pagination'];
					$temp_start = $start;
				}

				if ( $mode == '' || $mode == 'approved' )
				{
					$sql = "SELECT article_title, article_approved, article_id, article_broken
						FROM " . PUB_ARTICLES_TABLE . "
						WHERE article_approved = '0'
						ORDER BY article_date DESC";

					if ( $mode == 'approved' )
					{
						if ( ( !$result = $db->sql_query( $sql ) ) )
						{
							mx_message_die( GENERAL_ERROR, 'Couldn\'t get article info', '', __LINE__, __ARTICLE__, $sql );
						}

						$total_files = $db->sql_numrows( $result );
					}

					if ( !( $result = $publisher_functions->sql_query_limit( $sql, $limit, $temp_start ) ) )
					{
						mx_message_die( GENERAL_ERROR, 'Couldn\'t get article info', '', __LINE__, __ARTICLE__, $sql );
					}

					while ( $row = $db->sql_fetchrow( $result ) )
					{
						$approved_article_rowset[] = $row;
					}
				}

				if ( $mode == '' || $mode == 'broken' )
				{
					$sql = "SELECT article_title, article_approved, article_id, article_broken
						FROM " . PUB_ARTICLES_TABLE . "
						WHERE article_broken = '1'
						ORDER BY article_date DESC";

					if ( $mode == 'broken' )
					{
						if ( ( !$result = $db->sql_query( $sql ) ) )
						{
							mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info', '', __LINE__, __ARTICLE__, $sql );
						}

						$total_files = $db->sql_numrows( $result );
					}

					if ( !( $result = $publisher_functions->sql_query_limit( $sql, $limit, $temp_start ) ) )
					{
						mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info', '', __LINE__, __ARTICLE__, $sql );
					}

					while ( $row = $db->sql_fetchrow( $result ) )
					{
						$broken_article_rowset[] = $row;
					}
				}

				if ( $mode == '' )
				{
					$global_array = array( 
						0 => array( 
							'lang_var' => $lang['Approved_files'],
							'row_set' => $approved_article_rowset,
							'approval' => 'approve' ),
						1 => array( 'lang_var' => $lang['Broken_files'],
							'row_set' => $broken_article_rowset,
							'approval' => 'both' ),
						2 => array( 'lang_var' => $lang['All_files'],
							'row_set' => $all_article_rowset,
							'approval' => 'unapprove' ) );
				}
				elseif ( $mode == 'all_file' || $mode == 'article_art' )
				{
					$global_array = array( 0 => array( 'lang_var' => $lang['All_files'],
							'row_set' => $all_article_rowset,
							'approval' => 'unapprove' ) );
				}
				elseif ( $mode == 'all_file' || $mode == 'article_art'  || $mode == 'article_cat' )
				{
					$global_array = array( 0 => array( 'lang_var' => $lang['All_files'],
							'row_set' => $all_article_rowset,
							'approval' => 'unapprove' ) );
				}
				elseif ( $mode == 'approved' )
				{
					$global_array = array( 0 => array( 'lang_var' => $lang['Approved_files'],
							'row_set' => $approved_article_rowset,
							'approval' => 'approve' ) );
				}
				elseif ( $mode == 'broken' )
				{
					$global_array = array( 0 => array( 'lang_var' => $lang['Broken_files'],
							'row_set' => $broken_article_rowset,
							'approval' => 'both' ) );
				}
			}

			$s_article_list = '';
			foreach( $s_article_actions as $article_mode => $lang_var )
			{
				$s = '';
				if ( $mode == $article_mode )
				{
					$s = ' selected="selected"';
				}
				$s_article_list .= '<option value="' . $article_mode . '"' . $s . '>' . $lang_var . '</option>';
			}

			$cat_list = '<select name="cat_id">';
			if ( !$publisher->cat_rowset[$cat_id]['cat_parent'] )
			{
				$cat_list .= '<option value="0" selected>' . $lang['None'] . '</option>\n';
			}
			else
			{
				$cat_list .= '<option value="0">' . $lang['None'] . '</option>\n';
			}
			$cat_list .= $publisher->generate_jumpbox(0, 0, array($cat_id => 1), true);
			$cat_list .= '</select>';

			$template->assign_vars(array( 
					'L_EDIT' => $lang['Edit'],
					'L_DELETE' => $lang['Delete'],
					'L_CATEGORY' => $lang['Category'],
					'L_MODE' => $lang['View'],
					'L_GO' => $lang['Go'],
					'L_DELETE_ARTICLE' => $lang['Delete_selected'],
					'L_APPROVE' => $lang['Approve'],
					'L_UNAPPROVE' => $lang['Unapprove'],
					'L_APPROVE_ARTICLE' => $lang['Approve_selected'],
					'L_UNAPPROVE_ARTICLE' => $lang['Unapprove_selected'],
					'L_NO_FILES' => $lang['No_file'],

					'PAGINATION' => mx_generate_pagination(mx_append_sid("admin_publisher.$phpEx?action=article_manage&amp;mode=$mode&amp;sort_method=$sort_method&amp;sort_order=$sort_order&cat_id=$cat_id" ), $total_files, $publisher_config['pagination'], $start),
					'PAGE_NUMBER' => sprintf( $lang['Page_of'], ( floor( $start / $publisher_config['pagination'] ) + 1 ), ceil( $total_files / $publisher_config['pagination'] ) ),

					'S_CAT_LIST' => $cat_list,
					'S_MODE_SELECT' => $s_article_list ) 
				);

			foreach( $global_array as $files_data )
			{
				$approve = false;
				$unapprove = false;
				if ( $files_data['approval'] == 'both' )
				{
					$approve = $unapprove = true;
				}
				elseif ( $files_data['approval'] == 'approve' )
				{
					$approve = true;
				}
				elseif ( $files_data['approval'] == 'unapprove' )
				{
					$unapprove = true;
				}

				$template->assign_block_vars( 'article_mode', array( 
						'L_ARTICLE_MODE' => $files_data['lang_var'],
						'DATA' => ( isset( $files_data['row_set'] ) ) ? true : false,
						'APPROVE' => $approve,
						'UNAPPROVE' => $unapprove ) 
					);

				if ( isset( $files_data['row_set'] ) )
				{
					$i = $start + 1;
					foreach( $files_data['row_set'] as $article_data )
					{
						$approve_mode = ( $article_data['article_approved'] ) ? 'do_unapprove' : 'do_approve';
						$template->assign_block_vars( 'article_mode.article_row', array( 
								'ARTICLE_NAME' => $article_data['article_name'],
								'ARTICLE_NUMBER' => $i++,
								'ARTICLE_ID' => $article_data['article_id'],
								'U_ARTICLE_EDIT' => mx_append_sid( "admin_publisher.$phpEx?action=article_manage&mode=edit&article_id={$article_data['article_id']}" ),
								'U_ARTICLE_DELETE' => mx_append_sid( "admin_publisher.$phpEx?action=article_manage&mode=delete&article_id={$article_data['article_id']}" ),
								'U_ARTICLE_APPROVE' => mx_append_sid( "admin_publisher.$phpEx?action=article_manage&mode=$approve_mode&article_id={$article_data['article_id']}" ),
								'L_APPROVE' => ( $article_data['article_approved'] ) ? $lang['Unapprove'] : $lang['Approve'] ) 
							);
					}
				}
			}
		}
		elseif ( $mode == 'add' || $mode == 'edit' || $mirrors )
		{
			if ( $mode == 'add' )
			{
				$article_name = '';
				$article_desc = '';
				$article_long_desc = '';
				$article_author = '';
				$article_version = '';
				$article_website = '';
				$article_posticons = $publisher_functions->post_icons();
				$article_cat_list = $publisher->generate_jumpbox( 0, 0, '', true );
				$article_license = $publisher_functions->license_list();
				$pin_checked_yes = '';
				$pin_checked_no = ' checked';
				$article_download = 0;
				$approved_checked_yes = ' checked';
				$approved_checked_no = '';
				$article_ssurl = '';
				$ss_checked_yes = '';
				$ss_checked_no = ' checked';
				$article_url = '';
				$custom_exist = $custom_field->display_edit();
			}
			else
			{
				$sql = 'SELECT *
					FROM ' . PUB_ARTICLES_TABLE . "
					WHERE article_id = $article_id";
				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info', '', __LINE__, __FILE__, $sql );
				}
				$article_info = $db->sql_fetchrow( $result );

				$article_name = $article_info['article_name'];
				$article_desc = $article_info['article_desc'];
				$article_long_desc = $article_info['article_longdesc'];
				$article_author = $article_info['article_creator'];
				$article_version = $article_info['article_version'];
				$article_website = $article_info['article_docsurl'];
				$article_posticons = $publisher_functions->post_icons( $article_info['article_posticon'] );
				$article_cat_list = $publisher->generate_jumpbox( 0, 0, array( $article_info['article_category_id'] => 1 ), true );
				$article_license = $publisher_functions->license_list( $article_info['article_license'] );
				$pin_checked_yes = ( $article_info['article_pin'] ) ? ' checked' : '';
				$pin_checked_no = ( !$article_info['article_pin'] ) ? ' checked' : '';
				$article_download = intval( $article_info['article_dls'] );
				$approved_checked_yes = ( $article_info['article_approved'] ) ? ' checked' : '';
				$approved_checked_no = ( !$article_info['article_approved'] ) ? ' checked' : '';
				$article_ssurl = $article_info['article_ssurl'];
				$ss_checked_yes = ( $article_info['article_sshot_link'] ) ? ' checked' : '';
				$ss_checked_no = ( !$article_info['article_sshot_link'] ) ? ' checked' : '';
				$article_url = $article_info['article_dlurl'];
				$article_unique_name = $article_info['unique_name'];
				$article_dir = $article_info['article_dir'];
				$custom_exist = $custom_field->display_edit( $article_id );
			}

			$template->assign_vars(array(
					'U_MIRRORS_PAGE' => mx_append_sid("admin_publisher.$phpEx?action=article_manage&mode=mirrors&article_id=$article_id"),
					'ADD_MIRRORS' => $mirrors,
					'MODE_EDIT' => ( $mode == 'edit' ) ? true : false,
					'MODE' => $mode,
					'ARTICLESIZE' => intval($publisher_config['max_file_size']),
					'ARTICLE_NAME' => $article_name,
					'ARTICLE_DESC' => $article_desc,
					'ARTICLE_LONG_DESC' => $article_long_desc,
					'ARTICLE_AUTHOR' => $article_author,
					'ARTICLE_VERSION' => $article_version,
					'ARTICLE_SSURL' => $article_ssurl,
					'ARTICLE_WEBSITE' => $article_website,
					'ARTICLE_DLURL' => $article_url,
					'ARTICLE_DOWNLOAD' => $article_download,
					'CUSTOM_EXIST' => $custom_exist,
					'APPROVED_CHECKED_YES' => $approved_checked_yes,
					'APPROVED_CHECKED_NO' => $approved_checked_no,
					'SS_CHECKED_YES' => $ss_checked_yes,
					'SS_CHECKED_NO' => $ss_checked_no,
					'PIN_CHECKED_YES' => $pin_checked_yes,
					'PIN_CHECKED_NO' => $pin_checked_no,
					'MIRROR_ARTICLE' => $article_unique_name,
					'U_UPLOADED_MIRROR' => get_formated_url() . '/' . $article_dir . $article_unique_name,

					'L_ARTICLE_APPROVED' => $lang['Approved'],
					'L_ARTICLE_APPROVED_INFO' => $lang['Approved_info'],
					'L_ADDTIONAL_FIELD' => $lang['Addtional_field'],
					'L_SCREENSHOT' => $lang['Scrsht'],
					'L_FILES' => $lang['Articles'],
					'L_ARTICLE_NAME' => $lang['Article_title'],
					'L_ARTICLE_NAME_INFO' => $lang['Filenameinfo'],
					'L_ARTICLE_SHORT_DESC' => $lang['Filesd'],
					'L_ARTICLE_SHORT_DESC_INFO' => $lang['Filesdinfo'],
					'L_ARTICLE_LONG_DESC' => $lang['Fileld'],
					'L_ARTICLE_LONG_DESC_INFO' => $lang['Fileldinfo'],
					'L_ARTICLE_AUTHOR' => $lang['Filecreator'],
					'L_ARTICLE_AUTHOR_INFO' => $lang['Filecreatorinfo'],
					'L_ARTICLE_VERSION' => $lang['Fileversion'],
					'L_ARTICLE_VERSION_INFO' => $lang['Fileversioninfo'],
					'L_FILESS' => $lang['Articles'],
					'L_FILESSINFO' => $lang['Filessinfo'],
					'L_FILESS_UPLOAD' => $lang['Filess_upload'],
					'L_FILESSINFO_UPLOAD' => $lang['Filessinfo_upload'],
					'L_ARTICLE_SSLINK' => $lang['Filess_link'],
					'L_ARTICLE_SSLINK_INFO' => $lang['Filess_link_info'],
					'L_FILESSUPLOAD' => $lang['Filessupload'],
					'L_ARTICLE_WEBSITE' => $lang['Filedocs'],
					'L_ARTICLE_WEBSITE_INFO' => $lang['Filedocsinfo'],
					'L_ARTICLE_URL' => $lang['Fileurl'],
					'L_ARTICLE_UPLOAD' => $lang['File_upload'],
					'L_ARTICLEINFO_UPLOAD' => $lang['Fileinfo_upload'],
					'L_ARTICLE_URL_INFO' => $lang['Fileurlinfo'],
					'L_ARTICLE_POSTICONS' => $lang['Filepi'],
					'L_ARTICLE_POSTICONS_INFO' => $lang['Filepiinfo'],
					'L_ARTICLE_CAT' => $lang['Filecat'],
					'L_ARTICLE_CAT_INFO' => $lang['Filecatinfo'],
					'L_ARTICLE_LICENSE' => $lang['Filelicense'],
					'L_NONE' => $lang['None'],
					'L_FILE_LICENSE_INFO' => $lang['Filelicenseinfo'],
					'L_ARTICLE_PINNED' => $lang['Filepin'],
					'L_ARTICLE_PINNED_INFO' => $lang['Filepininfo'],
					'L_FILE_DOWNLOAD' => $lang['Filedls'],
					'L_MIRRORS' => $lang['Mirrors'],
					'L_MIRRORS_INFO' => $lang['Mirrors_explain'],
					'L_CLICK_HERE_MIRRORS' => $lang['Click_here_mirrors'],
					'L_UPLOADED_ARTICLE' => $lang['Uploaded_file'],
					'L_NO' => $lang['No'],
					'L_YES' => $lang['Yes'],

					'S_POSTICONS' => $article_posticons,
					'S_LICENSE_LIST' => $article_license,
					'S_CAT_LIST' => $article_cat_list ) 
				);
		}
		elseif ( $mode == 'mirrors' )
		{
			if ( isset( $_POST['delete_mirrors'] ) )
			{
				$mirror_ids = ( isset( $_POST['mirror_ids'] ) ) ? array_map( 'intval', $_POST['mirror_ids'] ) : array();

				if ( !empty( $mirror_ids ) )
				{
					$publisher->delete_mirror( $mirror_ids );
				}
			}
			if ( isset( $_POST['add_new'] ) )
			{
				$article_upload = ( empty( $_POST['new_download_url'] ) ) ? true : false;
				$article_remote_url = ( !empty( $_POST['new_download_url'] ) ) ? $_POST['new_download_url'] : '';
				$article_local = ( $_FILES['new_userfile']['tmp_name'] !== 'none' ) ? $_FILES['new_userfile']['tmp_name'] : '';
				$article_realname = ( $_FILES['new_userfile']['name'] !== 'none' ) ? $_FILES['new_userfile']['name'] : '';
				$article_size = ( !empty( $_FILES['new_userfile']['size'] ) ) ? $_FILES['new_userfile']['size'] : '';
				$article_type = ( !empty( $_FILES['new_userfile']['type'] ) ) ? $_FILES['new_userfile']['type'] : '';
				$mirror_location = ( !empty( $_POST['new_location'] ) ) ? $_POST['new_location'] : '';

				$publisher->mirror_add_update( $article_id, $article_upload, $article_remote_url, $article_local, $article_realname, $article_size, $article_type, $mirror_location );
			}

			if ( isset( $_POST['modify'] ) )
			{
				$article_urls = ( !empty( $_POST['download_url'] ) ) ? $_POST['download_url'] : array();
				$userfiles = ( !empty( $_FILES['userfile'] ) ) ? $_FILES['userfile'] : array();
				$locations = ( !empty( $_POST['location'] ) ) ? $_POST['location'] : array();

				$data = array();

				foreach( $article_urls as $mirror_id => $article_url )
				{
					$data[$mirror_id]['download_url'] = $article_url;
				}

				foreach( array_keys( $userfiles ) as $key )
				{
					foreach( $userfiles[$key] as $mirror_id => $userfile )
					{
						$data[$mirror_id][$key] = $userfile;
					}
				}

				foreach( $locations as $mirror_id => $location )
				{
					$data[$mirror_id]['location'] = $location;
				}

				unset( $article_urls );
				unset( $userfiles );
				unset( $locations );

				foreach( $data as $mirror_id => $mirror_data )
				{
					$article_upload = ( empty( $mirror_data['download_url'] ) ) ? true : false;
					$article_remote_url = ( !empty( $mirror_data['download_url'] ) ) ? $mirror_data['download_url'] : '';
					$article_local = ( $mirror_data['tmp_name'] !== 'none' ) ? $mirror_data['tmp_name'] : '';
					$article_realname = ( $mirror_data['name'] !== 'none' ) ? $mirror_data['name'] : '';
					$article_size = ( !empty( $mirror_data['size'] ) ) ? $mirror_data['size'] : '';
					$article_type = ( !empty( $mirror_data['type'] ) ) ? $mirror_data['type'] : '';

					$mirror_location = ( !empty( $mirror_data['location'] ) ) ? $mirror_data['location'] : '';

					$publisher->mirror_add_update( $article_id, $article_upload, $article_remote_url, $article_local, $article_realname, $article_size, $article_type, $mirror_location, $mirror_id );
				}

				unset( $data );
			}

			$sql = 'SELECT f.*
				FROM ' . PUB_MIRRORS_TABLE . " AS f
				WHERE f.article_id = '" . $article_id . "'
				ORDER BY mirror_id";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt select download', '', __LINE__, __FILE__, $sql );
			}

			$mirrors_data = array();
			while ( $row = $db->sql_fetchrow( $result ) )
			{
				$mirrors_data[$row['mirror_id']] = $row;
			}

			$template->assign_vars( array( 'ROW_NOT_EMPTY' => ( empty( $mirrors_data ) ) ? false : true,
					'ARTICLESIZE' => intval( $publisher_config['max_file_size'] ),

					'L_MIRROR_LOCATION' => $lang['Mirror_location'],
					'L_ARTICLE_UPLOAD' => $lang['File_upload'],
					'L_ARTICLE_DELETE' => $lang['Delete'],
					'L_DELETE' => $lang['Delete_selected'],
					'L_ARTICLEINFO_UPLOAD' => $lang['Fileinfo_upload'],
					'L_UPLOADED_ARTICLE' => $lang['Uploaded_file'],
					'L_ARTICLE_URL' => $lang['Fileurl'],
					'L_ARTICLE_URL_INFO' => $lang['Fileurl'],
					'L_MODIFY' => $lang['Efiletitle'],
					'L_ADD_NEW' => $lang['Afiletitle'],
					'L_ADD_NEW_MIRROR' => $lang['Add_new_mirror'] ) 
				);

			foreach( $mirrors_data as $mirror_id => $mirror_data )
			{
				$template->assign_block_vars( 'row', array( 'LOCATION' => $mirror_data['mirror_location'],
						'MIRROR_ID' => $mirror_id,
						'MIRROR_URL' => $mirror_data['article_dlurl'],
						'MIRROR_ARTICLE' => $mirror_data['unique_name'],
						'U_UPLOADED_MIRROR' => get_formated_url() . '/' . $mirror_data['article_dir'] . $mirror_data['unique_name'] ) 
					);
			}
		}

		$template->assign_vars( array( 'ERROR' => ( sizeof( $db->error ) ) ? implode( '<br />', $db->error ) : '' ) 
			);

		$template->pparse( 'admin' );

		$this->_publisher();
		$publisher_cache->unload();

	}
}
?>
