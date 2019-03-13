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

<!-- INCLUDE pub_header.tpl -->
<!-- BEGIN switch_toc -->
<p><span class="maintitle">{L_TOC}</span><br /><br />
<span class="nav">
<!-- BEGIN pages -->
{switch_toc.pages.TOC_ITEM}
<!-- END pages -->
</span>
<!-- END switch_toc -->

<span class="maintitle">{ARTICLE_TITLE}</span>
<p><span class="gensmall"><b>{ARTICLE_DESCRIPTION}</b></span>

<div class="articleDetails">
<table width="100%" cellpadding="4" cellspacing="1" border="0">
  	<tr>
	 	<td class="row2">
		<span class="gensmall"><b>{L_ARTICLE_AUTHOR}</b></span> <span class="gensmall">{ARTICLE_AUTHOR}</span><br />
		<span class="gensmall"><b>{L_ARTICLE_DATE}</b></span> <span class="gensmall">{ARTICLE_DATE}</span><br />
		<span class="gensmall">{VIEWS}</span><br />
		<span class="gensmall"><b>{L_ARTICLE_TYPE}</b></span> <span class="gensmall">{ARTICLE_TYPE}</span><br />

		<!-- BEGIN custom_field -->
		<span class="gensmall"><b>{custom_field.CUSTOM_NAME}</b> </span> <span class="gensmall">{custom_field.DATA} </span><br />
		<!-- END custom_field -->
		<!-- BEGIN switch_ratings -->
		<hr>
		<span class="gensmall"><b>{L_RATINGS}</b></span> <span class="gensmall">{switch_ratings.RATING} ({switch_ratings.VOTES} {switch_ratings.L_VOTES})</span>
		<span class="gensmall"><a href="{switch_ratings.U_RATE}" class="gensmall">{switch_ratings.DO_RATE}</a></span>
		<!-- END switch_ratings -->
		</td>
		<td align="right" valign="top" class="row2">
		  <a href="{U_PRINT}" class="gensmall">{L_PRINT}</a>
		</td>
	</tr>
</table>
</div>

<div id="articlewrap">
<div id="toc" class="contents"></div>

{ARTICLE_TEXT}

<!-- BEGIN switch_pages -->
<p><span class="nav">
{L_GOTO_PAGE}
<!-- BEGIN pages -->
{switch_pages.pages.PAGE_LINK}
<!-- END pages -->
</span>
<!-- END switch_pages -->
</div>

<p><span class="cattitle">&nbsp;{B_EDIT_IMG}&nbsp;{B_DELETE_IMG}</span>

<!-- BEGIN use_comments -->
	<p>
	<div class="articleDetails"><span class="cattitle">{use_comments.L_COMMENTS}</span></div>

	<!-- BEGIN no_comments -->
	<p><span class="genmed">{use_comments.no_comments.L_NO_COMMENTS}</span>
	<!-- END no_comments -->

	<p>
	<table width="100%" cellspacing="0" cellpadding="4" border="1">
	<!-- BEGIN text -->
	  	<tr>
			<td width="100" align="left" valign="top" class="row2">
				<span class="name">
					<b>{use_comments.text.POSTER}</b></span><hr /><br />
					<span class="postdetails">{use_comments.text.POSTER_RANK}<br />
					{use_comments.text.RANK_IMAGE}{use_comments.text.POSTER_AVATAR}
				</span><br />&nbsp;
			</td>
			<td class="row1" height="28" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="80%" valign="middle"><span class="genmed"><img src="{use_comments.text.ICON_MINIPOST_IMG}" width="12" height="9" border="0" />&nbsp;<b>{use_comments.text.TITLE}</b> </span><span class="genmed">({use_comments.text.TIME})</span></td>
						<td align="right">
						<!-- BEGIN auth_edit -->
						{use_comments.text.auth_edit.B_EDIT_IMG}
						<!--<a href="{use_comments.text.auth_edit.U_COMMENT_EDIT}"><img src="{use_comments.text.auth_edit.EDIT_IMG}" alt="{use_comments.text.auth_edit.L_COMMENT_EDIT}" title="{use_comments.text.auth_edit.L_COMMENT_EDIT}" border="0"></a>-->
						<!-- END auth_edit -->
						<!-- BEGIN auth_delete -->
						{use_comments.text.auth_delete.B_DELETE_IMG}
						<!--<a href="{use_comments.text.auth_delete.U_COMMENT_DELETE}"><img src="{use_comments.text.auth_delete.DELETE_IMG}" alt="{use_comments.text.auth_delete.L_COMMENT_DELETE}" title="{use_comments.text.auth_delete.L_COMMENT_DELETE}" border="0"></a>-->
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
	<!-- END text -->
	</table>

	<p>
	<!-- BEGIN comments_pag -->
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	  <tr>
		<td><span class="nav">{use_comments.comments_pag.PAGE_NUMBER}</span></td>
		<td align="right"><span class="nav">{use_comments.comments_pag.PAGINATION}</span></td>
	  </tr>
	</table>
	<!-- END comments_pag -->

	<p>
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