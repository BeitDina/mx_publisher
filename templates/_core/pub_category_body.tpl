<link href="{U_PORTAL_ROOT_PATH}modules/mx_publisher/templates/_core/mx_publisher.css" rel="stylesheet" type="text/css" media="screen" />
<!-- INCLUDE pub_header.tpl -->
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" class="nav">
		<a href="{U_KB}" class="nav">{L_KB}</a>
		<!-- BEGIN navlinks -->
		&nbsp;&raquo;&nbsp;<a href="{navlinks.U_VIEW_CAT}" class="nav">{navlinks.CAT_NAME}</a>
		<!-- END navlinks -->
		</td>
	</tr>
</table>

<!-- BEGIN CAT_NAV_STANDARD -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" >
  	<tr>
		<th class="thCornerL" width="6%">&nbsp;</th>
  	   	<th class="thTop">&nbsp;{L_CATEGORY}&nbsp;</th>
		<th class="thCornerR" width="10%">&nbsp;{L_LAST_ARTICLE}&nbsp;</th>
	   	<th class="thCornerR" width="50" >&nbsp;{L_ARTICLES}&nbsp;</th>
  	</tr>
  	<!-- BEGIN catrow -->
  	<!-- BEGIN catcol -->
 	<tr>
		<td class="row1" align="center" valign="middle"><img src="{CAT_NAV_STANDARD.catrow.catcol.CAT_IMAGE}" border="0" alt="{CAT_NAV_STANDARD.catrow.catcol.CAT_DESCRIPTION}"></td>
  	   	<td class="row1" onmouseout="this.className='row1';" onmouseover="this.className='row2';" ><a href="{CAT_NAV_STANDARD.catrow.catcol.U_CATEGORY}" class="cattitle">{CAT_NAV_STANDARD.catrow.catcol.CATEGORY}</a><br /><span class="genmed">{CAT_NAV_STANDARD.catrow.catcol.CAT_DESCRIPTION}</span></td>
		<td class="row2" align="center" valign="middle"><span class="genmed">{CAT_NAV_STANDARD.catrow.catcol.LAST_ARTICLE}</span></td>
	   	<td class="row2" align="center" valign="middle"><span class="genmed">{CAT_NAV_STANDARD.catrow.catcol.CAT_ARTICLES}</span></td>
  	</tr>
  	<!-- BEGIN show_subs -->
  	<tr>
		<td class="row2" width="6%">&nbsp;</td>
  	   	<td class="row2" colspan="2"><span class="genmed"><b>{CAT_NAV_STANDARD.catrow.catcol.L_SUB_CAT}:</b> {CAT_NAV_STANDARD.catrow.catcol.SUB_CAT}</span></td>
	   	<td class="row2" align="center" valign="middle">&nbsp;</td>
  	</tr>
  	<!-- END show_subs -->
  	<!-- END catcol -->
  	<!-- END catrow -->

  <!-- BEGIN no_cats -->
  <tr>
  	   <td class="row1" align="center" colspan="4" height="50"><span class="genmed">{CAT_NAV_STANDARD.no_cats.COMMENT}</span></td>
  </tr>
  <!-- END no_cats -->
  <tr>
  	  <td class="cat" colspan="4">&nbsp;</td>
  </tr>
</table>
<br>
<!-- END CAT_NAV_STANDARD -->

<!-- BEGIN CAT_NAV_SIMPLE -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<th class="thHead">{L_CATEGORIES}</th>
  </tr>
  <tr><td class="row1">
	<table border="0" cellpadding="5" cellspacing="1" width="100%">
	<!-- BEGIN catrow -->
		<tr>
		<!-- BEGIN catcol -->
		<td width="{WIDTH}%">
		<table border="0" cellpadding="2" cellspacing="2" width="100%">
		<tr>
			<td><a href="{CAT_NAV_SIMPLE.catrow.catcol.U_CATEGORY}"><img src="{CAT_NAV_SIMPLE.catrow.catcol.CAT_IMAGE}" alt="{CAT_NAV_SIMPLE.catrow.catcol.CAT_DESCRIPTION}" align="absmiddle" border="0" /></a></td>
			<td width="100%" valign="middle"><a href="{CAT_NAV_SIMPLE.catrow.catcol.U_CATEGORY}"  class="cattitle">{CAT_NAV_SIMPLE.catrow.catcol.CATEGORY}</a>&nbsp;<span class="gensmall">({CAT_NAV_SIMPLE.catrow.catcol.CAT_ARTICLES})</span><br>
			{CAT_NAV_SIMPLE.catrow.catcol.SUB_CAT}
			</td>
		</tr></table>
		</td>
		<!-- END catcol -->
      		</tr>
	<!-- END catrow -->
	</table>
  </td></tr>
