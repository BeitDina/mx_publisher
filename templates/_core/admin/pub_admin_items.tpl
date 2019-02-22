
<!-- IF S_MODE_SETUP -->
<!-- ENDIF -->

<!-- IF S_MODE_MANAGE -->
<h1>{L_ACP_DOWNLOAD_SYSTEM} - {L_ACP_MANAGE_CATEGORIES}</h1>
<p>{L_ACP_CAT_SELECT}</p>
<br	/>

<p><strong>{NAVIGATION}</strong></p>
<form id="pa_files" method="post" action="{S_ACTION}">
	<fieldset class="quick">
		<input type="hidden" name="action" value="create" />
		<input class="button2" name="addforum" type="submit" value="{L_ACP_CAT_NEW}" />
	</fieldset>
	{S_FORM_TOKEN}
</form>
<!-- IF .catrow -->
<table>
	<col/><col/><col/><col class="row2" />
	<tbody>
	<!-- BEGIN catrow -->
		<!-- IF catrow.CAT_SUBS --><tr class="row1"><!-- ELSE --><tr class="row2"><!-- ENDIF -->
			<td style="width: 5%; text-align: center;">{catrow.FOLDER_IMAGE}</td>
			<td>
				<strong>{catrow.CAT_NAME} <!-- IF not catrow.CAT_SUBS_SHOW -->- {L_ACP_SUB_DL_CAT}<!-- ENDIF --></strong>
				<!-- IF catrow.CAT_DESCRIPTION --><br /><span>{catrow.CAT_DESCRIPTION}</span><!-- ENDIF -->
			</td>
			<td style="width: 10%; text-align: center;"><strong>{L_ACP_NEW_CAT_NAME_SHOW}</strong>
				<!-- IF catrow.CAT_NAME_SHOW --><br /><span>{catrow.CAT_NAME_SHOW}</span><!-- ENDIF --></td>
			<td class="actions">
				<!-- IF catrow.S_FIRST_ROW && not catrow.S_LAST_ROW -->
					{ICON_MOVE_UP_DISABLED}
					<a href="{catrow.U_MOVE_DOWN}">{ICON_MOVE_DOWN}</a>
				<!-- ELSEIF not catrow.S_FIRST_ROW && not catrow.S_LAST_ROW -->
					<a href="{catrow.U_MOVE_UP}">{ICON_MOVE_UP}</a>
					<a href="{catrow.U_MOVE_DOWN}">{ICON_MOVE_DOWN}</a>
				<!-- ELSEIF catrow.S_LAST_ROW && not catrow.S_FIRST_ROW -->
					<a href="{catrow.U_MOVE_UP}">{ICON_MOVE_UP}</a>
					{ICON_MOVE_DOWN_DISABLED}
				<!-- ELSE -->
					{ICON_MOVE_UP_DISABLED}
					{ICON_MOVE_DOWN_DISABLED}
				<!-- ENDIF -->
				<a href="{catrow.U_EDIT}">{ICON_EDIT}</a>
				<a href="{catrow.U_DELETE}">{ICON_DELETE}</a>
			</td>
		</tr>
	<!-- END catrow -->
	</tbody>
</table>
<!-- ENDIF -->
<form id="pa_files" method="post" action="{S_ACTION}">
	<fieldset class="quick">
		<input type="hidden" name="action" value="create" />
		<input class="button2" name="addforum" type="submit" value="{L_ACP_CAT_NEW}" />
	</fieldset>
	{S_FORM_TOKEN}
</form>
<!-- ENDIF -->

<!-- IF S_MODE_CREATE -->
<h1>{L_ACP_DOWNLOAD_SYSTEM} - {L_ACP_CAT_NEW}</h1>
<p>{L_ACP_CAT_NEW_EXPLAIN}</p>
<br />
<!-- ENDIF -->

<!-- IF S_MODE_EDIT -->
<h1>{L_ACP_DOWNLOAD_SYSTEM} - {L_ACP_EDIT_CAT}</h1>
<p>{L_ACP_EDIT_CAT_EXPLAIN}</p>
<br />
<!-- ENDIF -->

