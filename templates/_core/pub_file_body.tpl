<script language='javascript'>
    <!--
    function delete_item(theURL)
	{
       if (confirm('Are you sure you want to delete this item??'))
	   {
          window.location.href=theURL;
       }
       else
	   {
          alert ('No Action has been taken.');
       }
    }

    function disable_popup(id)
    {
    	if (id)
    	{
    		alert(disableMsg['msg_'+id]);
    	}
    	else
    	{
    		alert('{FILE_DISABLE_MSG}');
    	}
    }
	-->
</script>

<!-- INCLUDE pub_header.tpl -->
<table width="100%" cellpadding="2" cellspacing="2">
  <tr>
	<td valign="bottom">
		<span class="nav"><a href="{U_DOWNLOAD_HOME}" class="nav ask target-block_{BLOCK_ID}">{DOWNLOAD}</a><!-- BEGIN navlinks -->&nbsp;&raquo;&nbsp;<a href="{navlinks.U_VIEW_CAT}" class="nav ask target-block_{BLOCK_ID}">{navlinks.CAT_NAME}</a><!-- END navlinks -->&nbsp;&raquo;&nbsp;{FILE_NAME}</span>
	</td>
  </tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" class="forumline">
  <tr>
	<th class="thCornerL" align="left" colspan="2">{L_FILE} - {FILE_NAME}</th>
	<th class="thCornerR" align="right" nowrap>
<!-- IF AUTH_EDIT -->
		{B_EDIT_IMG} &nbsp;&nbsp;
<!-- ENDIF -->
<!-- IF AUTH_DELETE -->
		{B_DELETE_IMG}
<!-- ENDIF -->
	</th>
  </tr>
<tr>
	<td class="row2" valign="middle" width="20%"><span class="genmed">{L_DESC}:</span></td>
	<td class="row1" valign="middle" width="80%" colspan="2"><span class="genmed">{FILE_LONGDESC}</span></td>
</tr>
<tr>
	<td class="row2" valign="middle" width="20%"><span class="genmed">{L_SUBMITED_BY}:</span></td>
	<td class="row1" valign="middle" width="80%" colspan="2"><span class="name">{FILE_SUBMITED_BY}</span></td>
</tr>
<!-- IF SHOW_AUTHOR -->
<tr>
	<td class="row2" valign="middle" width="20%"><span class="genmed">{L_AUTHOR}:</span></td>
	<td class="row1" valign="middle" width="80%" colspan="2"><span class="genmed">{FILE_AUTHOR}</span></td>
</tr>
<!-- ENDIF -->
<!-- IF SHOW_VERSION -->
<tr>
	<td class="row2" valign="middle" width="20%"><span class="genmed">{L_VERSION}:</span></td>
	<td class="row1" valign="middle" width="80%" colspan="2"><span class="genmed">{FILE_VERSION}</span></td>
  </tr>
<!-- ENDIF -->
<!-- IF SHOW_SCREENSHOT -->
<tr>
	<td class="row2" valign="middle" width="20%"><span class="genmed">{L_SCREENSHOT}:</span></td>
	<!-- IF SS_AS_LINK -->
	<td class="row1" valign="middle" width="80%" colspan="2"><span class="genmed"><a href="{FILE_SCREENSHOT}" target="_blank">{L_CLICK_HERE}</a></span></td>
	<!-- ELSE -->
	<td class="row1" valign="middle" width="80%" colspan="2"><span class="genmed"><a href="javascript:mpFoto('{FILE_SCREENSHOT}')"><img src="{FILE_SCREENSHOT}" border="0" width="100" hight="100"></a></span></td>
	<!-- ENDIF -->
  </tr>
<!-- ENDIF -->
<!-- IF SHOW_WEBSITE -->
  <tr>
	<td class="row2" valign="middle" width="20%"><span class="genmed">{L_WEBSITE}:</span></td>
	<td class="row1" valign="middle" width="80%" colspan="2"><span class="genmed"><a href="{FILE_WEBSITE}" target="_blank">{L_CLICK_HERE}</a></span></td>
  </tr>
<!-- ENDIF -->
<tr>
	<td class="row2" valign="middle"><span class="genmed">{L_DATE}:</span></td>
	<td class="row1" valign="middle" colspan="2"><span class="genmed">{TIME}</span></td>
  </tr>
