<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: publisher_functions.php,v 1.62 2012/01/09 06:58:15 orynider Exp $
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
 * publisher_functions.
 *
 * This class is used for general pa handling
 *
 * @access public
 * @author Jon Ohlsson
 *
 */
class publisher_functions
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\request\request */
	protected $request;
	
	/** @var \phpbb\auth\auth */
	protected $auth;	
	
	/** @var ContainerInterface */
	protected $container;	
	
	/** @var \phpbb\cache\cache */
	protected $cache;

	/** @var \orynider\publisher\core\ publisher */
	protected $publisher;	

	/** @var \orynider\publisher\core\publisher_cache */
	protected $publisher_cache;
	
	/** @var \orynider\publisher\core\templates */
	protected $templates;	
	
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \phpbb\extension\manager */
	protected $extension_manager;

	/** @var string */
	protected $php_ext;

	/** @var string phpBB root path */
	protected $root_path;
	protected $mx_root_path;
	protected $module_root_path;
	protected $phpbb_root_path;
	
	var $total_cat = 0;	
	
	/** @var string */	
	var $cat_rowset = array();
	
	/** @var string */	
	var $subcat_rowset = array();
	
	/** @var string */	
	var $comments = array();
	
	/** @var string */	
	var $ratings = array();
	
	/** @var string */	
	var $information = array();
	
	/** @var string */	
	var $notification = array();

	var $modified = false;
	var $error = array();
	var $auth_user = array();
	var $page_title = '';
	var $jumpbox = '';
	var $auth_can_list = '';
	var $navigation = '';

	var $debug = false; // Toggle debug output on/off
	var $debug_msg = array();	

	/**
	* The database tables
	*
	* @var string
	*/
	protected $pub_files_table;

	protected $pub_cat_table;

	protected $pub_config_table;
	
	protected $pub_votes_table;
	
	protected $pub_comments_table;
	
	protected $pub_license_table;
	
	public function publisher_functions()
	{
		global $mx_cache, $publisher_cache, $mx_request_vars, $template, $mx_user, $db, $phpbb_auth;  
		global $board_config, $phpEx, $phpbb_root_path, $mx_root_path, $module_root_path;
		
		$this->auth 				= $phpbb_auth;
		$this->template 			= $template;
		$this->user 				= $mx_user;
		$this->db 					= $db;
		$this->helper 				= $mx_cache;
		$this->request 			= $mx_request_vars;
		$this->container 			= $mx_cache;
		$this->cache 				= $mx_cache;
		$this->publisher_cache 	= $publisher_cache;
		$this->config 				= $board_config;
		$this->pagination 		= $mx_cache;
		$this->extension_manager	= $mx_cache;
		$this->php_ext 			= $phpEx;
		$this->root_path 			= $mx_root_path;
		$this->mx_root_path 	= $mx_root_path;
		$this->module_root_path 	= $module_root_path;
		$this->phpbb_root_path 	= $phpbb_root_path;
		
		$this->pub_files_table 	= PUB_FILES_TABLE;
		$this->pub_cat_table 	= PUB_CAT_TABLE;
		$this->pub_config_table 	= PUB_CONFIG_TABLE;
		$this->pub_votes_table 		= PUB_VOTES_TABLE;
		$this->pub_comments_table 	= PUB_COMMENTS_TABLE;
		$this->pub_license_table 	= PUB_LICENSE_TABLE;
		$this->pub_auth_access_table = PUB_AUTH_ACCESS_TABLE;
		
		$this->ext_name = $this->request->variable('ext_name', 'mx_publisher');
		//$this->module_root_path = $this->ext_path = $this->extension_manager->get_extension_path($this->ext_name, true);
		$sql = 'SELECT *
			FROM ' . $this->pub_cat_table . '
			ORDER BY cat_order ASC';

		if ( !( $result = $this->db->sql_query( $sql ) ) )
		{
			$this->message_die(GENERAL_ERROR, 'Couldnt Query categories info', '', __LINE__, __FILE__, $sql);
		}
		
		$cat_rowset = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		
		//$auth->acl_get('u_pub_files_download');

		for( $i = 0; $i < $cats = count($cat_rowset); $i++ )
		{
			if (isset($this->auth_user[$cat_rowset[$i]['cat_id']]['auth_view'] ) && $this->auth_user[$cat_rowset[$i]['cat_id']]['auth_view'] )
			{
				$this->cat_rowset[$cat_rowset[$i]['cat_id']] = $cat_rowset[$i];
				$this->subcat_rowset[$cat_rowset[$i]['cat_parent']][$cat_rowset[$i]['cat_id']] = $cat_rowset[$i];
				$this->total_cat++;

				//
				// Comments
				// Note: some settings are category dependent, but may use default config settings
				//
				$this->comments[$cat_rowset[$i]['cat_id']]['activated'] = $cat_rowset[$i]['cat_allow_comments'] == -1 ? ($publisher_config['use_comments'] == 1 ? true : false ) : ( $cat_rowset[$i]['cat_allow_comments'] == 1 ? true : false );

				switch($this->backend)
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
					$this->comments[$cat_rowset[$i]['cat_id']]['internal_comments'] = true; // autocreate comments when updated
				}
				
				if ($this->comments[$cat_rowset[$i]['cat_id']]['activated'] && !$this->comments[$cat_rowset[$i]['cat_id']]['internal_comments'] && intval($this->comments[$cat_rowset[$i]['cat_id']]['comments_forum_id']) < 1)
				{
					$this->message_die(GENERAL_ERROR, 'Init Failure, phpBB comments with no target forum_id :( <br> Category: ' . $cat_rowset[$i]['cat_name'] . ' Forum_id: ' . $this->comments[$cat_rowset[$i]['cat_id']]['comments_forum_id']);
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
	}
	
	/**
	* Obtain publisher config values
	*/
	public function config_values()
	{
		$publisher_config = $publisher_cached_config = array();
		if (($this->publisher_cache->get('publisher_config')) === false)
		{
			$sql = 'SELECT config_name, config_value, is_dynamic
				FROM ' . $this->pub_config_table;
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!$row['is_dynamic'])
				{
					$publisher_cached_config[$row['config_name']] = $row['config_value'];
				}
				$publisher_config[$row['config_name']] = $row['config_value'];
			}
			$this->db->sql_freeresult($result);
			$this->publisher_cache->put('publisher_config', $publisher_cached_config);
		}
		else
		{
			$sql = 'SELECT config_name, config_value, is_dynamic
				FROM ' . $this->pub_config_table;
			if ( !( $result = $this->db->sql_query($sql) ) )
			{
				$this->message_die(GENERAL_ERROR, 'Couldnt query publisher configuration', '', __LINE__, __FILE__, $sql );
			}
			
			while ($row = $this->db->sql_fetchrow($result))
			{
				$publisher_config[$row['config_name']] = $row['config_value'];
			}
			$this->db->sql_freeresult($result);
		}
		return $publisher_config;
	}
	
	/**
	* Set publisher config values
	 *
	 * @param unknown_type $config_name
	 * @param unknown_type $config_value
	 */
	function set_config($key, $new_value, $use_cache = false)
	{
		// Read out config values
		$publisher_config = $this->config_values();
		$old_value = !isset($publisher_config[$key]) ? $publisher_config[$key] : false;		
		$use_cache = (($key == 'comments_pagination') || ($key == 'pagination')) ? true : false;
			
		$sql = 'UPDATE ' . $this->pub_config_table . "
			SET config_value = '" . $this->db->sql_escape($new_value) . "'
			WHERE config_name = '" . $this->db->sql_escape($key) . "'";
		if ($old_value !== false)
		{
			$sql .= " AND config_value = '" . $this->db->sql_escape($old_value) . "'";
		}
		$this->db->sql_query($sql);
		if (!$this->db->sql_affectedrows() && isset($publisher_config[$key]))
		{
			return false;
		}
		if (!isset($publisher_config[$key]))
		{
			$sql = 'INSERT INTO ' . $this->pub_config_table . ' ' . $this->db->sql_build_array('INSERT', array(
				'config_name'	=> $key,
				'config_value'	=> $new_value,
				'is_dynamic'	=> ($use_cache) ? 0 : 1));
			$this->db->sql_query($sql);
		}
		
		$publisher_config[$key] = $new_value;
		
		if ($use_cache)
		{
			$this->publisher_cache->destroy('config');
			$this->publisher_cache->put('config', $publisher_config);	
		}
		
		return true;
	}

	/**
	* Obtain publisher config values
	 * decapritated
	 * @return unknown
	 */
	function publisher_config()
	{
		$publisher_config = array();
		
		$sql = "SELECT *
			FROM " . $this->pub_config_table;
		if ( !( $result = $this->db->sql_query($sql) ) )
		{
			$this->message_die(GENERAL_ERROR, 'Couldnt query publisher configuration', '', __LINE__, __FILE__, $sql );
		}
		while ( $row = $this->db->sql_fetchrow( $result ) )
		{
			$publisher_config[$row['config_name']] = trim( $row['config_value'] );
		}
		$this->db->sql_freeresult($result);
		return ( $publisher_config );
	}
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function obtain_publisher_config($use_cache = true)
	{
		global $db, $publisher_cache;
		
		if (($publisher_config = $publisher_cache->get('config')) && ($use_cache))
		{
			return $publisher_config;
		}
		else
		{		
			$sql = "SELECT *
				FROM " . PUB_CONFIG_TABLE;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				if (!function_exists('mx_message_die'))
				{
					die("Couldnt query publisher configuration, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
				}
				else
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt query portal configuration', '', __LINE__, __FILE__, $sql );
				}
			}

			while ( $row = $db->sql_fetchrow( $result ) )
			{
				$publisher_config[$row['config_name']] = trim( $row['config_value'] );
			}

			$db->sql_freeresult($result);

			$publisher_cache->put('config', $publisher_config);		

			return($publisher_config);
		}			
	}	

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mode
	 * @param unknown_type $page_id
	 */
	/*
	function generate_smilies( $mode, $page_id )
	{
		global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
		global $user_ip, $session_length, $starttime;
		global $userdata, $mx_user;
		global $mx_root_path, $module_root_path, $is_block, $phpEx;

		$inline_columns = 4;
		$inline_rows = 5;
		$window_columns = 8;

		if ( $mode == 'window' )
		{
			if ( !MXBB_MODULE )
			{
				$userdata = session_pagestart( $user_ip, $page_id );
				init_userprefs( $userdata );
			}
			else
			{
				$mx_user->init($user_ip, PAGE_INDEX);
			}

			$gen_simple_header = true;

			$page_title = $lang['Review_topic'] . " - $topic_title";

			include( $mx_root_path . 'includes/page_header.' . $phpEx );

			$template->set_filenames( array( 'smiliesbody' => 'posting_smilies.tpl' ) );
		}

		$sql = "SELECT emoticon, code, smile_url
			FROM " . SMILIES_TABLE . "
			ORDER BY smilies_id";
		if ( $result = $db->sql_query( $sql ) )
		{
			$num_smilies = 0;
			$rowset = array();
			while ( $row = $db->sql_fetchrow( $result ) )
			{
				if ( empty( $rowset[$row['smile_url']] ) )
				{
					$rowset[$row['smile_url']]['code'] = str_replace( "'", "\\'", str_replace( '\\', '\\\\', $row['code'] ) );
					$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
					$num_smilies++;
				}
			}

			if ( $num_smilies )
			{
				$smilies_count = ( $mode == 'inline' ) ? min( 19, $num_smilies ) : $num_smilies;
				$smilies_split_row = ( $mode == 'inline' ) ? $inline_columns - 1 : $window_columns - 1;

				$s_colspan = 0;
				$row = 0;
				$col = 0;

				while ( list( $smile_url, $data ) = @each( $rowset ) )
				{
					if ( !$col )
					{
						$template->assign_block_vars( 'smilies_row', array() );
					}

					$template->assign_block_vars( 'smilies_row.smilies_col', array(
						'SMILEY_CODE' => $data['code'],
						'SMILEY_IMG' => $phpbb_root_path . $board_config['smilies_path'] . '/' . $smile_url,
						'SMILEY_DESC' => $data['emoticon']
					));

					$s_colspan = max( $s_colspan, $col + 1 );

					if ( $col == $smilies_split_row )
					{
						if ( $mode == 'inline' && $row == $inline_rows - 1 )
						{
							break;
						}
						$col = 0;
						$row++;
					}
					else
					{
						$col++;
					}
				}

				if ( $mode == 'inline' && $num_smilies > $inline_rows * $inline_columns )
				{
					$template->assign_block_vars( 'switch_smilies_extra', array() );

					$template->assign_vars( array(
						'L_MORE_SMILIES' => $lang['More_emoticons'],
						'U_MORE_SMILIES' => mx_append_sid( $phpbb_root_path . "posting.$phpEx?mode=smilies" )
					));
				}

				$template->assign_vars( array(
					'L_EMOTICONS' => $lang['Emoticons'],
					'L_CLOSE_WINDOW' => $lang['Close_window'],
					'S_SMILIES_COLSPAN' => $s_colspan
				));
			}
		}

		if ( $mode == 'window' )
		{
			$template->pparse( 'smiliesbody' );
			include( $mx_root_path . 'includes/page_tail.' . $phpEx );
		}
	}
	*/

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $query
	 * @param unknown_type $total
	 * @param unknown_type $offset
	 * @return unknown
	 */
	function sql_query_limit( $query, $total, $offset = 0, $sql_cache = false )
	{
		global $db;

		$query .= ' LIMIT ' . ( ( !empty( $offset ) ) ? $offset . ', ' . $total : $total );
		return $sql_cache ? $db->sql_query( $query, $sql_cache ) : $db->sql_query( $query );
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $file_rating
	 * @return unknown
	 */
	function get_rating( $file_id, $file_rating = '' )
	{
		global $db, $lang;

		$sql = "SELECT AVG(rate_point) AS rating
			FROM " . PUB_VOTES_TABLE . "
			WHERE votes_file = '" . $file_id . "'";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt rating info for the giving file', '', __LINE__, __FILE__, $sql );
		}

		$row = $db->sql_fetchrow( $result );
		$db->sql_freeresult( $result );
		$file_rating = $row['rating'];

		return ( $file_rating != 0 ) ? round( $file_rating, 2 ) . ' / 10' : $lang['Not_rated'];
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $page_title
	 */
	function page_header( $page_title )
	{
		global $publisher_config, $lang, $template, $userdata, $images, $publisher, $mx_user;
		global $template, $db, $theme, $gen_simple_header, $starttime, $phpEx, $board_config, $user_ip;
		global $admin_level, $level_prior, $tree, $do_gzip_compress;
		global $phpbb_root_path, $mx_root_path, $module_root_path, $is_block, $title, $mx_block;
		global $action;

		if ( $action != 'download' )
		{
			//include_once( $mx_root_path . 'includes/page_header.' . $phpEx );
		}

		if ( $action == 'category' )
		{
			$_REQUEST['cat'] = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : $_REQUEST['cat_id'];
			
			$upload_url = mx_append_sid($publisher->this_mxurl("action=user_upload&cat_id={$_REQUEST['cat']}"));
			$upload_auth = $publisher->modules[$publisher->module_name]->auth_user[$_REQUEST['cat']]['auth_upload'];
			$mcp_url = mx_append_sid( $publisher->this_mxurl( "action=mcp&cat_id={$_REQUEST['cat']}" ) );
			$mcp_auth = $publisher->modules[$publisher->module_name]->auth_user[$_REQUEST['cat']]['auth_mod'];
			
			if ($publisher->modules[$publisher->module_name]->auth_user[$_REQUEST['cat']]['auth_post'] || $publisher->modules[$publisher->module_name]->auth_user[$_REQUEST['cat']]['auth_mod'])
			{
				$add_article_url = mx_append_sid($publisher->this_mxurl("action=add&cat=" . $_REQUEST['cat']));
				$template->assign_block_vars('switch_add_article', array());
				$template->assign_block_vars('MCP', array());
			}
			else
			{
				$add_article_url = '';
			}
		}
		else
		{
			$upload_url = mx_append_sid($publisher->this_mxurl("action=user_upload"));

			$cat_list = $publisher->modules[$publisher->module_name]->generate_jumpbox( 0, 0, '', true, true );
			$upload_auth = (empty($cat_list)) ? FALSE : TRUE;
			$upload_auth = false;
			$mcp_auth = false;
			unset( $cat_list );
		}

		$template->assign_vars( array(
				'L_TITLE' => $title,
				'IS_AUTH_VIEWALL' => ( $publisher_config['settings_viewall'] ) ? ( ( $publisher->modules[$publisher->module_name]->auth_global['auth_viewall'] ) ? true : false ) : false,
				'IS_AUTH_SEARCH' => ( $publisher->modules[$publisher->module_name]->auth_global['auth_search'] ) ? true : false,
				'IS_AUTH_STATS' => ( $publisher->modules[$publisher->module_name]->auth_global['auth_stats'] ) ? true : false,
				'IS_AUTH_TOPLIST' => ( $publisher->modules[$publisher->module_name]->auth_global['auth_toplist'] ) ? true : false,

				'IS_AUTH_UPLOAD' => $upload_auth,
				'IS_ADMIN' => ( $mx_user->data['user_level'] == ADMIN && $mx_user->data['session_logged_in'] ) ? true : 0,
				'IS_MOD' => $publisher->modules[$publisher->module_name]->auth_user[$_REQUEST['cat_id']]['auth_mod'],
				'IS_AUTH_MCP' => $mcp_auth,

				'L_OPTIONS' => $lang['Options'],
				'L_SEARCH' => $lang['Search'],
				'L_STATS' => $lang['Statistics'],
				'L_TOPLIST' => $lang['Toplist'],
				'L_UPLOAD' => $lang['User_upload'],
				'L_VIEW_ALL' => $lang['Viewall'],
				'L_ADD_ARTICLE' => $lang['Add_article'],
			
				'SEARCH_IMG' => $images['pub_search'],
				'STATS_IMG' => $images['pub_stats'],
				'TOPLIST_IMG' => $images['pub_toplist'],
				'ADD_ARTICLE_IMG' => $images['pub_post'],
				'UPLOAD_IMG' => $images['pub_upload'],
				'VIEW_ALL_IMG' => $images['pub_viewall'],
				'MCP_IMG' => $images['pub_moderator'],
				'MCP_LINK' => $lang['MCP_title'],

				'U_TOPLIST' => mx_append_sid($publisher->this_mxurl("action=toplist")),
				'U_PASEARCH' => mx_append_sid($publisher->this_mxurl("action=search")),
				'U_UPLOAD' => $upload_url,
				'U_VIEW_ALL' => mx_append_sid($publisher->this_mxurl("action=viewall")),
				'U_VIEW_ALL' => mx_append_sid($publisher->this_mxurl( "&action=stats&sort_method=viewall&sort_order=DESC") ),
				'U_PASTATS' => mx_append_sid($publisher->this_mxurl("action=stats" )),
				'U_PUBSTATS' => mx_append_sid($publisher->this_mxurl( "&action=stats") ),
				'U_ADD_ARTICLE' => $add_article_url,
				'U_MCP' => $mcp_url,

				'MX_ROOT_PATH' => $mx_root_path,
				'BLOCK_ID' => $mx_block->block_id,

				// Buttons
				'B_SEARCH_IMG' => $this->create_button('pub_search', $lang['Search'], mx_append_sid($publisher->this_mxurl("action=search"))),
				'B_STATS_IMG' => $this->create_button('pub_stats', $lang['Statistics'], mx_append_sid($publisher->this_mxurl("action=stats"))),
				'B_TOPLIST_IMG' => $this->create_button('pub_toplist', $lang['Toplist'], mx_append_sid($publisher->this_mxurl("action=toplist"))),
				'B_ADD_ARTICLE_IMG' => $this->create_button('pub_post', $lang['Add_article'], $add_article_url),
				'B_UPLOAD_IMG' => $this->create_button('pub_upload', $lang['User_upload'], $upload_url),
				'B_VIEW_ALL_IMG' => $this->create_button('pub_viewall', $lang['Viewall'], mx_append_sid($publisher->this_mxurl("action=viewall"))),
				'B_MCP_LINK' => $this->create_button('pub_moderator', $lang['MCP_title'], $mcp_url),
			));
	}

	/**
	 * Enter description here...
	 *
	 */
	function page_footer()
	{
		global $publisher_cache, $lang, $template, $board_config, $publisher, $userdata;
		global $phpEx, $template, $do_gzip_compress, $debug, $db, $starttime;
		global $phpbb_root_path, $mx_root_path, $module_root_path, $is_block, $page_id;
		global $pub_module_version, $pub_module_orig_author, $pub_module_author;

		$template->assign_vars( array(
			'L_QUICK_GO' => $lang['Quick_go'],
			'L_QUICK_NAV' => $lang['Quick_nav'],
			'L_QUICK_JUMP' => $lang['Quick_jump'],
			'JUMPMENU' => $publisher->modules[$publisher->module_name]->generate_jumpbox( 0, 0, array( $_GET['cat_id'] => 1 ) ),
			'S_JUMPBOX_ACTION' => mx_append_sid( $publisher->this_mxurl( ) ),

			'S_AUTH_LIST' => $publisher->modules[$publisher->module_name]->auth_can_list,

			'MX_PAGE' => $page_id,
			'L_MODULE_VERSION' => $pub_module_version,
			'L_MODULE_ORIG_AUTHOR' => $pub_module_orig_author,
			'L_MODULE_AUTHOR' => $pub_module_author,
			'S_TIMEZONE' => sprintf( $lang['All_times'], $lang[number_format( $board_config['board_timezone'] )] ) )
		);

		$publisher->modules[$publisher->module_name]->_publisher();

		if ( !MXBB_MODULE || MXBB_27x )
		{
			$template->assign_block_vars( 'copy_footer', array() );
		}

		if ( !isset( $_GET['explain'] ) )
		{
			$template->pparse( 'body' );
		}

		$publisher_cache->unload();

		if ( $action != 'download' )
		{
			if ( !$is_block )
			{
				//include( $mx_root_path . 'includes/page_tail.' . $phpEx );
			}
		}
	}
	

	/**
	 * Quick stats.
	 *
	 * @param unknown_type $category_id
	 */
	function get_quick_stats( $category_id = '' )
	{
		global $db, $template, $lang, $kb_config;

		$stats_list = '';

		$sql_stat = "SELECT *
				FROM " . PUB_TYPES_TABLE;

		$sql_stat .= " ORDER BY type";

		if ( !( $result = $db->sql_query( $sql_stat ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Error getting quick stats", '', __LINE__, __FILE__, $sql );
		}

		$ii = 0;
		while ( $type = $db->sql_fetchrow( $result ) )
		{
			$ii++;
			$type_id = $type['id'];
			$type_name = isset($lang['PUB_type_' . $type['type']]) ? $lang['PUB_type_' . $type['type']] : $type['type'];

			$sql = "SELECT article_id FROM " . PUB_ARTICLES_TABLE . "
				WHERE article_type = $type_id ";

			if ( !empty( $category_id ) )
			{
				$sql .= " AND article_category_id = '$category_id'";
			}

			if ( !( $count = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, "error getting quick stats", '', __LINE__, __FILE__, $sql );
			}

			$number_count = 0;
			$number_count = $db->sql_numrows( $count );

			if ( !empty( $category_id ) && $number_count > 0 )
			{
				$stats_list .= empty($stats_list) ? $type_name . '(' . $number_count . ')&nbsp' : '&bull;&nbsp;' . $type_name . '(' . $number_count . ')&nbsp' ;
			}
		}

		if (!empty($stats_list))
		{
			$template->assign_block_vars( 'switch_quick_stats', array(
				'L_QUICK_STATS' => $lang['Quick_stats'],
				'STATS' => $stats_list
			));
		}
	}

	/**
	 * get type list for adding and editing articles.
	 *
	 * @param unknown_type $sel_id
	 */
	function get_pub_type_list( $sel_id )
	{
		global $db, $template;

		$sql = "SELECT *
	       	FROM " . PUB_TYPES_TABLE;

		if ( !( $type_result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not obtain category information", '', __LINE__, __FILE__, $sql );
		}

		while ( $type = $db->sql_fetchrow( $type_result ) )
		{
			$type_name = isset($lang['PUB_type_' . $type['type']]) ? $lang['PUB_type_' . $type['type']] : $type['type'];
			$type_id = $type['id'];

			if ( $sel_id == $type_id )
			{
				$status = 'selected';
			}
			else
			{
				$status = '';
			}

			$type = '<option value="' . $type_id . '" ' . $status . '>' . $type_name . '</option>';

			$template->assign_block_vars( 'types', array(
				'TYPE' => $type )
			);
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $article
	 * @return unknown
	 */
	function article_formatting( $article )
	{
		// Prepare ingress/preword
		$search = array ();
		$replace = array ();

		$search = array ( "'\[title*?[^\[\]]*?\]'si",
			"'\[\/title*?[^\[\]]*?\]'si",
			"'\[subtitle*?[^\[\]]*?\]'si",
			"'\[\/subtitle*?[^\[\]]*?\]'si",
			"'\[subsubtitle*?[^\[\]]*?\]'si",
			"'\[\/subsubtitle*?[^\[\]]*?\]'si",
			"'\[quote*?[^\[\]]*?\]'si",
			"'\[\/quote*?[^\[\]]*?\]'si",
			"'\[abstract*?[^\[\]]*?\]'si",
			"'\[\/abstract*?[^\[\]]*?\]'si" );

		$replace = array ( "<span class=\"cattitle\">",
			"</span>",
			"<span class=\"topictitle\">",
			"</span>",
			"<span class=\"gensmall\"><b>",
			"</b></span>",
			"<div align=\"center\"><span class=\"gensmall\"><i>''",
			"''</i></span></div>",
			"<table cellpadding=\"20\" style=\"margin-bottom: -20px;\"><tr><td><span class=\"postbody\" style=\"font-weight: bold; font-size: 9pt;\">",
			"</span></td></td></tr></table>" );

		$article = preg_replace( $search, $replace, $article );

		return $article;
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
				$sql_error = array(@print_r(@$this->db->sql_error($sql), true));
				$sql_error['message'] = (isset($sql_error['message'])) ? $sql_error['message'] : '<br /><br />SQL : ' . $sql; 
				$sql_error['code'] = (isset($sql_error['code'])) ? $sql_error['code'] : 0;
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
	 * @param unknown_type $file_posticon
	 * @return unknown
	 */
	function post_icons($file_posticon = '')
	{
		global $lang, $phpbb_root_path;
		global $mx_root_path, $module_root_path, $is_block, $phpEx;
		$curicons = 1;

		if ( $file_posticon == 'none' || $file_posticon == 'none.gif' or empty( $file_posticon ) )
		{
			$posticons .= '<input type="radio" name="posticon" value="none" checked><a class="gensmall">' . $lang['None'] . '</a>&nbsp;';
		}
		else
		{
			$posticons .= '<input type="radio" name="posticon" value="none"><a class="gensmall">' . $lang['None'] . '</a>&nbsp;';
		}

		$handle = @opendir( $module_root_path . ICONS_DIR );

		while ( $icon = @readdir( $handle ) )
		{
			if ( $icon !== '.' && $icon !== '..' && $icon !== 'index.htm' )
			{
				if ( $file_posticon == $icon )
				{
					$posticons .= '<input type="radio" name="posticon" value="' . $icon . '" checked><img src="' . PORTAL_URL . $module_root_path . ICONS_DIR . $icon . '">&nbsp;';
				}
				else
				{
					$posticons .= '<input type="radio" name="posticon" value="' . $icon . '"><img src="' . PORTAL_URL . $module_root_path . ICONS_DIR . $icon . '">&nbsp;';
				}

				$curicons++;

				if ( $curicons == 8 )
				{
					$posticons .= '<br>';
					$curicons = 0;
				}
			}
		}
		@closedir( $handle );
		return $posticons;
	}

	/**
	 * Create buttons.
	 *
	 * You can create code for buttons:
	 * 1) Simple textlinks (MX_BUTTON_TEXT)
	 * 2) Standard image links (MX_BUTTON_IMAGE)
	 * 3) Generic buttons, with spanning text on top background image (MX_BUTTON_GENERIC)
	 *
	 * Note: The rollover feature is done using a css shift technique, so you do not need separate images
	 *
	 * @param unknown_type $type
	 * @param unknown_type $label
	 * @param unknown_type $url
	 * @param unknown_type $img
	 */
	function create_button($key, $label, $url, $img = '', $alt = '', $type = 'image')
	{
		switch($type)
		{
			case 'text':
				$this_buttontype = MX_BUTTON_TEXT;
			break;

			case 'image':
				$this_buttontype = MX_BUTTON_IMAGE;
			break;

			case 'generic':
				$this_buttontype = MX_BUTTON_GENERIC;
			break;

			default:
				$this_buttontype = $type;
			break;
		}
		
		switch($this_buttontype)
		{
			case MX_BUTTON_TEXT:
				return '<a class="text button" href="'. $url .'"><span>' . $label . '</span></a>';
			break;

			case MX_BUTTON_IMAGE:
				return '<a class="image button" href="'. $url .'"><img src = "' . $this->img($key, $label, false, '', 'src') . '" alt="' . $label . '" title="' . $label . '" border="0"></a>';
			break;

			case MX_BUTTON_GENERIC:
				return '<a class="generic button" href="'. $url .'"><span>' . $label . '</span></a>';
			break;

			default:
				return '<a class="' . $type . ' button" href="'. $url .'"><img src = "' . $this->img($key, $label, false, '', 'src') . '" alt="' . $label . '" title="' . $label . '" border="0"></a>';
			break;
		}
		
	}

	/**
	 * Create icons.
	 *
	 * You can create code for icons:
	 * 1) Simple textlinks (MX_BUTTON_TEXT)
	 * 2) Standard image links (MX_BUTTON_IMAGE)
	 * 3) Generic buttons, with spanning text on top background image (MX_BUTTON_GENERIC)
	 *
	 * Note: The rollover feature is done using a css shift technique, so you do not need separate images
	 *
	 * @param unknown_type $type
	 * @param unknown_type $label
	 * @param unknown_type $url
	 * @param unknown_type $img
	 */
	function create_icon($key, $label, $url, $img = '', $alt = '', $type = 'image')
	{	
		switch($type)
		{
			case 'text':
				$this_buttontype = MX_BUTTON_TEXT;
			break;

			case 'image':
				$this_buttontype = MX_BUTTON_IMAGE;
			break;

			case 'generic':
				$this_buttontype = MX_BUTTON_GENERIC;
			break;

			default:
				$this_buttontype = $type;
			break;
		}
		
		switch($this_buttontype)
		{
			case MX_BUTTON_TEXT:
				return '<a class="text button" href="'. $url .'"><span>' . $label . '</span></a>';
			break;

			case MX_BUTTON_IMAGE:
				return '<a class="image button" href="'. $url .'"><img src = "' . $this->img($key, $label, false, '', 'src') . '" alt="' . $label . '" title="' . $label . '" border="0"></a>';
			break;

			case MX_BUTTON_GENERIC:
				return '<a class="generic button" href="'. $url .'"><span>' . $label . '</span></a>';
			break;

			default:
				return '<a class="' . $type . ' button" href="'. $url .'"><img src = "' . $this->img($key, $label, false, '', 'src') . '" alt="' . $label . '" title="' . $label . '" border="0"></a>';
			break;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $license_id
	 * @return unknown
	 */
	function license_list( $license_id = 0 )
	{
		global $db, $lang;

		if ( $license_id == 0 )
		{
			$list .= '<option calue="0" selected>' . $lang['None'] . '</option>';
		}
		else
		{
			$list .= '<option calue="0">' . $lang['None'] . '</option>';
		}

		$sql = 'SELECT *
			FROM ' . PUB_LICENSE_TABLE . '
			ORDER BY license_id';

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
		}

		while ( $license = $db->sql_fetchrow( $result ) )
		{
			if ( $license_id == $license['license_id'] )
			{
				$list .= '<option value="' . $license['license_id'] . '" selected>' . $license['license_name'] . '</option>';
			}
			else
			{
				$list .= '<option value="' . $license['license_id'] . '">' . $license['license_name'] . '</option>';
			}
		}
		return $list;
	}

	/**
	* Specify/Get image
	*
	* phpBB2 Graphics - redefined for mxBB
	* - Uncomment and redefine phpBB graphics
	*
	* If you need to redefine some phpBB graphics, look within the phpBB/templates folder for the template_name.cfg file and
	* redefine those $image['xxx'] you want. Note: Many phpBB images are reused all over mxBB (eg see below), thus if you redefine
	* common phpBB images, this will have immedaite effect for all mxBB pages.
	*
	*/
	function img($img, $alt = '', $width = false, $suffix = '', $type = '')
	{
		static $imgs;
		global $phpbb_root_path, $mx_root_path, $theme, $board_config;
		global $mx_user, $mx_block, $images;
		
		/*
		* Look at MX-Publisher-Module folder.........................................................................MX-Publisher-module
		*/
		if (isset($mx_block->module_root_path))
		{
			$module_root_path = $this->module_root_path = $this->ext_path = $mx_root_path . $mx_block->module_root_path;
		}
		else
		{
			global $module_root_path; 
			
			if (isset($module_root_path))
			{
				$this->module_root_path = $this->ext_path = $module_root_path;
			}
			else
			{
				global $mx_root_path;
				$module_root_path = $this->module_root_path = $this->ext_path = is_dir($mx_root_path . 'modules/mx_publisher/') ? $mx_root_path . 'modules/mx_publisher/' : $mx_root_path . 'modules/mx_coreblocks/';
			}
		}
		
		$title = '';
		$img_ext = 'gif'; 
		if ($alt)
		{
			$alt = $mx_user->lang($alt);
			$title = ' title="' . $alt . '"';
		}
		
		if (strpos($img, '.') !== false)
		{
			// Nested img
			$image_filename = $img;
			$img_ext = substr(strrchr($image_filename, '.'), 1);
			$img = basename($image_filename, '.' . $img_ext);
			$this->img_array['image_filename'] = array(
				''.$img => $img . '.' . $img_ext,
			);
			unset($img_name, $image_filename);
		}
		
		if ($width !== false)
		{
			$this->img_array['image_width'] = array(
				''.$img => $width,
			);
		}
		
		// Load phpBB Template configuration data
		$current_template_path = $mx_user->current_template_path;
		$template_name = $mx_user->template_name;
		
		//Replace $mx_user->template_path with $mx_user->style_path
		$template_path = $mx_user->template_name;
		$default_template_path = $mx_user->default_template_name;
		
		/* Here we overwrite phpBB images from the template configuration file with images from database  */
		if (!is_array($this->img_array))
		{
			$this->img_array['image_filename'] = array(
				'site_logo' => "logo.gif",
				'upload_bar' => "upload_bar.gif",
				'icon_contact_aim' => "icon_aim.gif",
				'icon_contact_email' => "icon_email.gif",
				'icon_contact_icq' => "icon_icq_add.gif",
				'icon_contact_jabber' => "icon_jabber.gif",
				'icon_contact_msnm' => "icon_msnm.gif",
				'icon_contact_pm' => "icon_pm.gif",
				'icon_contact_yahoo' => "icon_yim.gif",
				'icon_contact_www' => "icon_www.gif",
				'icon_post_delete' => "icon_delete.gif",
				'icon_post_edit' => "icon_edit.gif",
				'icon_post_info' => "icon_info.gif",
				'icon_post_quote' => "icon_quote.gif",
				'icon_post_report' => "icon_report.gif",
				'icon_user_online' => "icon_online.gif",
				'icon_user_offline' => "icon_offline.gif",
				'icon_user_profile' => "icon_profile.gif",
				'icon_user_search' => "icon_search.gif",
				'icon_user_warn' => "icon_warn.gif",
				'button_pm_forward' => "reply.gif",
				'button_pm_new' => "msg_newpost.gif",
				'button_pm_reply' => "reply.gif",
				'button_topic_locked' => "msg_newpost.gif",
				'button_topic_new' => "post.gif",
				'button_topic_reply' => "reply.gif",
				'forum_link' => "forum_link.gif",
				'forum_read' => "forum_read.gif",
				'forum_read_locked' => "forum_read_locked.gif",
				'forum_read_subforum' => "forum_read_subforum.gif",
				'forum_unread' => "forum_unread.gif",
				'forum_unread_locked' => "forum_unread_locked.gif",
				'forum_unread_subforum' => "forum_unread_subforum.gif",
				'topic_moved' => "topic_moved.gif",
				'topic_read' => "topic_read.gif",
				'topic_read_mine' => "topic_read_mine.gif",
				'topic_read_hot' => "topic_read_hot.gif",
				'topic_read_hot_mine' => "topic_read_hot_mine.gif",
				'topic_read_locked' => "topic_read_locked.gif",
				'topic_read_locked_mine' => "topic_read_locked_mine.gif",
				'topic_unread' => "topic_unread.gif",
				'topic_unread_mine' => "topic_unread_mine.gif",
				'topic_unread_hot' => "topic_unread_hot.gif",
				'topic_unread_hot_mine' => "topic_unread_hot_mine.gif",
				'topic_unread_locked' => "topic_unread_locked.gif",
				'topic_unread_locked_mine' => "topic_unread_locked_mine.gif",
				'sticky_read' => "sticky_read.gif",
				'sticky_read_mine' => "sticky_read_mine.gif",
				'sticky_read_locked' => "sticky_read_locked.gif",
				'sticky_read_locked_mine' => "ticky_read_locked_mine.gif",
				'sticky_unread' => "sticky_unread.gif",
				'sticky_unread_mine' => "sticky_unread_mine.gif",
				'sticky_unread_locked' => "sticky_unread_locked.gif",
				'sticky_unread_locked_mine' => "sticky_unread_locked_mine.gif",
				'announce_read' => "announce_read.gif",
				'announce_read_mine' => "announce_read_mine.gif",
				'announce_read_locked' => "announce_read_locked.gif",
				'announce_read_locked_mine' => "announce_read_locked_mine.gif",
				'announce_unread' => "announce_unread.gif",
				'announce_unread_mine' => "announce_unread_mine.gif",
				'announce_unread_locked' => "announce_unread_locked.gif",
				'announce_unread_locked_mine' => "announce_unread_locked_mine.gif",
				'global_read' => "announce_read.gif",
				'global_read_mine' => "announce_read_mine.gif",
				'global_read_locked' => "announce_read_locked.gif",
				'global_read_locked_mine' => "announce_read_locked_mine.gif",
				'global_unread' => "announce_unread.gif",
				'global_unread_mine' => "announce_unread_mine.gif",
				'global_unread_locked' => "announce_unread_locked.gif",
				'global_unread_locked_mine' => "announce_unread_locked_mine.gif",
				'subforum_read' => "", 
				'subforum_unread' => "",
				'pm_read' => "topic_read.gif",
				'pm_unread' => "topic_unread.gif",
				'icon_back_top' => "",
				'icon_post_target' => "icon_post_target.gif",
				'icon_post_target_unread' => "icon_post_target_unread.gif",
				'icon_topic_attach' => "icon_topic_attach.gif",
				'icon_topic_latest' => "icon_topic_latest.gif",
				'icon_topic_newest' => "icon_topic_newest.gif",
				'icon_topic_reported' => "icon_topic_reported.gif",
				'icon_topic_unapproved' => "icon_topic_unapproved.gif"
			);
		}
		
		$this->img_array['image_lang'] = array(
			'icon_post_edit' => $mx_user->img_lang,
			'icon_post_quote' => $mx_user->img_lang,
			'button_pm_forward' => $mx_user->img_lang,
			'button_pm_new' => $mx_user->img_lang,
			'button_pm_reply' => $mx_user->img_lang,
			'button_topic_new' => $mx_user->img_lang,
			'button_topic_reply' => $mx_user->img_lang
		);

		//Setup current style path for phpBB3 styles
		$img_data = $imgs[$img];

		if (empty($mx_user->img_array))
		{
			trigger_error('NO_STYLE_DATA', E_USER_ERROR);
		}

		$lang_dir = ( is_dir($module_root_path. $current_template_path . 'lang_' . $mx_user->user_language_name . '/') ) ?  'lang_' . $mx_user->user_language_name : ( is_dir($module_root_path. $current_template_path . 'lang_' . $mx_user->default_language_name . '/') ? 'lang_' . $mx_user->default_language_name : 'lang_' . $mx_user->user_language_name);

		$img_data['src'] = isset($images[$img]) ? $images[$img] : is_file($module_root_path . $current_template_path . '/images/' . $lang_dir . '/' . $img . '.' . $img_ext) ? $module_root_path . $current_template_path . '/images/' . $lang_dir . '/' . $img . '.' . $img_ext : $module_root_path . $mx_user->current_template_path . '/images/' . $img . '.' . $img_ext;
		$img_data['src'] = isset($img_data['src']) ? $img_data['src'] : is_file($module_root_path . $mx_user->default_current_template_path . '/images/' . $lang_dir . '/' . $img . '.' . $img_ext) ? $module_root_path . $mx_user->default_current_template_path . '/images/' . $lang_dir . '/' . $img . '.' . $img_ext : $module_root_path . $mx_user->default_current_template_path . '/images/' . $img . '.' . $img_ext;
		$img_data['src'] = is_file($img_data['src']) ? $img_data['src'] : str_replace($current_template_path, $mx_user->default_current_template_path, $img_data['src']);

		$alt = (!empty($mx_user->lang[$alt])) ? $mx_user->lang[$alt] : $alt;

		$use_width = ($width === false) ? $img_data['width'] : $width;

		/* - First try phpBB3 template theme images then template lang images */
		switch ($type)
		{
			case 'src':
				return $img_data['src'];
			break;

			case 'width':
				return $use_width;
			break;

			case 'height':
				return $img_data['height'];
			break;

			case 'filename':
				return $img . '.' . $img_ext;
			break;

			case 'class':
			case 'name':
				return $img;
			break;

			case 'alt':
				return $alt;
			break;

			case 'ext':
				return $img_ext;
			break;

			case 'full_tag':
				return '<img src="' . $img_data['src'] . '"' . (($use_width) ? ' width="' . $use_width . '"' : '') . (($img_data['height']) ? ' height="' . $img_data['height'] . '"' : '') . ' alt="' . $alt . '" title="' . $alt . '" />';
			break;

			case 'html':	
			default:
				return '<span class="imageset ' . $img . '"' . $title . '>' . $alt . '</span>';
			break;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_type
	 * @return unknown
	 */
	function gen_unique_name( $file_type )
	{
		global $publisher_config;
		global $mx_root_path, $module_root_path, $is_block, $phpEx;

		srand((double)microtime() * 1000000); // for older than version 4.2.0 of PHP

		do
		{
			$filename = md5(uniqid(rand())) . $file_type;
		}
		while ( file_exists( $publisher_config['upload_dir'] . '/' . $filename ) );

		return $filename;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $filename
	 * @return unknown
	 */
	function get_extension($filename)
	{
		//return strtolower( array_pop( explode( '.', $filename ) ) );
		return strtolower(array_pop($array = (explode('.', $filename))));
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $userfile
	 * @param unknown_type $userfile_name
	 * @param unknown_type $userfile_size
	 * @param unknown_type $upload_dir
	 * @param unknown_type $local
	 * @return unknown
	 */
	function upload_file( $userfile, $userfile_name, $userfile_size, $upload_dir = '', $local = false )
	{
		global $phpbb_root_path, $lang, $phpEx, $board_config, $publisher_config, $userdata;
		global $publisher, $cat_id, $mx_root_path, $module_root_path, $is_block, $phpEx;

		@set_time_limit(0);
		$file_info = array();

		$file_info['error'] = false;

		if ( file_exists( $module_root_path . $upload_dir . $userfile_name ) )
		{
			$userfile_name = time() . $userfile_name;
		}
		// =======================================================
		// if the file size is more than the allowed size another error message
		// =======================================================
		if ( $userfile_size > $publisher_config['max_file_size'] && ( $publisher->modules[$publisher->module_name]->auth_user[$cat_id]['auth_mod'] || $userdata['user_level'] != ADMIN ) && $userdata['session_logged_in'] )
		{
			$file_info['error'] = true;
			if ( !empty( $file_info['message'] ) )
			{
				$file_info['message'] .= '<br>';
			}
			$file_info['message'] .= $lang['Filetoobig'];
		}
		// =======================================================
		// Then upload the file, and check the php version
		// =======================================================
		else
		{
			$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

			$upload_mode = ( @$ini_val( 'open_basedir' ) || @$ini_val( 'safe_mode' ) ) ? 'move' : 'copy';
			$upload_mode = ( $local ) ? 'local' : $upload_mode;

			if ( $this->do_upload_file( $upload_mode, $userfile, $module_root_path . $upload_dir . $userfile_name ) )
			{
				$file_info['error'] = true;
				if ( !empty( $file_info['message'] ) )
				{
					$file_info['message'] .= '<br>';
				}
				$file_info['message'] .= 'Couldn\'t Upload the File.';
			}
			$file_info['url'] = get_formated_url() . '/' . $module_root_path . $upload_dir . $userfile_name;
		}
		return $file_info;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $upload_mode
	 * @param unknown_type $userfile
	 * @param unknown_type $userfile_name
	 * @return unknown
	 */
	function do_upload_file( $upload_mode, $userfile, $userfile_name )
	{
		switch ( $upload_mode )
		{
			case 'copy':
				if ( !@copy( $userfile, $userfile_name ) )
				{
					if ( !@move_uploaded_file( $userfile, $userfile_name ) )
					{
						return false;
					}
				}
				@chmod( $userfile_name, 0666 );
				break;

			case 'move':
				if ( !@move_uploaded_file( $userfile, $userfile_name ) )
				{
					if ( !@copy( $userfile, $userfile_name ) )
					{
						return false;
					}
				}
				@chmod( $userfile_name, 0666 );
				break;

			case 'local':
				if ( !@copy( $userfile, $userfile_name ) )
				{
					return false;
				}
				@chmod( $userfile_name, 0666 );
				@unlink( $userfile );
				break;
		}

		return;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $file_data
	 * @return unknown
	 */
	function get_file_size( $file_id, $file_data = '' )
	{
		global $db, $lang, $phpbb_root_path, $publisher_config;
		global $mx_root_path, $module_root_path, $is_block, $phpEx;

		$directory = $module_root_path . $publisher_config['upload_dir'];

		if ( empty( $file_data ) )
		{
			$sql = "SELECT file_dlurl, file_size, unique_name, file_dir
				FROM " . PUB_FILES_TABLE . "
				WHERE file_id = '" . $file_id . "'";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query Download URL', '', __LINE__, __FILE__, $sql );
			}

			$file_data = $db->sql_fetchrow( $result );

			$db->sql_freeresult( $result );
		}

		$file_url = $file_data['file_dlurl'];
		$file_size = $file_data['file_size'];

		$formated_url = get_formated_url();
		$html_path = $formated_url . '/' . $directory;
		$update_filesize = false;

		if ( ( ( substr( $file_url, 0, strlen( $html_path ) ) == $html_path ) || !empty( $file_data['unique_name'] ) ) && empty( $file_size ) )
		{
			$file_url = basename( $file_url ) ;
			$file_name = basename( $file_url );

			if ( ( !empty( $file_data['unique_name'] ) ) && ( !file_exists( $module_root_path . $file_data['file_dir'] . $file_data['unique_name'] ) ) )
			{
				return $lang['Not_available'];
			}

			if ( empty( $file_data['unique_name'] ) )
			{
				$file_size = @filesize( $directory . $file_name );
			}
			else
			{
				$file_size = @filesize( $module_root_path . $file_data['file_dir'] . $file_data['unique_name'] );
			}

			$update_filesize = true;
		}
		elseif ( empty( $file_size ) && ( ( !( substr( $file_url, 0, strlen( $html_path ) ) == $html_path ) ) || empty( $file_data['unique_name'] ) ) )
		{
			$ourhead = "";
			$url = parse_url( $file_url );
			$host = $url['host'];
			$path = $url['path'];
			$port = ( !empty( $url['port'] ) ) ? $url['port'] : 80;
			$errno = ''; 
			$errstr = '';

			$fp = @fsockopen( $host, $port, $errno, $errstr, 20 );

			if ( !$fp )
			{
				return $lang['Not_available'];
			}
			else
			{
				fputs( $fp, "HEAD $file_url HTTP/1.1\r\n" );
				fputs( $fp, "HOST: $host\r\n" );
				fputs( $fp, "Connection: close\r\n\r\n" );

				while ( !feof( $fp ) )
				{
					$ourhead = sprintf( '%s%s', $ourhead, fgets ( $fp, 128 ) );
				}
			}
			@fclose ( $fp );

			$split_head = explode( 'Content-Length: ', $ourhead );

			$file_size = round( abs( $split_head[1] ) );
			$update_filesize = true;
		}
		
		if ( !$file_size )
		{
			//Check if file is not hosted on same domain relative to mx_root_path
			if (file_exists(str_replace(PORTAL_URL, "./", $file_url)))
			{
				$file_size = @filesize(str_replace(PORTAL_URL, "./", $file_url));
			}
			elseif  (file_exists($mx_root_path . $module_root_path . $file_data['file_dir'] . str_replace(PORTAL_URL, "./", $file_url)))
			{			
				$file_size = @filesize($mx_root_path . $module_root_path . $file_data['file_dir'] . str_replace(PORTAL_URL, "./", $file_url));
			}				
			else
			{
				return $lang['Not_available'];
			}				
		}		

		if ( $update_filesize )
		{
			$sql = 'UPDATE ' . PUB_FILES_TABLE . "
				SET file_size = '$file_size'
				WHERE file_id = '$file_id'";

			if ( !( $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not update filesize', '', __LINE__, __FILE__, $sql );
			}
		}

		if ( $file_size < 1024 )
		{
			$file_size_out = intval( $file_size ) . ' ' . $lang['Bytes'];
		}
		if ( $file_size >= 1025 )
		{
			$file_size_out = round( intval( $file_size ) / 1024 * 100 ) / 100 . ' ' . $lang['KB'];
		}
		if ( $file_size >= 1048575 )
		{
			$file_size_out = round( intval( $file_size ) / 1048576 * 100 ) / 100 . ' ' . $lang['MB'];
		}

		return $file_size_out;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $filename
	 * @return unknown
	 */
	function publisher_unlink( $filename )
	{
		global $publisher_config, $lang;

		$deleted = @unlink( $filename );

		if ( @file_exists( $this->publisher_realpath( $filename ) ) )
		{
			$filesys = preg_replace('/', '\\', $filename);
			$deleted = @system( "del $filesys" );

			if ( @file_exists( $this->publisher_realpath( $filename ) ) )
			{
				$deleted = @chmod ( $filename, 0775 );
				$deleted = @unlink( $filename );
				$deleted = @system( "del $filesys" );
			}
		}

		return ( $deleted );
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $path
	 * @return unknown
	 */
	function publisher_realpath( $path )
	{
		global $phpbb_root_path, $phpEx;

		return ( !@function_exists( 'realpath' ) || !@realpath( $phpbb_root_path . 'includes/functions.' . $phpEx ) ) ? $path : @realpath( $path );
	}
}

/**
 * mx_user_info
 *
 * This class is used to determin Browser and operating system info of the user
 *
 * @access public
 * @author http://www.chipchapin.com
 * @copyright (c) 2002 Chip Chapin <cchapin@chipchapin.com>
 */
class mx_user_info
{
	var $agent = 'unknown';
	var $ver = 0;
	var $majorver = 0;
	var $minorver = 0;
	var $platform = 'unknown';

	/**
	 * Constructor.
	 *
	 * Determine client browser type, version and platform using heuristic examination of user agent string.
	 *
	 * @param unknown_type $user_agent allows override of user agent string for testing.
	 */
	function mx_user_info( $user_agent = '' )
	{
		global $_SERVER, $HTTP_USER_AGENT, $_SERVER;

		if ( !empty( $_SERVER['HTTP_USER_AGENT'] ) )
		{
			$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
		}
		else if ( !empty( $_SERVER['HTTP_USER_AGENT'] ) )
		{
			$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
		}
		else if ( !isset( $HTTP_USER_AGENT ) )
		{
			$HTTP_USER_AGENT = '';
		}

		if ( empty( $user_agent ) )
		{
			$user_agent = $HTTP_USER_AGENT;
		}

		$user_agent = strtolower($user_agent);
		// Determine browser and version
		// The order in which we test the agents patterns is important
		// Intentionally ignore Konquerer.  It should show up as Mozilla.
		// post-Netscape Mozilla versions using Gecko show up as Mozilla 5.0
		// known browsers, list will be updated routinely, check back now and then
		if ( preg_match( '/(android\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(iphone\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(ipod\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;		
		elseif ( preg_match( '/(phoenix\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(firebird\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;	
		elseif ( preg_match( '/(konqueror |konq\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;		
		elseif ( preg_match( '/(netscape\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;		
		elseif ( preg_match( '/(opera |opera\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(msie )([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;			
		elseif ( preg_match( '/(theworld )([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(chrome\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;		
		elseif ( preg_match( '/(safari |saf\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;		
		elseif ( preg_match( '/(applewebkit )([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ); 
		elseif ( preg_match( '/(mozilla\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) );
		elseif ( preg_match( '/(firefox\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(maxthon )([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;		
		// covers Netscape 6-7, K-Meleon, Most linux versions, uses moz array below
		elseif ( preg_match( '/(gecko |moz\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(netpositive |netp\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(lynx |lynx\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(elinks |elinks\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(links |links\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(w3m |w3m\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(webtv |webtv\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(amaya |amaya\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(dillo |dillo\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(ibrowsevibrowse |ibrowsevibrowse\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(icab |icab\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(crazy browser |ie\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(sonyericssonp800 |sonyericssonp800\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(aol )([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(camino )([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		// search engine spider bots:
		elseif ( preg_match( '/(googlebot |google\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(mediapartners-google |adsense\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(yahoo-verticalcrawler |yahoo\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(yahoo! slurp |yahoo\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(yahoo-mm |yahoomm\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(inktomi |inktomi\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(slurp |inktomi\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(fast-webcrawler |fast\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(msnbot |msn\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(ask jeeves |ask\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(teoma |ask\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(scooter |scooter\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(openbot |openbot\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(ia_archiver |ia_archiver\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(zyborg |looksmart\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(almaden |ibm\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(baiduspider |baidu\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(psbot |psbot\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(gigabot |gigabot\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(naverbot |naverbot\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(surveybot |surveybot\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(boitho.com-dc |boitho\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(objectssearch |objectsearch\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(answerbus |answerbus\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(sohu-search |sohu\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(iltrovatore-setaccio |il-set\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		// various http utility libaries
		elseif ( preg_match( '/(w3c_validator |w3c\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(wdg_validator |wdg\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(libwww-perl |libwww-perl\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(jakarta commons-httpclient |jakarta\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(python-urllib |python-urllib\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		// download apps
		elseif ( preg_match( '/(getright |getright\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		elseif ( preg_match( '/(wget |wget\/)([0-9]*).([0-9]{1,2})/', $user_agent, $matches ) ) ;
		else
		{
			$matches[1] = 'unknown';
			$matches[2] = 0;
			$matches[3] = 0;
		}

		$this->majorver = $matches[2];
		$this->minorver = $matches[3];
		$this->ver = $matches[2] . '.' . $matches[3];
		switch ( $matches[1] )
		{
			case 'Android/':
			case 'android ':
				$this->agent = 'ANDROID';
			break;
			case 'iPhone/':
			case 'iphone ':
				$this->agent = 'IPHONE';
			break;
			case 'iPod/':
			case 'ipod ':
				$this->agent = 'IPOD';
			break;
			case 'Chrome/':
			case 'chrome ':
				$this->agent = 'GOOGLE_CHROME';
			break;
			case 'opera/':
			case 'opera ':
				$this->agent = 'OPERA';
			break;				
			case 'opera/':
			case 'opera ':
				$this->agent = 'OPERA';
			break;
			case 'msie ':
				$this->agent = 'IE';
			break;
			case 'TheWorld/':
			case 'theworld ':			
				$this->agent = 'THEWORLD';
			break;			
			case 'mozilla/':
				$this->agent = 'NETSCAPE';
				if ( $this->majorver >= 5 )
				{
					$this->agent = 'MOZILLA';
				}
			break;
			case 'firefox/':
			case 'firefox ':			
				$this->agent = 'MOZILLA';
			break;			
 			case 'phoenix ':
 			case 'firebird ':
				$this->agent = 'MOZILLA';
			break;
			case 'konqueror ':
			case 'konq ':
				$this->agent = 'KONQUEROR';
			break;
			case 'lynx/':
			case 'lynx ':
				$this->agent = 'LYNX';
			break;
			case 'safari ':
			case 'saf ':
				$this->agent = 'SAFARI';
			break;
			case 'Maxthon/':
			case 'maxthon ':			
				$this->agent = 'MAXTHON';
			break;			
			case 'aol/':
			case 'aol ':
				$this->agent = 'AOL';
			break;
			case 'omniweb':
			case 'omni ':
				$this->agent = 'OTHER';
			break;
			case 'gecko ':
 			case 'moz ':
				$this->agent = 'OTHER';
			break;
			case 'netpositive ':
			case 'netp ':
				$this->agent = 'OTHER';
			break;

			case 'elinks/':
			case 'elinks ':
				$this->agent = 'OTHER';
			break;
			case 'links/':
			case 'links ':
				$this->agent = 'OTHER';
			break;
			case 'w3m/':
			case 'w3m ':
				$this->agent = 'OTHER';
			break;
			case 'webtv/':
			case 'webtv ':
				$this->agent = 'OTHER';
			break;
			case 'amaya/':
			case 'amaya ':
				$this->agent = 'OTHER';
			break;
			case 'dillo/':
			case 'dillo ':
				$this->agent = 'OTHER';
			break;
			case 'ibrowsevibrowse/':
			case 'ibrowsevibrowse ':
				$this->agent = 'OTHER';
			break;
			case 'icab/':
			case 'icab ':
				$this->agent = 'OTHER';
			break;
			case 'crazy browser ':
			case 'ie ':
				$this->agent = 'OTHER';
			break;
			case 'camino/ ':
			case 'camino ':
				$this->agent = 'OTHER';
			break;
			case 'sonyericssonp800/':
			case 'sonyericssonp800 ':
				$this->agent = 'OTHER';
			break;
			
			case 'googlebot ':
			case 'google ':
			case 'mediapartners-google ':
			case 'adsense ':
			case 'yahoo-verticalcrawler ':
			case 'yahoo ':
			case 'yahoo! slurp ':
			case 'yahoo-mm ':
			case 'yahoomm ':
			case 'inktomi ':
			case 'slurp ':
			case 'fast-webcrawler ':
			case 'msnbot ':
			case 'msn ':
			case 'ask jeeves ':
			case 'ask ':
			case 'teoma ':
			case 'scooter ':
			case 'openbot ':
			case 'ia_archiver ':
			case 'zyborg ':
			case 'looksmart ':
			case 'almaden ':
			case 'baiduspider ':
			case 'baidu ':
			case 'psbot ':
			case 'gigabot ':
			case 'naverbot ':
			case 'surveybot ':
			case 'boitho.com-dc ':
			case 'boitho ':
			case 'objectssearch ':
			case 'answerbus ':
			case 'sohu-search ':
			case 'sohu ':
			case 'iltrovatore-setaccio ':
			case 'il-set ':
				$this->agent = 'BOT';
			break;
			case 'unknown':
				$this->agent = 'UNKNOWN';
			break;
			default:
				$this->agent = 'Oops!';
		}	
		// Determine platform
		// This is very incomplete for platforms other than Win/Mac
		if ( preg_match( '/(android|iphone|ipod|win|mac|linux|unix|x11|freebsd|beos|ubuntu|fedora|os2|irix|sunos|aix)/', $user_agent, $matches ) );
		else $matches[1] = 'unknown';
		
		switch ( $matches[1] )
		{
			// Mobiles		
			case 'android':
				$this->platform = 'Android';
			break;		
			case 'iphone':
				$this->platform = 'IOS';
			break;	
			case 'ipod':
				$this->platform = 'IOS';
			break;
			// Windows			
			case 'win':
				$this->platform = 'Win';
			break;		
			// Mac			
			case 'mac':
				$this->platform = 'Mac';
			break;
			case 'os2':
				$this->platform = 'OS2';
				break;			
			// Linux		
			case 'linux':
				$this->platform = 'Linux';
			break;
			case 'unix':
			case 'x11':
				$this->platform = 'Unix';
			break;
			case 'freebsd':
				$this->platform = 'FreeBSD';
			break;
			case 'beos':
				$this->platform = 'BeOS';
			break;
			case 'ubuntu':
				$this->platform = 'Ubuntu';
			break;
			case 'fedora':
				$this->platform = 'Fedora';
			break;			
			
            case 'irix':
				$this->platform = 'IRIX';
			break;
            case 'sunos':
				$this->platform = 'SunOS';
			break;
            case 'aix':
				$this->platform = 'Aix';
			break;
            case 'palm':
				$this->platform = 'PalmOS';
			break;
			case 'unknown':
				$this->platform = 'Other';
			break;
			default:
				$this->platform = 'Oops!';
		}
	}

	/**
	 * update_info.
	 *
	 * @param unknown_type $id
	 */
	function update_info( $id )
	{
		global $user_ip, $db, $userdata;

		$where_sql = ( $userdata['user_id'] != ANONYMOUS ) ? "user_id = '" . $userdata['user_id'] . "'" : "downloader_ip = '" . $user_ip . "'";

		$sql = "SELECT user_id, downloader_ip
			FROM " . PUB_FILES_INFO_TABLE . "
			WHERE $where_sql";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query User id', '', __LINE__, __FILE__, $sql );
		}

		if ( !$db->sql_numrows( $result ) )
		{
			$sql = "INSERT INTO " . PUB_FILES_INFO_TABLE . " (file_id, user_id, downloader_ip, downloader_os, downloader_browser, browser_version)
						VALUES('" . $id . "', '" . $userdata['user_id'] . "', '" . $user_ip . "', '" . $this->platform . "', '" . $this->agent . "', '" . $this->ver . "')";
			if ( !( $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Update Downloader Table Info', '', __LINE__, __FILE__, $sql );
			}
		}

		$db->sql_freeresult( $result );
	}
}

/**
 * mx_pub_notification.
 *
 * This class extends general mx_notification class
 *
 * // MODE: MX_PM_MODE/MX_MAIL_MODE, $id: get all file/article data for this id
 * $mx_notification->init($mode, $id); // MODE: MX_PM_MODE/MX_MAIL_MODE
 *
 * // MODE: MX_PM_MODE/MX_MAIL_MODE, ACTION: MX_NEW_NOTIFICATION/MX_EDITED_NOTIFICATION/MX_APPROVED_NOTIFICATION/MX_UNAPPROVED_NOTIFICATION
 * $mx_notification->notify( $mode = MX_PM_MODE, $action = MX_NEW_NOTIFICATION, $to_id, $from_id, $subject, $message, $html_on, $bbcode_on, $smilies_on )
 *
 * @access public
 * @author Jon Ohlsson
 */
class mx_pub_notification extends mx_notification
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $item_id
	 */
	function init($item_id = 0, $allow_comment_wysiwyg = 0)
	{
		global $db, $lang, $module_root_path, $phpbb_root_path, $mx_root_path, $phpEx, $userdata, $publisher;

			// =======================================================
			// item id is not set, give him/her a nice error message
			// =======================================================
			if (empty($item_id))
			{
				mx_message_die(GENERAL_ERROR, 'Bad Init pars');
			}

			unset($this->langs);

			//
			// Build up generic lang keys
			//
			$this->langs['item_not_exist'] = $lang['File_not_exist'];
			$this->langs['module_title'] = $lang['PUB_prefix'];

			$this->langs['notify_subject_new'] = $lang['PUB_notify_subject_new'];
			$this->langs['notify_subject_edited'] = $lang['PUB_notify_subject_edited'];
			$this->langs['notify_subject_approved'] = $lang['PUB_notify_subject_approved'];
			$this->langs['notify_subject_unapproved'] = $lang['PUB_notify_subject_unapproved'];
			$this->langs['notify_subject_deleted'] = $lang['PUB_notify_subject_deleted'];

			$this->langs['notify_new_body'] = $lang['PUB_notify_new_body'];
			$this->langs['notify_edited_body'] = $lang['PUB_notify_edited_body'];
			$this->langs['notify_approved_body'] = $lang['PUB_notify_approved_body'];
			$this->langs['notify_unapproved_body'] = $lang['PUB_notify_unapproved_body'];
			$this->langs['notify_deleted_body'] = $lang['PUB_notify_deleted_body'];

			$this->langs['item_title'] = $lang['File'];
			$this->langs['author'] = $lang['Submited'] ? $lang['Submited'] : $lang['Creator'];
			$this->langs['item_description'] = $lang['Desc'];
			$this->langs['item_type'] = '';
			$this->langs['category'] = $lang['Category'];
			$this->langs['read_full_item'] = $lang['PUB_goto'];
			$this->langs['edited_item_info'] = $lang['Edited_Article_info'];

			switch ( SQL_LAYER )
			{
				case 'oracle':
					$sql = "SELECT f.*, AVG(r.rate_point) AS rating, COUNT(r.votes_file) AS total_votes, u.user_id, u.username
						FROM " . PUB_FILES_TABLE . " AS f, " . PUB_VOTES_TABLE . " AS r, " . USERS_TABLE . " AS u, " . PUB_CATEGORY_TABLE . " AS c
						WHERE f.file_id = r.votes_file(+)
						AND f.user_id = u.user_id(+)
						AND c.cat_id = a.file_catid
						AND f.file_id = '" . $item_id . "'
						GROUP BY f.file_id ";
					break;

				default:
            		$sql = "SELECT f.*, AVG(r.rate_point) AS rating, COUNT(r.votes_file) AS total_votes, u.user_id, u.username
                  		FROM " . PUB_FILES_TABLE . " AS f
                     		LEFT JOIN " . PUB_CATEGORY_TABLE . " AS cat ON f.file_catid = cat.cat_id
                     		LEFT JOIN " . PUB_VOTES_TABLE . " AS r ON f.file_id = r.votes_file
                     		LEFT JOIN " . USERS_TABLE . " AS u ON f.user_id = u.user_id
                  		WHERE f.file_id = '" . $item_id . "'
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
			if ( !$item_data = $db->sql_fetchrow( $result ) )
			{
				mx_message_die( GENERAL_MESSAGE, $this->langs['Item_not_exist'] );
			}

			$db->sql_freeresult( $result );

			unset($this->data);

			//
			// File data
			//
			$this->data['item_id'] = $item_id;
			$this->data['item_title'] = $item_data['file_name'];
			$this->data['item_desc'] = $item_data['file_desc'];


			//
			// Category data
			//
			$this->data['item_category_id'] = $item_data['cat_id'];
			$this->data['item_category_name'] = $item_data['cat_name'];

			//
			// File author
			//
			$this->data['item_author_id'] = $item_data['user_id'];
			$this->data['item_author'] = ( $item_data['user_id'] != ANONYMOUS ) ? $item_data['username'] : $lang['Guest'];

			//
			// File editor
			//
			$this->data['item_editor_id'] = $userdata['user_id'];
			$this->data['item_editor'] = ( $userdata['user_id'] != '-1' ) ? $userdata['username'] : $lang['Guest'];

			$mx_root_path_tmp = $mx_root_path; // Stupid workaround, since phpbb posts need full paths.
			$mx_root_path = '';
			$this->temp_url = PORTAL_URL . $publisher->this_mxurl("action=" . "file&file_id=" . $this->data['item_id'], false, true);
			$mx_root_path = $mx_root_path_tmp;

			//
			// Toggles
			//
			$this->allow_comment_wysiwyg = $allow_comment_wysiwyg;
	}
}

// ------------------------------------
// Functions
// ------------------------------------

/**
 * Enter description here...
 *
 * @return unknown
 */
function get_formated_url()
{
	global $board_config;
	global $mx_script_name;

	$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
	$server_name = preg_replace( '#^\/?(.*?)\/?$#', '\1', trim( $board_config['server_name'] ) );
	$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim( $board_config['server_port'] ) : '';
	$script_name = preg_replace( '#^\/?(.*?)\/?$#', '\1', trim( $mx_script_name ) );
	$script_name = ( $script_name == '' ) ? $script_name : '/' . $script_name;
	$formated_url = $server_protocol . $server_name . $server_port . $script_name;

	return $formated_url;
}

/**
 * Enter description here...
 *
 * @param unknown_type $rating
 * @return unknown
 */
function paImageRating( $rating )
{
	global $db, $album_sp_config, $module_root_path;

	if ( !$rating )
		return( "<i>Not Rated</i>" );
	else
		return ( round( $rating, 2 ) );
}

// =========================================================================
// this function Borrowed from Acyd Burn attachment mod, (thanks Acyd for this great mod)
// =========================================================================
function send_file_to_browser($real_filename, $physical_filename, $upload_dir)
{
	global $_SERVER, $HTTP_USER_AGENT, $_SERVER, $lang, $db, $publisher_functions;

	if ( $upload_dir == '' )
	{
		$filename = $physical_filename;
	}
	else
	{
		$filename = $upload_dir . $physical_filename;
	}

	$gotit = false;
	if (!file_exists($publisher_functions->publisher_realpath($filename)))
	{
		mx_message_die(GENERAL_ERROR, $lang['Error_no_download'] . '<br /><br /><b>404 File Not Found:</b> The File <i>' . $filename . '</i> does not exist.');
	}
	else
	{
		$gotit = true;
		$size = @filesize( $filename );
		if ( $size > ( 1048575 * 6 ) )
		{
			return false;
		}
	}

	// Determine the Browser the User is using, because of some nasty incompatibilities.
	// borrowed from phpMyAdmin. :)
	$user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
	$log_version = array();
	//return preg_match(‘|#'.$pattern.'#', $string, $array);  
	if (preg_match('/Opera ([0-9].[0-9]{1,2})/', $user_agent, $log_version))
	{
		$browser_version = $log_version[2];
		$browser_agent = 'opera';
	}
	else if (preg_match('/MSIE ([0-9].[0-9]{1,2})/', $user_agent, $log_version))
	{
		$browser_version = $log_version[1];
		$browser_agent = 'ie';
	}
	else if (preg_match( '/(mozilla\/)([0-9]*).([0-9]{1,2})/', $user_agent, $log_version))
	{
		$browser_version = $log_version[1];
		$browser_agent = 'mozilla';
	}
	else if (preg_match( '/(Safari\/)([0-9]*).([0-9]{1,2})/', $user_agent, $log_version))		
	{
		$browser_version = $log_version[1] . '.' . $log_version[1];
		$browser_agent = 'safari';
	}
	else if (preg_match('/BROWSER_CHROME ([0-9].[0-9]{1,2})/', strtoupper($user_agent), $log_version))		
	{
		$browser_version = $log_version[1] . '.' . $log_version[1];
		$browser_agent = 'CHROME';
	}	
	else if (preg_match( '/(theworld\/)([0-9]*).([0-9]{1,2})/', $user_agent, $log_version))
	{
		$browser_version = $log_version[1];
		$browser_agent = 'theworld';
	}		
	else if (preg_match( '/(maxthon\/)([0-9]*).([0-9]{1,2})/', $user_agent, $log_version))
	{
		$browser_version = $log_version[1];
		$browser_agent = 'maxthon';
	}	
	else if (preg_match( '/(OmniWeb\/)([0-9]*).([0-9]{1,2})/', $user_agent, $log_version))	
	{
		$browser_version = $log_version[1];
		$browser_agent = 'omniweb';
	}
	else if (preg_match( '/(Konqueror\/)([0-9]*).([0-9]{1,2})/', $user_agent, $log_version))		
	{
		$browser_version = $log_version[2];
		$browser_agent = 'konqueror';
	}
	else if (preg_match('/BROWSER_IPHONE ([0-9].[0-9]{1,2})/', strtoupper($user_agent), $log_version))		
	{
		$browser_version = $log_version[2];
		$browser_agent = 'IPHONE';	        
	}
	else if (preg_match('/BROWSER_IPOD ([0-9].[0-9]{1,2})/', strtoupper($user_agent), $log_version))		
	{	
		$browser_version = $log_version[2];
		$browser_agent = 'IPOD';	        
	} 
	else if (preg_match('/BROWSER_ANDROID ([0-9].[0-9]{1,2})/', strtoupper($user_agent), $log_version))		
	{		
		$browser_version = $log_version[2];
		$browser_agent = 'ANDROID';	        
	}        
	else
	{
		$browser_version = 0;
		$browser_agent = 'other';
	}

	//
	// Get mimetype
	//
	switch ($publisher_functions->get_extension($physical_filename))
	{
		case 'pdf':
			$mimetype = 'application/pdf';
		break;

		case 'zip':
			$mimetype = 'application/zip';
		break;

		case 'gzip':
			$mimetype = 'application/x-gzip';
		break;

		case 'tar':
			$mimetype = 'application/x-tar';
		break;

		case 'tar.gz':
			$mimetype = 'application/x-gzip';
		break;

		case 'tar.bz2':
			$mimetype = 'application/x-bzip2';
		break;

		case 'doc':
			$mimetype = 'application/msword';
		break;

		// Windows Media Player
		case 'mpg':
			$mimetype = 'application/x-mplayer2';
		break;

		case 'mp3':
			$mimetype = 'audio/mp3';
		break;

		/*
		case 'asx':
			$mimetype = 'video/x-ms-asf';
		break;

		case 'wma':
			$mimetype = 'audio/x-ms-wma';
		break;

		case 'wax':
			$mimetype = 'audio/x-ms-wax';
		break;

		case 'wmv':
			$mimetype = 'video/x-ms-wmv';
		break;

		case 'wvx':
			$mimetype = 'video/x-ms-wvx';
		break;

		case 'wm':
			$mimetype = 'video/x-ms-wm';
		break;

		case 'wmx':
			$mimetype = 'video/x-ms-wmx';
		break;

		case 'wmz':
			$mimetype = 'application/x-ms-wmz';
		break;

		case 'wmd':
			$mimetype = 'application/x-ms-wmd';
		break;
		*/

		// Real Player
		case 'rpm':
			$mimetype = 'audio/x-pn-realaudio-plugin';
		break;

		default:
			$mimetype = ($browser_agent == 'ie' || $browser_agent == 'opera') ? 'application/octetstream' : 'application/octet-stream';
		break;
	}

	//
	// Correct the Mime Type, if it's an octetstream
	//
	/*
	if ( ( $mimetype == 'application/octet-stream' ) || ( $mimetype == 'application/octetstream' ) )
	{
		$mimetype = ($browser_agent == 'ie' || $browser_agent == 'opera') ? 'application/octetstream' : 'application/octet-stream';
	}
	*/

	// Correct the mime type - we force application/octetstream for all files, except images
	// Please do not change this, it is a security precaution
	//$mimetype = ($browser_agent == 'ie' || $browser_agent == 'opera') ? 'application/octetstream' : 'application/octet-stream';

	if (@ob_get_length())
	{
		@ob_end_clean();
	}
	@ini_set( 'zlib.output_compression', 'Off' );

	header('Pragma: public');
	header('Cache-control: private, must-revalidate');

	// Send out the Headers
	if ( isset($_GET['save_as']) || true)
	{
		//
		// Force the "save file as" dialog
		//
		$mimetype = 'application/x-download'; // Fix for avoiding browser doing an 'inline' for known mimetype anyway
		header('Content-Type: ' . $mimetype . '; name="' . $real_filename . '"');
		header('Content-Disposition: attachment; filename="' . $real_filename . '"');
	}
	else
	{
		header('Content-Type: ' . $mimetype . '; name="' . $real_filename . '"');
		header('Content-Disposition: inline; filename="' . $real_filename . '"');
	}

	// Now send the File Contents to the Browser
	$size = @filesize($filename);
	if ($size)
	{
		header("Content-length: $size");
	}
	$result = @readfile($filename);

	if (!$result)
	{
		// PHP track_errors setting On?
		if (!empty($php_errormsg))
		{
			mx_message_die( GENERAL_ERROR, 'Unable to deliver file.<br />Error was: ' . $php_errormsg, E_USER_WARNING);
		}

		mx_message_die( GENERAL_ERROR, 'Unable to deliver file.');
	}

	flush();
	exit;
}

function pub_redirect( $file_url )
{
	global $publisher_cache, $db;
	if ( isset( $db ) )
	{
		$db->sql_close();
	}

	if ( isset( $publisher_cache ) )
	{
		$publisher_cache->unload();
	}
	// Redirect via an HTML form for PITA webservers
	if ( @preg_match( '/Microsoft|WebSTAR|Xitami/', getenv( 'SERVER_SOFTWARE' ) ) )
	{
		header( 'Refresh: 0; URL=' . $file_url );
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta http-equiv="refresh" content="0; url=' . $file_url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $file_url . '">HERE</a> to be redirected</div></body></html>';
		exit;
	}
	// Behave as per HTTP/1.1 spec for others
	header( "Location: $file_url" );
	exit();
}
?>