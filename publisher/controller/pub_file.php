<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: pub_file.php,v 1.29 2009/12/02 03:49:01 orynider Exp $
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
class publisher_file extends publisher_public
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $action
	 */
	function main($action  = false)
	{
		global $template, $lang, $board_config, $phpEx, $publisher_config, $images;
		global $phpbb_root_path, $userdata, $db, $publisher_functions, $mx_user;
		global $mx_root_path, $module_root_path, $is_block, $mx_request_vars;

		// =======================================================
		// Request vars
		// =======================================================
		$start = $mx_request_vars->get('start', MX_TYPE_INT, 0);
		$file_id = $mx_request_vars->request('file_id', MX_TYPE_INT, '');
		$page_num = $mx_request_vars->request('page_num', MX_TYPE_INT, 1) - 1;

		if ( empty( $file_id ) )
		{
			mx_message_die( GENERAL_MESSAGE, $lang['File_not_exist'] );
		}

		// =======================================================
		// =======================================================
		switch ( SQL_LAYER )
		{
			case 'oracle':
				$sql = "SELECT f.*, AVG(r.rate_point) AS rating, COUNT(r.votes_file) AS total_votes, u.user_id, u.username, cat.cat_allow_ratings, cat.cat_allow_comments
					FROM " . PUB_FILES_TABLE . " AS f, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_CATEGORY_TABLE . " AS cat
					WHERE f.file_id = r.votes_file(+)
					AND f.user_id = u.user_id(+)
					AND f.file_id = $file_id
					AND f.file_approved = 1
					AND f.file_catid = cat.cat_id
					GROUP BY f.file_id ";
			break;

			default:
				$sql = "SELECT f.*, AVG(r.rate_point) AS rating, COUNT(r.votes_file) AS total_votes, u.user_id, u.username, cat.cat_allow_ratings, cat.cat_allow_comments
					FROM " . PUB_FILES_TABLE . " AS f 
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON f.file_id = r.votes_file
						LEFT JOIN " . USERS_TABLE . " AS u ON f.user_id = u.user_id
						LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON f.file_catid = cat.cat_id
						LEFT JOIN " . PUB_ARTICLES_TABLE . " AS t ON t.article_category_id = cat.cat_id
					WHERE f.file_id = $file_id
					AND f.file_approved = 1
					GROUP BY f.file_id ";
			break;
		}

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query file info', '', __LINE__, __FILE__, $sql );
		}

		// ===================================================
		// file doesn't exist'
		// ===================================================
		if ( !$file_data = $db->sql_fetchrow( $result ) )
		{
			mx_message_die( GENERAL_MESSAGE, $lang['File_not_exist'] );
		}
		$db->sql_freeresult( $result );

		// ===================================================
		// mx_pafiledb auth for viewing file
		// ===================================================
		if ( ( !$this->auth_user[$file_data['file_catid']]['auth_view_file'] ) )
		{
			if ( !$mx_user->data['session_logged_in'] )
			{
				//mx_redirect(mx_append_sid($mx_root_path . "login.$phpEx?redirect=".$this->this_mxurl("action=file&file_id=" . $file_id), true));
			}
			$message = sprintf( $lang['Sorry_auth_view'], $this->auth_user[$file_data['file_catid']]['auth_view_file_type'] );
			mx_message_die( GENERAL_MESSAGE, $message );
		}

		$template->assign_vars( array(
			'L_INDEX' => "<<",

			'U_INDEX' => mx_append_sid( $mx_root_path . 'index.' . $phpEx ),
			'U_PROJECTS_HOME' => mx_append_sid( $this->this_mxurl() ),

			'FILE_NAME' => $file_data['file_name'],
			'PROJECTS' => $publisher_config['module_name']
		));

		// ===================================================
		// Prepare file info to display them
		// ===================================================
		$file_time = mx_create_date( $board_config['default_dateformat'], $file_data['file_time'], $board_config['board_timezone'] );
		$file_last_download = ( $file_data['file_last'] ) ? mx_create_date( $board_config['default_dateformat'], $file_data['file_last'], $board_config['board_timezone'] ) : $lang['never'];
		$file_update_time = ( $file_data['file_update_time'] ) ? mx_create_date( $board_config['default_dateformat'], $file_data['file_update_time'], $board_config['board_timezone'] ) : $lang['never'];
		$file_author = trim( $file_data['file_creator'] );
		$file_version = trim( $file_data['file_version'] );
		$file_screenshot_url = trim( $file_data['file_ssurl'] );
		$file_website_url = trim( $file_data['file_docsurl'] );
		$file_download_link = ( $file_data['file_license'] > 0 ) ? mx_append_sid( $this->this_mxurl( 'action=license&license_id=' . $file_data['file_license'] . '&file_id=' . $file_id ) ) : mx_append_sid( $this->this_mxurl( 'action=download&file_id=' . $file_id, 1 ) );
		$file_size = $publisher_functions->get_file_size( $file_id, $file_data );

		$file_poster = ( $file_data['user_id'] != ANONYMOUS ) ? '<a href="' . mx_append_sid( $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $file_data['user_id'] ) . '">' : '';
		$file_poster .= ( $file_data['user_id'] != ANONYMOUS ) ? $file_data['username'] : $lang['Guest'];
		$file_poster .= ( $file_data['user_id'] != ANONYMOUS ) ? '</a>' : '';

		if ( !MXBB_MODULE )
		{
			$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
			$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
			$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
			$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
			$false_phpbb_url = $server_protocol . $server_name . $server_port . '/';
			$false_phpbb_path = './';
			$file_screenshot_url = str_replace($false_phpbb_url . $false_phpbb_path, PORTAL_URL, $file_screenshot_url);
		}

		//
		// Disabled file
		//
		if ($file_data['file_disable'])
		{
			$file_download_link = 'javascript:disable_popup()';
		}
		
		//overwrite some phpBB3 vars
		$images['pub_icon_delpost'] = $publisher_functions->img('icon_post_delete', 'DELETE_POST', false, '', 'src');
		$images['pub_icon_edit'] = $publisher_functions->img('icon_post_edit', 'EDIT_POST', false, '', 'src');

		$template->assign_vars( array(
			'L_CLICK_HERE' => $lang['Click_here'],
			'L_AUTHOR' => $lang['Creator'],
			'L_VERSION' => $lang['Version'],
			'L_SCREENSHOT' => $lang['Scrsht'],
			'L_WEBSITE' => $lang['Docs'],
			'L_FILE' => $lang['File'],
			'L_DESC' => $lang['Desc'],
			'L_DATE' => $lang['Date'],
			'L_UPDATE_TIME' => $lang['Update_time'],
			'L_LASTTDL' => $lang['Lastdl'],
			'L_DLS' => $lang['Dls'],
			'L_SIZE' => $lang['File_size'],
			'L_EDIT' => $lang['Editfile'],
			'L_DELETE' => $lang['Deletefile'],
			'L_PROJECTS' => $lang['Downloadfile'],
			'L_EMAIL' => $lang['Emailfile'],
			'L_SUBMITED_BY' => $lang['Submiter'],

			'SHOW_AUTHOR' => ( !empty( $file_author ) ) ? true : false,
			'SHOW_VERSION' => ( !empty( $file_version ) ) ? true : false,
			'SHOW_SCREENSHOT' => ( !empty( $file_screenshot_url ) ) ? true : false,
			'SHOW_WEBSITE' => ( !empty( $file_website_url ) ) ? true : false,
			'SS_AS_LINK' => ( $file_data['file_sshot_link'] ) ? true : false,
			'FILE_NAME' => $file_data['file_name'],
			'FILE_LONGDESC' => nl2br( $file_data['file_longdesc'] ),
			'FILE_SUBMITED_BY' => $file_poster,
			'FILE_AUTHOR' => $file_author,
			'FILE_VERSION' => $file_version,
			'FILE_SCREENSHOT' => $file_screenshot_url,
			'FILE_WEBSITE' => $file_website_url,
			'FILE_DISABLE_MSG' => nl2br( $file_data['disable_msg'] ),

			'AUTH_EDIT' => ( ( $this->auth_user[$file_data['file_catid']]['auth_edit_file'] && $file_data['user_id'] == $userdata['user_id'] ) || $this->auth_user[$file_data['file_catid']]['auth_mod'] ) ? true : false,
			'AUTH_DELETE' => ( ( $this->auth_user[$file_data['file_catid']]['auth_delete_file'] && $file_data['user_id'] == $userdata['user_id'] ) || $this->auth_user[$file_data['file_catid']]['auth_mod'] ) ? true : false,
			'AUTH_PROJECTS' => ( $this->auth_user[$file_data['file_catid']]['auth_download'] ) ? true : false,
			'AUTH_EMAIL' => ( $this->auth_user[$file_data['file_catid']]['auth_email'] ) ? true : false,

			'DELETE_IMG' => $images['pub_icon_delpost'],
			'EDIT_IMG' => $images['pub_icon_edit'],
			'PROJECTS_IMG' => $images['pub_download'],
			'EMAIL_IMG' => $images['pub_email'],

			'TIME' => $file_time,
			'UPDATE_TIME' => ( $file_data['file_update_time'] != $file_data['file_time'] ) ? $file_update_time : $lang['never'],
			'FILE_DLS' => intval( $file_data['file_dls'] ),
			'FILE_SIZE' => $file_size,
			'LAST' => $file_last_download,

			'U_PROJECTS' => $file_download_link,
			'U_DELETE' => mx_append_sid( $this->this_mxurl( 'action=user_upload&do=delete&file_id=' . $file_id ) ),
			'U_EDIT' => mx_append_sid( $this->this_mxurl( 'action=user_upload&file_id=' . $file_id ) ),
			'U_EMAIL' => mx_append_sid( $this->this_mxurl( 'action=email&file_id=' . $file_id ) ),

			// Buttons
			'B_PROJECTS_IMG' => $mx_user->create_button('pub_download', $lang['Downloadfile'], $file_download_link),
			'B_DELETE_IMG' => $mx_user->create_button('pub_icon_delpost', $lang['Deletefile'], "javascript:delete_item('". mx_append_sid( $this->this_mxurl( 'action=user_upload&do=delete&file_id=' . $file_id )) . "')"),
			'B_EDIT_IMG' => $mx_user->create_button('pub_icon_edit', $lang['Editfile'], mx_append_sid( $this->this_mxurl( 'action=user_upload&file_id=' . $file_id ) )),
			'B_EMAIL_IMG' => $mx_user->create_button('pub_email', $lang['Emailfile'], mx_append_sid( $this->this_mxurl( 'action=email&file_id=' . $file_id ))),
		));

		$custom_field = new mx_custom_field(PUB_CUSTOM_TABLE, PUB_CUSTOM_DATA_TABLE);
		$custom_field->init();
		$custom_field->display_data($file_id);

		//
		// Ratings
		//
		if ( $this->ratings[$file_data['file_catid']]['activated'] )
		{
			$file_rating = ( $file_data['rating'] != 0 ) ? round( $file_data['rating'], 2 ) . '/10' : $lang['Not_rated'];

			if ( $this->auth_user[$file_data['file_catid']]['auth_rate'] )
			{
				$rate_img = $images['pub_rate'];
			}

			$template->assign_block_vars( 'use_ratings', array(
				'L_RATING' => $lang['DlRating'],
				'L_RATE' => $lang['Rate'],
				'L_VOTES' => $lang['Votes'],
				'FILE_VOTES' => $file_data['total_votes'],
				'RATING' => $file_rating,

				//
				// Allowed to rate
				//
				'RATE_IMG' => $rate_img,
				'U_RATE' => mx_append_sid( $this->this_mxurl( 'action=rate&file_id=' . $file_id ) ),

				// Buttons
				'B_RATE_IMG' => $mx_user->create_button('pub_rate', $lang['Rate'], mx_append_sid( $this->this_mxurl( 'action=rate&file_id=' . $file_id ) )),

			));
		}

		//
		// Comments
		//
		if ( $this->comments[$file_data['file_catid']]['activated'] && $this->auth_user[$file_data['file_catid']]['auth_view_comment'])
		{
			$comments_type = $this->comments[$file_data['file_catid']]['internal_comments'] ? 'internal' : 'phpbb';

			//
			// Instatiate comments
			//
			include_once( $module_root_path . 'publisher/core/functions_comment.' . $phpEx );
			$publisher_comments = new publisher_comments();
			$publisher_comments->init( $file_data, $comments_type );
			$publisher_comments->display_comments();
		}

		// ===================================================
		// assign var for navigation
		// ===================================================
		$this->generate_navigation( $file_data['file_catid'] );

		//
		// User authorisation levels output
		//
		$this->auth_can($file_data['file_catid']);

		//
		// Output all
		//
		$this->display( $lang['Download'], 'pub_file_body.tpl' );
	}
}
?>