<tr>
	<td class="row2" valign="middle"><span class="genmed">{L_UPDATE_TIME}:</span></td>
	<td class="row1" valign="middle" colspan="2"><span class="genmed">{UPDATE_TIME}</span></td>
  </tr>
  <tr>
	<td class="row2" valign="middle"><span class="genmed">{L_LASTTDL}:</span></td>
	<td class="row1" valign="middle" colspan="2"><span class="genmed">{LAST}</span></td>
  </tr>
  <tr>
	<td class="row2" valign="middle"><span class="genmed">{L_SIZE}:</span></td>
	<td class="row1" valign="middle" colspan="2"><span class="genmed">{FILE_SIZE}</span></td>
  </tr>
<!-- BEGIN use_ratings -->
  <tr>
	<td class="row2" valign="middle"><span class="genmed">{use_ratings.L_RATING}:</span></td>
	<td class="row1" valign="middle" colspan="2"><span class="genmed">{use_ratings.RATING} ({use_ratings.FILE_VOTES} {use_ratings.L_VOTES})</span></td>
  </tr>
<!-- END use_ratings -->
  <tr>
	<td class="row2" valign="middle"><span class="genmed">{L_DLS}:</span></td>
	<td class="row1" valign="middle" colspan="2"><span class="genmed">{FILE_DLS}</span></td>
  </tr>
<!-- BEGIN custom_field -->
  <tr>
	<td class="row2" valign="middle"><span class="genmed">{custom_field.CUSTOM_NAME}:</span></td>
	<td class="row1" valign="middle" colspan="2"><span class="genmed">{custom_field.DATA}</span></td>
  </tr>
<!-- END custom_field -->
  <tr>
	<td class="cat" align="center" colspan="3"></td>
  </tr>
</table>

<table width="100%" cellpadding="2" cellspacing="0">
  <tr>
<!-- IF AUTH_DOWNLOAD -->
	<td width="33%" align="center">{B_DOWNLOAD_IMG}</td>
<!-- ENDIF -->

<!-- BEGIN use_ratings -->
	<td width="34%" align="center">{use_ratings.B_RATE_IMG}</td>
<!-- END use_ratings -->

<!-- IF AUTH_EMAIL -->
	<td width="33%" align="center">{B_EMAIL_IMG}</td>
<!-- ENDIF -->
  </tr>
</table>
<br />

<!-- BEGIN use_comments -->
<table width="100%" cellpadding="4" cellspacing="1" class="forumline">
  	<tr>
		<th class="thCornerL" colspan="2">{use_comments.L_COMMENTS}</th>
  	</tr>
	<!-- BEGIN no_comments -->
  	<tr>
		<td colspan="2" class="row1" align="center"><span class="genmed">{use_comments.no_comments.L_NO_COMMENTS}</span></td>
  	</tr>
	<!-- END no_comments -->

	<!-- BEGIN text -->
  	<tr>
		<td width="100" align="left" valign="top" class="row1"><span class="name">
			<b>{use_comments.text.POSTER}</b></span><hr /><br />
			<span class="postdetails">{use_comments.text.POSTER_RANK}<br />
			{use_comments.text.RANK_IMAGE}{use_comments.text.POSTER_AVATAR}</span><br />&nbsp;
		</td>
		<td class="row1" height="28" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="80%" valign="middle"><span class="genmed"><img src="{use_comments.text.ICON_MINIPOST_IMG}" width="12" height="9" border="0" />&nbsp;<b>{use_comments.text.TITLE}</b> </span><span class="genmed">({use_comments.text.TIME})</span></td>
					<td align="right">
					<!-- BEGIN auth_edit -->
					{use_comments.text.auth_edit.B_EDIT_IMG}
					<!-- END auth_edit -->
					<!-- BEGIN auth_delete -->
					{use_comments.text.auth_delete.B_DELETE_IMG}
					<!-- END auth_delete -->
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td colspan="2"valign="top"><span class="postbody">{use_comments.text.TEXT}</span></td>
				</tr>
			</table>
		</td>
  	</tr>
  	<tr>
		<td class="spaceRow" colspan="2" height="1"><img src="{use_comments.text.ICON_SPACER}" alt="" width="1" height="1" /></td>
  	</tr>
	<!-- END text -->
</table>

<!-- BEGIN comments_pag -->
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
	<td><span class="nav">{use_comments.comments_pag.PAGE_NUMBER}</span></td>
	<td align="right"><span class="nav">{use_comments.comments_pag.PAGINATION}</span></td>
  </tr>
</table>
<!-- END comments_pag -->

<!-- BEGIN auth_post -->
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  	<tr>
		<td>{use_comments.auth_post.B_REPLY_IMG}</td>
  	</tr>
</table>
<br clear="all" />
<!-- END auth_post -->
<!-- END use_comments -->

<!-- INCLUDE pub_footer.tpl -->