</table>
<br />
<!-- END CAT_NAV_SIMPLE -->

<!-- BEGIN ARTICLELIST -->
<table width="100%" cellpadding="0" cellspacing="0" class="forumline">
  <tr>
  	<td>
		<table width="100%" cellpadding="3" cellspacing="1">
		  <tr>
			<th class="thHead" colspan="2">{L_ARTICLES}</th>
		  </tr>
		<!-- BEGIN articlerow -->
		  <tr>
			<td rowspan="2" class="{ARTICLELIST.articlerow.COLOR}" valign="middle">&nbsp;<img src="{ARTICLELIST.articlerow.ARTICLE_IMAGE}" border="0" class="mx_icon"></td>
			<td width="100%" class="{ARTICLELIST.articlerow.COLOR}">
			<a href="{ARTICLELIST.articlerow.U_ARTICLE}" class="topictitle">{ARTICLELIST.articlerow.ARTICLE}</a>&nbsp;
			<br><span class="genmed">{ARTICLELIST.articlerow.ARTICLE_DESCRIPTION}</span>
			</td>
		  </tr>
		  <tr>
			<td valign="top" align="left" class="{ARTICLELIST.articlerow.COLOR}"><span class="gensmall">{L_ARTICLE_TYPE}: {ARTICLELIST.articlerow.ARTICLE_TYPE}&nbsp;&bull;&nbsp;{L_ARTICLE_DATE}: {ARTICLELIST.articlerow.ARTICLE_DATE}&nbsp;&bull;&nbsp;{L_VIEWS}: {ARTICLELIST.articlerow.ART_VIEWS}&nbsp;&bull;&nbsp;{L_ARTICLE_AUTHOR}:&nbsp;{ARTICLELIST.articlerow.ARTICLE_AUTHOR}
			<!-- BEGIN show_ratings -->
			&bull;&nbsp;{ARTICLELIST.articlerow.L_RATING}: {ARTICLELIST.articlerow.RATING} ({ARTICLELIST.articlerow.ARTICLE_VOTES} {L_VOTES}) {ARTICLELIST.articlerow.DO_RATE}
			<!-- END show_ratings -->
			</span>
			</td>
		  </tr>
		<!-- END articlerow -->

		</table>
		</td>
	</tr>
	<form action="{S_ACTION_SORT}" method="post">
	<input type="hidden" name="action" value="category">
	<input type="hidden" name="cat_id" value="{ID}">
	<input type="hidden" name="start" value="{START}">
	  <tr>
		<td align="center" colspan="2" class="cat"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;
		<select name="sort_method">
			<option {SORT_ALPHABETIC} value='Alphabetic'>{L_ALPHABETIC}</option>
			<option {SORT_LATEST} value='Latest'>{L_LATEST}</option>
			<option {SORT_TOPRATED} value='Toprated'>{L_TOPRATED}</option>
			<option {SORT_MOST_POPULAR} value='Most_popular'>{L_MOST_POPULAR}</option>
			<option {SORT_USERRANK} value='Userrank'>{L_USERRANK}</option>
			<option {SORT_ID} value='Id'>{L_ID}</option>
			</select>
			&nbsp;{L_ORDER}:
			<select name="sort_order">
				<option {SORT_ASC} value="ASC">{L_ASC}</option>
				<option {SORT_DESC} value="DESC">{L_DESC}</option>
			</select>
		&nbsp;<input type="submit" name="submit" value="{L_SORT}" class="liteoption" />
		</span></td>
	  </tr>
	</form>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr>
	<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right" valign="top"><span class="nav">{PAGINATION}</span></td>
  </tr>
</table>
<!-- END ARTICLELIST -->

<!-- BEGIN no_articles -->
<table class="forumline" width="100%" cellspacing="1" cellpadding="3">
	<tr>
		<th class="thHead">{no_articles.L_NO_ARTICLES}</th>
	</tr>
	<tr>
		<td class="row1" align="center" height="30"><span class="genmed">{no_articles.L_NO_ARTICLES_CAT}</span></td>
	</tr>
</table>
<!-- END no_articles -->
<!-- INCLUDE pub_footer.tpl -->