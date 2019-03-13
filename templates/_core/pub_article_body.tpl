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
	-->
</script>

<style type="text/css">
<!--
.articleDetails {
    width: 200px;
    display: block;
    border: 1px solid {T_TH_COLOR1};
    float:right;
}
-->
</style>

<!-- INCLUDE pub_header.tpl -->
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" class="nav">
		<a href="{U_PUB}" class="nav">{L_PUB}</a>
		<!-- BEGIN navlinks -->
		&nbsp;&raquo;&nbsp;<a href="{navlinks.U_VIEW_CAT}" class="nav">{navlinks.CAT_NAME}</a>
		<!-- END navlinks -->
		</td>
		<td align="right" class="nav">
		  <a href="{U_PRINT}" class="nav">{L_PRINT}</a>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <tr>
	<th class="thTop" align="left">
		{ARTICLE_TITLE}
	</th>
  </tr>
  <tr>
  	   <td class="row1" wrap="wrap">

  	   	<div class="articleDetails" align="right">
		<table width="100%" cellpadding="4" cellspacing="1" border="0">
		  <tr>
		  	  <td class="row2">
		  	  <span class="gensmall"><b>{L_ARTICLE_AUTHOR}</b></span> <span class="gensmall">{ARTICLE_AUTHOR}</span><br />
		  	  <span class="gensmall"><b>{L_ARTICLE_DATE}</b></span> <span class="gensmall">{ARTICLE_DATE}</span><br />
		  	  <span class="gensmall">{VIEWS}</span><br />
		  	  <span class="gensmall"><b>{L_ARTICLE_CATEGORY}</b></span> <span class="gensmall">{ARTICLE_CATEGORY}</span><br />
		  	  <span class="gensmall"><b>{L_ARTICLE_TYPE}</b></span> <span class="gensmall">{ARTICLE_TYPE}</span><br />

		    	<!-- BEGIN custom_field -->
					<span class="gensmall"><b>{custom_field.CUSTOM_NAME}</b> </span> <span class="gensmall">{custom_field.DATA} </span><br />
				<!-- END custom_field -->
			  	<!-- BEGIN switch_ratings -->
			  		<hr>
			  	  	<span class="gensmall"><b>{L_RATINGS}</b></span> <span class="gensmall">{switch_ratings.RATING} ({switch_ratings.VOTES} {switch_ratings.L_VOTES})</span>
			  	  	<span class="gensmall"><a href="{switch_ratings.U_RATE}" class="gensmall">{switch_ratings.B_RATE_IMG}</a></span>
			  	<!-- END switch_ratings -->
			  </td>
		  </tr>
		</table>
		</div>

	   	<span class="maintitle"style="font-size: 9pt;">{ARTICLE_TITLE}</span>
	   	<p><span class="gensmall"><b>{ARTICLE_DESCRIPTION}</b></span>

  		<!-- BEGIN switch_toc -->
       		<br />
       		<span class="maintitle">{L_TOC}</span><br /><br />
		   	<span class="nav">
		   	<!-- BEGIN pages -->
		   	{switch_toc.pages.TOC_ITEM}
		   	<!-- END pages -->
		   	</span>
		<!-- END switch_toc -->

		<p><span class="postbody">{ARTICLE_TEXT}</span>

  	   </td>
  </tr>
  <!-- BEGIN switch_pages -->
  <tr>
       <td class="row1" align="center"><span class="nav">{L_GOTO_PAGE}
	   <!-- BEGIN pages -->
	   {switch_pages.pages.PAGE_LINK}
	   <!-- END pages -->
	   </span></td>
  </tr>
<!-- END switch_pages -->
  <tr>
  	  <td class="cat" valign="middle" align="center"><span class="cattitle">&nbsp;{B_EDIT_IMG}&nbsp;{B_DELETE_IMG}&nbsp;{B_UPLOAD_IMG}</span>&nbsp;</td>
  </tr>
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
					{use_comments.text.auth_edit.B_EDIT_IMG}
					<a href="{use_comments.text.auth_edit.U_COMMENT_EDIT}"><img src="{use_comments.text.auth_edit.EDIT_IMG}" alt="{use_comments.text.auth_edit.L_COMMENT_EDIT}" title="{use_comments.text.auth_edit.L_COMMENT_EDIT}" border="0"></a>
					<!-- END auth_edit -->
				
					<!-- BEGIN auth_delete -->
					{use_comments.text.auth_delete.B_DELETE_IMG}
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
		<td>{use_comments.auth_post.B_REPLY_IMG}</td>
  	</tr>
</table>
<br clear="all" />
<!-- END auth_post -->
<!-- END use_comments -->

<!-- INCLUDE pub_footer.tpl -->