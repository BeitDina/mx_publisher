<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: functions_comment.php,v 1.33 2009/12/02 06:30:54 orynider Exp $
* @copyright (c) 2002-2006 [Mohd Basri, PHP Arena, FlorinCB, Jon Ohlsson] MX-Publisher Project Team
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
class publisher_comments extends mx_comments
{
	/**
	 * Init Comment vars.
	 *
	 * @param unknown_type $item_data
	 * @param unknown_type $comments_type
	 */
	function init($item_data, $comments_type = 'internal')
	{
		global $publisher, $mx_user, $publisher_config, $db, $images;

		if (!is_object($publisher) || empty($publisher_config))
		{
			mx_message_die(GENERAL_ERROR, 'Bad global arguments');
		}

		if (!is_array($item_data) && !empty($item_data))
		{
			$sql = 'SELECT *
				FROM ' . PUB_FILES_TABLE . "
				WHERE file_id = $item_data";

			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info', '', __LINE__, __FILE__, $sql );
			}

			$item_data = $db->sql_fetchrow( $result );
		}

		$this->comments_type = $comments_type == 'internal' ? 'internal' : 'phpbb';
		$this->cat_id = $item_data['file_catid'];
		$this->item_id = $item_data['file_id'];

		$this->topic_id = $item_data['topic_id'];

		$this->item_table = PUB_FILES_TABLE;
		$this->comments_table = PUB_COMMENTS_TABLE;
		$this->table_field_id = 'file_id';

		//
		// Auth
		//
		$this->forum_id = $publisher->modules[$publisher->module_name]->comments[$this->cat_id]['comments_forum_id'];

		$this->auth['auth_view'] = $publisher->modules[$publisher->module_name]->auth_user[$this->cat_id]['auth_view_comment'];
		$this->auth['auth_post'] = $publisher->modules[$publisher->module_name]->auth_user[$this->cat_id]['auth_post_comment'];
		$this->auth['auth_edit'] = $publisher->modules[$publisher->module_name]->auth_user[$this->cat_id]['auth_edit_comment'];
		$this->auth['auth_delete'] = $publisher->modules[$publisher->module_name]->auth_user[$this->cat_id]['auth_delete_comment'];
		$this->auth['auth_mod'] = $publisher->modules[$publisher->module_name]->auth_user[$this->cat_id]['auth_mod'];

		//
		// Pagination
		//
		$this->pagination_action = 'action=file';
		$this->pagination_target = 'file_id=';

		$this->pagination_num = empty($show_num_comments) ? $this->pagination_num : $show_num_comments;
		$this->u_pagination = $publisher->this_mxurl( $this->pagination_action . "&" . $this->pagination_target . $this->item_id  );

		//
		// Configs
		//
		$this->allow_wysiwyg = $publisher_config['allow_wysiwyg'];
		
		$this->allow_comment_wysiwyg = $publisher_config['allow_comment_wysiwyg'];
		$this->allow_comment_bbcode = $publisher_config['allow_comment_bbcode'];
		$this->allow_comment_html = $publisher_config['allow_comment_html'];
	 	$this->allow_comment_smilies = $publisher_config['allow_comment_smilies'];
	 	$this->allow_comment_links = $publisher_config['allow_comment_links'];
	 	$this->allow_comment_images = $publisher_config['allow_comment_images'];

	 	$this->no_comment_image_message = $publisher_config['no_comment_image_message'];
	 	$this->no_comment_link_message = $publisher_config['no_comment_link_message'];

		$this->max_comment_subject_chars = $publisher_config['max_comment_subject_chars'];
		$this->max_comment_chars = $publisher_config['max_comment_chars'];

		$this->formatting_comment_truncate_links = $publisher_config['formatting_comment_truncate_links'];
		$this->formatting_comment_image_resize = $publisher_config['formatting_comment_image_resize'];
		$this->formatting_comment_wordwrap = $publisher_config['formatting_comment_wordwrap'];
		
		//overwrite some phpBB3 vars
		$images['pub_icon_delpost'] = $mx_user->img('icon_post_delete', 'DELETE_POST', false, '', 'src');
		$images['pub_icon_edit'] = $mx_user->img('icon_post_edit', 'EDIT_POST', false, '', 'src');
		$images['pub_icon_minipost'] = $mx_user->img('icon_post_target', '', false, '', 'src');
		$images['pub_icon_latest_reply'] = $mx_user->img('icon_topic_latest', '', false, '', 'src');
		$images['pub_icon_newest_reply'] = $mx_user->img('icon_newest_reply', '', false, '', 'src');		

		//
		// Define comments images
		//
		$this->images = array(
			'icon_minipost' => $images['pub_icon_minipost'],
			'icon_latest_reply' => $images['pub_icon_latest_reply'],
			//'comment_post' => $images['pub_comment_post'],
			'comment_post' => 'pub_comment_post', // Button
			//'icon_edit' => $images['pub_comment_edit'],
			'icon_edit' => 'pub_icon_edit', // Button
			//'icon_delpost' => $images['pub_comment_delete'],
			'icon_delpost' => 'pub_icon_delpost', // Button
			'moderator' => 'pub_moderator'
		);

		$this->u_post = $publisher->this_mxurl( 'action=post_comment&item_id=' . $this->item_id . '&cat_id=' . $this->cat_id);
		$this->u_edit = $publisher->this_mxurl( 'action=post_comment&item_id=' . $this->item_id . '&cat_id=' . $this->cat_id );
		$this->u_delete = $publisher->this_mxurl( "action=post_comment&delete=do&item_id=".$this->item_id . '&cat_id=' . $this->cat_id );

	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ranks
	 */
	function obtain_ranks( &$ranks )
	{
		global $db, $publisher_cache;

		if (PORTAL_BACKEND != 'internal')
		{
			if ( $publisher_cache->exists( 'ranks' ) )
			{
				$ranks = $publisher_cache->get( 'ranks' );
			}
			else
			{
				$sql = "SELECT *
					FROM " . RANKS_TABLE . "
					ORDER BY rank_special, rank_min";

				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql );
				}

				$ranks = array();
				while ( $row = $db->sql_fetchrow( $result ) )
				{
					$ranks[] = $row;
				}

				$db->sql_freeresult( $result );
				$publisher_cache->put( 'ranks', $ranks );
			}
		}
	}
}
?>