<script language='javascript'>
    <!--
	var addItem = false;
	var deleteItem = false;

	function set_add_item(status)
	{
		addItem = status;
	}

	function set_delete_item(status)
	{
		deleteItem = status;
	}


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

	function disable_cat_list()
	{
		if(document.form.mode_mcp.options[document.form.mode_mcp.selectedIndex].value != 'cat')
		{
			document.form.cat_id.selectedIndex = '0';
			document.form.cat_id.disabled = true;
		}
		if(document.form.mode_mcp.options[document.form.mode_mcp.selectedIndex].value == 'cat')
		{
			document.form.cat_id.disabled = false;
		}
	}

	//
	// Taking from the Attachment MOD of Acyd Burn
	//
	function select(status)
	{
		for (i = 0; i < document.ids.length; i++)
		{
			document.ids.elements[i].checked = status;
		}
	}

	function check()
	{
		if(addItem)
		{
			return true;
		}

		for (i = 0; i < document.ids.length; i++)
		{
			if(document.ids.elements[i].checked == true)
			{
				if(deleteItem)
				{
			       if (confirm('Are you sure you want to delete these items??'))
				   {
				   		return true;
				   }
				   else
				   {
						return false;
				   }
				}
				return true;
			}
		}
		alert('Please Select at least one item.');
		return false;
	}
	-->
</script>
<!-- INCLUDE pub_header.tpl -->

<body onLoad="disable_cat_list();">

<form method="post" action="{S_ACTION}" name="form">
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
	<td>
		<br /><b><span class="genmed">{L_MODE}:</span></b> <select name="mode_mcp" onchange="disable_cat_list();">{S_MODE_SELECT}</select> <b><span class="genmed">{L_CATEGORY}:</span></b> {S_CAT_LIST} <input type="submit" class="liteoption" name="go" value="{L_GO}" />
	</td>
  </tr>
</table>
	{S_HIDDEN_FIELDS}
</form>

<form method="post" action="{S_ACTION}" name="ids" onsubmit="return check();">
<table width="100%" cellpadding="2" cellspacing="2">
  <tr>
	<td valign="bottom">
		<span class="nav"><a href="{U_ARTICLES}" class="nav">{ARTICLES}</a>&nbsp;&raquo;&nbsp;{L_MCP_TITLE}</span>
	</td>
  </tr>
</table>

<!-- BEGIN mcp_mode -->
<table width="100%" cellpadding="4" cellspacing="1" class="forumline">
  <tr>
	<th colspan="6" class="thHead">&nbsp;{mcp_mode.L_MODE}</span></th>
  </tr>
  <!-- IF mcp_mode.DATA -->
  <!-- BEGIN row -->
  <tr>
	<td class="row1" align="center" width="5%"><span class="genmed">{mcp_mode.row.NUMBER}</span></td>
	<td class="row1" width="50%"><span class="genmed">{mcp_mode.row.NAME}</span></td>
	<td class="row1" align="center" width="10%"><span class="gen"><a href="{mcp_mode.row.U_EDIT}">{L_EDIT}</a></span></td>
	<td class="row1" align="center" width="10%"><span class="gen"><a href="javascript:delete_item('{mcp_mode.row.U_DELETE}')">{L_DELETE}</a></span></td>
	<td class="row1" align="center" width="20%"><span class="gen"><a href="{mcp_mode.row.U_APPROVE}">{mcp_mode.row.L_APPROVE}</a></span></td>
	<td class="row1" align="center" width="5%"><span class="genmed"><input type="checkbox" name="ids[]" value="{mcp_mode.row.ID}" /></span></td>
  </tr>
   <!-- END row -->
   <!-- ELSE -->
   <!-- BEGIN no_data -->
  <tr>
	  <td class="row1" align="center"><span class="gen">{L_NO_ITEMS}</span></td>
  </tr>
   <!-- END no_data -->
   <!-- ENDIF -->
</table>
<br />
<!-- END mcp_mode -->
<table width="100%" cellspacing="2" border="0" cellpadding="2">
  <tr>
	<td align="right"><span class="nav">{PAGINATION}</span></td>
  </tr>
  <tr>
	<td align="right"><span class="nav">{PAGE_NUMBER}</span></td>
  </tr>
</table>
<table width="100%" cellpadding="3" cellspacing="1" class="forumline">
  <tr>
	<td class="cat" align="center">
	{S_HIDDEN_FIELDS}
	<input type="submit" class="mainoption" name="do_approve" value="{L_APPROVE_ITEM}" onClick="set_add_item(true); set_delete_item(false);" />
	<input type="submit" class="mainoption" name="do_unapprove" value="{L_UNAPPROVE_ITEM}" onClick="set_add_item(true); set_delete_item(false);" />
	<input type="submit" class="liteoption" name="do_delete" value="{L_DELETE_ITEM}" onClick="set_add_item(false); set_delete_item(true);" />
	</td>
  </tr>
</table>
</form>
<!-- INCLUDE pub_footer.tpl -->