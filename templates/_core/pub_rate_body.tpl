<!-- INCLUDE pub_header.tpl -->
<script language="JavaScript" type="text/javascript">
<!--
function checkRateForm() {
	if (document.rateform.rating.value == -1)
	{
		return false;
	}
	else
	{
		return true;
	}
}
// -->
</script>

<table width="100%" cellpadding="2" cellspacing="2">
  <tr>
	<td valign="bottom">
		<span class="nav"><a href="{U_DOWNLOAD_HOME}" class="nav">{DOWNLOAD}</a><!-- BEGIN navlinks -->&nbsp;&raquo;&nbsp;<a href="{navlinks.U_VIEW_CAT}" class="nav">{navlinks.CAT_NAME}</a><!-- END navlinks -->&nbsp;&raquo;&nbsp;<a href="{U_FILE_NAME}" class="nav">{FILE_NAME}</a>&nbsp;&raquo;&nbsp;{L_RATE}</span>
	</td>
  </tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" class="forumline">
  <tr> 
	<th colspan="2" class="thHead">{L_RATE}</th>
  </tr>
  <tr> 
	<td class="row1" width="90%"><span class="genmed">{RATEINFO}</span></td>
	<td class="row2">
	<form name="rateform" action="{S_RATE_ACTION}" method="post" onsubmit="return checkRateForm();">
		<select size="1" name="rating" class="forminput">
		<option value="-1" selected>{L_RATE}</option>
		<option value="1">{L_R1}</option>
		<option value="2">{L_R2}</option>
		<option value="3">{L_R3}</option>
		<option value="4">{L_R4}</option>
		<option value="5">{L_R5}</option>
		<option value="6">{L_R6}</option>
		<option value="7">{L_R7}</option>
		<option value="8">{L_R8}</option>
		<option value="9">{L_R9}</option>
		<option value="10">{L_R10}</option>
		<input type="hidden" name="action" value="rate">
		<input type="hidden" name="file_id" value="{ID}">
		</select>
	</td>
  </tr>
  <tr> 
	<td colspan="2" class="cat" align="center"><input class="liteoption" type="submit" value="{L_RATE}" name="submit">

&nbsp;</td>
  </tr>
</table>
</form>
<!-- INCLUDE pub_footer.tpl -->