<?php
/**
 * Language Tools Extension for the phpBB Forum Software package
 * @package MX-Publisher Module - mx_publisher
* @version $Id: pub_tcp.php,v 1.20 2008/09/21 14:25:33 orynider Exp $
* @copyright (c) orynider <http://mxpcms.sourceforge.net>
* @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
 
if (!defined('IN_PORTAL'))
{
	die("Hacking attempt");
}
define('MODULE_URL', PORTAL_URL . 'modules/mx_publisher/');
define('IN_AJAX', (isset($_GET['ajax']) && ($_GET['ajax'] == 1) && ($_SERVER['HTTP_SEREFER'] = $_SERVER['PHP_SELF'])) ? 1 : 0);
/**
* mx_publisher TCP (from langtools)
 *
 */
class publisher_tcp extends publisher_public
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $action
	 */
	function main($action = false)
	{
		global $db, $lang, $user, $userdata, $board_config, $phpEx, $images, $debug;
		global $mx_root_path, $phpbb_root_path, $module_root_path, $is_block;
		global $publisher_functions, $template, $publisher_config, $phpBB2;
		//include_once($module_root_path . 'core/translator.' . $phpEx);
die("coding attempt intercepted by SRI.");
		//@error_reporting( E_ALL || !E_NOTICE);
		//$pub_translator = new mx_translator();
		/**
		* Class   extends mx_translator
		* Displays a message to the user and allows him to send an email
		*/

		/* START Include language file */
		$language = ($mx_user->user_language_name) ? $mx_user->user_language_name : (($board_config['default_lang']) ? $board_config['default_lang'] : 'english');

		if ((@include $module_root_path . "language/lang_" . $language . "/info_acp_translator.$phpEx") === false)
		{
			if ((@include $module_root_path . "language/lang_english/info_acp_translator.$phpEx") === false)
			{
					mx_message_die(CRITICAL_ERROR, 'Language file ' . $module_root_path . "language/lang_" . $language . "/info_acp_translator.$phpEx" . ' couldn\'t be opened.');
			}
			$language = 'english'; 
		}

		//include_once($module_root_path . 'core/translator.' . $phpEx);
		
		/* Get an instance of the admin controller */
		if (!include_once($module_root_path . 'core/mx_translator.' . $phpEx))
		{
			die('Cant find ' . $module_root_path . 'core/mx_translator.' . $phpEx);
		}
		
		//$pub_translator = new orynider\mx_translator\controller\mxp_translator();
		$pub_translator = new mx_translator();
		
		/* Requests */
		//$action = $request->variable('action', '');
		
		/* general vars */
		$mode = $mx_request_vars->request('mode', 'generate');
		$start = $mx_request_vars->request('start', 0); 
		$s = $mx_request_vars->request('s', '');
		$ajax = $mx_request_vars->request('ajax', 0);
		$set_file = $mx_request_vars->request('set_file', '');
		$into = $mx_request_vars->request('into', '');
		/* */

		// Make the $u_action url available in the admin controller
		//$pub_translator->set_page_url($this->u_action);
		/** **/
		if ($mx_request_vars->is_post('submit') )
		{
			$mode = 'submit';
		}
		/** Load the "settings" or "manage" module modes **/
		switch ($mode)
		{
			case 'submit':
				// Is the form being submitted to us?
				if ($mx_request_vars->is_empty_post('translator_default_lang') || $mx_request_vars->is_empty_post('translator_choice_lang'))
				{
					mx_message_die(GENERAL_ERROR, "Failed to update translator configuration, you didn't specified valid values or your admin templates are incompatible with this version of MXP.");
				}
				$s_errors = (bool) count($errors);
				//acp_translator_set_config('translator_default_lang', ($mx_request_vars->request('translator_default_lang', 'en')));
				//acp_translator_set_config('translator_choice_lang', ($mx_request_vars->request('translator_choice_lang', 'de,fr,es,ro')));
				
				$params = $_SERVER['QUERY_STRING'];
				$params = "mode=config&i=-orynider-mx_translator-acp-translator_module";
				$u_action = mx_append_sid("{$admin_module_root_path}$basename?$params", false, true);
				
				// If no errors, process the form data
				//if (empty($errors))
				//{
					// Add option settings change action to the admin log
					//$pub_translator->log->add('admin', $mx_user->data['user_id'], $mx_user->ip, 'ACP_TRANSLATOR_SETTINGS_LOG');
					// Option settings have been updated and logged
					// Confirm this to the user and provide link back to previous page
					//trigger_error($pub_translator->lang('ACP_TRANSLATOR_SETTINGS_CHANGED') . adm_back_link($pub_translator->u_action));
				//}
				//trigger_error($pub_translator->lang('TRANSLATOR_CONFIG_SAVED') . adm_back_link($u_action));
				$message = $pub_translator->lang('ACP_TRANSLATOR_SETTINGS_CHANGED') . "<br /><br />" . sprintf($pub_translator->lang('CLICK_RETURN_CONFIG_INDEX'), "<a href=\"" . $u_action . "\">", "</a>") . "<br /><br />" . sprintf($pub_translator->lang('CLICK_RETURN_ADMIN_INDEX'), "<a href=\"" . mx_append_sid($mx_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");
				
				mx_message_die(GENERAL_MESSAGE, $message);	
			break;
			case 'config':
				// Load a template from adm/style for our ACP page
				$tpl_name = 'acp_translator_config';
				// Set the page title for our ACP page
				$page_title = $lang['ACP_TRANSLATOR'];
				// Load the display options handle in the admin controller  display_settings($tpl_name, $page_title);
				//display_settings($tpl_name, $page_title);
			break;
			
			case 'translate':
			default:
				switch ($s)
				{	
					case 'MXP':
						// Load a template from adm/style for our ACP page
						$tpl_name = 'lang_translate';
						// Set the page title for our ACP page
						$page_title = $lang['ACP_TRANSLATE_MX_PORTAL'];
						// Load the display options handle in the admin controller $pub_translator->display_translate($this->tpl_name, $this->page_title);
					break;
					case 'MODS':
						// Load a template from adm/style for our ACP page
						$tpl_name = 'lang_translate';
						// Set the page title for our ACP page
						$page_title = $lang['ACP_TRANSLATE_MX_MODULES'];
						// Load the display options handle in the admin controller $pub_translator->display_translate($this->tpl_name, $this->page_title);
					break;
					case 'PHPBB':
						// Load a template from adm/style for our ACP page
						$tpl_name = 'lang_translate';
						// Set the page title for our ACP page
						$page_title = $lang['ACP_TRANSLATE_PHPBB_LANG'];
						// Load the display options handle in the admin controller $pub_translator->display_translate($this->tpl_name, $this->page_title);
					break;
					case 'phpbb_ext':
						// Load a template from adm/style for our ACP page
						$tpl_name = 'lang_translate';
						// Set the page title for our ACP page
						$page_title = $lang['ACP_TRANSLATE_PHPBB_EXT'];
						// Load the display options handle in the admin controller $pub_translator->display_translate($this->tpl_name, $this->page_title);
					break;
				}
				
				if (IN_AJAX == 0)
				{
					$lang['ENCODING'] = $pub_translator->file_encoding;
					if (isset($_POST['save']) || isset($_POST['download']))
					{
						$pub_translator->file_preparesave();
					}
					if (isset($_POST['save']))
					{
						$pub_translator->file_save();
					}
					else if (isset($_POST['download']))
					{
						$pub_translator->file_download();
					}
					
					//require_once($mx_root_path . 'admin/page_header_admin.' . $phpEx);
					$template->set_filenames(array('body' => $tpl_name.'.html'));
					$template->assign_block_vars('file_to_translate_select', array());
					
					$s_action = $admin_module_root_path . $basename;
					$params = $_SERVER['QUERY_STRING'];
					
					/** -------------------------------------------------------------------------
					* Extend User Style with module lang and images
					* Usage:  $user->extend(LANG, IMAGES, '_core', 'img_file_in_dir', 'img_file_ext')
					* Switches:
					* - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
					* - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
					** ------------------------------------------------------------------------- */
					$pub_translator->extend(false, false, 'all', 'icon_info', false);
					
					/**
					* Reset custom module default style, once used.
					*/
					if (@file_exists($pub_translator->user_current_style_path . 'images/menu_icons/icon_info.gif'))
					{
						$img_info = $pub_translator->user_current_style_path . 'images/menu_icons/icon_info.gif';
					}
					else
					{
						$img_info = $pub_translator->default_current_style_path . 'images/menu_icons/icon_info.gif';
					}
					if (@file_exists($pub_translator->user_current_style_path . 'images/menu_icons/icon_google.gif'))
					{
						$img_google = $pub_translator->user_current_style_path . 'images/menu_icons/icon_google.gif';
					}
					else
					{
						$img_google = $pub_translator->default_current_style_path . 'images/menu_icons/icon_google.gif';
					}
					/* * /
					print_r($img_google); 
					/* */
					$template->assign_vars(array( // #
						'TH_COLOR2' => $theme['th_color2'],
						
						'S_ACTION' => $s_action . '?' . str_replace('&amp;', '&',$params),
						'S_ACTION_AJAX' => $s_action . '?' . str_replace('&amp;', '&',$params) . '&ajax=1',
						'S_LANGUAGE_INTO' => $pub_translator->gen_select_list('html', 'language', $pub_translator->language_into, $pub_translator->language_from),
						'S_MODULE_LIST' => $pub_translator->gen_select_list('html', 'modules', $pub_translator->module_select),
						'S_FILE_LIST' => $pub_translator->gen_select_list('html', 'files', $pub_translator->module_file),
						'L_RESET' => $lang['Reset'],
						'IMG_INFO' => $img_info,
						'IMG_GOOGLE' => $img_google,
						'I_LANGUAGE' => $pub_translator->language_into,
						'I_MODULE' => $pub_translator->module_select,
						'I_FILE' => $pub_translator->module_file,	
					));
					
					$pub_translator->assign_template_vars($template);	
					$template->assign_vars(array( // #
						'L_MX_MODULES' => $lang['ACP_TRANSLATE_MX_MODULES'],
					));
					
					if (($s == 'MODS') || ($s == 'phpbb_ext'))
					{
						$template->assign_block_vars('file_to_translate_select.modules', array());
						$template->assign_block_vars('modules', array());
					}	
					$pub_translator->file_translate();
					
					$template->pparse('body');
					//require_once($mx_root_path . 'admin/page_footer_admin.' . $phpEx);
				}
				else
				{ // AJAX
					$template->set_filenames( array('body' => 'selects.html'));
					$style = "width:100%;"; 
					if ($into == 'language')
					{
						$option_list = $pub_translator->gen_select_list('html', 'language', $pub_translator->language_into, $pub_translator->language_from);
						$name = 'language[into]';
						$id = 'f_lang_into';
					}
					if ($into == 'files')
					{
						$option_list = $pub_translator->gen_select_list('html', 'files', $pub_translator->module_file);
						$name = 'translate[file]';
						$id = 'f_select_file';
					}
					$template->assign_block_vars('ajax_select', array(
						'NAME'		=> $name,
						'ID'			=> $id,
						'STYLE'		=> $style,
						'OPTIONS'	=> $option_list,
					));
					$template->pparse('body');
				}
			break;
		}
	}
}
?>