<!-- IF S_MODE_CREATE -->
<form id="acp_pa_files" method="post" action="{U_ACTION}">
	<fieldset>
		<legend><!-- IF S_MODE_CREATE -->{L_ACP_NEW_CAT}<!-- ELSE -->{L_ACP_EDIT_CAT}<!-- ENDIF --></legend>
		<!-- IF ERROR_MSG -->
			<div class="errorbox">
				<h3>{L_WARNING}</h3>
				<p>{ERROR_MSG}</p>
			</div>
		<!-- ENDIF -->
		<dl>
			<dt><label for="cat_name">{L_ACP_NEW_CAT_NAME}{L_COLON}</label></dt>
			<dd><input class="text" type="text" id="cat_name" value="{CAT_NAME}" name="cat_name" size="53" maxlength="255" /></dd>
		</dl>
		<dl>
			<dt><label>{L_ACP_NEW_SUB_CAT_NAME}{L_COLON}</label><br /><span>{L_ACP_NEW_SUB_CAT_EXPLAIN}</span></dt>
			<dd><input class="text" type="text" id="cat_sub_dir" value="{CAT_SUB_DIR}" name="cat_sub_dir" size="53" maxlength="255" /></dd>
		</dl>
		<dl>
			<dt><label>{L_ACP_NEW_CAT_NAME_SHOW}{L_COLON}</label><br />{L_ACP_NEW_CAT_NAME_SHOW_EXPLAIN}</dt>
			<dd><label><input type="radio" class="radio" name="cat_name_show" value="1"<!-- IF CAT_NAME_SHOW --> id="cat_name_show" checked="checked" <!-- ENDIF --> /> {L_YES}</label>
			<label><input type="radio" class="radio" name="cat_name_show" value="0"<!-- IF not CAT_NAME_SHOW --> id="cat_name_show" checked="checked" <!-- ENDIF --> /> {L_NO}</label></dd>
		</dl>
		<dl>
			<dt><label>{L_ACP_SUB_DL_CAT}{L_COLON}</label><br /><span>{L_ACP_SUB_DL_CAT_EXPLAIN}</span></dt>
			<dd><select name="parent_id"><option value="0">{CAT_NAME_NO_SHOW}</option>{S_PARENT_OPTIONS}</select></dd>

		</dl>
		<dl>
			<dt><label for="cat_desc">{L_ACP_NEW_CAT_DESC}{L_COLON}</label><br /><span>{L_ACP_NEW_CAT_DESC_EXPLAIN}</span></dt>
			<dd><textarea id="cat_desc" name="cat_desc" rows="5" cols="45">{CAT_DESC}</textarea></dd>
			<dd><label><input type="checkbox" class="radio" name="desc_parse_bbcode"<!-- IF S_DESC_BBCODE_CHECKED --> checked="checked"<!-- ENDIF --> /> {L_PARSE_BBCODE}</label>
			<label><input type="checkbox" class="radio" name="desc_parse_smilies"<!-- IF S_DESC_SMILIES_CHECKED --> checked="checked"<!-- ENDIF --> /> {L_PARSE_SMILIES}</label>
			<label><input type="checkbox" class="radio" name="desc_parse_urls"<!-- IF S_DESC_URLS_CHECKED --> checked="checked"<!-- ENDIF --> /> {L_PARSE_URLS}</label></dd>
		</dl>
	</fieldset>

	<p class="submit-buttons">
		<input class="button1" type="submit" id="submit" name="submit" value="{L_SUBMIT}" />&nbsp;
		<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
	</p>
	{S_FORM_TOKEN}

</form>
<!-- ENDIF -->

