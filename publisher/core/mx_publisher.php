<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: mx_publisher.php,v 1.67 2013/10/03 10:05:44 orynider Exp $
* @copyright (c) 2002-2006 [Mohd Basri, PHP Arena, FlorinCB, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//namespace mx_publisher\publisher\core;

if ( !defined( 'IN_PORTAL' ) )
{
	die("Hacking attempt");
}

/**
 * publisher class
 *
 */
//class mx_publisher extends \mx_publisher\publisher\core\mx_publisher_auth
class mx_publisher extends mx_publisher_auth
{
	var $cat_rowset = array();
	var $subcat_rowset = array();
	var $total_cat = 0;

	var $comments = array();
	var $ratings = array();
	var $information = array();
	var $notification = array();

	var $modified = false;
	var $error = array();

	var $page_title = '';
	var $jumpbox = '';
	var $auth_can_list = '';
	var $navigation = '';

	var $debug = false; // Toggle debug output on/off
	var $debug_msg = array();

	//
	// mx_pub specific
	//
	var $sort_method = '';
	var $sort_method_extra = '';
	var $sort_order = '';

	var $reader_mode = false;
	/**
	 * Prepare data.
	 *
	 */
	function __construct()
	{
		global $db, $userdata, $mx_request_vars, $debug, $publisher_config, $mx_root_path, $module_root_path, $phpEx;

		$this->debug('mx_pub->__construct', basename( __FILE__ ));
		$this->db = $db;
		$this->request = $mx_request_vars;
		$this->mx_root_path = $mx_root_path;
		$this->module_root_path = $module_root_path;
		$this->php_ext = $phpEx;
		$this->init();
	}
	
	/**
	 * Prepare data.
	 *
	 */
	function init()
	{
		global $db, $userdata, $debug, $publisher_config;

		unset( $this->cat_rowset );
		unset( $this->subcat_rowset );
		unset( $this->comments );
		unset( $this->ratings );
		unset( $this->information );
		unset( $this->notification );

		$sql = 'SELECT *
			FROM ' . PUB_CATEGORY_TABLE . '
			ORDER BY cat_order ASC';

		if ( !($result = $db->sql_query($sql)))
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query categories info', '', __LINE__, __FILE__, $sql );
		}
		$cat_rowset = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		$this->auth($cat_rowset);

		for ($i = 0; $i < count($cat_rowset); $i++)
		{
			if ($this->auth_user[$cat_rowset[$i]['cat_id']]['auth_view'])
			{
				$this->cat_rowset[$cat_rowset[$i]['cat_id']] = $cat_rowset[$i];
				$this->subcat_rowset[$cat_rowset[$i]['cat_parent']][$cat_rowset[$i]['cat_id']] = $cat_rowset[$i];
				$this->total_cat++;
				
				//
				// Comments
				// Note: some settings are category dependent, but may use default config settings
				//
				$this->comments[$cat_rowset[$i]['cat_id']]['activated'] = $cat_rowset[$i]['cat_allow_comments'] == -1 ? ($publisher_config['use_comments'] == 1 ? true : false ) : ( $cat_rowset[$i]['cat_allow_comments'] == 1 ? true : false );

				switch($this->portal_config['portal_backend'])
				{
					case 'internal':
						$this->comments[$cat_rowset[$i]['cat_id']]['internal_comments'] = true; // phpBB or internal comments
						$this->comments[$cat_rowset[$i]['cat_id']]['autogenerate_comments'] = false; // autocreate comments when updated
						$this->comments[$cat_rowset[$i]['cat_id']]['comments_forum_id'] = 0; // phpBB target forum (only used for phpBB comments)
					break;

					default:
						$this->comments[$cat_rowset[$i]['cat_id']]['internal_comments'] = $cat_rowset[$i]['internal_comments'] == -1 ? ($publisher_config['internal_comments'] == 1 ? true : false ) : ( $cat_rowset[$i]['internal_comments'] == 1 ? true : false ); // phpBB or internal comments
						$this->comments[$cat_rowset[$i]['cat_id']]['autogenerate_comments'] = $cat_rowset[$i]['autogenerate_comments'] == -1 ? ($publisher_config['autogenerate_comments'] == 1 ? true : false ) : ( $cat_rowset[$i]['autogenerate_comments'] == 1 ? true : false ); // autocreate comments when updated
						$this->comments[$cat_rowset[$i]['cat_id']]['comments_forum_id'] = $cat_rowset[$i]['comments_forum_id'] < 1 ? ( intval($publisher_config['comments_forum_id']) ) : ( intval($cat_rowset[$i]['comments_forum_id']) ); // phpBB target forum (only used for phpBB comments)
					break;
				}

				if ($this->comments[$cat_rowset[$i]['cat_id']]['activated'] && !$this->comments[$cat_rowset[$i]['cat_id']]['internal_comments'] && intval($this->comments[$cat_rowset[$i]['cat_id']]['comments_forum_id']) < 1)
				{
					if ( !defined( 'IN_ADMIN' ) )
					{
						mx_message_die(GENERAL_ERROR, 'Init Failure, phpBB comments with no target forum_id :( <br> Category: ' . $cat_rowset[$i]['cat_name'] . ' Forum_id: ' . $this->comments[$cat_rowset[$i]['cat_id']]['comments_forum_id']);
					}
					else
					{
						print('Init Failure, phpBB comments with no target forum_id :( <br> Category: ' . $cat_rowset[$i]['cat_name'] . ' Forum_id: ' . $this->comments[$cat_rowset[$i]['cat_id']]['comments_forum_id']);
					}
				}

				//
				// Ratings
				//
				$this->ratings[$cat_rowset[$i]['cat_id']]['activated'] = $cat_rowset[$i]['cat_allow_ratings'] == -1 ? ($publisher_config['use_ratings'] == 1 ? true : false ) : ( $cat_rowset[$i]['cat_allow_ratings'] == 1 ? true : false );

				//
				// Information
				//
				$this->information[$cat_rowset[$i]['cat_id']]['activated'] = $cat_rowset[$i]['show_pretext'] == -1 ? ($publisher_config['show_pretext'] == 1 ? true : false ) : ( $cat_rowset[$i]['show_pretext'] == 1 ? true : false ); // phpBB or internal ratings

				//
				// Notification
				//
				$this->notification[$cat_rowset[$i]['cat_id']]['activated'] = $cat_rowset[$i]['notify'] == -1 ? (intval($publisher_config['notify'])) : ( intval($cat_rowset[$i]['notify']) ); // -1, 0, 1, 2
				$this->notification[$cat_rowset[$i]['cat_id']]['notify_group'] = $cat_rowset[$i]['notify_group'] == -1 || $cat_rowset[$i]['notify_group'] == 0 ? (intval($publisher_config['notify_group'])) : ( intval($cat_rowset[$i]['notify_group']) ); // Group_id
			}
		}
		
		$this->sort_order = $publisher_config['sort_order'];

		switch ( $publisher_config['sort_method'] )
		{
			case 'Id':
				$this->sort_method = 't.article_id';
				$this->sort_method_extra = 't.article_type' . " DESC, " ;
			break;
			case 'Latest':
				$this->sort_method = 't.article_date';
				$this->sort_method_extra = 't.article_type' . " DESC, " ;
			break;
			case 'Toprated':
				$this->sort_method = 'rating';
				$this->sort_method_extra = 't.article_type' . " DESC, " ;
			break;
			case 'Most_popular':
				$this->sort_method = 't.views';
				$this->sort_method_extra = 't.article_type' . " DESC, " ;
			break;
			case 'Userrank':
				$this->sort_method = 'u.user_rank';
				$this->sort_method_extra = 't.article_type' . " DESC, " ;
			break;
			case 'Alphabetic':
				$this->sort_method = 't.article_title';
				$this->sort_method_extra = 't.article_type' . " DESC, " ;
			break;
		}

		$this->reader_mode = $publisher_config['reader_mode'];
		$this->app_mode = $publisher_config['app_mode'];
	}

	/**
	 * Clean up
	 *
	 */
	function _publisher()
	{
		if ( $this->modified )
		{
			$this->sync_all();
		}
	}

	/**
	 * Add debug message.
	 *
	 * @param unknown_type $debug_msg
	 * @param unknown_type $file
	 * @param unknown_type $line_break
	 */
	function debug($debug_msg, $file = '', $line_break = true)
	{
		if ($this->debug)
		{
			$module_name = !empty($this->module_name) ? $this->module_name . ' :: ' : '';
			$file = !empty($file) ? ' (' . $file . ')' : '';
			$line_break = $line_break ? '<br>' : '';
			$this->debug_msg[] = $line_break . $module_name . $debug_msg . $file ;
		}
	}

	/**
	 * Display debug message.
	 *
	 * @return unknown
	 */
	function display_debug()
	{
		if ($this->debug)
		{
			$debug_message = '';
			foreach ($this->debug_msg as $key => $value)
			{
				$debug_message .= $value;
			}

			return $debug_message;
		}
	}

	/**
	 * Sync All.
	 *
	 */
	function sync_all()
	{
		foreach( $this->cat_rowset as $cat_id => $void )
		{
			$this->sync( $cat_id, false );
		}
		$this->init();
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cat_id
	 * @param unknown_type $init
	 */
	function sync($cat_id, $init = true)
	{
		global $db;

		$cat_nav = array();
		$this->category_nav( $this->cat_rowset[$cat_id]['cat_parent'], $cat_nav );

		$sql = 'UPDATE ' . PUB_CATEGORY_TABLE . "
			SET parents_data = ''
			WHERE cat_parent = " . $this->cat_rowset[$cat_id]['cat_parent'];

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query categories info', '', __LINE__, __FILE__, $sql );
		}

		$sql = 'UPDATE ' . PUB_CATEGORY_TABLE . "
				SET cat_files = '-1',
				cat_last_file_id = '0',
				cat_last_file_name = '',
				cat_last_file_time = '0'
				WHERE cat_id = '" . $cat_id . "'";
				
		/*
		//This is for later implementation
		
		$cat_data = array(
				'cat_files'			=> (int) 1,
				'cat_last_file_id'	=> (int) 0,
				'cat_last_file_time'=> (int) 0,
		);

		$sql = "UPDATE " . PUB_CATEGORY_TABLE . " 
				SET " . $db->sql_build_array('UPDATE', $cat_data) . "
				WHERE cat_id = '" . $cat_id . "'";				
		*/
		
		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query categories info', '', __LINE__, __FILE__, $sql );
		}
		if ( $init )
		{
			$this->init();
		}
		return;
	}
	
	/**
	 * Dummy function
	 */
	function message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
	{		
		//
		// Get SQL error if we are debugging. Do this as soon as possible to prevent
		// subsequent queries from overwriting the status of sql_error()
		//
		if (DEBUG && ($msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR))
		{
				
			if ( isset($sql) )
			{
				//$sql_error = array(@print_r(@$this->db->sql_error($sql)));
				$sql_error['message'] = $sql_error['message'] ? $sql_error['message'] : '<br /><br />SQL : ' . $sql; 
				$sql_error['code'] = $sql_error['code'] ? $sql_error['code'] : 0;
			}
			else
			{
				$sql_error = array(@print_r(@$this->db->sql_error_returned));
				$sql_error['message'] = $sql_error['message'] ? $sql_error['message'] : '<br /><br />SQL : ' . $sql; 
				$sql_error['code'] = $sql_error['code'] ? $sql_error['code'] : 0;
			}			
			
			$debug_text = '';

			if ( isset($sql_error['message']) )
			{
				$debug_text .= '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
			}

			if ( isset($sql_store) )
			{
				$debug_text .= "<br /><br />$sql_store";
			}

			if ( isset($err_line) && isset($err_file) )
			{
				$debug_text .= '</br /><br />Line : ' . $err_line . '<br />File : ' . $err_file;
			}
		}		
		
		switch($msg_code)
		{
			case GENERAL_MESSAGE:
				if ( $msg_title == '' )
				{
					$msg_title = $this->user->lang('Information');
				}
			break;

			case CRITICAL_MESSAGE:
				if ( $msg_title == '' )
				{
					$msg_title = $this->user->lang('Critical_Information');
				}
			break;

			case GENERAL_ERROR:
				if ( $msg_text == '' )
				{
					$msg_text = $this->user->lang('An_error_occured');
				}

				if ( $msg_title == '' )
				{
					$msg_title = $this->user->lang('General_Error');
				}
			break;

			case CRITICAL_ERROR:

				if ($msg_text == '')
				{
					$msg_text = $this->user->lang('A_critical_error');
				}

				if ($msg_title == '')
				{
					$msg_title = 'phpBB : <b>' . $this->user->lang('Critical_Error') . '</b>';
				}
			break;
		}
		
		//
		// Add on DEBUG info if we've enabled debug mode and this is an error. This
		// prevents debug info being output for general messages should DEBUG be
		// set TRUE by accident (preventing confusion for the end user!)
		//
		if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
		{
			if ( $debug_text != '' )
			{
				$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b> ' . $debug_text;
			}
		}		
		
		trigger_error($msg_title . ': ' . $msg_text);
	}  
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $parent_id
	 * @param unknown_type $cat_nav
	 */
	function category_nav($parent_id, $cat_nav)
	{
		if ( !empty( $this->cat_rowset[$parent_id] ) )
		{
			$this->category_nav( $this->cat_rowset[$parent_id]['cat_parent'], $cat_nav );
			$cat_nav[$parent_id] = $this->cat_rowset[$parent_id]['cat_name'];
		}
		return;
	}

	/**
	 * if there is no cat
	 *
	 * @return unknown
	 */
	function cat_empty()
	{
		return ( $this->total_cat == 0 ) ? true : false;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $true_false
	 */
	function modified( $true_false = false )
	{
		$this->modified = $true_false;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cat_id
	 * @return unknown
	 */
	function items_in_cat($cat_id)
	{
		$this->debug('mx_pub->items_in_cat', basename( __FILE__ ));

		if ( $this->cat_rowset[$cat_id]['number_articles'] == -1 || $this->modified )
		{
			global $db;

			$sql = 'SELECT COUNT(article_id) as total
				FROM ' . PUB_ARTICLES_TABLE . "
				WHERE approved = '1'
				AND article_category_id IN (" . $this->gen_cat_ids($cat_id) . ')
				ORDER BY article_date DESC';
			if ( !( $result = $db->sql_query($sql) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query Articles info', '', __LINE__, __FILE__, $sql );
			}

			$number_of_items = 0;
			if ( $row = $db->sql_fetchrow( $result ) )
			{
				$number_of_items = $row['total'];
			}

			$sql = 'UPDATE ' . PUB_CATEGORIES_TABLE . "
					SET number_articles = $number_of_items
					WHERE category_id = $cat_id";

			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query Files info', '', __LINE__, __FILE__, $sql );
			}
		}
		else
		{
			$number_of_items = $this->cat_rowset[$cat_id]['number_articles'];
		}

		return $number_of_items;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cat_id
	 * @return unknown
	 */
	function files_in_cat($cat_id)
	{
		if ( $this->cat_rowset[$cat_id]['cat_files'] == -1 || $this->modified )
		{
			global $db;

			$sql = 'SELECT COUNT(file_id) as total_articless
				FROM ' . PUB_FILES_TABLE . "
				WHERE file_approved = '1'
				AND file_catid IN (" . $this->gen_cat_ids( $cat_id ) . ')
				ORDER BY file_time DESC';

			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query Files info', '', __LINE__, __FILE__, $sql );
			}

			$number_of_items = 0;
			if ( $row = $db->sql_fetchrow( $result ) )
			{
				$number_of_items = $row['total_articless'];
			}

			$sql = 'UPDATE ' . PUB_CATEGORY_TABLE . "
					SET cat_files = $number_of_items
					WHERE cat_id = $cat_id";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query Files info', '', __LINE__, __FILE__, $sql );
			}
		}
		else
		{
			$number_of_items = $this->cat_rowset[$cat_id]['cat_files'];
		}

		return $number_of_items;
	}

	/**
	 * Jump menu function.
	 * 
	 * @param unknown_type $cat_id to handle parent cat_id
	 * @param unknown_type $depth related to function to generate tree
	 * @param unknown_type $default the cat you wanted to be selected
	 * @param unknown_type $for_file TRUE high category ids will be -1
	 * @param unknown_type $check_upload if true permission for upload will be checked
	 * @return unknown
	 */
	function generate_jumpbox($cat_id = 0, $depth = 0, $default = '', $for_file = false, $check_upload = true, $auth = 'auth_view' )
	{
		global $page_id;
		//static $cat_rowset = false;

		if (!is_array($cat_rowset))
		{
			if ($check_upload)
			{
				if (!empty($this->cat_rowset))
				{
					foreach($this->cat_rowset as $row)
					{
						if ($this->auth_user[$row['cat_id']][$auth])
						{
							$cat_rowset[$row['cat_id']] = $row;
						}
					}
				}
			}
			else
			{
				$cat_rowset = $this->cat_rowset;
			}
		}

		$cat_list .= '';

		$pre = str_repeat( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth );

		$temp_cat_rowset = $cat_rowset;

		if (!empty($temp_cat_rowset))
		{
			foreach ($temp_cat_rowset as $temp_cat_id => $cat)
			{
				if ($cat['cat_parent'] == $cat_id)
				{
					if (is_array($default))
					{
						if (isset($default[$cat['cat_id']]))
						{
							$sel = ' selected="selected"';
						}
						else
						{
							$sel = '';
						}
					}
			
					global $publisher_config;
			
					$start = $this->request->get('start', MX_TYPE_INT, 0);
					$sort_method = isset($_REQUEST['sort_method']) ? $_REQUEST['sort_method'] : $publisher_config['sort_method'];
					$sort_order = isset($_REQUEST['sort_order']) ? $_REQUEST['sort_order'] : $publisher_config['sort_order'];
			
					$cat_pre = (!$cat['cat_allow_file']) ? '+ ' : '- ';
					$sub_cat_id = ($for_file) ? ((!$cat['cat_allow_file']) ? -1 : $cat['cat_id']) : $cat['cat_id'];
					$cat_class = (!$cat['cat_allow_file']) ? 'class="greyed"' : '';
					$cat_list .= '<option value="' . $sub_cat_id . '"' . $sel . ' ' . $cat_class . ' />' . $pre . $cat_pre . $cat['cat_name'] . '</option>';
					
					//action=user_upload, edit
					$action_user_upload = ( $this->request->is_get('action') && ($this->request->request('action', '') == 'user_upload' || $this->request->request('action', '') == 'edit') ) ? true : false; 
					
					if ($action_user_upload == true)
					{
						$this->init_items($sort_method, $sort_order, $start, $cat['cat_id']);
				
						$article_rowset = $this->article_rowset;
				
						if (count($article_rowset) > 0)
						{
							$articlelist = $filelist = true;
							for ($i = 1; $i < count($article_rowset); $i++)
							{
								$article_id = $article_rowset[$i]['article_id'];
								$views = $article_rowset[$i]['views'];

								$article_title = $article_rowset[$i]['article_title'];
								$article_description = $article_rowset[$i]['article_description'] ;
								$article_cat_id = $article_rowset[$i]['article_category_id'];
								$article_approved = $article_rowset[$i]['approved'];
								
								$cat_list .= ($article_cat_id == $cat['cat_id']) ? '<option value="' . $article_cat_id . '"' . $sel . ' ' . $cat_class . ' />' . $pre . $cat_pre . $article_title . '</option>' : '';
							}
						}
					}
					$cat_list .= $this->generate_jumpbox($cat['cat_id'], $depth + 1, $default, $for_file, $check_upload);
				}
			}
			return $cat_list;
		}
		else
		{
			return;
		}
	}

	/**
	 * get_sub_cat.
	 *
	 * get all sub category in side certain category
	 * - used when listing files/articles/links etc
	 *
	 * @param unknown_type $cat_id
	 * @return unknown
	 */
	function get_sub_cat( $cat_id )
	{
		global $mx_root_path, $module_root_path, $is_block, $phpEx;

		$cat_sub = '';
		if ( !empty( $this->subcat_rowset[$cat_id] ) )
		{
			$class = "gensmall";
			$init_link_max = ( count( $this->subcat_rowset[$cat_id] ) > 3 ) ? 3 : count( $this->subcat_rowset[$cat_id] );
			$truncate = false;
			$i = 0;
			foreach( $this->subcat_rowset[$cat_id] as $cat_id => $cat_row )
			{
				if ( $this->auth_user[$cat_row['cat_id']]['auth_view'] && ( $cat_row['cat_allow_file'] || !empty( $this->subcat_rowset[$cat_row['cat_id']] ) ) )
				{
					$i++;
					if ($i > $init_link_max)
					{
						$truncate = true;
						break;
					}
					$cat_sub .= (!empty($cat_sub) ? '<span class=' . $class . '>, </span>' : '') . '<a href="' . mx_append_sid( $this->this_mxurl( 'action=category&cat_id=' . $cat_row['cat_id'] ) ) . '" class=' . $class . '>' . $cat_row['cat_name'] . '</a>';
				}
				else
				{
					if ( !empty( $this->subcat_rowset[$cat_row['cat_id']] ) )
					{
						foreach( $this->subcat_rowset[$cat_row['cat_id']] as $sub_cat_id => $sub_cat_row )
						{
							if ( $sub_cat_row['cat_allow_file'] )
							{
								$i++;
								if ($i > $init_link_max)
								{
									$truncate = true;
									break;
								}
								$cat_sub .= (!empty($cat_sub) ? '<span class=' . $class . '>, </span>' : '') . '<a href="' . mx_append_sid( $this->this_mxurl( 'action=category&cat_id=' . $sub_cat_row['cat_id'] ) ) . '" class=' . $class . '>' . $sub_cat_row['cat_name'] . '</a>';
							}
						}
					}
				}
			}
			
			if ($truncate)
			{
				$cat_sub .= '<span class=' . $class . '>, ...</span>';
			}
		}
		return $cat_sub;
	}

	/**
	 * generate_navigation.
	 *
	 * @param unknown_type $cat_id
	 */
	function generate_navigation($cat_id)
	{
		global $template, $db;

		if ( $this->cat_rowset[$cat_id]['parents_data'] == '' )
		{
			$cat_nav = array();
			$this->category_nav($this->cat_rowset[$cat_id]['cat_parent'], $cat_nav);

			$sql = 'UPDATE ' . PUB_CATEGORY_TABLE . "
				SET parents_data = '" . addslashes( serialize( $cat_nav ) ) . "'
				WHERE cat_parent = " . $this->cat_rowset[$cat_id]['cat_parent'];

			if ( !( $db->sql_query( $sql ) ) )
			{
				mx_message_die(GENERAL_ERROR, 'Couldnt Query categories info', '', __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$cat_nav = unserialize(stripslashes($this->cat_rowset[$cat_id]['parents_data']));
		}

		if ( !empty( $cat_nav ) )
		{
			foreach ( $cat_nav as $parent_cat_id => $parent_name )
			{
				$template->assign_block_vars('navlinks', array(
					'CAT_NAME' => $parent_name,
					'U_VIEW_CAT' => mx_append_sid($this->this_mxurl('action=category&cat_id=' . $parent_cat_id)))
				);
			}
		}

		$template->assign_block_vars( 'navlinks', array(
			'CAT_NAME' => $this->cat_rowset[$cat_id]['cat_name'],
			'U_VIEW_CAT' => mx_append_sid($this->this_mxurl('action=category&cat_id=' . $this->cat_rowset[$cat_id]['cat_id'])))
		);

		return;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cat_id
	 * @return unknown
	 */
	function new_item_in_cat( $cat_id )
	{
		global $publisher_config, $board_config, $db, $_COOKIE;

		$cat_array = explode(', ', $this->gen_cat_ids( $cat_id ));

		$files_new = 0;
		$time = time() - ( $publisher_config['settings_newdays'] * 24 * 60 * 60 );

		foreach ( $cat_array as $key => $cat_id )
		{
			if ( $this->auth_user[$cat_id]['auth_read'] && $this->cat_rowset[$cat_id]['cat_last_file_time'] > $time)
			{
				$files_new++;
			}
		}

		return $files_new;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cat_id
	 * @param unknown_type $article_info
	 */
	function last_item_in_cat($cat_id, $article_info = array())
	{
		if ((empty($this->cat_rowset[$cat_id]['cat_last_article_id']) && empty( $this->cat_rowset[$cat_id]['cat_last_article_name'] ) && empty( $this->cat_rowset[$cat_id]['cat_last_article_time'] ) ) || $this->modified )
		{
			global $db;

			$sql = 'SELECT article_date, article_id, article_title, article_category_id
				FROM ' . PUB_ARTICLES_TABLE . "
				WHERE approved = '1'
				AND article_category_id IN (" . $this->gen_cat_ids($cat_id) . ")
				ORDER BY article_date DESC";

			if ( !( $result = $db->sql_query($sql) ) )
			{
				mx_message_die(GENERAL_ERROR, 'Couldnt Query links info', '', __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$temp_cat[] = $row;
			}

			$article_info = $temp_cat[0];
			if (!empty($article_info))
			{
				$sql = 'UPDATE ' . PUB_CATEGORIES_TABLE . "
					SET cat_last_article_id = " . intval( $article_info['article_id'] ) . ",
					cat_last_article_name = '" . addslashes( $article_info['article_title'] ) . "',
					cat_last_article_time = " . intval( $article_info['article_date'] ) . "
					WHERE category_id = $cat_id";

				if ( !( $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt Query links info', '', __LINE__, __FILE__, $sql );
				}
			}
		}
		else
		{
			$article_info['article_id'] = $this->cat_rowset[$cat_id]['cat_last_article_id'];
			$article_info['article_title'] = $this->cat_rowset[$cat_id]['cat_last_article_name'];
			$article_info['article_date'] = $this->cat_rowset[$cat_id]['cat_last_article_time'];
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cat_id
	 * @param unknown_type $file_info
	 */
	function last_file_in_cat( $cat_id, &$file_info )
	{
		if ( ( empty( $this->cat_rowset[$cat_id]['cat_last_file_id'] ) && empty( $this->cat_rowset[$cat_id]['cat_last_file_name'] ) && empty( $this->cat_rowset[$cat_id]['cat_last_file_time'] ) ) || $this->modified )
		{
			global $db;

			$sql = 'SELECT file_time, file_id, file_name, file_catid
				FROM ' . PUB_FILES_TABLE . "
				WHERE file_approved = '1'
				AND file_catid IN (" . $this->gen_cat_ids($cat_id) . ")
				ORDER BY file_time DESC";

			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query Files info', '', __LINE__, __FILE__, $sql );
			}

			while ( $row = $db->sql_fetchrow( $result ) )
			{
				$temp_cat[] = $row;
			}

			$file_info = $temp_cat[0];
			if ( !empty( $file_info ) )
			{
				$sql = 'UPDATE ' . PUB_CATEGORY_TABLE . "
					SET cat_last_file_id = " . intval( $file_info['file_id'] ) . ",
					cat_last_file_name = '" . addslashes( $file_info['file_name'] ) . "',
					cat_last_file_time = " . intval( $file_info['file_time'] ) . "
					WHERE cat_id = $cat_id";

				if ( !( $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt Query Files info', '', __LINE__, __FILE__, $sql );
				}
			}
		}
		else
		{
			$file_info['file_id'] = $this->cat_rowset[$cat_id]['cat_last_file_id'];
			$file_info['file_name'] = $this->cat_rowset[$cat_id]['cat_last_file_name'];
			$file_info['file_time'] = $this->cat_rowset[$cat_id]['cat_last_file_time'];
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cat_id
	 * @param unknown_type $cat_ids
	 * @return unknown
	 */
	function gen_cat_ids( $cat_id, $cat_ids = '' )
	{
		if ( !empty( $this->subcat_rowset[$cat_id] ) )
		{
			foreach( $this->subcat_rowset[$cat_id] as $subcat_id => $cat_row )
			{
				$cat_ids = $this->gen_cat_ids( $subcat_id, $cat_ids );
			}
		}

		if ( !empty( $this->cat_rowset[$cat_id] ) )
		{
			$cat_ids .= ( ( $cat_ids != '' ) ? ', ' : '' ) . $cat_id;
		}
		return $cat_ids;
	}

	/**
	 * display_categories.
	 *
	 * @param unknown_type $parent
	 */
	function display_categories( $parent = PUB_ROOT_CAT )
	{
		global $db, $template, $board_config, $lang, $phpBB2, $phpbb_root_path, $mx_root_path, $module_root_path, $phpEx, $is_block, $page_id, $publisher_config, $userdata, $images, $pub_quick_nav;

		$cat_id = $parent;

		$this->debug('mx_pub->display_categories', basename( __FILE__ ));

		if ( $this->cat_empty() )
		{
			if ( !$userdata['session_logged_in'] )
			{
				$redirect = ($cat_id != PUB_ROOT_CAT) ? $this->this_mxurl("$action_name=$action_default&cat_id=$cat_id") : $this->this_mxurl();
				mx_redirect(mx_append_sid("login.$phpEx?redirect=$redirect", true));
			}
			mx_message_die( GENERAL_ERROR, 'Either you are not allowed to view any category, or there is no category in the database' );
		}

		//
		// Introduce a style switch for simple/standard category navigation
		//
		$cat_style = $publisher_config['use_simple_navigation'] ? 'CAT_NAV_SIMPLE' : 'CAT_NAV_STANDARD';

		$template->assign_block_vars( $cat_style, array() );
		$template->assign_vars( array(
			'L_SUB_CAT' => $lang['Sub_category'],
			'L_CATEGORY' => $lang['Category'],
			'L_CATEGORIES' => $lang['Categories'],
			'L_LAST_ARTICLE' => $lang['Last_article'],
			'L_FILES' => $lang['Files'] )
		);

		//
		// Output the categories
		//
		$num_of_cats = 0;
		if ( isset( $this->subcat_rowset[$parent] ) )
		{
			//
			// Variables needed for the simple nav
			//
			$catnum = count($this->subcat_rowset[$parent]);
			$catcol = $publisher_config['cat_col'] > 0 ? $publisher_config['cat_col'] : 1;
			$num_of_rows = intval( $catnum / $catcol );

			if ( $catnum % $catcol )
			{
				$num_of_rows++;
			}

			$template->assign_vars( array( 'WIDTH' => 100 / $catcol ) );
			$i = 0;

			foreach($this->subcat_rowset[$parent] as $category_id => $category)
			{
				//
				// Auth
				//
				if ( $this->auth_user[$category_id]['auth_view'])
				{
					if ( $i == 0 || $i ==  $catcol)
					{
						$template->assign_block_vars($cat_style.'.catrow', array());
						$i = 0;
					}
					$i++;

					$category_articles = $this->items_in_cat($category_id);
					$category_details = isset($category['cat_desc']) ? $category['cat_desc'] :  $category['category_details'];
					$category_name = isset($category['cat_name']) ? $category['cat_name'] : $category['category_name'];
					$category_url = mx_append_sid($this->this_mxurl("action=category&cat_id=$category_id"));

					$num_of_cats++;

					$last_article_info = array();
					$this->last_item_in_cat($category_id, $last_file_info); // Needed to update cat article stats

					if ( !empty($last_file_info['article_id']) && $this->auth_user[$category_id]['auth_view'])
					{
						$last_file_time = $phpBB2->create_date($board_config['default_dateformat'], $last_file_info['article_date'], $board_config['board_timezone']);
						$last_file = $last_file_time . '<br />';
						$last_file_name = (strlen(stripslashes($last_file_info['article_title'])) > 20) ? substr(stripslashes($last_file_info['article_title']), 0, 20 ) . '...' : stripslashes($last_file_info['article_title']);
						$last_file .= '<a href="' . mx_append_sid($this->this_mxurl( 'action=article&k=' . $last_file_info['article_id'] ) ) . '" alt="' . stripslashes($last_file_info['article_title']) . '" title="' . stripslashes($last_file_info['article_title']) . '">' . $last_file_name . '</a> ';
						$last_file .= '<a href="' . mx_append_sid($this->this_mxurl( 'action=article&k=' . $last_file_info['article_id'] ) ) . '"><img src="' . $images['kb_icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_file'] . '" title="' . $lang['View_latest_file'] . '" /></a>';
					}
					elseif (!empty($last_file_info['file_id'] ) && $this->auth_user[$category_id]['auth_read'])
					{
						$last_file_time = $phpBB2->create_date($board_config['default_dateformat'], $last_file_info['file_time'], $board_config['board_timezone'] );
						$last_file = $last_file_time . '<br />';
						$last_file_name = ( strlen( stripslashes($last_file_info['file_name'] ) ) > 50) ? substr(stripslashes($last_file_info['file_name']), 0, 50) . '...' : stripslashes($last_file_info['file_name']);
						$last_file .= '<a href="' . mx_append_sid($this->this_mxurl( 'action=file&file_id=' . $last_file_info['file_id'])) . '" alt="' . stripslashes($last_file_info['file_name'] ) . '" title="' . stripslashes($last_file_info['file_name']) . '">' . $last_file_name . '</a> ';
						$last_file .= '<a href="' . mx_append_sid($this->this_mxurl( 'action=file&file_id=' . $last_file_info['file_id'])) . '"><img src="' . $images['pub_icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_file'] . '" title="' . $lang['View_latest_file'] . '" /></a>';
					}
					else
					{
						$last_file = $lang['No_articles'];
					}

					$is_new = false;
					if ( $this->new_item_in_cat( $category_id ) )
					{
						$is_new = true;
					}

					$sub_cat = $this->get_sub_cat( $category_id );
					$template->assign_block_vars( $cat_style.'.catrow.catcol', array(
						'IS_HIGHER_CAT' => false,
						'CATEGORY' => $category_name,
						'U_CATEGORY' => $category_url,
						'CAT_DESCRIPTION' => $category_details,
						'CAT_ARTICLES' => $category_articles,
						'CAT_IMAGE' => $is_new ? $images['pub_category_new'] : $images['pub_category'],
						'L_SUB_CAT' => $lang['Sub_categories'],
						'U_CAT' => mx_append_sid( $this->this_mxurl( "$action_name=$action_default&cat_id=" . $subcat_id . $map_xtra ) ),
						'SUB_CAT' => ( !empty( $sub_cat ) ) ? '<br /><b>' . $lang['Sub_category'] . ': </b>' . $sub_cat :  '',
						'CAT_IMAGE' => ( $is_new ) ? $images['pub_folder_new'] : $images['pub_folder'],
						'CAT_NEW_FILE' => ( $is_new ) ? $lang['New_file'] : $lang['No_new_file'],
						'CAT_NAME' => isset($category['cat_name']) ? $category['cat_name'] : $category['category_name'],
						'CAT_DESC' => isset($category['cat_desc']) ? $category['cat_desc'] :  $category['category_details'],
						'FILECAT' => $this->items_in_cat($subcat_id),
						'LAST_FILE' => $last_file)
					);

					if (!empty( $sub_cat ))
					{
						$template->assign_block_vars( $cat_style.'.catrow.catcol.show_subs', array());
					}
				}
			}
		}

		if ( $num_of_cats == 0 )
		{
			$template->assign_block_vars( $cat_style.'.no_cats', array(
				'COMMENT' => 'Either you are not allowed to view any category, or you haven\'t selected any KB categories to use in this block. Admin should validate the blockCP settings. ',
			));
		}
	}
	
	/**
	 * display_categories.
	 *
	 * @param unknown_type $cat_id
	 */
	function display_file_categories( $cat_id = PUB_ROOT_CAT )
	{
		global $db, $template, $lang, $mx_user, $userdata, $phpEx, $images;
		global $publisher_config, $board_config, $debug, $phpBB2;

		if ( $this->cat_empty() )
		{
			if ( !$userdata['session_logged_in'] )
			{
				$redirect = ( $cat_id != PUB_ROOT_CAT ) ? $this->this_mxurl( "action=category&cat_id=$cat_id" ) : $this->this_mxurl();
				mx_redirect( mx_append_sid( "login.$phpEx?redirect=$redirect", true ) );
			}
			mx_message_die( GENERAL_ERROR, 'Either you are not allowed to view any category, or there is no category in the database' );
		}

		$template->assign_vars( array(
			'CAT_NAV_SIMPLE' => true,
			'L_SUB_CAT' => $lang['Sub_category'],
			'L_CATEGORY' => $lang['Category'],
			'L_LAST_FILE' => $lang['Last_file'],
			'L_FILES' => $lang['Files'] )
		);

		//
		// Output the categories
		//
		if ( isset( $this->subcat_rowset[$cat_id] ) )
		{
			$catnum = count($this->subcat_rowset[$cat_id]);
			$catcol = $publisher_config['cat_col'] > 0 ? $publisher_config['cat_col'] : 1;
			$num_of_rows = intval( $catnum / $catcol );

			if ( $catnum % $catcol )
			{
				$num_of_rows++;
			}

			$template->assign_vars( array( 'WIDTH' => 100 / $catcol ) );
			$i = 0;

			foreach( $this->subcat_rowset[$cat_id] as $subcat_id => $subcat_row )
			{
				if ( $i == 0 || $i ==  $catcol)
				{
					$template->assign_block_vars( 'catcol', array() );
					$i = 0;
				}
				$i++;

				$last_file_info = array();
				$this->last_item_in_cat( $subcat_id, $last_file_info );

				if ( !empty( $last_file_info['file_id'] ) && $this->auth_user[$subcat_id]['auth_read'] )
				{
					$last_file_time = $phpBB2->create_date( $board_config['default_dateformat'], $last_file_info['file_time'], $board_config['board_timezone'] );
					$last_file = $last_file_time . '<br />';
					$last_file_name = ( strlen( stripslashes( $last_file_info['file_name'] ) ) > 50 ) ? substr( stripslashes( $last_file_info['file_name'] ), 0, 50 ) . '...' : stripslashes( $last_file_info['file_name'] );
					$last_file .= '<a href="' . mx_append_sid( $this->this_mxurl( 'action=file&file_id=' . $last_file_info['file_id'] ) ) . '" alt="' . stripslashes( $last_file_info['file_name'] ) . '" title="' . stripslashes( $last_file_info['file_name'] ) . '">' . $last_file_name . '</a> ';
					$last_file .= '<a href="' . mx_append_sid( $this->this_mxurl( 'action=file&file_id=' . $last_file_info['file_id'] ) ) . '"><img src="' . $images['pub_icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_file'] . '" title="' . $lang['View_latest_file'] . '" /></a>';
				}
				else
				{
					$last_file = $lang['No_file'];
				}

				$is_new = false;
				if ($this->new_item_in_cat($subcat_id))
				{
					$is_new = true;
				}

				$sub_cat = $this->get_sub_cat($subcat_id);
				$template->assign_block_vars('catcol.no_cat_parent', array(
					'U_CAT' => mx_append_sid( $this->this_mxurl( 'action=category&cat_id=' . $subcat_id ) ),
					'SUB_CAT' => ( !empty( $sub_cat ) ) ? "&nbsp;&nbsp;$sub_cat" : "",
					'CAT_IMAGE' => ($is_new) ? $images['pub_folder_new'] : $images['pub_folder'],
					'CAT_NAME' => $subcat_row['cat_name'],
					'FILECAT' => $this->items_in_cat($subcat_id))
				);
			}
		}
	}

	/**
	 * display_categories - original.
	 *
	 * @param unknown_type $cat_id
	 */
	function display_categories_original( $cat_id = PUB_ROOT_CAT, $action_name = 'action', $action_default = 'category', $map_xtra = '' )
	{
		global $db, $template, $lang, $userdata, $phpEx, $images;
		global $publisher_config, $board_config, $debug;
		global $phpbb_root_path, $mx_root_path, $module_root_path, $is_block, $phpEx;

		if ( $this->cat_empty() )
		{
			if ( !$userdata['session_logged_in'] )
			{
				$redirect = ($cat_id != PUB_ROOT_CAT) ? $this->this_mxurl("$action_name=$action_default&cat_id=$cat_id") : $this->this_mxurl();
				mx_redirect(mx_append_sid("login.$phpEx?redirect=$redirect", true));
			}
			mx_message_die( GENERAL_ERROR, 'Either you are not allowed to view any category, or there is no category in the database' );
		}

		$cat_style = $publisher_config['use_simple_navigation'] ? 'CAT_NAV_SIMPLE' : 'CAT_NAV_STANDARD';

		$template->assign_block_vars( $cat_style, array() );
		$template->assign_vars( array(
			'CAT_NAV_STANDARD' => true,
			'L_SUB_CAT' => $lang['Sub_category'],
			'L_CATEGORY' => $lang['Category'],
			'L_LAST_FILE' => $lang['Last_file'],
			'L_SUB_CAT' => $lang['Sub_category'],
			'L_CATEGORY' => $lang['Category'],
			'L_CATEGORIES' => $lang['Categories'],
			'L_LAST_ARTICLE' => $lang['Last_article'],
			'L_FILES' => $lang['Files'] )
		);

		//
		// Category navigation for cat_id that allow files
		// - used in cat pages without files
		//
		if ( isset( $this->subcat_rowset[$cat_id] ) )
		{
			foreach( $this->subcat_rowset[$cat_id] as $subcat_id => $subcat_row )
			{
				if ( ( $subcat_row['cat_allow_file'] == PUB_CAT_ALLOW_FILE ) )
				{
					$category_articles = $this->items_in_cat($subcat_id);
					$category_details = $subcat_row['category_details'];
					$category_name = $subcat_row['category_name'];
					
					$category_url = mx_append_sid( $this->this_mxurl( "action=category&cat=$subcat_id" ) );

					$num_of_cats++;

					$last_article_info = array();
					$this->last_item_in_cat($subcat_id, $last_file_info); // Needed to update cat article stats
					
					if ( !empty( $last_file_info['article_id'] ) && $this->auth_user[$subcat_id]['auth_view'] )
					{
						$last_file_time = $phpBB2->create_date( $board_config['default_dateformat'], $last_file_info['article_date'], $board_config['board_timezone'] );
						$last_file = $last_file_time . '<br />';
						$last_file_name = ( strlen( stripslashes( $last_file_info['article_title'] ) ) > 20 ) ? substr( stripslashes( $last_file_info['article_title'] ), 0, 20 ) . '...' : stripslashes( $last_file_info['article_title'] );
						$last_file .= '<a href="' . mx_append_sid( $this->this_mxurl( 'action=article&k=' . $last_file_info['article_id'] ) ) . '" alt="' . stripslashes( $last_file_info['article_title'] ) . '" title="' . stripslashes( $last_file_info['article_title'] ) . '">' . $last_file_name . '</a> ';
						$last_file .= '<a href="' . mx_append_sid( $this->this_mxurl( 'action=article&k=' . $last_file_info['article_id'] ) ) . '"><img src="' . $images['kb_icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_file'] . '" title="' . $lang['View_latest_file'] . '" /></a>';
					}
					elseif ( !empty( $last_file_info['file_id'] ) && $this->auth_user[$subcat_id]['auth_read'] )
					{
						$last_file_time = $phpBB2->create_date( $board_config['default_dateformat'], $last_file_info['file_time'], $board_config['board_timezone'] );
						$last_file = $last_file_time . '<br />';
						$last_file_name = ( strlen( stripslashes( $last_file_info['file_name'] ) ) > 50 ) ? substr( stripslashes( $last_file_info['file_name'] ), 0, 50 ) . '...' : stripslashes( $last_file_info['file_name'] );
						$last_file .= '<a href="' . mx_append_sid( $this->this_mxurl( 'action=file&file_id=' . $last_file_info['file_id'] ) ) . '" alt="' . stripslashes( $last_file_info['file_name'] ) . '" title="' . stripslashes( $last_file_info['file_name'] ) . '">' . $last_file_name . '</a> ';
						$last_file .= '<a href="' . mx_append_sid( $this->this_mxurl( 'action=file&file_id=' . $last_file_info['file_id'] ) ) . '"><img src="' . $images['pub_icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_file'] . '" title="' . $lang['View_latest_file'] . '" /></a>';
					}
					else
					{
						$last_file = $lang['No_articles'];
					}
					$is_new = false;

					if ( $this->new_item_in_cat( $subcat_id ) )
					{
						$is_new = true;
					}

					$sub_cat = $this->get_sub_cat( $subcat_id );

					$template->assign_block_vars( 'no_cat_parent', array(
						'IS_HIGHER_CAT' => false,
						'U_CATEGORY' => $category_url,
						'CAT_DESCRIPTION' => $category_details,
						'CAT_ARTICLES' => $category_articles,
						'CAT_IMAGE' => $is_new ? $images['pub_category_new'] : $images['pub_category'],
						'L_SUB_CAT' => $lang['Sub_categories'],
						'U_CAT' => mx_append_sid( $this->this_mxurl( "$action_name=$action_default&cat_id=" . $subcat_id . $map_xtra ) ),
						'SUB_CAT' => ( !empty( $sub_cat ) ) ? '<br /><b>' . $lang['Sub_category'] . ': </b>' . $sub_cat :  '',
						'CAT_IMAGE' => ( $is_new ) ? $images['pub_folder_new'] : $images['pub_folder'],
						'CAT_NEW_FILE' => ( $is_new ) ? $lang['New_file'] : $lang['No_new_file'],
						'CAT_NAME' => $subcat_row['cat_name'],
						'FILECAT' => $this->items_in_cat( $subcat_id ),
						'LAST_FILE' => $last_file,
						'CAT_DESC' => $subcat_row['cat_desc'] )
					);
				}
			}
		}

		//
		// Category navigation for cat_id that doesn't allow files
		// - used in cat pages with files
		//
		if ( isset( $this->subcat_rowset[$cat_id] ) )
		{
			foreach( $this->subcat_rowset[$cat_id] as $subcat_id => $subcat_row )
			{
				$total_sub_cat = 0;
				if ( isset( $this->subcat_rowset[$subcat_id] ) )
				{
					foreach( $this->subcat_rowset[$subcat_id] as $sub_no_cat_id => $sub_no_cat_row )
					{
						if ( $sub_no_cat_row['cat_allow_file'] == PUB_CAT_ALLOW_FILE )
						{
							$sub_cat_rowset[$total_sub_cat] = $sub_no_cat_row;
							$total_sub_cat++;
						}
					}
				}

				//
				// This is a container category
				//
				if ( ( $subcat_row['cat_allow_file'] != PUB_CAT_ALLOW_FILE ) )
				{
					if ( $total_sub_cat )
					{
						$template->assign_block_vars( 'no_cat_parent', array(
							'IS_HIGHER_CAT' => true,
							'U_CAT' => mx_append_sid( $this->this_mxurl( "$action_name=$action_default&cat_id=" . $subcat_id . $map_xtra) ),
							'CAT_NAME' => $subcat_row['cat_name'] )
						);
					}

					for( $k = 0; $k < $total_sub_cat; $k++ )
					{
						$last_file_info = array();
						$this->last_item_in_cat( $sub_cat_rowset[$k]['cat_id'], $last_file_info );

						if ( $sub_cat_rowset[$k]['cat_parent'] == $subcat_id )
						{
							if ( !empty( $last_file_info['file_id'] ) && $this->auth_user[$sub_cat_rowset[$k]['cat_id']]['auth_read'] )
							{
								$last_file_time = $phpBB2->create_date($board_config['default_dateformat'], $last_file_info['file_time'], $board_config['board_timezone']);
								$last_file = $last_file_time . '<br />';
								$last_file_name = ( strlen( $last_file_info['file_name'] ) > 50 ) ? substr( $last_file_info['file_name'], 0, 50 ) . '...' : $last_file_info['file_name'];
								$last_file .= '<a href="' . mx_append_sid( $this->this_mxurl( 'action=file&file_id=' . $last_file_info['file_id'] ) ) . '">' . $last_file_name . '</a> ';
								$last_file .= '<a href="' . mx_append_sid( $this->this_mxurl( 'action=file&file_id=' . $last_file_info['file_id'] ) ) . '"><img src="' . $images['pub_icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_file'] . '" title="' . $lang['View_latest_file'] . '" /></a>';
							}
							else
							{
								$last_file = $lang['No_file'];
							}

							$is_new = false;

							if ( $this->new_item_in_cat( $sub_cat_rowset[$k]['cat_id'] ) )
							{
								$is_new = true;
							}

							$sub_cat = $this->get_sub_cat( $sub_cat_rowset[$k]['cat_id'] );
							$template->assign_block_vars( $cat_style.'.catrow.catcol', array(
								'IS_HIGHER_CAT' => false,
								'CATEGORY' => $category_name,
								'U_CATEGORY' => $category_url,
								'U_CAT' => mx_append_sid( $this->this_mxurl( "$action_name=$action_default&cat_id=" . $sub_cat_rowset[$k]['cat_id'] . $map_xtra ) ),
								'CAT_DESCRIPTION' => $category_details,
								'CAT_ARTICLES' => $category_articles,
								'CAT_IMAGE' => ( $is_new ) ? $images['pub_folder_new'] : $images['pub_folder'],
								//'SUB_CAT' => ( !empty( $sub_cat ) ) ? "&nbsp;&nbsp;$sub_cat" : "",
								'SUB_CAT' => ( !empty( $sub_cat ) ) ? '<br /><b>' . $lang['Sub_category'] . ': </b>' . $sub_cat : '',
								'L_SUB_CAT' => $lang['Sub_categories'],
								
								'CAT_NEW_FILE' => ( $is_new ) ? $lang['New_file'] : $lang['No_new_file'],
								'CAT_NAME' => $sub_cat_rowset[$k]['cat_name'],
								'FILECAT' => $this->items_in_cat( $sub_cat_rowset[$k]['cat_id'] ),
								
								'LAST_ARTICLE' => $last_file,
								'LAST_FILE' => $last_file,
								
								'CAT_DESC' => $sub_cat_rowset[$k]['cat_desc'] )
							);
						} // Have a permission to view the category
					} // It is not parent category
				}
			}
		} //higher Category
	}

	/**
	 * display files.
	 *
	 * @param unknown_type $sort_method
	 * @param unknown_type $sort_order
	 * @param unknown_type $start
	 * @param unknown_type $cat_id
	 * @param unknown_type $show_file_message
	 * @param unknown_type $sort_options_list
	 * @param unknown_type $sql_xtra
	 * @param unknown_type $target_page_id
	 */
	function display_files( $sort_method, $sort_order, $start, $cat_id = false, $show_file_message = true, $sort_options_list = false, $sql_xtra = '', $target_page_id = false )
	{
		global $db, $publisher_config, $template, $board_config;
		global $images, $lang, $phpEx, $publisher_functions, $phpBB2;
		global $phpbb_root_path, $mx_root_path, $module_root_path, $is_block;

		$filelist = false;

		$article_rowset = array();
		$total_file = 0;

		//
		// Category SQL
		//
		if (!$cat_id)
		{
			$cat_where = "AND f1.file_catid IN (" . $this->gen_cat_ids( '0' ) . ")";
		}
		else if (is_array($cat_id))
		{
			$cat_where = "AND f1.file_catid IN (" . $this->gen_cat_ids( $cat_id['parent'] ) . ")";
			$cat_id = false;
		}
		else
		{
			$cat_where = "AND f1.file_catid = $cat_id";
		}

		//
		// This first query is needed to find pinned files
		//
		switch ( SQL_LAYER )
		{
			case 'oracle':
				$sql = "SELECT f1.*, f1.file_id, r.votes_file, AVG(r.rate_point) AS rating, COUNT(r.votes_file) AS total_votes, u.user_id, u.username
					FROM " . PUB_FILES_TABLE . " AS f1, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_CATEGORY_TABLE . " AS cat
					WHERE f1.file_id = r.votes_file(+)
					AND f1.user_id = u.user_id(+)
					AND f1.file_id = c.file_id(+)
					AND f1.file_pin = " . FILE_PINNED . "
					AND f1.file_approved = 1
					AND f1.file_catid = cat.cat_id
					$cat_where
					$sql_xtra
					GROUP BY f1.file_id
					ORDER BY $sort_method $sort_order";
			break;

			default:
				$sql = "SELECT f1.*, f1.file_id, r.votes_file, IF(COUNT(r.rate_point) > 0, AVG(r.rate_point), 0) AS rating, COUNT(r.votes_file) AS total_votes, u.user_id, u.username
					FROM " . PUB_FILES_TABLE . " AS f1
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON f1.file_id = r.votes_file
						LEFT JOIN " . USERS_TABLE . " AS u ON f1.user_id = u.user_id
						LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON f1.file_catid = cat.cat_id
					WHERE f1.file_pin = " . FILE_PINNED . "
					AND f1.file_approved = 1
					$cat_where
					$sql_xtra
					GROUP BY f1.file_id
					ORDER BY $sort_method $sort_order";
			break;
		}

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info for this category', '', __LINE__, __FILE__, $sql );
		}

		$article_rowset = array();
		$total_file = 0;

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			if ( $this->auth_user[$row['file_catid']]['auth_read'] )
			{
				$article_rowset[] = $row;
			}
		}

		$db->sql_freeresult( $result );

		//
		// Main query
		//
		switch ( SQL_LAYER )
		{
			case 'oracle':
				$sql = "SELECT f1.*, f1.file_id, r.votes_file, AVG(r.rate_point) AS rating, COUNT(r.votes_file) AS total_votes, u.user_id, u.username
					FROM " . PUB_FILES_TABLE . " AS f1, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_CATEGORY_TABLE . " AS cat
					WHERE f1.file_id = r.votes_file(+)
					AND f1.user_id = u.user_id(+)
					AND f1.file_pin <> " . FILE_PINNED . "
					AND f1.file_approved = 1
					AND f1.file_catid = cat.cat_id
					$cat_where
					$sql_xtra
					GROUP BY f1.file_id
					ORDER BY $sort_method $sort_order";
			break;

			default:
				$sql = "SELECT f1.*, f1.file_id, r.votes_file, AVG(r.rate_point) AS rating, COUNT(r.votes_file) AS total_votes, u.user_id, u.username
					FROM " . PUB_FILES_TABLE . " AS f1
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON f1.file_id = r.votes_file
						LEFT JOIN " . USERS_TABLE . " AS u ON f1.user_id = u.user_id
						LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON f1.file_catid = cat.cat_id
					WHERE f1.file_pin <> " . FILE_PINNED . "
					AND f1.file_approved = 1
					$cat_where
					$sql_xtra
					GROUP BY f1.file_id
					ORDER BY $sort_method $sort_order";
			break;
		}

		if ( !( $result = $db->sql_query_limit( $sql, $publisher_config['pagination'], $start ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info for this category', '', __LINE__, __FILE__, $sql );
		}

		while ($row = $db->sql_fetchrow($result))
		{
			if ($this->auth_user[$row['file_catid']]['auth_read'] )
			{
				$article_rowset[] = $row;
			}
		}

		$db->sql_freeresult( $result );

		$sql = "SELECT COUNT(f1.file_id) as total_file
			FROM " . PUB_FILES_TABLE . " AS f1
			WHERE f1.file_approved='1'
			$cat_where
			$sql_xtra";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get number of file', '', __LINE__, __FILE__, $sql );
		}

		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$total_file = $row['total_file'];
		unset($row);

		//
		// Ratings
		//
		$pub_use_ratings = false;
		for ( $i = 0; $i < count( $article_rowset ); $i++ )
		{
			if ( $this->ratings[$article_rowset[$i]['file_catid']]['activated'] )
			{
				$pub_use_ratings = true;
				break;
			}
		}

		for ( $i = 0; $i < count( $article_rowset ); $i++ )
		{
			// ===================================================
			// Format the date for the given file
			// ===================================================
			$date = $phpBB2->create_date( $board_config['default_dateformat'], $article_rowset[$i]['file_time'], $board_config['board_timezone'] );
			$date_updated = $phpBB2->create_date( $board_config['default_dateformat'], $article_rowset[$i]['file_update_time'], $board_config['board_timezone'] );
			// ===================================================
			// Get rating and comments for the file and format it
			// ===================================================
			$rating = ( $article_rowset[$i]['rating'] != 0 ) ? round( $article_rowset[$i]['rating'], 2 ) . '/10' : $lang['Not_rated'];
			//$comments = ( $article_rowset[$i]['total_comments'] != 0 ) ? $article_rowset[$i]['total_comments'] : $lang['No_comments'];
			// ===================================================
			// If the file is new then put a new image in front of it
			// ===================================================
			$is_new = false;
			if ( (time() - ( $publisher_config['settings_newdays'] * 24 * 60 * 60 )) < $article_rowset[$i]['file_time'] )
			{
				$is_new = true;
			}

			$cat_name = ( empty( $cat_id ) ) ? $this->cat_rowset[$article_rowset[$i]['file_catid']]['cat_name'] : '';
			$cat_url = mx_append_sid($this->this_mxurl('action=category&cat_id=' . $article_rowset[$i]['file_catid']));
			// ===================================================
			// Get the post icon fot this file
			// ===================================================
			if ( $article_rowset[$i]['file_pin'] != ARTICLE_PINNED )
			{
				if ( $article_rowset[$i]['file_posticon'] == 'none' || $article_rowset[$i]['file_posticon'] == 'none.gif' )
				{
					$posticon = PORTAL_URL . $module_root_path . ICONS_DIR . 'none.gif';
				}
				else
				{
					$posticon = PORTAL_URL . $module_root_path . ICONS_DIR . $article_rowset[$i]['file_posticon'];
				}
			}
			else
			{
				$posticon = $images['pub_folder_sticky'];
			}

			$save_as_icon = PORTAL_URL . $module_root_path . ICONS_DIR . 'icon_download1.gif';

			//
			// Poster
			//
			$file_poster = ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . mx_append_sid( $phpbb_root_path . 'profile.' . $phpEx . '?action=viewprofile&amp;' . POST_USERS_URL . '=' . $article_rowset[$i]['user_id'] ) . '" target=_blank>' : '';
			$file_poster .= ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? $article_rowset[$i]['username'] : $article_rowset[$i]['post_username'] . '(' . $lang['Guest'] . ')';
			$file_poster .= ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';

			// ===================================================
			// Assign Vars
			// ===================================================
			if (!$article_rowset[$i]['file_disable'])
			{
				$dl_link_jump = mx_append_sid( $this->this_mxurl( 'action=download&file_id=' . $article_rowset[$i]['file_id'], true, false ) );
				$dl_link_jump_save_as = mx_append_sid( $this->this_mxurl( 'action=download&file_id=' . $article_rowset[$i]['file_id'] . '&save_as', true, false ) );
			}
			else
			{
				$dl_link_jump = $dl_link_jump_save_as = "javascript:disable_popup(".$article_rowset[$i]['file_id'].")";
			}

			$template->assign_block_vars( "file_rows", array(
				'L_NEW_FILE' => $lang['New_file'],
				'L_SAVE_AS' => $lang['Save_as'],
				'PIN_IMAGE' => $posticon,
				'SAVE_AS_IMAGE' => $save_as_icon,
				'FILE_NAME' => $article_rowset[$i]['file_name'],
				'FILE_DESC' => $article_rowset[$i]['file_desc'],
				'FILE_ID' => $article_rowset[$i]['file_id'],
				'DATE' => $date,
				'UPDATED' => $date_updated,
				'L_RATING' => $lang['DlRating'],
				'DO_RATE' => $this->auth_user[$cat_id]['auth_rate'] ? '<a href="' . mx_append_sid( $this->this_mxurl( 'action=rate&amp;file_id=' . $article_rowset[$i]['file_id'] ) ) . '">' . $lang['Do_rate'] . '</a>' : '',
				'L_COMMENT' => '<a href="' . mx_append_sid( $this->this_mxurl( 'action=post_comment&amp;item_id=' . $article_rowset[$i]['file_id'] . '&amp;cat_id=' . $article_rowset[$i]['file_catid'] ) ) . '">' . $lang['Comments'] . '</a>',
				'RATING' => $rating,
				'FILE_VOTES' => $article_rowset[$i]['total_votes'],
				'FILE_DLS' => $article_rowset[$i]['file_dls'],
				'CAT_NAME' => $cat_name,
				'IS_NEW_FILE' => $is_new,

				'U_CAT' => $cat_url,
				'SHOW_RATINGS' => ( $pub_use_ratings ?  true : false ),
				'U_FILE' => mx_append_sid( $this->this_mxurl( 'action=file&file_id=' . $article_rowset[$i]['file_id'], false, false, $target_page_id ) ),
				'U_FILE_JUMP' => $dl_link_jump,
				'U_FILE_JUMP_SAVE_AS' => $dl_link_jump_save_as,
				'COLOR' => ( ( $i % 2 ) ? "row2" : "row1" ),
				'POSTER' => $file_poster,
				'FILE_DISABLE_MSG' => nl2br( $article_rowset[$i]['disable_msg'] ),

				'FILE_NEW_IMAGE' => $images['pub_file_new'],
				'HAS_SCREENSHOTS' => ( !empty( $article_rowset[$i]['file_ssurl'] ) ) ? true : false,
				'SS_AS_LINK' => ( $article_rowset[$i]['file_sshot_link'] ) ? true : false,
				'FILE_SCREENSHOT' => $article_rowset[$i]['file_ssurl'],
				'FILE_SCREENSHOT_URL' => $module_root_path . 'publisher/images/lwin.gif',
			));

			//
			// Options (only used for the toplist block)
			//
			if ($sort_options_list)
			{
				foreach ($sort_options_list as $sort_option => $options_value)
				{
					switch ($sort_option)
					{
						case 'date':
							$template->assign_block_vars( "file_rows.display_date", array());
						break;
						case 'username':
							$template->assign_block_vars( "file_rows.display_username", array());
						break;
						case 'counter':
							$template->assign_block_vars( "file_rows.display_counter", array());
						break;
						case 'rate':
							$template->assign_block_vars( "file_rows.display_rate", array());
						break;
					}
				}
			}

			$filelist = true;
			$pub_use_ratings = $this->ratings[$article_rowset[$i]['file_catid']]['activated'];
		}

		if ( $filelist )
		{
			$action = ( empty( $cat_id ) ) ? 'viewall' : 'category&amp;cat_id=' . $cat_id;
			$template->assign_vars( array(
				'FILELIST' => $filelist,
				'ORIGINAL_STYLE' => false,

				'L_CATEGORY' => $lang['Category'],
				'L_VOTES' => $lang['Votes'],
				'L_DOWNLOADS' => $lang['Dls'],
				'L_SUBMITED_BY' => $lang['Submiter'],
				'L_DATE' => $lang['Date'],
				'L_NAME' => $lang['Name'],
				'L_FILE' => $lang['File'],
				'L_FILES' => $lang['Files'],
				'L_UPDATE_TIME' => $lang['Update_time'],
				'L_SCREENSHOTS' => $lang['Scrsht'],

				'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
				'L_ORDER' => $lang['Order'],
				'L_SORT' => $lang['Sort'],

				'L_ASC' => $lang['Sort_Ascending'],
				'L_DESC' => $lang['Sort_Descending'],

				'SORT_NAME' => ( $sort_method == 'file_name' ) ? 'selected="selected"' : '',
				'SORT_TIME' => ( $sort_method == 'file_time' ) ? 'selected="selected"' : '',
				'SORT_RATING' => ( $sort_method == 'rating' ) ? 'selected="selected"' : '',
				'SORT_DOWNLOADS' => ( $sort_method == 'file_dls' ) ? 'selected="selected"' : '',
				'SORT_UPDATE_TIME' => ( $sort_method == 'file_update_time' ) ? 'selected="selected"' : '',

				'SORT_ASC' => ( $sort_order == 'ASC' ) ? 'selected="selected"' : '',
				'SORT_DESC' => ( $sort_order == 'DESC' ) ? 'selected="selected"' : '',
				'PAGINATION' => $phpBB2->generate_pagination( mx_append_sid( $this->this_mxurl( "action=$action&amp;sort_method=$sort_method&amp;sort_order=$sort_order" ) ), $total_file, $publisher_config['pagination'], $start ),
				'PAGE_NUMBER' => sprintf( $lang['Page_of'], ( floor( $start / $publisher_config['pagination'] ) + 1 ), ceil( $total_file / $publisher_config['pagination'] ) ),
				'ID' => $cat_id,
				'START' => $start,
				'SHOW_RATINGS' => ( $pub_use_ratings ) ? true : false,

				'S_ACTION_SORT' => mx_append_sid( $this->this_mxurl( "action=$action" ) ) )
			);
		}
		else
		{
			$template->assign_vars( array(
				'L_CATEGORY' => $lang['Category'],
				'L_RATING' => $lang['DlRating'],
				'L_DOWNLOADS' => $lang['Dls'],
				'L_DATE' => $lang['Date'],
				'L_NAME' => $lang['Name'],
				'L_FILE' => $lang['File'],
				'L_UPDATE_TIME' => $lang['Update_time'],
				'L_SCREENSHOTS' => $lang['Scrsht'],
				'NO_FILE' => $show_file_message,
				'L_NO_FILES' => $lang['No_files'],
				'L_NO_FILES_CAT' => $lang['No_files_cat'] )
			);
		}

		return $total_file;
	}

	/**
	 * init items.
	 *
	 * @param unknown_type $sort_method
	 * @param unknown_type $sort_order
	 * @param unknown_type $start
	 * @param unknown_type $cat_id
	 */
	function init_items($sort_method, $sort_order, $start, $cat_id = false)
	{
		global $db, $publisher_config, $template, $board_config;
		global $images, $lang, $phpEx, $publisher_functions, $phpBB2;
		global $phpbb_root_path, $mx_root_path, $module_root_path, $is_block, $phpEx;

		$articlelist = $filelist = false;

		$article_rowset = array();
		$total_articles = 0;

		//
		// Category SQL
		//
		if (!$cat_id)
		{
			$cat_where = "AND t.article_category_id IN (" . $this->gen_cat_ids(PUB_ROOT_CAT) . ")";
		}
		else if (is_array($cat_id))
		{
			$cat_where = "AND t.article_category_id IN (" . $this->gen_cat_ids( $cat_id['parent'] ) . ")";
			$cat_id = false;
		}
		else
		{
			$cat_where = "AND t.article_category_id = $cat_id";
		}

		//
		// This first query is needed to find pinned articles
		//
		switch (SQL_LAYER)
		{
			case 'oracle':
				$sql = "SELECT t.*, f1.*, t.article_id, f1.file_id, t.article_category_id, r.votes_article, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, COUNT(c.article_id) AS total_comments
					FROM " . PUB_ARTICLES_TABLE . " AS t, " . PUB_FILES_TABLE . " AS f1, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_COMMENTS_TABLE . " AS c, " . PUB_CATEGORY_TABLE . " AS cat
					WHERE t.article_id = r.votes_article(+)
					AND t.user_id = u.user_id(+)
					AND t.article_id = c.article_id(+)
					AND t.approved = 1
					AND t.article_category_id = cat.cat_id
					$cat_where
					$sql_xtra
					GROUP BY t.article_id
					ORDER BY $sort_method $sort_order";
			break;
				
			default:
				$sql = "SELECT t.*, f1.*, t.article_id, f1.file_id, t.article_category_id, r.votes_article, IF(COUNT(r.rate_point) > 0, AVG(r.rate_point), 0) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, COUNT(c.article_id) AS total_comments, typ.type
					FROM " . PUB_ARTICLES_TABLE . " AS t
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON t.article_id = r.votes_article
						LEFT JOIN " . PUB_TYPES_TABLE . " AS typ ON t.article_type = typ.id
						LEFT JOIN " . USERS_TABLE . " AS u ON t.article_author_id = u.user_id
						LEFT JOIN " . PUB_FILES_TABLE . " AS f1 ON f1.file_id = r.votes_file
						LEFT JOIN " . PUB_COMMENTS_TABLE . " AS c ON t.article_id = c.article_id
						LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON t.article_category_id = cat.cat_id
					WHERE t.approved = 1
					$cat_where
					$sql_xtra
					GROUP BY t.article_id
					ORDER BY $sort_method $sort_order";
			break;
		}

		if (!( $result = $db->sql_query($sql)))
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info for this category', '', __LINE__, __FILE__, $sql );
		}

		$article_rowset = array();
		$total_articles = 0;

		while ($row = $db->sql_fetchrow($result))
		{
			if ($this->auth_user[$row['article_category_id']]['auth_read'] )
			{
				$this->article_rowset[] = $row;
			}
		}
		$db->sql_freeresult($result);

		//
		// Main query
		//
		switch (SQL_LAYER)
		{
			case 'oracle':
				$sql = "SELECT t.*, f1.*, t.article_id, f1.file_id, t.article_category_id, r.votes_article, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username
					FROM " . PUB_ARTICLES_TABLE . " AS t, " . PUB_FILES_TABLE . " AS f1, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_CATEGORY_TABLE . " AS cat
					WHERE t.article_id = r.votes_article(+)
					AND t.user_id = u.user_id(+)
					AND t.article_id = c.article_id(+)
					AND t.article_pin = " . ARTICLE_PINNED . "
					AND t.approved = 1
					AND t.article_category_id = cat.cat_id
					$cat_where
					$sql_xtra
					GROUP BY t.article_id
					ORDER BY $sort_method $sort_order";
				break;

			default:
				$sql = "SELECT t.*, f1.*, t.article_id, f1.file_id, t.article_category_id, r.votes_article, IF(COUNT(r.rate_point) > 0, AVG(r.rate_point), 0) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, typ.type
					FROM " . PUB_ARTICLES_TABLE . " AS t
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON t.article_id = r.votes_article
						LEFT JOIN " . PUB_TYPES_TABLE . " AS typ ON t.article_type = typ.id
						LEFT JOIN " . USERS_TABLE . " AS u ON t.article_author_id = u.user_id
						LEFT JOIN " . PUB_FILES_TABLE . " AS f1 ON f1.file_id = r.votes_file
						LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON t.article_category_id = cat.cat_id
					WHERE t.article_pin = " . ARTICLE_PINNED . "
					AND t.approved = 1
					$cat_where
					$sql_xtra
					GROUP BY t.article_id
					ORDER BY $sort_method $sort_order";
				break;
		}

		if ( !( $result = $db->sql_query_limit( $sql, $publisher_config['pagination'], $start ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info for this category', '', __LINE__, __FILE__, $sql );
		}

		while ($row = $db->sql_fetchrow($result))
		{
			if ( $this->auth_user[$row['file_catid']]['auth_read'] )
			{
				$this->article_rowset[] = $row;
			}
		}
		$db->sql_freeresult($result);
	}

	/**
	 * display items.
	 *
	 * @param unknown_type $sort_method
	 * @param unknown_type $sort_order
	 * @param unknown_type $start
	 * @param unknown_type $cat_id
	 * @param unknown_type $show_file_message
	 * @param unknown_type $sort_options_list
	 * @param unknown_type $sql_xtra
	 * @param unknown_type $target_page_id
	 */
	function display_items($sort_method, $sort_order, $start, $cat_id = false, $show_file_message = true, $sort_options_list = false, $sql_xtra = '', $target_page_id = false )
	{
		global $db, $publisher_config, $template, $board_config;
		global $images, $lang, $phpEx, $publisher_functions, $phpBB2;
		global $phpbb_root_path, $mx_root_path, $module_root_path, $is_block, $phpEx;

		$articlelist = $filelist = false;

		$article_rowset = array();
		$total_articles = 0;

		//
		// Category SQL
		//
		
		/*
		if (!$cat_id)
		{
			$cat_where = "AND t.article_category_id IN (" . $this->gen_cat_ids(PUB_ROOT_CAT) . ")";
		}
		else if (is_array($cat_id))
		{
			$cat_where = "AND t.article_category_id IN (" . $this->gen_cat_ids( $cat_id['parent'] ) . ")";
			$cat_id = false;
		}
		else
		{
			$cat_where = "AND t.article_category_id = $cat_id";
		}

		//
		// This first query is needed to find pinned articles
		//
		switch (SQL_LAYER)
		{
			case 'oracle':
				$sql = "SELECT t.*, f1.*, t.article_id, f1.file_id, t.article_category_id, r.votes_article, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, COUNT(c.article_id) AS total_comments
					FROM " . PUB_ARTICLES_TABLE . " AS t, " . PUB_FILES_TABLE . " AS f1, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_COMMENTS_TABLE . " AS c, " . PUB_CATEGORY_TABLE . " AS cat
					WHERE t.article_id = r.votes_article(+)
					AND t.user_id = u.user_id(+)
					AND t.article_id = c.article_id(+)
					AND t.approved = 1
					AND t.article_category_id = cat.cat_id
					$cat_where
					$sql_xtra
					GROUP BY t.article_id
					ORDER BY $sort_method $sort_order";
			break;
				
			default:
				$sql = "SELECT t.*, f1.*, t.article_id, f1.file_id, t.article_category_id, r.votes_article, IF(COUNT(r.rate_point) > 0, AVG(r.rate_point), 0) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, COUNT(c.article_id) AS total_comments, typ.type
					FROM " . PUB_ARTICLES_TABLE . " AS t
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON t.article_id = r.votes_article
						LEFT JOIN " . PUB_TYPES_TABLE . " AS typ ON t.article_type = typ.id
						LEFT JOIN " . USERS_TABLE . " AS u ON t.article_author_id = u.user_id
						LEFT JOIN " . PUB_FILES_TABLE . " AS f1 ON f1.file_id = r.votes_file
						LEFT JOIN " . PUB_COMMENTS_TABLE . " AS c ON t.article_id = c.article_id
						LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON t.article_category_id = cat.cat_id
					WHERE t.approved = 1
					$cat_where
					$sql_xtra
					GROUP BY t.article_id
					ORDER BY $sort_method $sort_order";
			break;
		}

		if (!( $result = $db->sql_query($sql)))
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info for this category', '', __LINE__, __FILE__, $sql );
		}

		while ($row = $db->sql_fetchrow($result))
		{
			if ($this->auth_user[$row['article_category_id']]['auth_read'] )
			{
				$article_rowset[] = $row;
			}
		}
		$db->sql_freeresult($result);

		//
		// Main query
		//
		switch (SQL_LAYER)
		{
			case 'oracle':
				$sql = "SELECT t.*, f1.*, t.article_id, f1.file_id, t.article_category_id, r.votes_article, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username
					FROM " . PUB_ARTICLES_TABLE . " AS t, " . PUB_FILES_TABLE . " AS f1, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_CATEGORY_TABLE . " AS cat
					WHERE t.article_id = r.votes_article(+)
					AND t.user_id = u.user_id(+)
					AND t.article_id = c.article_id(+)
					AND t.article_pin = " . ARTICLE_PINNED . "
					AND t.approved = 1
					AND t.article_category_id = cat.cat_id
					$cat_where
					$sql_xtra
					GROUP BY t.article_id
					ORDER BY $sort_method $sort_order";
				break;

			default:
				$sql = "SELECT t.*, f1.*, t.article_id, f1.file_id, t.article_category_id, r.votes_article, IF(COUNT(r.rate_point) > 0, AVG(r.rate_point), 0) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, typ.type
					FROM " . PUB_ARTICLES_TABLE . " AS t
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON t.article_id = r.votes_article
						LEFT JOIN " . PUB_TYPES_TABLE . " AS typ ON t.article_type = typ.id
						LEFT JOIN " . USERS_TABLE . " AS u ON t.article_author_id = u.user_id
						LEFT JOIN " . PUB_FILES_TABLE . " AS f1 ON f1.file_id = r.votes_file
						LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON t.article_category_id = cat.cat_id
					WHERE t.article_pin = " . ARTICLE_PINNED . "
					AND t.approved = 1
					$cat_where
					$sql_xtra
					GROUP BY t.article_id
					ORDER BY $sort_method $sort_order";
				break;
		}

		if ( !( $result = $db->sql_query_limit( $sql, $publisher_config['pagination'], $start ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info for this category', '', __LINE__, __FILE__, $sql );
		}

		while ($row = $db->sql_fetchrow($result))
		{
			if ( $this->auth_user[$row['file_catid']]['auth_read'] )
			{
				$article_rowset[] = $row;
			}
		}
		$db->sql_freeresult($result);
		*/
		$this->init_items($sort_method, $sort_order, $start, $cat_id);
		
		$article_rowset = $this->article_rowset;
		
		$sql = "SELECT COUNT(t.article_id) as total_articles
			FROM " . PUB_ARTICLES_TABLE . " AS t
			WHERE t.approved='1'
			$cat_where
			$sql_xtra";
		if (!($result = $db->sql_query($sql)))
		{
			mx_message_die(GENERAL_ERROR, 'Couldn\'t get number of file', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$total_articles = $row['total_articles'];
		unset($row);

		if (count($article_rowset) > 0)
		{
			$template->assign_block_vars('ARTICLELIST', array() );
			$articlelist = $filelist = true;
		}
		for ( $i = 0; $i < count( $article_rowset ); $i++ )
		{
			if ( $this->ratings[$article_rowset[$i]['file_catid']]['activated'] )
			{
				$pub_use_ratings = true;
				break;
			}
		}
		//
		// Ratings
		//
		$pub_use_ratings = false;
		for ( $i = 0; $i < count( $article_rowset ); $i++ )
		{
			if ( $this->ratings[$article_rowset[$i]['file_catid']]['activated'] )
			{
				$pub_use_ratings = true;
				break;
			}
		}

		for ( $i = 0; $i < count( $article_rowset ); $i++ )
		{
			// ===================================================
			// Format the date for the given file
			// ===================================================
			$date = $phpBB2->create_date( $board_config['default_dateformat'], $article_rowset[$i]['file_time'], $board_config['board_timezone'] );
			$date_updated = $phpBB2->create_date( $board_config['default_dateformat'], $article_rowset[$i]['file_update_time'], $board_config['board_timezone'] );
			// ===================================================
			// Get rating and comments for the file and format it
			// ===================================================
			$rating = ( $article_rowset[$i]['rating'] != 0 ) ? round( $article_rowset[$i]['rating'], 2 ) . '/10' : $lang['Not_rated'];
			$comments = ( $article_rowset[$i]['total_comments'] != 0 ) ? $article_rowset[$i]['total_comments'] : $lang['No_comments'];
			// ===================================================
			// If the file is new then put a new image in front of it
			// ===================================================
			$is_new = false;
			if (time() - ($publisher_config['settings_newdays'] * 24 * 60 * 60) < $article_rowset[$i]['article_date'])
			{
				$is_new = true;
			}
	
			$cat_name =  isset($this->cat_rowset[$article_rowset[$i]['file_catid']]['cat_name']) ? $this->cat_rowset[$article_rowset[$i]['file_catid']]['cat_name'] : '';
			$cat_name =  isset($this->cat_rowset[$article_rowset[$i]['file_catid']]['category_name']) ? $this->cat_rowset[$article_rowset[$i]['file_catid']]['category_name'] : $cat_name;
			$category_name = $cat_name = (empty($cat_id)) ? $cat_name : '';
	
			$cat_url = isset($article_rowset[$i]['article_category_id']) ? mx_append_sid($this->this_mxurl( 'action=category&cat_id=' . $article_rowset[$i]['article_category_id'])) : mx_append_sid($this->this_mxurl('action=category&cat_id=' . $article_rowset[$i]['file_catid']));
			
			$article_description = $article_rowset[$i]['article_description'] ;
			$article_cat_id = $article_rowset[$i]['article_category_id'];
			$article_approved = $article_rowset[$i]['approved'];
			// ===================================================
			// Get the post icon fot this file
			// ===================================================
			if ( $article_rowset[$i]['file_pin'] != ARTICLE_PINNED )
			{
				if ( $article_rowset[$i]['file_posticon'] == 'none' || $article_rowset[$i]['file_posticon'] == 'none.gif' )
				{
					$posticon = PORTAL_URL . $module_root_path . ICONS_DIR . 'none.gif';
				}
				else
				{
					$posticon = PORTAL_URL . $module_root_path . ICONS_DIR . $article_rowset[$i]['file_posticon'];
				}
			}
			else
			{
				$posticon = $images['pub_folder_sticky'];
			}

			$save_as_icon = PORTAL_URL . $module_root_path . ICONS_DIR . 'icon_download1.gif';
			
			//
			// type
			//
			$article_type = isset($lang['PUB_type_' . $article_rowset[$i]['type']]) ? $lang['PUB_type_' . $article_rowset[$i]['type']] : $article_rowset[$i]['type'];

			//
			// author information
			//
			$author = ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . mx_append_sid($phpbb_root_path . ((PORTAL_BACKEND == 'internal') && (PORTAL_BACKEND == 'phpbb2') ? 'profile.' : 'ucp.') . $phpEx . '?action=viewprofile&' . POST_USERS_URL . '=' . $article_rowset[$i]['user_id'] ) . '" target=_blank>' : '';
			$author .= ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? $article_rowset[$i]['username'] : $article_rowset[$i]['post_username'] . '(' . $lang['Guest'] . ')';
			$author .= ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';
			
			$file_poster = ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . mx_append_sid($phpbb_root_path . ((PORTAL_BACKEND == 'internal') && (PORTAL_BACKEND == 'phpbb2') ? 'profile.' : 'ucp.') . $phpEx . '?action=viewprofile&amp;' . POST_USERS_URL . '=' . $article_rowset[$i]['user_id'] ) . '" target=_blank>' : '';
			$file_poster .= ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? $article_rowset[$i]['username'] : $article_rowset[$i]['post_username'] . '(' . $lang['Guest'] . ')';
			$file_poster .= ( $article_rowset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';

			$article_id = $article_rowset[$i]['article_id'];
			$views = $article_rowset[$i]['views'];

			$article_title = $article_rowset[$i]['article_title'];

			//
			// Article Url - Standard or App
			//
			$article_url = mx_append_sid( $this->this_mxurl( "action=article&k=$article_id", false, false, $target_page_id ) );

			// ===================================================
			// Assign Vars
			// ===================================================
			if (!$article_rowset[$i]['file_disable'])
			{
				$dl_link_jump = mx_append_sid( $this->this_mxurl( 'action=download&file_id=' . $article_rowset[$i]['file_id'], true, false ) );
				$dl_link_jump_save_as = mx_append_sid( $this->this_mxurl( 'action=download&file_id=' . $article_rowset[$i]['file_id'] . '&save_as', true, false ) );
			}
			else
			{
				$dl_link_jump = $dl_link_jump_save_as = "javascript:disable_popup(".$article_rowset[$i]['file_id'].")";
			}

			$template->assign_block_vars("ARTICLELIST.articlerow", array(
				'ARTICLE_ID' => $article_id,
				'ARTICLE' => $article_title,
				'ARTICLE_DESCRIPTION' => $article_description,
				'ARTICLE_TYPE' => $article_type,
				'ARTICLE_DATE' => $article_date,
				'ARTICLE_AUTHOR' => $author,
				'CATEGORY' => $cat_name,
				'ART_VIEWS' => $views,

				'ARTICLE_VOTES' => $article_rowset[$i]['total_votes'],
				'L_RATING' => $lang['Votes_label'],
				'DO_RATE' => $this->auth_user[$cat_id]['auth_rate'] ? '<a href="' . mx_append_sid( $this->this_mxurl( 'action=rate&k=' . $article_rowset[$i]['article_id'] ) ) . '">' . $lang['ADD_RATING'] . '</a>' : '',
				'RATING' => $rating,

				'U_ARTICLE' => $article_url,
				'U_CAT' => $cat_url,

				//'U_APPROVE' => $approve,

				'S_ARTICLE_IMAGE_NEW' => $is_new,
				'ARTICLE_IMAGE' => $is_new ? $images['pub_article_new'] : $images['pub_article'], //subSilver based
				'ARTICLE_IMAGE_ICON_NEW' => $images['pub_article_new'], //prosilver based new
				'ARTICLE_IMAGE_ICON' => $images['pub_article'], //prosilver based default

				'COLOR' => ( ( $i % 2 ) ? "row2" : "row1" ),
				'ROW' => ( ( $i % 2 ) ? "bg2" : "bg1" ),

				'POSTER' => $file_poster,

				//'U_DELETE' => $delete
			));

			if ( $pub_use_ratings )
			{
				$template->assign_block_vars( "ARTICLELIST.articlerow.show_ratings", array() );
			}

			if ( $is_new )
			{
				$template->assign_block_vars( "ARTICLELIST.articlerow.is_new_file", array() );
			}

			//
			// Options (only used for the toplist block)
			//
			if ($sort_options_list)
			{
				foreach ($sort_options_list as $sort_option => $options_value)
				{
					switch ($sort_option)
					{
						case 'date':
							$template->assign_block_vars( "ARTICLELIST.articlerow.display_date", array());
						break;
						case 'username':
							$template->assign_block_vars( "ARTICLELIST.articlerow.display_username", array());
						break;
						case 'counter':
							$template->assign_block_vars( "ARTICLELIST.articlerow.display_counter", array());
						break;
						case 'rate':
							$template->assign_block_vars( "ARTICLELIST.articlerow.display_rate", array());
						break;
					}
				}
			}

		}

		if ( $filelist )
		{
			$action = (empty($cat_id)) ? 'stats' : 'category&amp;cat=' . $cat_id;

			$sort_method = isset($_REQUEST['sort_method']) ? $_REQUEST['sort_method'] : $publisher_config['sort_method'];
			$sort_order = isset($_REQUEST['sort_order']) ? $_REQUEST['sort_order'] : $publisher_config['sort_order'];

			$template->assign_vars( array(
				'L_CATEGORY' => $lang['Category'],
				'L_CATEGORY_NAME' => $category_name,
				'L_ARTICLE' => $lang['Article'],
				'L_ARTICLES' => $lang['Articles'],
				'L_ARTICLE_TYPE' => $lang['Article_type'],
				'L_ARTICLE_CATEGORY' => $lang['Category'],
				'L_ARTICLE_DATE' => $lang['Date'],
				'L_ARTICLE_AUTHOR' => $lang['Author'],
				'L_VIEWS' => $lang['Views'],
				'L_VOTES' => $lang['Votes'],

				'L_LINK_SITE_DESC' => $lang['Siteld'],
				'L_DOWNLOADS' => $lang['Hits'],
				'L_DATE' => $lang['Date'],
				'L_NAME' => $lang['Sitename'],
				'L_FILE' => $lang['Link'],
				'L_SUBMITED_BY' => $lang['Submiter'],
				'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],

				'L_ORDER' => $lang['Order'],
				'L_SORT' => $lang['Sort'],

				'L_ID' => $lang['Top_id'],
				'L_LATEST' => $lang['Top_latest'],
				'L_TOPRATED' => $lang['Top_toprated'],
				'L_MOST_POPULAR' => $lang['Top_most_popular'],
				'L_USERRANK' => $lang['Top_userrank'],
				'L_ALPHABETIC' => $lang['Top_alphabetic'],

				'L_ASC' => $lang['Sort_Ascending'],
				'L_DESC' => $lang['Sort_Descending'],

				'SORT_ID' => ( $sort_method == 'Id' ) ? 'selected="selected"' : '',
				'SORT_LATEST' => ( $sort_method == 'Latest' ) ? 'selected="selected"' : '',
				'SORT_TOPRATED' => ( $sort_method == 'Toprated' ) ? 'selected="selected"' : '',
				'SORT_MOST_POPULAR' => ( $sort_method == 'Most_popular' ) ? 'selected="selected"' : '',
				'SORT_USERRANK' => ( $sort_method == 'Userrank' ) ? 'selected="selected"' : '',
				'SORT_ALPHABETIC' => ( $sort_method == 'Alphabetic' ) ? 'selected="selected"' : '',

				'SORT_ASC' => ( $sort_order == 'ASC' ) ? 'selected="selected"' : '',
				'SORT_DESC' => ( $sort_order == 'DESC' ) ? 'selected="selected"' : '',

				'PAGINATION' => mx_generate_pagination( mx_append_sid( $this->this_mxurl( "&action=$action&amp;sort_method=$sort_method&sort_order=$sort_order" ) ), $total_file, $publisher_config['pagination'], $start),
				'PAGE_NUMBER' => sprintf( $lang['Page_of'], ( floor( $start / $publisher_config['pagination'] ) + 1 ), ceil( $total_file / $publisher_config['pagination'] ) ),
				'ID' => $cat_id,
				'START' => $start,

				'S_ACTION_SORT' => mx_append_sid( $this->this_mxurl( "&action=$action" ) ) )
			);
		}
		else
		{
			if ($this->cat_rowset[$cat_id]['cat_allow_file'])
			{
				$template->assign_block_vars( 'no_articles', array(
					'L_NO_ARTICLES' => $lang['No_articles'],
					'L_NO_ARTICLES_CAT' => $lang['No_Articles']
				) );
			}
		}

		return $total_articles;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $sort_method
	 * @param unknown_type $sort_order
	 * @param unknown_type $start
	 * @param unknown_type $show_file_message
	 * @param unknown_type $cat_id
	 */
	/*
	function display_items_quickdl( $sort_method, $sort_order, $start, $show_file_message, $cat_id = false )
	{
		global $db, $publisher_config, $template, $board_config;
		global $images, $lang, $phpEx, $publisher_functions;
		global $phpbb_root_path, $mx_root_path, $module_root_path, $is_block, $phpEx;

		$filelist = false;

		if ( empty( $cat_id ) )
		{
			$cat_where = '';
		}
		else
		{
			$cat_where = "AND f1.file_catid = $cat_id";
		}

		switch ( SQL_LAYER )
		{
			case 'oracle':
				$sql = "SELECT f1.*, f1.file_id, r.votes_article, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, COUNT(c.comments_id) AS total_comments, cat.cat_allow_ratings, cat.cat_allow_comments
					FROM " . PUB_FILES_TABLE . " AS f1, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_COMMENTS_TABLE . " AS c, " . PUB_CATEGORY_TABLE . " AS cat
					WHERE f1.file_id = r.votes_article(+)
					AND f1.user_id = u.user_id(+)
					AND f1.file_id = c.file_id(+)
					AND f1.file_pin = " . ARTICLE_PINNED . "
					AND f1.file_approved = 1
					AND f1.file_catid = cat.cat_id
					$cat_where
					GROUP BY f1.file_id
					ORDER BY $sort_method $sort_order";
				break;

			default:
				$sql = "SELECT f1.*, f1.file_id, r.votes_article, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, COUNT(c.comments_id) AS total_comments, cat.cat_allow_ratings, cat.cat_allow_comments
					FROM " . PUB_FILES_TABLE . " AS f1
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON f1.file_id = r.votes_article
						LEFT JOIN " . USERS_TABLE . " AS u ON f1.user_id = u.user_id
						LEFT JOIN " . PUB_COMMENTS_TABLE . " AS c ON f1.file_id = c.file_id
						LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON f1.file_catid = cat.cat_id
					WHERE f1.file_pin = " . ARTICLE_PINNED . "
					AND f1.file_approved = 1
					$cat_where
					GROUP BY f1.file_id
					ORDER BY $sort_method $sort_order";
				break;
		}

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info for this category', '', __LINE__, __FILE__, $sql );
		}

		$article_rowset = array();
		$total_articles = 0;

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			if ( $this->auth_user[$row['file_catid']]['auth_read'] )
			{
				$article_rowset[] = $row;
			}
		}

		$db->sql_freeresult( $result );

		switch ( SQL_LAYER )
		{
			case 'oracle':
				$sql = "SELECT f1.*, f1.file_id, r.votes_article, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, COUNT(c.comments_id) AS total_comments
					FROM " . PUB_FILES_TABLE . " AS f1, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_COMMENTS_TABLE . " AS c
					WHERE f1.file_id = r.votes_article(+)
					AND f1.user_id = u.user_id(+)
					AND f1.file_id = c.file_id(+)
					AND f1.file_pin <> " . ARTICLE_PINNED . "
					AND f1.file_approved = 1
					$cat_where
					GROUP BY f1.file_id
					ORDER BY $sort_method $sort_order";
				break;

			default:
				$sql = "SELECT f1.*, f1.file_id, r.votes_article, AVG(r.rate_point) AS rating, COUNT(r.votes_article) AS total_votes, u.user_id, u.username, COUNT(c.comments_id) AS total_comments
					FROM " . PUB_FILES_TABLE . " AS f1
						LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON f1.file_id = r.votes_article
						LEFT JOIN " . USERS_TABLE . " AS u ON f1.user_id = u.user_id
						LEFT JOIN " . PUB_COMMENTS_TABLE . " AS c ON f1.file_id = c.file_id
					WHERE f1.file_pin <> " . ARTICLE_PINNED . "
					AND f1.file_approved = 1
					$cat_where
					GROUP BY f1.file_id
					ORDER BY $sort_method $sort_order";
				break;
		}

		if ( !( $result = $publisher_functions->sql_query_limit( $sql, $publisher_config['pagination'], $start ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info for this category', '', __LINE__, __FILE__, $sql );
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			if ( $this->auth_user[$row['file_catid']]['auth_read'] )
			{
				$article_rowset[] = $row;
			}
		}

		$db->sql_freeresult( $result );

		$where_sql = ( !empty( $cat_id ) ) ? "AND file_catid = $cat_id" : '';
		$sql = "SELECT COUNT(file_id) as total_articles
			FROM " . PUB_FILES_TABLE . "
			WHERE file_approved='1'
			$where_sql";

		if ( !( $result = $db->sql_query( $sql, 300 ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldn\'t get number of file', '', __LINE__, __FILE__, $sql );
		}

		$row = $db->sql_fetchrow( $result );
		$db->sql_freeresult( $result );

		$total_articles = $row['total_articles'];
		unset( $row );

		for ( $i = 0; $i < count( $article_rowset ); $i++ )
		{
			// ===================================================
			// Format the date for the given file
			// ===================================================
			$date = phpBB2::create_date( $board_config['default_dateformat'], $article_rowset[$i]['file_time'], $board_config['board_timezone'] );
			$date_updated = phpBB2::create_date( $board_config['default_dateformat'], $article_rowset[$i]['file_update_time'], $board_config['board_timezone'] );
			// ===================================================
			// Get rating for the file and format it
			// ===================================================
			$rating = ( $article_rowset[$i]['rating'] != 0 ) ? round( $article_rowset[$i]['rating'], 2 ) . ' / 10' : $lang['Not_rated'];
			// ===================================================
			// If the file is new then put a new image in front of it
			// ===================================================
			$is_new = false;
			if ( time() - ( $publisher_config['settings_newdays'] * 24 * 60 * 60 ) < $article_rowset[$i]['file_time'] )
			{
				$is_new = true;
			}

			$cat_name = ( empty( $cat_id ) ) ? $this->cat_rowset[$article_rowset[$i]['file_catid']]['cat_name'] : '';
			$cat_url = mx_append_sid( $this->this_mxurl( 'action=category&cat_id=' . $article_rowset[$i]['file_catid'] ) );
			// ===================================================
			// Get the post icon fot this file
			// ===================================================
			if ( $article_rowset[$i]['file_pin'] != ARTICLE_PINNED )
			{
				if ( $article_rowset[$i]['file_posticon'] == 'none' || $article_rowset[$i]['file_posticon'] == 'none.gif' )
				{
					$posticon = $images['pub_spacer'];
				}
				else
				{
					$posticon = PORTAL_URL . $module_root_path . ICONS_DIR . $article_rowset[$i]['file_posticon'];
				}
			}
			else
			{
				$posticon = $images['pub_folder_sticky'];
			}
			// ===================================================
			// Assign Vars
			// ===================================================
			$template->assign_block_vars( "file_rows", array( 'L_NEW_FILE' => $lang['New_file'],

					'PIN_IMAGE' => $posticon,
					'FILE_NEW_IMAGE' => $images['pub_file_new'],
					'HAS_SCREENSHOTS' => ( !empty( $article_rowset[$i]['file_ssurl'] ) ) ? true : false,
					'SS_AS_LINK' => ( $article_rowset[$i]['file_sshot_link'] ) ? true : false,
					'FILE_SCREENSHOT' => $article_rowset[$i]['file_ssurl'],
					'FILE_SCREENSHOT_URL' => $module_root_path . 'publisher/images/lwin.gif',
					'FILE_NAME' => $article_rowset[$i]['file_name'],
					'FILE_DESC' => $article_rowset[$i]['file_desc'],
					'DATE' => $date,
					'UPDATED' => $date_updated,
					'RATING' => $rating,
					'FILE_DLS' => $article_rowset[$i]['file_dls'],
					'CAT_NAME' => $cat_name,
					'IS_NEW_FILE' => $is_new,

					'U_CAT' => $cat_url,
					'U_FILE' => mx_append_sid( $this->this_mxurl( 'action=download&file_id=' . $article_rowset[$i]['file_id'], true ) ) )
				);
			$filelist = true;
		}

		if ( $filelist )
		{
			$action = ( empty( $cat_id ) ) ? 'viewall' : 'category&amp;cat_id=' . $cat_id;
			$template->assign_vars( array( 'L_CATEGORY' => $lang['Category'],
					'L_RATING' => $lang['DlRating'],
					'L_PROJECTS' => $lang['Dls'],
					'L_DATE' => $lang['Date'],
					'L_NAME' => $lang['Name'],
					'L_FILE' => $lang['File'],
					'L_UPDATE_TIME' => $lang['Update_time'],
					'L_SCREENSHOTS' => $lang['Scrsht'],

					'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
					'L_ORDER' => $lang['Order'],
					'L_SORT' => $lang['Sort'],

					'L_ASC' => $lang['Sort_Ascending'],
					'L_DESC' => $lang['Sort_Descending'],

					'SORT_NAME' => ( $sort_method == 'file_name' ) ? 'selected="selected"' : '',
					'SORT_TIME' => ( $sort_method == 'file_time' ) ? 'selected="selected"' : '',
					'SORT_RATING' => ( $sort_method == 'rating' ) ? 'selected="selected"' : '',
					'SORT_PROJECTS' => ( $sort_method == 'file_dls' ) ? 'selected="selected"' : '',
					'SORT_UPDATE_TIME' => ( $sort_method == 'file_update_time' ) ? 'selected="selected"' : '',

					'SORT_ASC' => ( $sort_order == 'ASC' ) ? 'selected="selected"' : '',
					'SORT_DESC' => ( $sort_order == 'DESC' ) ? 'selected="selected"' : '',
					'PAGINATION' => phpBB2::generate_pagination( mx_append_sid( $this->this_mxurl( "action=$action&amp;sort_method=$sort_method&amp;sort_order=$sort_order" ) ), $total_articles, $publisher_config['pagination'], $start ),
					'PAGE_NUMBER' => sprintf( $lang['Page_of'], ( floor( $start / $publisher_config['pagination'] ) + 1 ), ceil( $total_articles / $publisher_config['pagination'] ) ),
					'FILELIST' => $filelist,
					'ID' => $cat_id,
					'START' => $start,

					'S_ACTION_SORT' => mx_append_sid( $this->this_mxurl( "action=$action" ) ) )
				);
		}
		else
		{
			$template->assign_vars( array( 'NO_FILE' => $show_file_message,
					'L_NO_FILES' => $lang['No_files'],
					'L_NO_FILES_CAT' => $lang['No_files_cat'] )
				);
		}
	}
	*/

	/**
	 * auth_can.
	 *
	 * @param unknown_type $cat_id
	 */
	function auth_can($cat_id)
	{
		global $lang;

		$this->auth_can_list = '<br />' . ( ( $this->auth_user[$cat_id]['auth_upload'] ) ? $lang['PUB_Rules_upload_can'] : $lang['PUB_Rules_upload_cannot'] ) . '<br />';
		$this->auth_can_list .= ( ( $this->auth_user[$cat_id]['auth_view_file'] ) ? $lang['PUB_Rules_view_file_can'] : $lang['PUB_Rules_view_file_cannot'] ) . '<br />';
		$this->auth_can_list .= ( ( $this->auth_user[$cat_id]['auth_edit_file'] ) ? $lang['PUB_Rules_edit_file_can'] : $lang['PUB_Rules_edit_file_cannot'] ) . '<br />';
		$this->auth_can_list .= ( ( $this->auth_user[$cat_id]['auth_delete_file'] ) ? $lang['PUB_Rules_delete_file_can'] : $lang['PUB_Rules_delete_file_cannot'] ) . '<br />';
		$this->auth_can_list .= ( ( $this->comments[$cat_id]['activated'] ? ( ( $this->auth_user[$cat_id]['auth_view_comment'] ? $lang['PUB_Rules_view_comment_can'] : $lang['PUB_Rules_view_comment_cannot'] ) . '<br />') : ''));
		$this->auth_can_list .= ( ( $this->comments[$cat_id]['activated'] ? ( ( $this->auth_user[$cat_id]['auth_post_comment'] ? $lang['PUB_Rules_post_comment_can'] : $lang['PUB_Rules_post_comment_cannot'] ) . '<br />') : ''));
		$this->auth_can_list .= ( ( $this->ratings[$cat_id]['activated'] ? ( ( $this->auth_user[$cat_id]['auth_rate'] ? $lang['PUB_Rules_rate_can'] : $lang['PUB_Rules_rate_cannot'] ) . '<br />') : ''));
		$this->auth_can_list .= ( ( $this->auth_user[$cat_id]['auth_download'] ) ? $lang['PUB_Rules_download_can'] : $lang['PUB_Rules_download_cannot'] ) . '<br />';

		if ( $this->auth_user[$cat_id]['auth_mod'] )
		{
			$this->auth_can_list .= $lang['PUB_Rules_moderate_can'];
		}
	}

	/**
	 * MX URL Fix
	 * Temporary solution to handle addons urls 
	 *
	 * @param unknown_type $args
	 * @param unknown_type $force_standalone_mode
	 * @param unknown_type $non_html_amp
	 * @return unknown
	 */
	function this_mxurl($args = '', $force_standalone_mode = false, $non_html_amp = false, $is_block = true)
	{
		global $mx_root_path, $module_root_path, $page_id, $phpEx, $is_block;
	
		$page = $this->request->variable('page', $page_id);
		$pageId = $this->request->variable('page_id', $page);
		$start = $this->request->get('start', MX_TYPE_INT, 0);
	
		$file_id = $this->request->request('file_id', MX_TYPE_INT, '');
		$page_num = $this->request->request('page_num', MX_TYPE_INT, 1) - 1;
	
		$dynamicId = isset($_GET['dynamic_block']) ? ($non_html_amp ? '&dynamic_block=' : '&amp;dynamic_block=') . $this->request->variable('dynamic_block') : '';
		$actions_args = isset($args) ? @explode('&', str_replace('?', '&', str_replace('&amp;', '&', $args))) : '';
	
		$mode = $this->request->variable('mode', '');
		$action = $this->request->variable('action', $mode);
		$do = $this->request->variable('do', '');
		$article_id = $this->request->variable('article_id', '');
		$cat_id = $this->request->variable('cat_id', '');
	
		if ( ($cat_id == 0) && ($article_id !== 0) )
		{
			$sql = "SELECT article_id
				FROM " . PUB_ARTICLES_TABLE . "
				WHERE article_id = '" . $article_id . "'";
			if ( !( $result = $this->db->sql_query( $sql ) ) )
			{
				$this->message_die( GENERAL_ERROR, 'Couldnt query download file category', '', __LINE__, __FILE__, $sql );
			}
			$article_data = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			
			$cat_id = $article_data['article_category_id'];
		}
	
		$use_action = isset($action) ? '_' . str_replace('category', 'cat', $action) : '';
	
		$use_cat_or_file_array = ((isset($cat_id) && !isset($article_id)) || (!isset($cat_id) && isset($article_id))) ? true : false;					
		$use_cat_and_file_array = isset($cat_id) && isset($article_id) ? true : false;
	
		$use_cat_array = ($use_cat_file_array == false) && isset($cat_id) ? true : false;	
		$use_action_do_array = isset($action) && isset($do) ? true : false;
	
		$route_cat_or_file_array = (($use_cat_or_file_array == true) && ($use_cat_array == true)) ? array('cat_id' => $cat_id) : ( (($use_cat_or_file_array == true) && ($use_file_array == true )) ? array('file_id' => $file_id) : array('mode' => $mode) );
		$route_cat_and_file_array = ($use_cat_and_file_array == true) ? array('cat_id' => $cat_id, 'article_id' => $article_id) : $route_cat_or_file_array;	
	
		$route_action_do_file_array = (($use_action_do_array == true) && ($use_file_array == true)) ? array('action' => $action, 'do' => $do, 'file_id' => $file_id) : ((($use_action_do_array == true) && ($use_cat_array == true)) ? array('mode' => $mode, 'do' => $do, 'file_id' => $file_id) : $route_cat_and_file_array);
	
		$route_array = ($use_action_do_array == true && is_array($route_action_do_file_array)) ? $route_action_do_file_array : $route_cat_and_file_array;		
	
		$this->backend = PORTAL_BACKEND;
	
		$dynamicId = !empty($_GET['dynamic_block']) ? ( $non_html_amp ? '&dynamic_block=' : '&amp;dynamic_block=' ) . $_GET['dynamic_block'] : '';

		$args .= ($args == '' ? '' : '&' ) . 'modrewrite=no';
	
		if ( !MXBB_MODULE )
		{
			$mxurl = PORTAL_URL . $module_root_path . 'app.' . $phpEx . ( $args == '' ? '' : '?' . $args );
			return $mxurl;
		}

		if ( $force_standalone_mode || !$is_block )
		{
			$mxurl = PORTAL_URL . $module_root_path . 'app.' . $phpEx . ( $args == '' ? '' : '?' . $args );
		}
		else
		{
			$mxurl = PORTAL_URL . 'index.' . $phpEx;
			
			if (is_numeric($pageId))
			{
				$mxurl .= '?page=' . $pageId . $dynamicId . ( $args == '' ? ( $non_html_amp ? '&' : '&amp;' ) . 'action=' . $action : ( $non_html_amp ? '&' : '&amp;' ) . $args );
			}
			else
			{
				$mxurl .= ( $args == '' ? ( $non_html_amp ? '&' : '&amp;' ) . 'action=' . $mode : ( $non_html_amp ? '&' : '&amp;' ) . $args );
			}
		}
		return $mxurl;
	}

	// =============================================
	// Admin and mod functions
	// =============================================

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $rating
	 */
	function update_voter_info( $file_id, $rating )
	{
		global $db, $userdata, $lang, $publisher_config;

		$ipaddy = getenv ( "REMOTE_ADDR" );

		if ($publisher_config['votes_check_ip'] && $publisher_config['votes_check_userid'])
		{
			$where_sql = ( $userdata['user_id'] != ANONYMOUS ) ? "(user_id = '" . $userdata['user_id'] . "' OR votes_ip = '" . $ipaddy . "')": "votes_ip = '" . $ipaddy . "'";
		}
		else if($publisher_config['votes_check_ip'])
		{
			$where_sql = ( $publisher_config['votes_check_ip'] ) ? "votes_ip = '" . $ipaddy . "'" : '';
		}
		else if($publisher_config['votes_check_userid'])
		{
			$where_sql = ( $userdata['user_id'] != ANONYMOUS ) ? "user_id = '" . $userdata['user_id'] . "'" : '';
		}
		else
		{
			$where_sql = "user_id = '-99'";
		}
		$where_sql .= !empty($where_sql) ? " AND votes_article = '" . $file_id . "'" : "votes_article = '" . $file_id . "'";

		$sql = "SELECT user_id, votes_ip
			FROM " . PUB_VOTES_TABLE . "
			WHERE $where_sql
			LIMIT 1";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query User id', '', __LINE__, __FILE__, $sql );
		}

		//
		// Has already voted. Should we care?
		//
		if ( !$db->sql_numrows( $result ) )
		{
			$user_info = new mx_user_info();

			$sql = "INSERT INTO " . PUB_VOTES_TABLE . " (user_id, votes_ip, votes_article, rate_point, voter_os, voter_browser, browser_version)
						VALUES('" . $userdata['user_id'] . "', '" . $ipaddy . "', '" . $file_id . "','" . $rating . "', '" . $user_info->platform . "', '" . $user_info->agent . "', '" . $user_info->ver . "')";

			if ( !( $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Update Votes Table Info', '', __LINE__, __FILE__, $sql );
			}
		}
		else
		{
			$message = $lang['Rerror'] . "<br /><br />" . sprintf( $lang['Click_return'], "<a href=\"" . mx_append_sid( $this->this_mxurl( "action=link&amp;link_id=$file_id" ) ) . "\">", "</a>" );
			mx_message_die( GENERAL_MESSAGE, $message );
		}

		$db->sql_freeresult( $result );
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $article_data
	 * @param unknown_type $item_id
	 * @param unknown_type $cid
	 * @param unknown_type $subject
	 * @param unknown_type $message
	 * @param unknown_type $html_on
	 * @param unknown_type $bbcode_on
	 * @param unknown_type $smilies_on
	 */
	function update_add_comment($article_data = '', $item_id, $cid, $subject = '', $message = '', $html_on = false, $bbcode_on = true, $smilies_on = false, $allow_wysiwyg = false)
	{
		global $template, $mx_pub_functions, $lang, $board_config, $phpEx, $publisher_config, $db, $images, $userdata;
		global $html_entities_match, $html_entities_replace, $unhtml_specialchars_match, $unhtml_specialchars_replace;
		global $mx_root_path, $module_root_path, $phpbb_root_path, $is_block, $phpEx, $mx_request_vars;

		//
		// Ensure we have article_data defined
		//
		if (!is_array($article_data) && !empty($item_id) && $item_id > 0)
		{
			$sql = "SELECT *
				FROM " . PUB_ARTICLES_TABLE . "
				WHERE article_id = '" . $item_id . "'";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt select download', '', __LINE__, __FILE__, $sql );
			}

			if ( !$article_data = $db->sql_fetchrow( $result ) )
			{
				mx_message_die( GENERAL_MESSAGE, $lang['Article_not_exsist'] );
			}

			$db->sql_freeresult( $result );
		}

		//
		// vars (can both be POSTed or send through the function)
		//
		$update_comment = $cid > 0 ? true : false;
		$subject = !empty($subject) ? $subject : $_POST['subject'];
		$message = !empty($message) ? $message : $_POST['message'];

		$length = strlen($message);

		//
		// Instantiate the mx_text class
		//
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on);
		$mx_text->allow_all_html_tags = $allow_wysiwyg;

		//
		// Encode for db storage
		//
		$title = $mx_text->encode_simple($subject);
		$comments_text = $mx_text->encode($message);
		$comment_bbcode_uid = $mx_text->bbcode_uid;

		if ( $length > $publisher_config['max_comment_chars'] )
		{
			mx_message_die( GENERAL_ERROR, 'Your comment is too long!<br/>The maximum length allowed in characters is ' . $publisher_config['max_comment_chars'] . '' );
		}

		if ( $update_comment )
		{
			if ( $this->comments[$article_data['article_category_id']]['internal_comments'] )
			{
				$sql = "UPDATE " . PUB_COMMENTS_TABLE . "
					SET comments_text = '" . str_replace( "\'", "''", $comments_text ) . "',
				          comments_title = '" . str_replace( "\'", "''", $title ) . "',
				          comment_bbcode_uid = '" . $comment_bbcode_uid . "'
				    WHERE comments_id = " . $cid . "
						AND article_id = ". $item_id;

				if ( !( $db->sql_query($sql)) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt update comments', '', __LINE__, __FILE__, $sql );
				}
			}
			else
			{
				include( $module_root_path . 'publisher/core/functions_comment.' . $phpEx );
				$publisher_comments = new publisher_comments();
				$publisher_comments->init( $item_id );

				$return_data = $publisher_comments->post( 'update', $cid, $title, $comments_text, $userdata['user_id'], $userdata['username'], 0, '', '', $comment_bbcode_uid);
			}

		}
		else
		{
			if ( $this->comments[$article_data['article_category_id']]['internal_comments'] )
			{
				$time = time();
				$poster_id = intval($userdata['user_id']);
				$sql = "INSERT INTO " . PUB_COMMENTS_TABLE . "(article_id, comments_text, comments_title, comments_time, comment_bbcode_uid, poster_id)
					VALUES('$item_id','" . str_replace("\'", "''", $comments_text) . "','" . str_replace("\'", "''", $title) . "','$time', '$comment_bbcode_uid','$poster_id')";

				if (!($db->sql_query($sql)))
				{
					mx_message_die(GENERAL_ERROR, 'Couldnt insert comments', '', __LINE__, __FILE__, $sql);
				}
			}
			else
			{
				include($module_root_path . 'publisher/core/functions_comment.' . $phpEx);
				$publisher_comments = new publisher_comments();
				$publisher_comments->init($item_id);

				$return_data = $publisher_comments->post( 'insert', '', $title, $comments_text, $userdata['user_id'], $userdata['username'], 0, '', '', $comment_bbcode_uid);
			}
		}

		if ( !$this->comments[$article_data['article_category_id']]['internal_comments'] )
		{

			//
			// Update the item data itself
			//
			if ($article_data['topic_id'] == 0 )
			{
				//
				// Update item with new topic_id
				//
				$sql = "UPDATE " . PUB_ARTICLES_TABLE . "
					SET topic_id = '" . $return_data['topic_id'] . "'
				    WHERE article_id = ". $item_id;

				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt update item', '', __LINE__, __FILE__, $sql );
				}

				$db->sql_freeresult( $result );
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @return unknown
	 */
	function update_add_item( $file_id = false )
	{
		global $db, $phpbb_root_path, $userdata, $publisher_config, $_FILES, $publisher_functions, $user_ip, $auth, $module_root_path;

		$ss_upload = ( empty( $_POST['screen_shot_url'] ) ) ? true : false;
		$ss_remote_url = ( !empty( $_POST['screen_shot_url'] ) ) ? $_POST['screen_shot_url'] : '';
		$ss_local = ( $_FILES['screen_shot']['tmp_name'] !== 'none' ) ? $_FILES['screen_shot']['tmp_name'] : '';
		$ss_name = ( $_FILES['screen_shot']['name'] !== 'none' ) ? $_FILES['screen_shot']['name'] : '';
		$ss_size = ( !empty( $_FILES['screen_shot']['size'] ) ) ? $_FILES['screen_shot']['size'] : '';

		$file_upload = ( empty( $_POST['download_url'] ) ) ? true : false;
		$file_remote_url = ( !empty( $_POST['download_url'] ) ) ? $_POST['download_url'] : '';
		$file_local = ( $_FILES['userfile']['tmp_name'] !== 'none' ) ? $_FILES['userfile']['tmp_name'] : '';
		$file_realname = ( $_FILES['userfile']['name'] !== 'none' ) ? $_FILES['userfile']['name'] : '';
		$file_size = ( !empty( $_FILES['userfile']['size'] ) ) ? $_FILES['userfile']['size'] : '';
		$file_type = ( !empty( $_FILES['userfile']['type'] ) ) ? $_FILES['userfile']['type'] : '';

		$cat_id = ( isset( $_REQUEST['cat_id'] ) ) ? intval( $_REQUEST['cat_id'] ) : 0;
		$file_name = ( isset( $_POST['name'] ) ) ? addslashes( htmlspecialchars( $_POST['name'] ) ) : '';
		$file_long_desc = ( isset( $_POST['long_desc'] ) ) ? addslashes( htmlspecialchars( $_POST['long_desc'] ) ) : '';
		$file_short_desc = ( isset( $_POST['short_desc'] ) ) ? addslashes( htmlspecialchars( $_POST['short_desc'] ) ) : ( ( !empty( $_POST['long_desc'] ) ) ? substr( addslashes( htmlspecialchars( $_POST['long_desc'] ) ), 0, 100 ) . '...' : '' );
		$file_author = ( isset( $_POST['author'] ) ) ? addslashes( htmlspecialchars( $_POST['author']  ) ) : ( ( $userdata['user_id'] != ANONYMOUS ) ? $userdata['username'] : '' );
		$file_version = ( isset( $_POST['version'] ) ) ? addslashes( htmlspecialchars( $_POST['version'] ) ) : '';
		$file_website = ( isset( $_POST['website'] ) ) ? addslashes( htmlspecialchars( $_POST['website'] ) ) : '';

		if ( !empty( $file_website ) )
		{
			$file_website = ( !preg_match( '#^http[s]?:\/\/#i', $file_website ) ) ? 'http://' . $file_website : $file_website;
			$file_website = ( preg_match( '#^http[s]?\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i', $file_website ) ) ? $file_website : '';
		}

		$file_posticon = ( isset( $_POST['posticon'] ) ) ? htmlspecialchars( $_POST['posticon'] ) : '';
		$file_license = ( isset( $_POST['license'] ) ) ? intval( $_POST['license'] ) : 0;
		$file_pin = ( isset( $_POST['pin'] ) ) ? intval( $_POST['pin'] ) : 0;
		$file_disable = ( isset( $_POST['file_disable'] ) ) ? intval( $_POST['file_disable'] ) : 0;
		$disable_msg = ( isset( $_POST['disable_msg'] ) ) ? addslashes( htmlspecialchars( $_POST['disable_msg'] ) ) : '';
		$file_ss_link = ( isset( $_POST['sshot_link'] ) ) ? intval( $_POST['sshot_link'] ) : 0;
		$file_dls = ( isset( $_POST['file_download'] ) ) ? intval( $_POST['file_download'] ) : 0;
		$file_time = time();

		if ( $cat_id == -1 )
		{
			$this->error[] = $lang['Missing_field'];
		}

		if ( empty( $file_name ) )
		{
			$this->error[] = $lang['Missing_field'];
		}

		if ( empty( $file_long_desc ) )
		{
			$this->error[] = $lang['Missing_field'];
		}

		if ( empty( $file_remote_url ) && empty( $file_local ) && !$file_id )
		{
			$this->error[] = $lang['Missing_field'];
		}

		$forbidden_extensions = array_map('trim', @explode( ',', $publisher_config['forbidden_extensions']));
		$file_extension = $publisher_functions->get_extension($file_realname);

		if (in_array($file_extension, $forbidden_extensions))
		{
			$this->error[] = 'You are not allowed to upload this type of files';
		}

		$allowed_ss_extensions = array('jpg', 'gif', 'png');

		if ( !empty( $ss_name ) )
		{
			$ss_file_extension = $publisher_functions->get_extension( $ss_name );

			if ( !in_array( $ss_file_extension, $allowed_ss_extensions ) )
			{
				$this->error[] = 'You are not allowed to upload this type of screenshot image';
			}
		}

		if ( sizeof( $this->error ) )
		{
			return;
		}

		$physical_file_name = '';

		if ( $file_id )
		{
			$sql = 'SELECT file_dlurl, file_size, unique_name, file_dir, real_name, file_approved
				FROM ' . PUB_FILES_TABLE . "
				WHERE file_id = '$file_id'";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query Download URL', '', __LINE__, __FILE__, $sql );
			}

			$file_data = $db->sql_fetchrow( $result );

			$db->sql_freeresult( $result );

			if ( !empty( $file_remote_url ) || !empty( $file_local ) )
			{
				if ( !empty( $file_data['unique_name'] ) )
				{
					$publisher_functions->publisher_unlink( $module_root_path . $file_data['file_dir'] . $file_data['unique_name'] );
				}
			}
			else
			{
				$file_remote_url = $file_data['file_dlurl'];
				$physical_file_name = $file_data['unique_name'];
				$file_realname = $file_data['real_name'];

				if ( empty( $file_local ) )
				{
					$file_upload = false;
				}
			}
		}
		
		if ( !$file_size )
		{
			$file_size = $lang['Not_available'];
		}

		if ( $file_upload )
		{
			$physical_file_name = $publisher_functions->gen_unique_name( '.' . $file_extension );

			$file_info = $publisher_functions->upload_file( $file_local, $physical_file_name, $file_size, $publisher_config['upload_dir'] );

			if ( $file_info['error'] )
			{
				mx_message_die( GENERAL_ERROR, $file_info['message'] );
			}
		}

		if ( !empty( $ss_remote_url ) || !empty( $ss_local ) )
		{
			if ( $ss_upload )
			{
				$screen_shot_info = $publisher_functions->upload_file( $ss_local, $ss_name, $ss_size, $publisher_config['screenshots_dir'] );

				if ( $screen_shot_info['error'] )
				{
					mx_message_die( GENERAL_ERROR, $screen_shot_info['message'] );
				}
				$screen_shot_url = $screen_shot_info['url'];
			}
			else
			{
				$screen_shot_url = $ss_remote_url;
			}
		}

		if ( !$file_id )
		{
			if ($this->auth_user[$cat_id]['auth_approval'] || $this->auth_user[$cat_id]['auth_mod'])
			{
				$file_approved = 1;
			}
			else
			{
				$file_approved = 0;
			}
		}
		else
		{
			if ($this->auth_user[$cat_id]['auth_approval_edit'] || $this->auth_user[$cat_id]['auth_mod'])
			{
				$file_approved = 1;
			}
			else
			{
				$file_approved = 0;
			}
		}

		/*
		if ( $publisher->modules[$publisher->module_name]->auth_user[$cat_id]['auth_approval'] || ( $publisher->modules[$publisher->module_name]->auth_user[$cat_id]['auth_mod'] && $userdata['session_logged_in'] ) )
		{
			if ( !$file_id )
			{
				$file_approved = 1;
			}
			else
			{
				$file_approved = isset( $file_data['file_approved'] ) &&  !( $publisher->modules[$publisher->module_name]->auth_user[$cat_id]['auth_mod'] && $userdata['session_logged_in'] ) ? $file_data['file_approved'] : 1;
			}
		}
		else
		{
			$file_approved = 0;
		}
		*/


		if ( !$file_id )
		{
			$sql = 'INSERT INTO ' . PUB_FILES_TABLE . " (user_id, poster_ip, file_name, file_size, unique_name, real_name, file_dir, file_desc, file_creator, file_version, file_longdesc, file_ssurl, file_sshot_link, file_dlurl, file_time, file_update_time, file_catid, file_posticon, file_license, file_dls, file_last, file_pin, file_disable, disable_msg, file_docsurl, file_approved)
					VALUES('{$userdata['user_id']}', '$user_ip', '" . str_replace( "\'", "''", $file_name ) . "', '$file_size', '$physical_file_name', '$file_realname', '{$publisher_config['upload_dir']}', '" . str_replace( "\'", "''", $file_short_desc ) . "', '" . str_replace( "\'", "''", $file_author ) . "', '" . str_replace( "\'", "''", $file_version ) . "', '" . str_replace( "\'", "''", $file_long_desc ) . "', '$screen_shot_url', '$file_ss_link', '$file_remote_url', '$file_time', '$file_time', '$cat_id', '$file_posticon', '$file_license', '$file_dls', '0', '$file_pin', '$file_disable', '$disable_msg', '$file_website', '$file_approved')";
		}
		else
		{
			$sql = 'SELECT *
				FROM ' . PUB_FILES_TABLE . "
				WHERE file_id = '$file_id'";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query Download URL', '', __LINE__, __FILE__, $sql );
			}

			$update_data = $db->sql_fetchrow( $result );

			$db->sql_freeresult($result);
			
			$sql = array(
				'file_name' => str_replace( "\'", "''", $file_name ),
				'file_desc' => str_replace( "\'", "''", $file_short_desc ),
				'file_longdesc' => str_replace( "\'", "''", $file_long_desc ),
				'file_catid' => (int) $cat_id,
				'file_approved' => (int) $file_approved,

				'file_size' => (int) $file_size,
				'unique_name' => $physical_file_name,
				'real_name' => $file_realname,
				'file_dir' => $publisher_config['upload_dir'],
				'file_creator' => str_replace( "\'", "''", $file_author ),
				'file_version' => str_replace( "\'", "''", $file_version ),
				'file_ssurl' => $screen_shot_url,
				'file_sshot_link' => (int) $update_data['file_sshot_link'],
				'file_dlurl' => $file_remote_url,
				'file_posticon' => $file_posticon,
				'file_license' => (int) $file_license,
				'file_docsurl' => $file_website,

				'file_time' => (int) $update_data['file_time'],
				'user_id' => (int) $update_data['user_id'],
				'poster_ip' => $update_data['poster_ip'],
				'file_update_time' => (int) $file_time,
				'file_last' => (int) $update_data['file_last'],
				'file_pin' => (int) $file_pin,
				'file_disable' => (int) $file_disable,
				'disable_msg' => $disable_msg,
				'file_broken' => (int) $update_data['file_broken'],
				'topic_id' => (int) $update_data['topic_id'],
				'file_dls' => (int) $file_dls,
			);

			$sql = "UPDATE " . PUB_FILES_TABLE . " SET " . $db->sql_build_array('UPDATE', $sql) . "
				WHERE file_id = '" . $db->sql_escape($file_id) . "'";
		}
	
		if (!($db->sql_query($sql)))
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Add the file information to the database', '', __LINE__, __FILE__, $sql );
		}
		$this->modified( true );

		if ( $file_id )
		{
			return $file_id;
		}
		else
		{
			return $db->sql_nextid();
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $cat_id
	 * @param unknown_type $mode_notification
	 */
	function update_add_item_notify($file_id = false, $mode_notification = 'edit')
	{
		global $db;

		if ( in_array( $mode_notification, array( 'add', 'edit', 'do_approve', 'do_unapprove', 'delete' ) ) )
		{
			if (!$file_id)
			{
				die('bad update_add_item_notify arg');
			}

			if (is_array($file_id) && !empty($file_id))
			{
				$fileIdsArray = $file_id;
			}
			else
			{
				$fileIdsArray[] = $file_id;
			}

			foreach($fileIdsArray as $fileId)
			{
				$sql = "SELECT file_catid
					FROM " . PUB_FILES_TABLE . "
					WHERE file_id = '" . $fileId . "'";

				if (!$result = $db->sql_query($sql))
				{
					mx_message_die( GENERAL_ERROR, 'Couldn\'t get file info', '', __LINE__, __FILE__, $sql );
				}

				$row = $db->sql_fetchrow($result);
				$catId = $row['file_catid'];

				//
				// Notification
				//
				if ($this->notification[$catId]['activated'] > 0) // -1, 0, 1, 2
				{
					//
					// Instatiate notification
					//
					$publisher_notification = new mx_pub_notification();
					$publisher_notification->init($fileId);

					//
					// Now send notification
					//
					$mx_notification_mode = $this->notification[$catId]['activated'] == 1 ? MX_PM_MODE : MX_MAIL_MODE;

					switch ( $mode_notification )
					{
						case 'add':
							$mx_notification_action = MX_NEW_NOTIFICATION;
						break;
						case 'edit':
							$mx_notification_action = MX_EDITED_NOTIFICATION;
						break;
						case 'do_approve':
							$mx_notification_action = MX_APPROVED_NOTIFICATION;
						break;
						case 'do_unapprove':
							$mx_notification_action = MX_UNAPPROVED_NOTIFICATION;
						break;
						case 'delete':
							$mx_notification_action = MX_DELETED_NOTIFICATION;
						break;
					}

					$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
					$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');

					$publisher_notification->notify($mx_notification_mode, $mx_notification_action);

					if ( $this->notification[$catId]['notify_group'] > 0 )
					{
						$publisher_notification->notify( $mx_notification_mode, $mx_notification_action, - intval($this->notification[$catId]['notify_group']) );
					}
				}
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id
	 * @param unknown_type $mode
	 */
	function delete_items( $id, $mode = 'file' )
	{
		global $db, $phpbb_root_path, $publisher_functions;

		if ( $mode == 'category' )
		{
			$file_ids = array();
			$files_data = array();

			$sql = 'SELECT file_id, unique_name, file_dir
				FROM ' . PUB_FILES_TABLE . "
				WHERE file_catid = $id";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt select files', '', __LINE__, __FILE__, $sql );
			}

			while ( $row = $db->sql_fetchrow( $result ) )
			{
				$file_ids[] = $row['file_id'];
				$files_data[] = $row;
			}

			$where_sql = "WHERE file_catid = $id";
		}
		else
		{
			$sql = 'SELECT file_id, unique_name, file_dir
				FROM ' . PUB_FILES_TABLE . "
				WHERE file_id = $id";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt select files', '', __LINE__, __FILE__, $sql );
			}

			$file_data = $db->sql_fetchrow( $result );

			$where_sql = "WHERE file_id = $id";
		}

		$sql = 'DELETE FROM ' . PUB_FILES_TABLE . "
			$where_sql";

		unset( $where_sql );

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt delete files', '', __LINE__, __FILE__, $sql );
		}

		$where_sql = ( $mode != 'file' && !empty( $file_ids ) ) ? ' IN (' . implode( ', ', $file_ids ) . ') ' : " = $id";

		$sql = 'DELETE FROM ' . PUB_CUSTOM_DATA_TABLE . "
			WHERE customdata_file$where_sql";

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt delete custom data', '', __LINE__, __FILE__, $sql );
		}

		$sql = 'DELETE FROM ' . PUB_MIRRORS_TABLE . "
			WHERE file_id$where_sql";

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt delete mirror for this file', '', __LINE__, __FILE__, $sql );
		}

		if ( $mode == 'category' )
		{
			foreach( $files_data as $file_data )
			{
				if ( !empty( $file_data['unique_name'] ) )
				{
					$publisher_functions->publisher_unlink( $phpbb_root_path . $file_data['file_dir'] . $file_data['unique_name'] );
				}
			}
		}
		else
		{
			if ( !empty( $file_data['unique_name'] ) )
			{
				$publisher_functions->publisher_unlink( $phpbb_root_path . $file_data['file_dir'] . $file_data['unique_name'] );
			}
		}

		if ( $mode == 'file' )
		{
			$this->modified( true );
		}

		return;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $file_upload
	 * @param unknown_type $file_remote_url
	 * @param unknown_type $file_local
	 * @param unknown_type $file_realname
	 * @param unknown_type $file_size
	 * @param unknown_type $file_type
	 * @param unknown_type $mirror_location
	 * @param unknown_type $mirror_id
	 */
	function mirror_add_update( $file_id, $file_upload, $file_remote_url, $file_local, $file_realname, $file_size, $file_type, $mirror_location, $mirror_id = false )
	{
		global $db, $phpbb_root_path, $db, $_POST, $userdata, $publisher_config, $_FILES, $_REQUEST, $publisher_functions;
		// MX
		global $mx_root_path, $module_root_path, $is_block, $phpEx;

		if ( empty( $file_remote_url ) && empty( $file_local ) && !$file_id )
		{
			$this->error[] = $lang['Missing_field'];
		}

		$forbidden_extensions = array_map( 'trim', @explode( ',', $publisher_config['forbidden_extensions'] ) );

		$file_extension = $publisher_functions->get_extension( $file_realname );

		if ( in_array( $file_extension, $forbidden_extensions ) )
		{
			$this->error[] = 'You are not allowed to upload this type of files';
		}

		if ( sizeof( $this->error ) )
		{
			return;
		}

		$physical_file_name = '';

		if ( $mirror_id )
		{
			$sql = 'SELECT file_dlurl, unique_name, file_dir
				FROM ' . PUB_MIRRORS_TABLE . "
				WHERE mirror_id = $mirror_id";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query Download URL', '', __LINE__, __FILE__, $sql );
			}

			$mirror_data = $db->sql_fetchrow( $result );

			$db->sql_freeresult( $result );

			if ( !empty( $file_remote_url ) || !empty( $file_local ) )
			{
				if ( !empty( $mirror_data['unique_name'] ) )
				{
					$publisher_functions->publisher_unlink( $module_root_path . $mirror_data['file_dir'] . $mirror_data['unique_name'] );
				}
			}
			else
			{
				$file_remote_url = $mirror_data['file_dlurl'];
				$physical_file_name = $mirror_data['unique_name'];
				$file_dir = $mirror_data['file_dir'];

				if ( empty( $file_local ) )
				{
					$file_upload = false;
				}
			}
		}

		if ( $file_upload )
		{
			$physical_file_name = $publisher_functions->gen_unique_name( '.' . $file_extension );

			$file_info = $publisher_functions->upload_file( $file_local, $physical_file_name, $file_size, $module_root_path . $publisher_config['upload_dir'] );

			if ( $file_info['error'] )
			{
				mx_message_die( GENERAL_ERROR, $file_info['message'] );
			}
		}

		if ( !$mirror_id )
		{
			$sql = 'INSERT INTO ' . PUB_MIRRORS_TABLE . " (file_id, unique_name, file_dir, file_dlurl, mirror_location)
					VALUES($file_id, '$physical_file_name', '{$publisher_config['upload_dir']}', '$file_remote_url', '" . str_replace( "\'", "''", $mirror_location ) . "')";
		}
		else
		{
			$sql = "UPDATE " . PUB_MIRRORS_TABLE . "
				SET file_id = $file_id,
				unique_name = '$physical_file_name',
				file_dir = '{$publisher_config['upload_dir']}',
				file_dlurl = '$file_remote_url',
				mirror_location = '" . str_replace( "\'", "''", $mirror_location ) . "'
				WHERE mirror_id = '$mirror_id'";
		}

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Add the file information to the database', '', __LINE__, __FILE__, $sql );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mirror_id
	 */
	function delete_mirror( $mirror_id )
	{
		global $db;

		$where_sql = ( is_array( $mirror_id ) ) ? 'IN (' . implode( ', ', $mirror_id ) . ')' : "= $mirror_id";

		$sql = 'DELETE FROM ' . PUB_MIRRORS_TABLE . "
			WHERE mirror_id $where_sql";

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt delete mirror for this file', '', __LINE__, __FILE__, $sql );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mode
	 * @param unknown_type $file_id
	 */
	function approve_item( $mode = 'do_approve', $file_id )
	{
		global $db;

		$file_approved = ( $mode == 'do_approve' ) ? 1 : 0;

		$sql = 'UPDATE ' . PUB_FILES_TABLE . "
			SET file_approved = $file_approved
			WHERE file_id = $file_id";

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Add the file information to the database', '', __LINE__, __FILE__, $sql );
		}

		$this->modified( true );
	}
}

/**
 * Public publisher class
 *
 */
class publisher_public extends mx_publisher
{
	var $modules = array();
	var $module_name = '';

	/**
	 * load module.
	 *
	 * @param unknown_type $module_name send module name to load it
	 */
	function module( $module_name )
	{
		if ( !class_exists( 'publisher_' . $module_name ) )
		{
			global $module_root_path, $phpEx;

			$this->module_name = $module_name;

			require_once( $module_root_path . 'publisher/controller/pub_' . $module_name . '.' . $phpEx );
			eval( '$this->modules[' . $module_name . '] = new publisher_' . $module_name . '();' );

			if ( method_exists( $this->modules[$module_name], 'init' ) )
			{
				$this->modules[$module_name]->init();
			}
		}
	}

	/**
	 * this will be replaced by the loaded module
	 *
	 * @param unknown_type $module_id
	 * @return unknown
	 */
	function main($module_id = false)
	{
		return false;
	}

	/**
	 * go ahead and output the page
	 *
	 * @param unknown_type $page_title send page title
	 * @param unknown_type $tpl_name template file name
	 */
	function display($page_title, $tpl_name)
	{
		global $template, $publisher_functions;

		$publisher_functions->page_header($page_title);

		$template->set_filenames(array('body' => $tpl_name));

		$publisher_functions->page_footer();
	}

}
?>