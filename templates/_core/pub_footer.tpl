			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top" height="35" width="50%">
				<br /><form method="get" name="jumpbox" action="{S_JUMPBOX_ACTION}" onSubmit="if(document.jumpbox.cat_id.value == -1){return false;}">
				<input type="hidden" name="action" value="category" />
				<input type="hidden" name="page" value="{MX_PAGE}" />
				<select name="cat_id" onchange="if(this.options[this.selectedIndex].value != -1){ forms['jumpbox'].submit() }">
				<option value="-1">{L_QUICK_JUMP}</option>
				{JUMPMENU}
				</select>
				<input type="submit" value="{L_QUICK_GO}" class="liteoption" />
				</span>
				</form>
			</td>
			<td align="right" width="50%"><span class="gensmall">{S_AUTH_LIST}</span></td>
		  </tr>
		</table>
	</td>
  </tr>
</table>

<!-- BEGIN copy_footer -->
<div align="center"><span class="copyright"><br />
Powered by {L_MODULE_VERSION}, {L_MODULE_ORIG_AUTHOR} & <a href="http://www.mx-publisher.com/" target="_phpbb" class="copyright">{L_MODULE_AUTHOR}</a> � 2002-2005 <br /><a href="http://www.phpbb.com/phpBB/viewtopic.php?t=193124" target="_phpbb" class="copyright">PHPBB.com MOD</a>
</span></div>
<!-- END copy_footer -->