<!-- IF S_MODE_EDIT -->
<form id="acp_pa_files" method="post" action="{U_ACTION}">
	<fieldset>
		<legend><!-- IF S_MODE_CREATE -->{L_ACP_NEW_CAT}<!-- ELSE -->{L_ACP_EDIT_CAT}<!-- ENDIF --></legend>
		<!-- IF ERROR_MSG -->
			<div class="errorbox">
				<h3>{L_WARNING}</h3>
				<p>{ERROR_MSG}</p>
			</div>
		<!-- ENDIF -->
		<dl>
			<dt><label for="cat_name">{L_ACP_NEW_CAT_NAME}{L_COLON}</label></dt>
			<dd><input class="text" type="text" id="cat_name" value="{CAT_NAME}" name="cat_name" maxlength="255" /></dd>
		</dl>
		<dl>
			<dt><label>{L_ACP_NEW_SUB_CAT_NAME}{L_COLON}</label><br /><span>{L_ACP_EDIT_SUB_CAT_EXPLAIN}</span></dt>
			<dd>{CAT_SUB_DIR}</dd>
		</dl>

		<dl>
			<dt><label>{L_ACP_NEW_CAT_NAME_SHOW}{L_COLON}</label><br />{L_ACP_NEW_CAT_NAME_SHOW_EXPLAIN}</dt>
			<dd><label><input type="radio" class="radio" name="cat_name_show" value="1"<!-- IF CAT_NAME_SHOW --> id="cat_name_show" checked="checked" <!-- ENDIF --> /> {L_YES}</label>
			<label><input type="radio" class="radio" name="cat_name_show" value="0"<!-- IF not CAT_NAME_SHOW --> id="cat_name_show" checked="checked" <!-- ENDIF --> /> {L_NO}</label></dd>
		</dl>
		<dl>
			<dt><label>{L_ACP_SUB_DL_CAT}{L_COLON}</label><br /><span>{L_ACP_SUB_DL_CAT_EXPLAIN}</span></dt>
			<dd><!-- IF S_HAS_SUBCATS --><select name="parent_id"><option value="0">{CAT_NAME_NO_SHOW}</option>{S_PARENT_OPTIONS}</select><!-- ELSE --><span>{L_ACP_SUB_HAS_CAT_EXPLAIN}</span><!-- ENDIF --></dd>
		</dl>
		<dl>
			<dt><label for="cat_desc">{L_ACP_NEW_CAT_DESC}{L_COLON}</label><br /><span>{L_ACP_NEW_CAT_DESC_EXPLAIN}</span></dt>
			<dd><textarea id="cat_desc" name="cat_desc" rows="5" cols="45">{CAT_DESC}</textarea></dd>
			<dd><label><input type="checkbox" class="radio" name="desc_parse_bbcode"<!-- IF S_DESC_BBCODE_CHECKED --> checked="checked"<!-- ENDIF --> /> {L_PARSE_BBCODE}</label>
			<label><input type="checkbox" class="radio" name="desc_parse_smilies"<!-- IF S_DESC_SMILIES_CHECKED --> checked="checked"<!-- ENDIF --> /> {L_PARSE_SMILIES}</label>
			<label><input type="checkbox" class="radio" name="desc_parse_urls"<!-- IF S_DESC_URLS_CHECKED --> checked="checked"<!-- ENDIF --> /> {L_PARSE_URLS}</label></dd>
		</dl>
	</fieldset>

	<p class="submit-buttons">
		<input class="button1" type="submit" id="submit" name="submit" value="{L_SUBMIT}" />&nbsp;
		<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
	</p>
	{S_FORM_TOKEN}

</form>
<!-- ENDIF -->

<!-- IF S_MODE_DELETE -->
<form id="acp_pa_files" method="post" action="{U_ACTION}">
	<fieldset>
		<legend><h1>{L_CONFIRM}</h1></legend>
			<dl>
				{CAT_DELETE}
			</dl>
			<p class="submit-buttons">
				<input class="button1" type="submit" id="submit" name="submit" value="{L_YES}" />&nbsp;
				<input class="button2" type="reset" id="reset" name="reset" value="{L_NO}" />
			</p>
		{S_FORM_TOKEN}
	</fieldset>
</form>
<!-- ENDIF -->
