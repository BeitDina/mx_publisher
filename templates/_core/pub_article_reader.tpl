<!-- INCLUDE pub_header.tpl -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-top:none;">
  	<tr>
  	   	<td class="row1" wrap="wrap">
  	   		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	   			<tr>
  	   				<td>
	   					<span class="maintitle"style="font-size: 9pt;">{ARTICLE_TITLE}</span>
					</td>
	   				<td class="row1" align="right" class="nav">
		  				<a href="{U_PRINT}" class="nav">{L_PRINT}</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
  	  	<td class="row2" colspan="2">
  	  		<hr>
	  	  	<span class="gensmall"><b>{L_ARTICLE_AUTHOR}</b></span> <span class="gensmall">{ARTICLE_AUTHOR}</span>
	  	  	<span class="gensmall"><b>{L_ARTICLE_DATE}</b></span> <span class="gensmall">{ARTICLE_DATE}</span>
	  	  	<span class="gensmall">{VIEWS}<br /></span>
		  	<span class="gensmall"><b>{L_ARTICLE_DESCRIPTION}</b></span> <span class="gensmall">{ARTICLE_DESCRIPTION}<br /></span>
	  	  	<!--<span class="gensmall"><b>{L_ARTICLE_CATEGORY}</b></span> <span class="gensmall">{ARTICLE_CATEGORY}</span>-->
	  	  	<span class="gensmall"><b>{L_ARTICLE_TYPE}</b></span> <span class="gensmall">{ARTICLE_TYPE}</span>

	    	<!-- BEGIN custom_field -->
				<span class="gensmall"><br /><b>{custom_field.CUSTOM_NAME}</b> </span> <span class="gen">{custom_field.DATA} </span>
			<!-- END custom_field -->
		  	<!-- BEGIN switch_ratings -->
		  		<hr>
		  	  	<span class="gensmall"><b>{L_RATINGS}</b></span> <span class="gensmall">{switch_ratings.RATING} </span>
		  	  	<span class="gensmall">[<a href="{switch_ratings.U_RATE}" class="gensmall">{switch_ratings.L_RATE}</a>]</span>
		  	<!-- END switch_ratings -->
			<hr>
		</td>
  	</tr>
  	<!-- BEGIN switch_toc -->
  	<tr>
       	<td class="row1" colspan="2" align="left"><br /><span class="maintitle">{L_TOC}</span><br /><br />
	   		<span class="nav">
			<!-- BEGIN pages -->
			{switch_toc.pages.TOC_ITEM}
			<!-- END pages -->
			</span>
	   	</td>
  	</tr>
	<!-- END switch_toc -->
  	<tr>
		<td class="row1" colspan="2" wrap="wrap">
			<span class="postbody">{ARTICLE_TEXT}</span>
		</td>
  	</tr>
  	<!-- BEGIN switch_pages -->
  	<tr>
       	<td class="row1" colspan="2" align="center"><span class="nav">{L_GOTO_PAGE}
		   	<!-- BEGIN pages -->
		   	{switch_pages.pages.PAGE_LINK}
		   	<!-- END pages -->
		   	</span>
		</td>
  	</tr>
<!-- END switch_pages -->
</table>

<!-- BEGIN use_comments -->
<br />
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
					<a href="{use_comments.text.auth_edit.U_COMMENT_EDIT}"><img src="{use_comments.text.auth_edit.EDIT_IMG}" alt="{use_comments.text.auth_edit.L_COMMENT_EDIT}" title="{use_comments.text.auth_edit.L_COMMENT_EDIT}" border="0"></a>
					<!-- END auth_edit -->
					<!-- BEGIN auth_delete -->
					<a href="{use_comments.text.auth_delete.U_COMMENT_DELETE}"><img src="{use_comments.text.auth_delete.DELETE_IMG}" alt="{use_comments.text.auth_delete.L_COMMENT_DELETE}" title="{use_comments.text.auth_delete.L_COMMENT_DELETE}" border="0"></a>
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
		<td><a href="{use_comments.auth_post.U_COMMENT_POST}"><img src="{use_comments.auth_post.REPLY_IMG}" border="0" alt="{use_comments.auth_post.L_COMMENT_ADD}" align="middle" /></a></td>
  	</tr>
</table>
<br clear="all" />
<!-- END auth_post -->
<!-- END use_comments -->
<!-- INCLUDE pub_footer.tpl -->