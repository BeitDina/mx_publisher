<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: pub_post.php,v 1.22 2013/04/04 11:58:51 orynider Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**
 * Enter description here...
 *
 */
class publisher_post extends publisher_public
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $action
	 */
	function main($action = false)
	{
		global $template, $mx_user, $publisher_functions, $lang, $board_config, $phpEx, $publisher_config, $db, $images, $userdata;
		global $mx_root_path, $module_root_path, $phpbb_root_path, $is_block, $mx_request_vars, $theme;
		global $html_entities_match, $html_entities_replace, $unhtml_specialchars_match, $unhtml_specialchars_replace;
		global $mx_block, $mx_bbcode, $_SERVER;

		//
		// Go full page
		//
		$mx_block->full_page = true;

		//
		// Request vars
		//
		$article_id = $mx_request_vars->request('k', MX_TYPE_INT, '');
		$cat_id = $mx_request_vars->is_request('cat_id') ? $mx_request_vars->request('cat_id', MX_TYPE_INT, 0) : $mx_request_vars->request('cat', MX_TYPE_INT, 0);

		$do = ( isset( $_REQUEST['do'] ) ) ? intval( $_REQUEST['do'] ) : '';
		$pub_post_mode = empty( $article_id ) ? 'add' : 'edit'; //Main mode toggle
		$this->page_title = $pub_post_mode == 'add' ? $lang['Add_article'] : $lang['Edit_article'];

		$delete = $mx_request_vars->request('delete', MX_TYPE_NO_TAGS, '');
		$preview = $mx_request_vars->is_request('preview');
		$cancel = $mx_request_vars->is_request('cancel');
		//$this->auth_user[$cat_id]['auth_post'] = 1;

		//
		// Main Auth
		//
		if (!empty($cat_id))
		{
			if (!$this->auth_user[$cat_id]['auth_post'])
			{
				mx_message_die( GENERAL_MESSAGE, $lang['Sorry_auth_post'] . $this->auth_user[$cat_id]['auth_post'] );
			}
		}
		else
		{
			$dropmenu = (!$cat_id) ? $this->generate_jumpbox(0, 0, '', true, true, 'auth_post') : $this->generate_jumpbox(0, 0, array($cat_id => 1), true, true, 'auth_post');

			if ( empty( $dropmenu ) )
			{
				mx_message_die(GENERAL_MESSAGE, $lang['Sorry_auth_post'] . $this->auth_user[$cat_id]['auth_post']);
			}
		}

		//
		// Load article info...if $article_id is set
		//
		if ($article_id)
		{
			$sql = 'SELECT *
				FROM ' . PUB_ARTICLES_TABLE . "
				WHERE article_id = '" . $article_id . "'";
			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(GENERAL_ERROR, 'Couldnt query article data', '', __LINE__, __FILE__, $sql);
			}

			$article_data = $db->sql_fetchrow($result);
			$cat_id = $article_data['article_category_id'];

			$db->sql_freeresult($result);
		}

		//
		// Further security.
		// Reset vars if no related data exist.
		//
		if ( $article_id && !$cat_id )
		{
			$article_id = 0;
		}

		if ( $cat_id && !$this->cat_rowset[$cat_id]['cat_id'] )
		{
			$cat_id = 0;
		}


		// =======================================================
		// Delete
		// =======================================================
		if ( $do == 'delete' && $article_id)
		{
			if ( ( $this->auth_user[$cat_id]['auth_delete'] && $article_data['user_id'] == $mx_user->data['user_id'] ) || $this->auth_user[$cat_id]['auth_mod'] )
			{
				//
				// Notification
				//
				$this->update_add_item_notify($article_id, 'delete');

				//
				// Comments
				//
				if ($this->comments[$cat_id]['activated'] && $publisher_config['del_topic'])
				{
					if ( $this->comments[$cat_id]['internal_comments'] )
					{
						$sql = 'DELETE FROM ' . PUB_COMMENTS_TABLE . "
						WHERE article_id = '" . $article_id . "'";
						if ( !($db->sql_query($sql)))
						{
							mx_message_die(GENERAL_ERROR, 'Couldnt delete comments', '', __LINE__, __FILE__, $sql);
						}
					}
					else
					{
						if ( $article_data['topic_id'] )
						{
							include($module_root_path . 'publisher/core/functions_comment.' . $phpEx);
							$publisher_comments = new publisher_comments();
							$publisher_comments->init($article_data, 'phpbb');
							$publisher_comments->post('delete_all', $article_data['topic_id']);
						}
					}
				}

				$this->delete_items( $article_id );
				$this->_publisher();
				$message = $lang['Article_Deleted'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid($this->this_mxurl("action=cat&cat=" . $cat_id)) . '">', '</a>' );
				mx_message_die(GENERAL_MESSAGE, $message);
			}
			else
			{
				mx_message_die(GENERAL_MESSAGE, $lang['Sorry_auth_delete']);
			}
		}

		//
		// Define more vars
		//
		$pub_title = $preview || isset($_POST['article_name']) ? $_POST['article_name'] : $article_data['article_title'];
		$pub_desc = $preview || isset($_POST['article_desc']) ? $_POST['article_desc'] : $article_data['article_description'];
		$pub_text = $preview || isset($_POST['message']) ? $_POST['message'] : $article_data['article_body'];
		$bbcode_uid = $preview ? '' : $article_data['bbcode_uid'];

		$username = $preview || isset($_POST['username']) ? $_POST['username'] : $article_data['username'];
		$type_id =  $preview || isset($_POST['type_id']) ? intval($_POST['type_id']) : $article_data['article_type'];

		//
		// Instatiate custom fields (only used in pub_article)
		//
		$mx_custom_field = new mx_custom_field(PUB_CUSTOM_TABLE, PUB_CUSTOM_DATA_TABLE);
		$mx_custom_field->init();

		//
		// wysiwyg
		//
		if ( $publisher_config['allow_wysiwyg'] && file_exists($mx_root_path . $publisher_config['wysiwyg_path'] . 'tinymce/jscripts/tiny_mce/tiny_mce.js'))
		{
			$allow_wysiwyg = true;
			$bbcode_on = false;
			$html_on = true;
			$smilies_on = false;
			$links_on = false;
			$images_on = false;
			
			//Get board  config default_lang iso code from lang_meta.php 
			$langcode = mx_get_langcode();

			//Get board  config default_lang iso code from lang_meta.php 
			$langguess = @function_exists('mx_guess_lang') ? mx_guess_lang(true) : $_SERVER['HTTP_ACCEPT_LANGUAGE'];

			if ($this->auth_user[$cat_id]['auth_mod'])
         	{
				$template->assign_block_vars("tinyMCE_admin", array(
					'PATH' => $mx_root_path,
					'LANG' => !empty($langcode) ? $langcode : $langguess,
					'TEMPLATE' => $mx_root_path . 'templates/'. $theme['template_name'] . '/' . $theme['head_stylesheet']
				));
         	}
         	else
         	{
				$template->assign_block_vars("tinyMCE", array(
					'PATH' => $mx_root_path,
					'LANG' => !empty($langguess) ? $langguess : $langcode,
					'TEMPLATE' => $mx_root_path . 'templates/'. $theme['template_name'] . '/' . $theme['head_stylesheet']
				));
         	}
		}
		else
		{
			$allow_wysiwyg = false;
			$bbcode_on = $publisher_config['allow_bbcode'] ? true : false;
			$html_on = $publisher_config['allow_html'] ? true : false;
			$smilies_on = $publisher_config['allow_smilies'] ? true : false;
			$links_on = $publisher_config['allow_links'] ? true : false;
			$images_on = $publisher_config['allow_images'] ? true : false;
			$board_config['allow_html_tags'] = $publisher_config['allowed_html_tags'];

			$template->assign_block_vars( 'formatting', array() );

			if ($smilies_on)
			{
				$mx_bbcode->generate_smilies( 'inline', PAGE_POSTING );
			}
		}

		//
		// Instantiate the mx_text and mx_text_formatting classes
		//
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on);

		$mx_text_formatting = new mx_text_formatting();

		//
		// Allow all html tags
		// Fix: Setting 'emtpy' enables all
		//
		$mx_text->allow_all_html_tags = $allow_wysiwyg;

		//
		// IF submit then upload the article and update the sql for it
		//
		if ($mx_request_vars->is_request('submit') && $cat_id)
		{
			if ( !$mx_request_vars->is_request('article_name') || !$mx_request_vars->is_request('article_desc') || !$mx_request_vars->is_request('message') )
			{
				$message = $lang['Empty_fields'] . '<br /><br />' . sprintf( $lang['Empty_fields_return'], '<a href="' . mx_append_sid($this->this_mxurl('action=add')) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
			
			//
			// Encode for db storage
			//
			$article_title = $mx_text->encode_simple($pub_title);
			$article_description = $mx_text->encode_simple($pub_desc);
			$article_text = $mx_text->encode($pub_text);
			$bbcode_uid = $mx_text->bbcode_uid;

			$username = $mx_text->encode_username($username);
			$date = time();
			$author_id = $userdata['user_id'] > 0 ? intval( $mx_user->data['user_id'] ) : '-1';

			if (!$article_id)
			{
				if ($this->auth_user[$cat_id]['auth_post'] || $this->auth_user[$cat_id]['auth_mod'])
				{

					//
					// Approve
					//
					$approve = $this->auth_user[$cat_id]['auth_approval'] || $this->auth_user[$cat_id]['auth_mod'] ?  1 : 0; // approved

					$sql = "INSERT INTO " . PUB_ARTICLES_TABLE . " ( article_category_id , article_title , article_description , article_date , article_author_id , username , bbcode_uid , article_body , article_type , approved, views )
					VALUES ( '$cat_id', '" . str_replace( "\'", "''", $article_title ) . "', '" . str_replace( "\'", "''", $article_description ) . "', '$date', '$author_id', '" . str_replace( "\'", "''", $username ) . "', '$bbcode_uid', '" . str_replace( "\'", "''", $article_text ) . "', '$type_id', '$approve', '0')";
					if (!($results = $db->sql_query($sql)))
					{
						mx_message_die( GENERAL_ERROR, "Could not submit aritcle", '', __LINE__, __FILE__, $sql );
					}

					//
					// Get new article id
					//
					$sql = "SELECT MAX(article_id) AS new_id FROM " . PUB_ARTICLES_TABLE;
					if (!($result = $db->sql_query($sql)))
					{
						mx_message_die(GENERAL_ERROR, "Couldn't find max article_id", "", __LINE__, __FILE__, $sql);
					}
					$temp_row = $db->sql_fetchrow($result);
					$article_id = $temp_row['new_id'];

					//
					// Update custom fields
					//
					$mx_custom_field->file_update_data($article_id);

					$this->modified(true);
					$this->_publisher();

				}
				else
				{
					$message = $lang['Sorry_auth_post'];
				}
			
			}
			else
			{
				if ( ($this->auth_user[$cat_id]['auth_edit'] && $article_data['user_id'] == $userdata['user_id'] ) || $this->auth_user[$cat_id]['auth_mod'] )
				{
					//
					// Approve
					//
					$approve = $this->auth_user[$cat_id]['auth_approval_edit'] || $this->auth_user[$cat_id]['auth_mod'] ? 1 : 0; // approved
					$sql = "UPDATE " . PUB_ARTICLES_TABLE . "
						SET article_category_id 	= '$cat_id',
								article_title 			= '" . str_replace( "\'", "''", $article_title ) . "',
								article_description 	= '" . str_replace( "\'", "''", $article_description ) . "',
								article_body 			= '" . str_replace( "\'", "''", $article_text ) . "',
								article_type 			= '" . $type_id . "',
								approved 			= '" . $approve . "',
								bbcode_uid 			= '" . $bbcode_uid . "'
						WHERE article_id 			= ". $article_id;
						
					if (!($results = $db->sql_query($sql)))
					{
						mx_message_die( GENERAL_ERROR, "Could not edit article", '', __LINE__, __FILE__, $sql );
					}

					//
					// Update custom fields
					//
					$mx_custom_field->file_update_data( $article_id );

					$this->modified( true );
					$this->_publisher();
				}
				else
				{
					$message = $lang['Sorry_auth_edit'];
				}
			}

			//
			// Notification
			//
			$this->update_add_item_notify($article_id, $pub_post_mode);

			//
			// Auto comment
			//
			if ( $this->comments[$cat_id]['activated'] && $this->comments[$cat_id]['autogenerate_comments'] )
			{
				//
				// Autogenerate comment (duplicate the notification message)
				//
				$mx_pub_notification = new mx_pub_notification();
				$mx_pub_notification->init( $article_id, $publisher_config['allow_comment_wysiwyg'] );
				$mx_pub_notification->_compose_auto_note($pub_post_mode == 'add' ? MX_NEW_NOTIFICATION : MX_EDITED_NOTIFICATION);

				//
				// Generate comment
				//
				$this->update_add_comment('', $article_id, 0, addslashes(trim($mx_pub_notification->topic_title)), addslashes(trim($mx_pub_notification->message)), true, false, false, true );
			}

			if ($approve == 1)
			{
		     	$message = $lang['Article_submitted'] . '<br /><br />' . sprintf( $lang['Click_return_pub'], '<a href="' . mx_append_sid($this->this_mxurl()) . '">', '</a>' ) . '<br /><br />' . sprintf($lang['Click_return_article'], '<a href="' . mx_append_sid($this->this_mxurl("action=article&amp;k=" . $article_id)) . '">', '</a>') . '<br /><br />' . sprintf( $lang['Click_return_index'], '<a href="' . mx_append_sid( $mx_root_path . "index.$phpEx" ) . '">', '</a>' );
			}
			else
			{
				$message = $lang['Article_submitted_Approve'] . '<br /><br />' . sprintf( $lang['Click_return_pub'], '<a href="' . mx_append_sid($this->this_mxurl()) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_index'], '<a href="' . mx_append_sid($this->this_mxurl()) . '">', '</a>' );
			}
			mx_message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			// =======================================================
			// IF not submit then load data MAIN form
			// =======================================================
			if (!$article_id)
			{
				$cat_id = $mx_request_vars->is_request('cat') ? $mx_request_vars->request('cat', MX_TYPE_INT, 0) : $mx_request_vars->request('cat_id', MX_TYPE_INT, 0);
				if (!$this->auth_user[$cat_id]['auth_post'])
				{
					mx_message_die(GENERAL_MESSAGE, $lang['Sorry_auth_post']);
				}
			}
			else
			{
				if (!(($this->auth_user[$cat_id]['auth_edit'] && $article_data['user_id'] == $mx_user->data['user_id'] ) || $this->auth_user[$cat_id]['auth_mod'] ) )
				{
					mx_message_die(GENERAL_MESSAGE, $lang['Sorry_auth_edit']);
				}
			}

			//
			// PreText HIDE/SHOW
			//
			if ( $publisher_config['show_pretext'] )
			{
				//
				// Pull Header/Body info.
				//
				$pt_header = $publisher_config['pt_header'];
				$pt_body = $publisher_config['pt_body'];

				$template->set_filenames( array( 'pretext' => 'pub_post_pretext.tpl' ) );

				$template->assign_vars( array(
					'PRETEXT_HEADER' => $pt_header,
					'PRETEXT_BODY' => $pt_body ) );

				$template->assign_var_from_handle( 'PUB_PRETEXT_BOX', 'pretext' );
			}

			if ( $preview )
			{
				//
				// Encode for preview
				//
				$preview_title = $mx_text->encode_preview_simple($pub_title);
				$preview_desc = $mx_text->encode_preview_simple($pub_desc);
				$preview_text = $mx_text->encode_preview($pub_text);

				if (!$publisher_config['allow_images'] || !$publisher_config['allow_links'])
				{
					$preview_text = $mx_text_formatting->remove_images_links( $preview_text, $publisher_config['allow_images'], $publisher_config['no_image_message'], $publisher_config['allow_links'], $publisher_config['no_link_message'] );
				}

				$template->set_filenames( array( 'preview' => 'pub_post_preview.tpl' ) );

				$template->assign_vars( array(
					'L_PREVIEW' => $lang['Preview'],
					'ARTICLE_TITLE' => $preview_title,
					'ARTICLE_DESC' => $preview_desc,
					'ARTICLE_BODY' => $preview_text,
					'PRE_COMMENT' => $preview_text)
				);

				$template->assign_var_from_handle('PUB_PREVIEW_BOX', 'preview');

				//
				// Decode for form editing
				//
				$pub_title = $mx_text->decode_simple($pub_title, true);
				$pub_desc = $mx_text->decode_simple($pub_desc, true);
				$pub_text = $mx_text->decode($pub_text, '', true);
			}
			else
			{
				//
				// Decode for form editing
				//
				$pub_title = $mx_text->decode_simple($pub_title, true);
				$pub_desc = $mx_text->decode_simple($pub_desc, true);
				$pub_text = $mx_text->decode($pub_text, $bbcode_uid, true);

			}

			//
			// show article form - MAIN
			//
			if ( $pub_post_mode == 'edit' )
			{
				$s_hidden_vars = '<input type="hidden" name="k" value="' . $article_id . '"><input type="hidden" name="bbcode_uid" value="' . $bbcode_uid . '"><input type="hidden" name="author_id" value="' . $author_id . '">';
			}
			else
			{
				$s_hidden_vars = '<input type="hidden" name="cat" value="' . $cat_id . '">';
			}

			//
			// Toggle selection
			//
			$html_status = ( $html_on ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
			$bbcode_status = ( $bbcode_on ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
			$smilies_status = ( $smilies_on ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];
			$links_status = ( $links_on ) ? $lang['Links_are_ON'] : $lang['Links_are_OFF'];
			$images_status = ( $images_on ) ? $lang['Images_are_ON'] : $lang['Images_are_OFF'];

			//
			// set up page
			//
			$template->set_filenames(array('body' => 'pub_post_body.tpl'));

			if (!$mx_user->data['session_logged_in'])
			{
				$template->assign_block_vars('switch_name', array());
			}

			$pub_action_url = $pub_post_mode == 'add' ? mx_append_sid($this->this_mxurl("action=add&cat=" . $cat_id)) : mx_append_sid($this->this_mxurl('action=edit'));
			$custom_data = $pub_post_mode == 'add' ? $mx_custom_field->display_edit() : $mx_custom_field->display_edit( $article_id );

			if ( $custom_data )
			{
				$template->assign_block_vars('custom_data_fields', array(
					'L_ADDTIONAL_FIELD' => $lang['Addtional_field']
				));
			}

			$template->assign_vars(array(
				'S_POST_ACTION' => $pub_action_url,
				'S_ACTION' => $pub_action_url,
				
				'S_HIDDEN_FIELDS' => $s_hidden_vars,

				'L_PUB' => $lang['PUB_title'],

				'ARTICLE_TITLE' => $pub_title,
				'ARTICLE_DESC' => $pub_desc,
				'ARTICLE_BODY' => $pub_text,
				'USERNAME' => $username,

				'L_ADD_ARTICLE' => $lang['Add_article'],

				'L_ARTICLE_TITLE' => $lang['Article_title'],
				'L_ARTICLE_DESCRIPTION' => $lang['Article_description'],
				'L_ARTICLE_TEXT' => $lang['Article_text'],
				'L_ARTICLE_CATEGORY' => $lang['Category'],
				'L_ARTICLE_TYPE' => $lang['Article_type'],
				'L_SUBMIT' => $lang['Submit'],
				'L_PREVIEW' => $lang['Preview'],
				'L_SELECT_TYPE' => $lang['Select'],
				'L_NAME' => $lang['Username'],

				'HTML_STATUS' => $html_status,
				'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . PHPBB_URL . mx_append_sid("faq.$phpEx?action=bbcode") . '" target="_phpbbcode">', '</a>'),
				'SMILIES_STATUS' => $smilies_status,
				'LINKS_STATUS' => $links_status,
				'IMAGES_STATUS' => $images_status,

				'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
				'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
				'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
				'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
				'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
				'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
				'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
				'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
				'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
				'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
				'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
				'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],

				'L_EMPTY_MESSAGE' => $lang['Empty_message'],
				'L_EMPTY_ARTICLE_NAME' => $lang['Empty_article_name'],
				'L_EMPTY_ARTICLE_DESC' => $lang['Empty_article_desc'],
				'L_EMPTY_CAT' => $lang['Empty_category'],
				'L_EMPTY_TYPE' => $lang['Empty_type'],

				'L_FONT_COLOR' => $lang['Font_color'],
				'L_COLOR_DEFAULT' => $lang['color_default'],
				'L_COLOR_DARK_RED' => $lang['color_dark_red'],
				'L_COLOR_RED' => $lang['color_red'],
				'L_COLOR_ORANGE' => $lang['color_orange'],
				'L_COLOR_BROWN' => $lang['color_brown'],
				'L_COLOR_YELLOW' => $lang['color_yellow'],
				'L_COLOR_GREEN' => $lang['color_green'],
				'L_COLOR_OLIVE' => $lang['color_olive'],
				'L_COLOR_CYAN' => $lang['color_cyan'],
				'L_COLOR_BLUE' => $lang['color_blue'],
				'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
				'L_COLOR_INDIGO' => $lang['color_indigo'],
				'L_COLOR_VIOLET' => $lang['color_violet'],
				'L_COLOR_WHITE' => $lang['color_white'],
				'L_COLOR_BLACK' => $lang['color_black'],

				'L_FONT_SIZE' => $lang['Font_size'],
				'L_FONT_TINY' => $lang['font_tiny'],
				'L_FONT_SMALL' => $lang['font_small'],
				'L_FONT_NORMAL' => $lang['font_normal'],
				'L_FONT_LARGE' => $lang['font_large'],
				'L_FONT_HUGE' => $lang['font_huge'],

				'L_PAGES' => $lang['L_Pages'],
				'L_PAGES_EXPLAIN' => $lang['L_Pages_explain'],

				'L_TOC' => $lang['L_Toc'],
				'L_TOC_EXPLAIN' => $lang['L_Toc_explain'],
				'L_ABSTRACT' => $lang['L_Abstract'],
				'L_ABSTRACT_EXPLAIN' => $lang['L_Abstract_explain'],
				'L_TITLE_FORMAT' => $lang['L_Title_Format'],
				'L_TITLE_FORMAT_EXPLAIN' => $lang['L_Title_Format_explain'],
				'L_SUBTITLE_FORMAT' => $lang['L_Subtitle_Format'],
				'L_SUBTITLE_FORMAT_EXPLAIN' => $lang['L_Subtitle_Format_explain'],
				'L_SUBSUBTITLE_FORMAT' => $lang['L_Subsubtitle_Format'],
				'L_SUBSUBTITLE_FORMAT_EXPLAIN' => $lang['L_Subsubtitle_Format_explain'],

				'L_OPTIONS' => $lang['L_Options'],
				'L_FORMATTING' => $lang['L_Formatting'],

				'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
				'L_STYLES_TIP' => $lang['Styles_tip']

			));

			$publisher_functions->get_pub_type_list($type_id);

			if ($pub_post_mode == 'edit')
			{
				$template->assign_block_vars( 'switch_edit', array(
					'CAT_LIST' => $this->generate_jumpbox(0, 0, array( $cat_id => 1 ), false, true, 'auth_edit')
				));
			}

			if ( $bbcode_on )
			{
				$template->assign_block_vars( 'switch_bbcodes', array());
			}

			// ===================================================
			// assign var for top navigation
			// ===================================================
			$this->generate_navigation($cat_id);

			//
			// User authorisation levels output
			//
			$this->auth_can($cat_id);

			//
			// Get footer quick dropdown jumpbox
			//
			$this->generate_jumpbox(0, 0, array($cat_id => 1));
			
			//
			// Output all
			//
			$this->display( $lang['Publisher'], 'pub_post_body.tpl' );
		}
	}
}
?>