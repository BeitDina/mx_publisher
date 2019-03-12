<?php
/**
*
* @package MX-Publisher Module - mx_pub
* @version $Id: pub_article.php,v 1.20 2008/07/01 21:49:22 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
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
class publisher_article extends publisher_public
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $action
	 */
	function main($action = false)
	{
		global $template, $lang, $theme, $db, $phpEx, $publisher_config, $mx_request_vars, $userdata;
		global $phpbb_root_path, $mx_root_path, $module_root_path, $is_block, $images;
		global $mx_custom_field, $publisher_functions, $print_version, $board_config, $mx_block;
		global $phpBB2, $page_id, $mx_user, $u_profile;

		//
		// Request vars
		//
		$start = $mx_request_vars->get('start', MX_TYPE_INT, 0);
		$view = $mx_request_vars->variable('view', '');
		
		$article_id = $mx_request_vars->is_request('k') ? $mx_request_vars->request('k', MX_TYPE_INT, '') : $mx_block->get_parameters('default_article_id');
		
		$page_num = $mx_request_vars->request('page_num', MX_TYPE_INT, 1) - 1;
		$print_version = $mx_request_vars->is_request('print') ? true : false; 
		$no_page_header = (isset($_REQUEST['view']) || $mx_request_vars->variable('view', '') == 'print') ? true : $print_version; 
		
		// ===================================================
		// article doesn't exist'
		// ===================================================
		if (empty($article_id))
		{
			mx_message_die(GENERAL_MESSAGE, $lang['Article_not_exsist']);
		}

		// =======================================================
		// article id is not set, give him/her a nice error message
		// =======================================================
		switch (SQL_LAYER)
		{
			case 'oracle':
				$sql = "SELECT f.*, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, typ.type
					FROM " . PUB_ARTICLES_TABLE . " AS f, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_TYPES_TABLE . " AS typ
					WHERE f.article_id = r.votes_article(+)
					AND f.article_type = typ.id(+)
					AND f.article_author_id = u.user_id(+)
					AND f.article_id = $article_id
					AND f.approved = 1
					GROUP BY f.article_id ";
			break;
			
			default:
				$sql = "SELECT f.*, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, typ.type
					FROM " . PUB_ARTICLES_TABLE . " AS f
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON f.article_id = r.votes_article
						LEFT JOIN " . PUB_TYPES_TABLE . " AS typ ON f.article_type = typ.id
						LEFT JOIN " . USERS_TABLE . " AS u ON f.article_author_id = u.user_id
					WHERE f.article_id = $article_id
					AND f.approved = 1
					GROUP BY f.article_id ";
			break;
		}

		if (!($result = $db->sql_query($sql)))
		{
			mx_message_die( GENERAL_ERROR, "Could not obtain article data", '', __LINE__, __FILE__, $sql );
		}
		if (!$pub_row = $db->sql_fetchrow($result))
		{
			mx_message_die(GENERAL_MESSAGE, $lang['Article_not_exsist']);
		}
		$db->sql_freeresult($result);

		// ===================================================
		// KB auth for viewing article
		// ===================================================
		if ((!$this->auth_user[$pub_row['article_category_id']]['auth_view']))
		{
			$message = $lang['Article_not_exsist'] . '<br /><br />' . sprintf( $lang['Click_return_pub'], '<a href="' . mx_append_sid( $this->this_mxurl() ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_index'], '<a href="' . mx_append_sid( $phpbb_root_path . "index.$phpEx" ) . '">', '</a>' );
			mx_message_die( GENERAL_MESSAGE, $message );
		}

		// ===================================================
		// Prepare article info to display them
		// ===================================================
		$article_title = $pub_row['article_title'];
		$article_description = $pub_row['article_description'];
		$article_category_id = $pub_row['article_category_id'];
		$article_category_name = $this->cat_rowset[$article_category_id]['category_name'];
		$author_id = $pub_row['article_author_id'];
		$approved = $pub_row['approved'];
		$date = $phpBB2->create_date( $board_config['default_dateformat'], $pub_row['article_date'], $board_config['board_timezone'] );
		$article_type = isset($lang['PUB_type_' . $pub_row['type']]) ? $lang['PUB_type_' . $pub_row['type']] : $pub_row['type'];
		$new_views = $pub_row['views'] + 1;
		$board_config['allow_html_tags'] = $publisher_config['allowed_html_tags'];

		$art_pages = explode('[page]', stripslashes($pub_row['article_body']));
		$article = trim($art_pages[$page_num]);
		$article = str_replace('[toc]', '', $article);
		$bbcode_uid = $pub_row['bbcode_uid'];

		//
		// Toggles
		//
		$bbcode_on = !$publisher_config['allow_wysiwyg'] ? ($publisher_config['allow_bbcode'] ? true : false) : false;
		$html_on = !$publisher_config['allow_wysiwyg'] ? ($publisher_config['allow_html'] ? true : false) : true;
		$smilies_on = !$publisher_config['allow_wysiwyg'] ? ($publisher_config['allow_smilies'] ? true : false) : false;

		$this->page_title = $article_title;

		//
		// Instantiate the mx_text and mx_text_formatting classes
		//
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on); // Note: allowed_html_tags is altered above
		$mx_text->allow_all_html_tags = $publisher_config['allow_wysiwyg'] ? true : false;

		$mx_text_formatting = new mx_text_formatting();

		//
		// Decode article for display
		//
		$article_title = $mx_text->display_simple($article_title);
		$article_description = $mx_text->display_simple($article_description);
		$article = $mx_text->display($article, $bbcode_uid);

		$article = $publisher_functions->article_formatting($article);

		//
		// Remove Images and/or links
		//
		if (!$publisher_config['allow_images'] || !$publisher_config['allow_inks'])
		{
			$article = $mx_text_formatting->remove_images_links( $article, $publisher_config['allow_images'], $publisher_config['no_image_message'], $publisher_config['allow_links'], $publisher_config['no_link_message'] );
		}

		//
		// Text formatting
		//
		if ( $publisher_config['max_subject_chars'] > 0 )
		{
			$article_title = $mx_text_formatting->truncate_text( $article_title, $publisher_config['max_subject_chars'], true );
		}

		if ( $publisher_config['max_description_chars'] > 0 )
		{
			$article_description = $mx_text_formatting->truncate_text( $article_description, $publisher_config['max_description_chars'], true );
		}

		if ( $publisher_config['max_chars'] > 0 )
		{
			$article = $mx_text_formatting->truncate_text( $article, $publisher_config['max_chars'], true );
		}

		if ( $publisher_config['formatting_truncate_links'] || $publisher_config['formatting_image_resize'] > 0 || $publisher_config['formatting_wordwrap'] )
		{
			$article = $mx_text_formatting->decode( $article, $publisher_config['formatting_truncate_links'], intval($publisher_config['formatting_image_resize']), $publisher_config['formatting_wordwrap'] );
		}

		//
		// Format text and data
		//
		$temp_url = mx_append_sid( $this->this_mxurl( "action=cat&amp;cat=$article_category_id" ) );
		$category = '<a href="' . $temp_url . '" class="gensmall">' . $article_category_name . '</a>';

		if ($author_id == -1)
		{
			$author_pub_art = ( $pub_row['username'] == '' ) ? $lang['Guest'] : $pub_row['username'];
		}
		else
		{
			$author_name = $pub_row['username'];
			$temp_url = mx_append_sid(PROFILE_PATH."?action=viewprofile&amp;" . POST_USERS_URL . "=$author_id");
			$author_pub_art = '<a href="' . $temp_url . '" class="gensmall">' . $author_name . '</a>';
		}

		$views = '<b>' . $lang['Views'] . '</b> ' . $new_views;

		if ( $page_num == 0 )
		{
			$sql = "UPDATE " . PUB_ARTICLES_TABLE . " SET
				    views = '" . $new_views . "'
				    WHERE article_id = " . $article_id;
		}
		if ( !( $result2 = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not update article's views", '', __LINE__, __FILE__, $sql );
		}

		//
		// Edit buttons
		//
		if ( ( $userdata['user_id'] == $author_id && $this->auth_user[$article_category_id]['auth_edit'] ) || $this->auth_user[$article_category_id]['auth_mod'] )
		{
			$temp_url = mx_append_sid( $this->this_mxurl( "action=edit&amp;k=" . $article_id ) );
			$edit_img = '<a href="' . $temp_url . '"><img src="' . $images['pub_icon_edit'] . '" alt="' . $lang['Edit_article'] . '" title="' . $lang['Edit_article'] . '" border="0" /></a>';
			$edit = '<a href="' . $temp_url . '">' . $lang['Edit_article'] . '</a>';
		}
		else
		{
			$edit_img = '';
			$edit = '';
		}

		//
		// Delete buttons
		//
		if ( !defined('PUB_APP') && (( $userdata['user_id'] == $author_id && $this->auth_user[$article_category_id]['auth_delete'] ) || $this->auth_user[$article_category_id]['auth_mod'] ))
		{
			$temp_url = mx_append_sid( $this->this_mxurl( "action=edit&do=delete&k=" . $article_id ) );
			//$temp_url = str_replace('../', '',$temp_url); // Hack for App
			$delete_img = '<a href="javascript:delete_item(\'' . $temp_url . '\')"><img src="' . $images['pub_icon_delpost'] . '" alt="' . $lang['Delete_article'] . '" title="' . $lang['Delete_article'] . '" border="0" /></a>';
			$delete = '<a href="javascript:delete_item(\'' . $temp_url . '\')">' . $lang['Delete_article'] . '</a>';
		}
		else
		{
			$delete_img = '';
			$delete = '';
		}

		//
		// If this is an allowed article, go ahead and display it
		//
		if ( !$this->auth_user[$article_category_id]['auth_view'] || !$article_title || ( !$approved && !$this->auth_user[$article_category_id]['auth_mod'] ) )
		{
			$message = $lang['Article_not_exsist'] . '<br /><br />' . sprintf( $lang['Click_return_pub'], '<a href="' . mx_append_sid( $this->this_mxurl() ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_index'], '<a href="' . mx_append_sid( $phpbb_root_path . "index.$phpEx" ) . '">', '</a>' );
			mx_message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			//
			// Start output of page
			//
			if (!$print_version)
			{
				if ($this->reader_mode)
				{
					$template->set_filenames(array('body' => 'pub_article_reader.tpl'));
				}
				else if ($this->app_mode)
				{
					$template->set_filenames(array('body' => 'pub_article_app.tpl'));
				}
				else
				{
					$template->set_filenames(array('body' => 'pub_article_body.tpl'));
				}
			}
			else
			{
				$template->set_filenames( array( 'body' => 'pub_article_body_print.tpl' ) );
			}

			$print_url = mx_append_sid($this->this_mxurl("action=article&amp;k=" . $article_id ."&amp;page_num=".($page_num +1)."&amp;start=".$start ."&amp;print=true", false));

			$template->assign_vars(array(
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf($lang['Page_of'], (floor($start / $publisher_config['comments_pagination']) + 1), ceil($num_of_replies / $publisher_config['comments_pagination'])),
				'L_GOTO_PAGE' => $lang['Goto_page'],

				'L_ARTICLE_DESCRIPTION' => $lang['Article_description'],
				'L_ARTICLE_DATE' => $lang['Date'],
				'L_ARTICLE_TYPE' => $lang['Article_type'],
				'L_ARTICLE_CATEGORY' => $lang['Category'],
				'L_ARTICLE_AUTHOR' => $lang['Author'],
				'L_GOTO_PAGE' => $lang['Goto_page'],
				'L_TOC' => $lang['TOC'],
				'L_RATINGS' => $lang['Votes_label'],
				'L_COMMENTS' => $lang['Comments_show_title'],
				'L_PRINT' => $lang['Print_version'],

				'U_VIEW_CATEGORY' 	=> mx_append_sid($this->this_mxurl('action=category&amp;cat_id=' . $cat_id)),
				'U_VIEW_OLDER_ARTICLE'	=> mx_append_sid($this->this_mxurl("action=article&amp;k=$article_id&amp;t=$article_id&amp;view=previous")),
				'U_VIEW_NEWER_ARTICLE'	=> mx_append_sid($this->this_mxurl("action=article&amp;k=$article_id&amp;t=$article_id&amp;view=next")),

				'U_PRINT' => $print_url,
				'U_PRINT_ARTICLE'	=> mx_append_sid($this->this_mxurl("action=article&amp;k=" . $article_id ."&amp;page_num=".($page_num +1)."&amp;start=".$start ."&amp;view=print", true)),

				'ARTICLE_TITLE' => $article_title,
				'ARTICLE_AUTHOR' => $author_pub_art,
				'ARTICLE_CATEGORY' => $category,
				'ARTICLE_TEXT' => $article,
				'ARTICLE_DESCRIPTION' => $article_description,
				'ARTICLE_DATE' => $date,
				'ARTICLE_TYPE' => $article_type,

				'EDIT_IMG' => $edit_img,
				'DELETE_IMG' => $delete_img,
				'EDIT' => $edit,
				'DELETE' => $delete,
				'VIEWS' => $views,

				'T_TH_COLOR1' 	=> '#'.$theme['th_color1'],	// Border Colors (main)

				// Buttons
				'B_DELETE_IMG' => $mx_user->create_button('pub_icon_delpost', $lang['Delete_article'], "javascript:delete_item('". mx_append_sid($this->this_mxurl("action=edit&amp;do=delete&amp;k=" . $article_id)) . "')"),
				'B_EDIT_IMG' => $mx_user->create_button('pub_icon_edit', $lang['Edit_article'], mx_append_sid($this->this_mxurl("action=edit&amp;k=" . $article_id))),
			 ));

			//
			// article pages table of contents
			//
			if (count($art_pages) > 1)
			{
				$template->assign_block_vars('switch_toc', array());

				$i = 0;
				while ($i < count($art_pages))
				{
					$page_number = $i + 1;

					$art_split = explode('[toc]', $art_pages[$i]);
					$article_toc = trim($art_split[0]);

					$article_toc = preg_replace( "'\[[\/\!]*?[^\[\]]*?\]'si", "", $article_toc ); // Fixed
					$article_toc = $mx_text->display($article_toc, $mx_block->get_parameters( 'Text', MX_GET_PAR_OPTIONS ));
					$article_toc = strip_tags($article_toc);

					if( $page_num != $i )
					{
						$temp_url = mx_append_sid(PORTAL_URL . "index.php?page=$page_id&amp;action=article&amp;k=$article_id&amp;page_num=$page_number" . $xtra_dynamic);
						$page_link = '<a href="' . $temp_url . '" class="nav">' . $page_number . ' - ' . $article_toc . '</a>';
					}
					else
					{
						$page_link = $page_number . ' - ' . $article_toc;
					}

					if( $i < count($art_pages) - 1 )
					{
						$page_link .= '<br />';
					}

					$template->assign_block_vars('switch_toc.pages', array( 'TOC_ITEM' => $page_link));
					$i++;
				}
			}

			//
			// article pages TOC navigation
			//
			if (count($art_pages) > 1)
			{
				$template->assign_block_vars('switch_pages', array());

				$start_pag = $start > -1 ? "&start=" . $start : '';

				$i = 0;
				while ($i < count($art_pages))
				{
					$page_number = $i + 1;

					if ($page_num != $i)
					{
						if (!$print_version)
						{
							$temp_url = mx_append_sid($this->this_mxurl("action=article&k=$article_id&page_num=$page_number" . $start_pag . $original_highlight));
						}
						else
						{
							$temp_url = mx_append_sid($this->this_mxurl("action=article&k=$article_id&page_num=$page_number&print=true" . $start_pag . $original_highlight, true));
						}
						$page_link = '<a href="' . $temp_url . '" class="nav">' . $page_number . '</a>';
					}
					else
					{
						$page_link = $page_number;
					}

					if ( $i < count($art_pages) - 1 )
					{
						$page_link .= ', ';
					}

					$template->assign_block_vars( 'switch_pages.pages', array( 'PAGE_LINK' => $page_link ) );
					$i++;
				}
			}
		}

		//
		// Instantiate custom fields
		//
		$mx_pub_custom_field = new mx_custom_field(PUB_CUSTOM_TABLE, PUB_CUSTOM_DATA_TABLE);
		$mx_pub_custom_field->init();
		$mx_pub_custom_field->display_data($article_id);

		//
		// Ratings
		//
		if ( $this->ratings[$article_category_id]['activated'] )
		{
			$article_rating = ( $pub_row['rating'] != 0 ) ? round( $pub_row['rating'], 2 ) . '/10' : $lang['No_votes'];

			if ( $this->auth_user[$article_category_id]['auth_rate'] )
			{
				$rate_img = $images['pub_rate'];
			}

			$template->assign_block_vars( 'switch_ratings', array(
				'L_RATING' => $lang['Votes_label'],
				'L_RATE' => $lang['Rate'],
				'L_VOTES' => $lang['Votes'],
				'DO_RATE' => $this->auth_user[$article_category_id]['auth_rate'] ? $lang['ADD_RATING'] : '',
				'VOTES' => $pub_row['total_votes'],
				'RATING' => $article_rating,

				//
				// Allowed to rate
				//
				'RATE_IMG' => $rate_img,
				'U_RATE' => mx_append_sid( $this->this_mxurl( 'action=rate&k=' . $article_id ) ),

				// Buttons
				'B_RATE_IMG' => $mx_user->create_button('pub_rate', $lang['ADD_RATING'], mx_append_sid( $this->this_mxurl( 'action=rate&k=' . $article_id ) )),

			));
		}

		//
		// Comments
		//
		if ( $this->comments[$article_category_id]['activated'] && $this->auth_user[$article_category_id]['auth_view_comment'])
		{
			$comments_type = $this->comments[$article_category_id]['internal_comments'] ? 'internal' : 'phpbb';

			//
			// Instatiate comments
			//
			include_once( $module_root_path . 'publisher/core/functions_comment.' . $phpEx );
			$mx_pub_comments = new mx_pub_comments();
			$mx_pub_comments->init($pub_row, $comments_type);
			$mx_pub_comments->display_comments();
		}

		//
		// assign var for top navigation
		//
		$this->generate_navigation($article_category_id);

		//
		// User authorisation levels output
		//
		$this->auth_can($article_category_id);

		//
		// Get footer quick dropdown jumpbox
		//
		//$this->generate_jumpbox('auth_view', $article_category_id, $article_category_id, true);
		$this->generate_jumpbox(0, 0, array($article_category_id => 1));
		
		$publisher_functions->page_footer();
	}
}
?>