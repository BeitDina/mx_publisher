<?php
/**
*
* @package MX-Publisher Module - mx_pub
* @version $Id: pub_pages.php,v 1.7 2008/06/03 20:10:28 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

class pub_pages
{
	var $target_file = 'app.php';
	var $phpbb_block_map = array();
	var $cache_key = '_pagemap_pub';

	var $get_cat = 'cat';
	var $get_item = 'k';

	var $cat_id = 0;
	var $item_id = 0;

	var $page_id = '';  // To be used externally (return)
	var $error = false; // To be used externally (return)

	function init($target_file)
	{
		global $db, $mx_user, $mx_cache, $mx_root_path, $module_root_path, $phpEx, $mx_table_prefix;

		//
		// Includes
		//
		include_once($module_root_path . 'publisher/core/publisher_constants.' . $phpEx);

		//
		// General init
		//
		$this->target_file = $target_file;
		$this->page_id = '';
		$this->phpbb_block_map = array();
		$this->cache_key = '_pagemap_pub_' . $this->target_file;

		if ( MXBB_27x )
		{
			//
			// Simple usage, for old MX-Publisher versions
			//
			$this->page_id = get_page_id( $this->target_file, true );

			if ( !$this->page_id )
			{
				$this->page_id = get_page_id('app.php', true);
			}
			if ( !$this->page_id )
			{
				//$this->page_id = 8;
			}
			$this->error = !$this->page_id ? true : false;

			//
			// Start initial var setup
			//
			$this->cat_id = $this->item_id = '';

			if ( isset( $_GET[$this->get_cat] ) || isset( $_POST[$this->get_cat] ) )
			{
				$this->cat_id = ( isset( $_GET[$this->get_cat] ) ) ? intval( $_GET[$this->get_cat] ) : intval( $_POST[$this->get_cat] );
			}
			else if ( isset( $_GET[$this->get_item] ) || isset( $_POST[$this->get_item] ) )
			{
				$this->item_id = ( isset( $_GET[$this->get_item] ) ) ? intval( $_GET[$this->get_item] ) : intval( $_POST[$this->get_item] );
			}
		}
		else
		{
			//
			// Note: This piece of code snippet is somewhat ugly and needs cleaning up...still it works...
			// What it does?
			// Well if given a direct kb article link, it finds on what portal page the kb block is located.
			// Since we can have different kb blocks on different portal pages displaying different kb categories/articles, this check is needed ;)
			//

			//
			// Try to reuse results.
			//
			if ( $mx_cache->_exists( $this->cache_key ) )
			{
				$this->phpbb_block_map = unserialize( $mx_cache->get( $this->cache_key ) );
			}
			else
			{
				//
				// Query to find all mappings between article categories and portal pages
				//
				$sql = "SELECT col.page_id, blk.block_id, sys.parameter_value, fnc.function_file
				   		FROM " . COLUMN_BLOCK_TABLE . " bct,
						" . COLUMN_TABLE . " col,
						" . BLOCK_TABLE . " blk,
						" . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
						" . FUNCTION_TABLE . " fnc,
						" . PARAMETER_TABLE . " par
				   		WHERE col.column_id = bct.column_id
						AND blk.function_id = fnc.function_id
						AND par.function_id = fnc.function_id
				   		AND blk.block_id    = bct.block_id
						AND blk.block_id    = sys.block_id
						AND par.parameter_type = 'pub_type_select'
						AND fnc.function_file = '".$this->target_file."'
				   		ORDER BY page_id, block_id";

				if ( !$phpbb_result = $db->sql_query( $sql ) )
				{
					mx_message_die( GENERAL_ERROR, "Could not query modules information", "", __LINE__, __FILE__, $sql );
				}

				while ( $phpbb_rows = $db->sql_fetchrow( $phpbb_result ) )
				{
					$phpbb_type_select_data = ( !empty( $phpbb_rows['parameter_value'] ) ) ? unserialize($phpbb_rows['parameter_value']) : array();

					if (is_array($phpbb_type_select_data))
					{
						foreach ($phpbb_type_select_data as $forum_id => $value)
						{
							if ($value == 1)
							{
								$this->phpbb_block_map[$forum_id] = $phpbb_rows['page_id'];
							}
						}
					}
				}
				$db->sql_freeresult($result);

				$mx_cache->put( $this->cache_key, serialize($this->phpbb_block_map) );
			}

			//
			// Start initial var setup
			//
			$this->cat_id = $this->item_id = $sql = '';
			if ( isset( $_GET[$this->get_cat] ) || isset( $_POST[$this->get_cat] ) )
			{
				$this->cat_id = ( isset( $_GET[$this->get_cat] ) ) ? intval( $_GET[$this->get_cat] ) : intval( $_POST[$this->get_cat] );
			}
			else if ( isset( $_GET[$this->get_item] ) || isset( $_POST[$this->get_item] ) )
			{
				$this->item_id = ( isset( $_GET[$this->get_item] ) ) ? intval( $_GET[$this->get_item] ) : intval( $_POST[$this->get_item] );

				$sql = "SELECT article_category_id
				FROM " . PUB_ARTICLES_TABLE . "
				WHERE article_id = $this->item_id";

				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, "no info - error", '', __LINE__, __FILE__, $sql );
				}

				$row = $db->sql_fetchrow( $result );

				$this->cat_id = $row['article_category_id'];
			}

			$this->page_id = $this->phpbb_block_map[$this->cat_id];

			if (!$this->page_id)
			{
				$this->page_id = get_page_id( $this->target_file, true );

				if ( !$this->page_id )
				{
					$this->page_id = get_page_id( $this->target_file, true );
				}
				
				if ( !$this->page_id )
				{
					//$this->page_id = 8;
				}
			}

			$this->error = !$this->page_id ? true : false;
		}
	}
}
?>