<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: lang_main.php,v 1.16 2008/09/24 19:13:14 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, publisher, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// Web: http://mxpcms.sourceforge.net
// Autor: Bodin Florin Ciprian and The MXP Developemt Team
// Email: orynider@users.souceforge.net
//
// General
//
$lang['PUB_title'] = 'Article Base';

$lang['Category'] = 'Category';
$lang['Sub_categories'] = 'Subcategories';
$lang['Article'] = 'Article';
$lang['Articles'] = 'Articles';
$lang['Article_description'] = 'Description';
$lang['Article_type'] = 'Type';
$lang['Article_keywords'] = 'Keywords';
$lang['Add_article'] = 'Add Article';
$lang['Click_cat_to_add'] = 'Click a category to add an article';
$lang['PUB_Home'] = 'Start Page - Articles Home';
$lang['No_articles'] = 'No Articles';
$lang['Article_title'] = 'Article Name';
$lang['Article_text'] = 'Article text';
$lang['Add_article'] = 'Submit Article';
$lang['Read_article'] = 'Reading Article';
$lang['Article_not_exsist'] = 'Article doesn\'t exist';
$lang['Category_not_exsist'] = 'Category doesn\'t exist';
$lang['Last_article'] = 'Last article';

$lang['Quick_jump'] = 'Select Category';
$lang['Error_no_download'] = 'The selected File does not exist anymore';
$lang['Options'] = 'Options';
$lang['Click_return'] = 'Click %sHere%s to return to the previous page';
$lang['Click_here'] = 'Click Here';
$lang['never'] = 'None';
$lang['publisher_disable'] = 'The Articles Database is disabled';
$lang['jump'] = 'Select a category';
$lang['viewall_disabled'] = 'This feature is disabled by the admin.';
$lang['New_file'] = 'New file';
$lang['No_new_file'] = 'No new file';
$lang['None'] = 'None';
$lang['No_file'] = 'No Files';
$lang['View_latest_file'] = 'View Latest File';
$lang['Edit'] = 'Edit';
$lang['Click_cat_to_add'] = 'Click on Category to add Article';
$lang['Standalone_Not_Supported'] = 'This module does not support standalone usage. In the AdminCP, add the KB block to a portal page.';

$lang['Article_submitted_Approve'] = 'Article Submitted Successfully.<br />An Administrator will review your article and decide whether to let users view it or not.';
$lang['Article_submitted'] = 'Article Submitted Successfully.';
$lang['Click_return_pub'] = 'Press %shere%s to return at ' . $lang['PUB_title'];
$lang['Click_return_article'] = 'Press %shere%s to return at ' . $lang['Article'];

$lang['Article_Edited_Approve'] = 'Article Edited Successfully.<br />It needs to be approved again before users can view it.';
$lang['Article_Edited'] = 'Article Edited Successfully.';
$lang['Edit_article'] = 'Edit Article';

$lang['Article_Deleted'] = 'The article was deleted successfully.';

//
// Notification
//
$lang['PUB_prefix'] = '[ PUB ]';
$lang['PUB_notify_subject_new'] = 'New Article!';
$lang['PUB_notify_subject_edited'] = 'Edited Article!';
$lang['PUB_notify_subject_approved'] = 'Approved Article!';
$lang['PUB_notify_subject_unapproved'] = 'Unapproved Article!';
$lang['PUB_notify_subject_deleted'] = 'Deleted Article!';

$lang['PUB_notify_new_body'] = 'A new article has been submitted.';
$lang['PUB_notify_edited_body'] = 'An article has been modified.';
$lang['PUB_notify_approved_body'] = 'An article has been approved.';
$lang['PUB_notify_unapproved_body'] = 'An article has been unapproved.';
$lang['PUB_notify_deleted_body'] = 'An article has been deleted.';
$lang['Edited_Article_info'] = 'Article updated by ';

$lang['Read_full_article'] = '>> Read Full Article';

//
// Auth Can
//
$lang['PUB_Rules_post_can'] = 'You <b>can</b> post new articles in this category';
$lang['PUB_Rules_post_cannot'] = 'You <b>cannot</b> post new articles in this category';
$lang['PUB_Rules_comment_can'] = 'You <b>can</b> comment articles in this category';
$lang['PUB_Rules_comment_cannot'] = 'You <b>cannot</b> comment articles in this category';
$lang['PUB_Rules_edit_can'] = 'You <b>can</b> edit your articles in this category';
$lang['PUB_Rules_edit_cannot'] = 'You <b>cannot</b> edit your articles in this category';
$lang['PUB_Rules_delete_can'] = 'You <b>can</b> delete your articles in this category';
$lang['PUB_Rules_delete_cannot'] = 'You <b>cannot</b> delete your articles in this category';
$lang['PUB_Rules_rate_can'] = 'You <b>can</b> rate articles in this category';
$lang['PUB_Rules_rate_cannot'] = 'You <b>cannot</b> rate articles in this category';
$lang['PUB_Rules_approval_can'] = 'Articles <b>need no</b> approval in this category';
$lang['PUB_Rules_approval_cannot'] = 'Articles <b>need</b> approval in this category';
$lang['PUB_Rules_approval_edit_can'] = 'Article edits <b>need no</b> approval in this category';
$lang['PUB_Rules_approval_edit_cannot'] = 'Article edits <b>need</b> approval in this category';
$lang['PUB_Rules_moderate'] = 'You <b>can</b> %smoderate this category%s'; // %s replaced by a href links, do not remove!
$lang['PUB_Rules_moderate_can'] = 'You <b>can</b> moderate this category'; // %s replaced by a href links, do not remove!

$lang['Empty_fields'] ='Please fill out all parts of the form.';
$lang['Empty_fields_return'] ='Click %sHere%s to return to the form.';
$lang['Empty_category'] ='You must choose a category';
$lang['Empty_type']='You must choose a type';
$lang['Empty_article_name'] = 'You must fill out the article name';
$lang['Empty_article_desc'] = 'You must fill out the article description';

$lang['Comments'] = 'Comments';

$lang['Post_comments'] = 'Post your comments';

$lang['Category_sub'] = 'Sub-Categories';
$lang['Quick_stats'] = 'Quick Stats';

$lang['No_Articles'] = 'There are no articles in this category!';
$lang['Not_authorized'] = 'Sorry, but you are not authorized!';
$lang['TOC'] = 'Contents';

//
// Print version
//
$lang['Print_version'] = '[Printable version]';

//
// Stats
//
$lang['View_All'] = 'View All';
$lang['Stats_Most_Popular'] = 'Stats Most Popular';
$lang['Stats_Latest'] = 'Stats Latest';
$lang['Top_toprated'] = 'Toprated Articles';
$lang['Top_most_popular'] = 'Most Popular';
$lang['Top_latest'] = 'Latest Articles';
$lang['Top_id'] = 'Article Id';
$lang['Top_creation'] = 'Article date';
$lang['Top_alphabetic'] = 'Alphabetic';
$lang['Top_userrank'] = 'Author userrank';

//
// Update result messages
//
$lang['Click_return'] = 'Click %sHere%s to return to previous page';
$lang['Click_return_pub'] = 'Click %sHere%s to return to the ' . $lang['PUB_title'];
$lang['Click_return_article'] = 'Click %sHere%s to return to the ' . $lang['Article'];

//
// Article formattting
//
$lang['Cat_all'] = 'All';

$lang['L_Pages'] = 'Pages';
$lang['L_Pages_explain'] = 'Use the \'[pages]\' command to split the article into pages';
$lang['L_Toc'] = 'Table of contents (TOC)';
$lang['L_Toc_explain'] = 'Use the \'[toc]\' command to add entry in the TOC';
$lang['L_Abstract'] = 'Abstract';
$lang['L_Abstract_explain'] = 'Use the \'[abstract]...[/abstract]\' environment to insert an abstract';

$lang['L_Title_Format'] = 'Title';
$lang['L_Title_Format_explain'] = 'Use the \'[title]...[/title]\' environment to insert a main title';

$lang['L_Subtitle_Format'] = 'Subtitle';
$lang['L_Subtitle_Format_explain'] = 'Use the \'[subtitle]...[/subtitle]\' environment to insert a subtitle';

$lang['L_Subsubtitle_Format'] = 'Sub-subtitle';
$lang['L_Subsubtitle_Format'] = 'Use the \'[subsubtitle]...[/subsubtitle]\' environment to insert a small header';

$lang['L_Subsubtitle_Format'] = 'Sub-subtitle';
$lang['L_Subsubtitle_Format_explain'] = 'Use the \'[subsubtitle]...[/subsubtitle]\' environment to insert a small header';

$lang['Options'] = 'Options ';

$lang['L_Options'] = 'Options:';
$lang['L_Formatting'] = 'Formatting:';

$lang['Default_article_id'] = 'Set default article, for the article viewer';

$lang['Click_here'] = 'Click here';
$lang['never'] = 'None';
$lang['pafiledb_disable'] = 'Download Database is disabled';
$lang['jump'] = 'Select a category';
$lang['viewall_disabled'] = 'This feature is disabled by the admin.';
$lang['New_file'] = 'New file';
$lang['No_new_file'] = 'No new file';
$lang['None'] = 'None';
$lang['No_file'] = 'No Files';
$lang['View_latest_file'] = 'View Latest File';

$lang['Error_no_download'] = 'The selected File does not exist anymore';

$lang['Article_description'] = 'Description';
$lang['Article_type'] = 'Type';
$lang['Article_keywords'] = 'Keywords';
$lang['Add_article_explain'] = 'Add Article';
$lang['Pub_Home'] = 'Publisher Home';
$lang['No_articles'] = 'No Articles';
$lang['Article_title'] = 'Article Name';
$lang['Article_text'] = 'Article text';
$lang['Add_article'] = 'Submit Article';
$lang['Read_article'] = 'Reading Article';
$lang['Article_not_exsist'] = 'Article doesn\'t exist';
$lang['Category_not_exsist'] = 'Category doesn\'t exist';
$lang['Last_article'] = 'Last article';

//
// Return
//
$lang['Click_return'] = 'Click %sHere%s to return to the previous page';

//
// Main
//
$lang['Files'] = 'Files';
$lang['Viewall'] = 'View All Files';
$lang['Vainfo'] = 'View all of the files in the database';
$lang['Quick_nav'] = 'Quick Navigation';
$lang['Quick_jump'] = 'Select Category';
$lang['Quick_go'] = 'Go';
$lang['Sub_category'] = 'Sub Category';
$lang['Last_file'] = 'Last File';

//
// Sort
//
$lang['Sort'] = 'Sort';
$lang['Name'] = 'Name';
$lang['Update_time'] = 'Last Updated';

//
// Category
//
$lang['No_files'] = 'No files found';
$lang['No_files_cat'] = 'There are no files in this category.';
$lang['Cat_not_exist'] = 'The category you selected does not exist.';
$lang['File_not_exist'] = 'The file you selected does not exist.';
$lang['License_not_exist'] = 'The license you selected does not exist.';

//
// File
//
$lang['File'] = 'File';
$lang['Desc'] = 'Description';
$lang['Creator'] = 'Creator';
$lang['Submited'] = 'Submited by';
$lang['Version'] = 'Version';
$lang['Scrsht'] = 'Screenshot';
$lang['Docs'] = 'Documentation/Manual';
$lang['Lastdl'] = 'Last Download';
$lang['Never'] = 'Never';
$lang['Votes'] = ' Votes';
$lang['Date'] = 'Date';
$lang['Update_time'] = 'Last Updated';
$lang['DlRating'] = 'Rating';
$lang['Dls'] = ' Downloads';
$lang['Downloadfile'] = 'Download File';
$lang['File_size'] = 'File Size';
$lang['Not_available'] = 'Not Available!';
$lang['Bytes'] = 'Bytes';
$lang['KB'] = 'Kilo Byte';
$lang['MB'] = 'Mega Byte';
$lang['Mirrors'] = 'Mirrors';
$lang['Mirrors_explain'] = 'Here you can add or edit mirrors for this file, make sure to verify all the information because the file will be submitted to the database';
$lang['Click_here_mirrors'] = 'Click Here to Add mirrors';
$lang['Mirror_location'] = 'Mirror Location';
$lang['Add_new_mirror'] = 'Add new mirror';
$lang['Save_as'] = 'Save As...';

//
// Admin Panels - File
//
$lang['File_manage_title'] = 'File Management';

$lang['Afile'] = 'File: Add';
$lang['Efile'] = 'File: Edit';
$lang['Dfile'] = 'File: Delete';
$lang['Afiletitle'] = 'Add File';
$lang['Efiletitle'] = 'Edit File';
$lang['Dfiletitle'] = 'Delete File';
$lang['Fileexplain'] = 'You can use the file management section to add, edit, and delete files.';
$lang['Upload'] = 'Upload File';
$lang['Uploadinfo'] = 'Upload this file';
$lang['Uploaderror'] = 'This file already exists. Please rename the file and try again.';
$lang['Uploaddone'] = 'This file has been successfully uploaded. The URL to the file is';
$lang['Uploaddone2'] = 'Click Here to place this URL in the Download URL field.';
$lang['Upload_do_done'] = 'Uploaded Sucessfully';
$lang['Upload_do_not'] = 'Not Uploaded';
$lang['Upload_do_exist'] = 'File Exist';
$lang['Filename'] = 'File Name';
$lang['Filenameinfo'] = 'This is the name of the file you are adding, such as \'My Picture.\'';
$lang['Filesd'] = 'Short Description';
$lang['Filesdinfo'] = 'This is a short description of the file. This will go on the page that lists all the files in a category, so this description should be short';
$lang['Fileld'] = 'Long Description';
$lang['Fileldinfo'] = 'This is a longer description of the file. This will go on the file\'s information page so this description can be longer';
$lang['Filecreator'] = 'Creator/Author';
$lang['Filecreatorinfo'] = 'This is the name of whoever created the file.';
$lang['Fileversion'] = 'File Version';
$lang['Fileversioninfo'] = 'This is the version of the file, such as 3.0 or 1.3 Beta';
$lang['Filess'] = 'Screenshot URL';
$lang['Filessinfo'] = 'This is a URL to a screenshot of the file. For example, if you are adding a Winamp skin, this would be a URL to a screenshot of Winamp with this skin. You can manually enter a URL or you can leave it blank and upload a screen shot using "Browse" above.';
$lang['Filess_upload'] = 'Upload Screenshot';
$lang['Filessinfo_upload'] = 'You can upload a screenshot by clicking on "Browse"';
$lang['Filess_link'] = 'Screenshot as a Link';
$lang['Filess_link_info'] = 'If you want to show the screenshot as a link, choose "yes".';
$lang['Filedocs'] = 'Documentation/Manual URL';
$lang['Filedocsinfo'] = 'This is a URL to the documentation or a manual for the file';
$lang['Fileurl'] = 'File URL';
$lang['Fileurlinfo'] = 'This is a URL to the file that will be downloaded. You can type it in manually or you can click on "Browse" above and upload a file.';
$lang['File_upload'] = 'File Upload';
$lang['Fileinfo_upload'] = 'You can upload a file by clicking on "Browse"';
$lang['Uploaded_file'] = 'Uploaded file';
$lang['Filepi'] = 'Post Icon';
$lang['Filepiinfo'] = 'You can choose a post icon for the file. The post icon will be shown next to the file in the list of files.';
$lang['Filecat'] = 'Category';
$lang['Filecatinfo'] = 'This is the category the file belongs in.';
$lang['Filelicense'] = 'License';
$lang['Filelicenseinfo'] = 'This is the license agreement the user must agree to before downloading the file.';
$lang['Filepin'] = 'Pin File';
$lang['Filepininfo'] = 'Choose if you want the file pinned or not. Pinned files will always be shown at the top of the file list.';
$lang['Filedisable'] = 'Disable file download';
$lang['Filedisableinfo'] = 'This setting makes the file disabled, but still visible. A pop-up message informs the user this file is not available at the moment.';
$lang['Filedisablemsg'] = 'Disable message';
$lang['Filedisablemsginfo'] = 'The pop-up message...';
$lang['Fileadded'] = 'The new file has been successfully added';
$lang['Filedeleted'] = 'The file has been successfully deleted';
$lang['Fileedited'] = 'The file you selected has been successfully edited';
$lang['Fderror'] = 'You didn\'t select any files to delete';
$lang['Filesdeleted'] = 'The files you selected have been successfully deleted';
$lang['Filetoobig'] = 'That file is too big!';
$lang['Approved'] = 'Approved';
$lang['Not_approved'] = '(Not Approved)';
$lang['Approved_info'] = 'Use this option to make the file available for users, and also to approve a file that has been uploaded by the users.';

$lang['Filedls'] = 'Download Total';
$lang['Addtional_field'] = 'Additional Field';
$lang['File_not_found'] = 'The file you specified cannot be found';
$lang['SS_not_found'] = 'The screenshot you specified cannot be found';

//
// MCP
//
$lang['MCP_title'] = 'Moderator Control Panel';
$lang['MCP_title_explain'] = 'Here moderators can approve and manage files';

$lang['View'] = 'View';

$lang['Approve_selected'] = 'Approve Selected';
$lang['Unapprove_selected'] = 'Unapprove Selected';
$lang['Delete_selected'] = 'Delete Selected';
$lang['No_item'] = 'There are no articles';
$lang['No_file'] = 'There are no files';
$lang['All_items'] = 'All articles';
$lang['All_files'] = 'All Files';
$lang['Approved_items'] = 'Approved articles';
$lang['Approved_files'] = 'Approved Files';
$lang['Unapproved_items'] = 'Unapproved articles';
$lang['Unapproved_files'] = 'Unapproved Files';
$lang['Broken_items'] = 'Broken articles';
$lang['Broken_files'] = 'Broken Files';
$lang['Item_cat'] = 'Articles in Category';
$lang['File_cat'] = 'File in Category';
$lang['Approve'] = 'Approve';
$lang['Unapprove'] = 'Unapprove';

$lang['Sorry_auth_delete'] = 'Sorry, but you cannot delete files in this category.';
$lang['Sorry_auth_mcp'] = 'Sorry, but you cannot moderate this category.';
$lang['Sorry_auth_approve'] = 'Sorry, but you cannot approve items in this category.';
$lang['Sorry_auth_post'] = 'Sorry, but you cannot post articles in this category.';
$lang['Sorry_auth_edit'] = 'Sorry, but you cannot edit articles in this category.';

$lang['Edit_article'] = 'Edit';
$lang['Delete_article'] = 'Delete';

//
// User Upload
//
$lang['User_upload'] = 'User Upload';


//
// License
//
$lang['License'] = 'License Agreement';
$lang['Licensewarn'] = 'You must agree to this license agreement to download';
$lang['Iagree'] = 'I Agree';
$lang['Dontagree'] = 'I do not agree';

//
// Added for v. 2.0
//
$lang['Addtional_field'] = 'More information (optional)';
$lang['No_cat_comments_forum_id'] = 'Comments are enabled but you have not specified the target phpBB forum category in the KB adminCP - Categories';



//
// Quick Nav
//
$lang['Quick_nav'] = 'Quick Navigation';
$lang['Quick_jump'] = 'Select Category';
$lang['Quick_go'] = 'Go';


//
// Search
//
$lang['Search'] = 'Search';
$lang['Search_results'] = 'Search Results';
$lang['Search_for'] = 'Search for';
$lang['Results'] = 'Results for';
$lang['No_matches'] = 'Sorry, no matches were found for';
$lang['Matches'] = 'matches were found for';
$lang['All'] = 'All Categories';
$lang['Choose_cat'] = 'Choose Category:';
$lang['Include_comments'] = 'Include Comments';
$lang['Submiter'] = 'Submitted by';

//
// Comments
//
$lang['PUB_comment_prefix'] = '[ PUB ] ';
$lang['Comments'] = 'Comments';
$lang['Comments_title'] = 'Comments Title';
$lang['Comment_subject'] = 'Comment Subject';
$lang['Comment'] = 'Comment';
$lang['Comment_explain'] = 'Use the textbox above to give your opinion on this file!';
$lang['Comment_add'] = 'Add Comment';
$lang['Comment_edit'] = 'Edit';
$lang['Comment_delete'] = 'Delete';
$lang['Comment_posted'] = 'Your comment has been entered successfully';
$lang['Comment_deleted'] = 'The comment you selected has been deleted successfully';
$lang['Comment_desc'] = 'Title';
$lang['No_comments'] = 'Not commented';
$lang['Links_are_ON'] = 'Links are <u>ENABLED</u>';
$lang['Links_are_OFF'] = 'Links are <u>DISABLED</u>';
$lang['Images_are_ON'] = 'Images are <u>ENABLED</u>';
$lang['Images_are_OFF'] = 'Images are <u>DISABLED</u>';
$lang['Check_message_length'] = 'Check Message Length';
$lang['Msg_length_1'] = 'Your message is ';
$lang['Msg_length_2'] = ' characters long.';
$lang['Msg_length_3'] = 'You have ';
$lang['Msg_length_4'] = ' characters available.';;
$lang['Msg_length_5'] = 'There are ';
$lang['Msg_length_6'] = ' characters remaining.';


//
// Statistics
//
$lang['Statistics'] = 'Statistics';
$lang['Stats_text'] = 'There are {total_files} files in {total_categories} categories<br>';
$lang['Stats_text'] .= 'There have been {total_downloads} total downloads<br><br>';
$lang['Stats_text'] .= 'The newest file is <a href={u_newest_file}>{newest_file}</a><br>';
$lang['Stats_text'] .= 'The oldest file is <a href={u_oldest_file}>{oldest_file}</a><br><br>';
$lang['Stats_text'] .= 'The average file rating is {average}/10<br>';
$lang['Stats_text'] .= 'The most popular file based on ratings is <a href={u_popular}>{popular}</a> with a rating of {most}/10<br>';
$lang['Stats_text'] .= 'The least popular file based on ratings is <a href={u_lpopular}>{lpopular}</a> with a rating of {least}/10<br><br>';
$lang['Stats_text'] .= 'The average amount of downloads each file has is {avg_dls}<br>';
$lang['Stats_text'] .= 'The most popular file based on downloads is <a href={u_most_dl}>{most_dl}</a> with {most_no} downloads<br>';
$lang['Stats_text'] .= 'The least popular file based on downloads is <a href={u_least_dl}>{least_dl}</a> with {least_no} downloads<br>';
$lang['Select_chart_type'] = 'Select Chart Type';
$lang['Bars'] = 'Bars';
$lang['Lines'] = 'Lines';
$lang['Area'] = 'Area';
$lang['Linepoints'] = 'Line Points';
$lang['Points'] = 'Points';
$lang['Chart_header'] = 'Files Stats - Files added to the database each month';
$lang['Chart_legend'] = 'Files';
$lang['X_label'] = 'Months';
$lang['Y_label'] = 'Number of Files';

//
// Rate
//
$lang['Votes_label'] = 'Rating';
$lang['Votes'] = 'Votes';
$lang['No_votes'] = 'No votes';
$lang['Rate'] = 'Evaluate';
$lang['ADD_RATING'] = '[Rate Article]';
$lang['Do_rate'] = '[Rate File]';
$lang['Rerror'] = 'Sorry, you have already rated this file.';
$lang['Rateinfo'] = 'You are about to rate the file <i>{filename}</i>.<br>Please select a rating below. 1 is the worst, 10 is the best.';
$lang['Rconf'] = 'You have given <i>{filename}</i> a rating of {rate}.<br>This makes the files new rating {newrating}.';
$lang['R1'] = '1';
$lang['R2'] = '2';
$lang['R3'] = '3';
$lang['R4'] = '4';
$lang['R5'] = '5';
$lang['R6'] = '6';
$lang['R7'] = '7';
$lang['R8'] = '8';
$lang['R9'] = '9';
$lang['R10'] = '10';
$lang['Not_rated'] = 'Not Rated';

//
// Email
//
$lang['Emailfile'] = 'E-mail File to a Friend';
$lang['Emailinfo'] = 'If you would like a friend to know about this file, you can fill out and submit this form and an e-mail containing the files information will be e-mailed to your friend!<br>Items marked with a * are required unless stated otherwise';
$lang['Yname'] = 'Your Name';
$lang['Yemail'] = 'Your E-mail Address';
$lang['Fname'] = 'Friends Name';
$lang['Femail'] = 'Friends E-mail Address';
$lang['Esub'] = 'E-mail Subject';
$lang['Etext'] = 'E-mail Text';
$lang['Defaultmail'] = 'I thought you might be interested in downloading the file located at';
$lang['Semail'] = 'Send E-mail';
$lang['Econf'] = 'Your e-mail has been sent successfully.';

//
// Comments
//
$lang['Comments'] = 'Comments';
$lang['Comments_title'] = 'Comments Title';
$lang['Comment_subject'] = 'Comment subject';
$lang['Comment'] = 'Comment';
$lang['Comment_explain'] = 'Use the text box above to give your opinion on this file!';
$lang['Comment_add'] = 'Add Comment';
$lang['Comment_edit'] = 'Edit';
$lang['Comment_delete'] = 'Delete';
$lang['Comment_posted'] = 'Your comment has been entered successfully';
$lang['Comment_deleted'] = 'The comment you selected has been deleted successfully';
$lang['Comment_desc'] = 'Title';
$lang['No_comments'] = 'Not Commented.';
$lang['Links_are_ON'] = 'Links is <u>ON</u>';
$lang['Links_are_OFF'] = 'Links is <u>OFF</u>';
$lang['Images_are_ON'] = 'Images is <u>ON</u>';
$lang['Images_are_OFF'] = 'Images is <u>OFF</u>';
$lang['Check_message_length'] = 'Check Message Length';
$lang['Msg_length_1'] = 'Your message is ';
$lang['Msg_length_2'] = ' characters long.';
$lang['Msg_length_3'] = 'You have ';
$lang['Msg_length_4'] = ' characters available.';;
$lang['Msg_length_5'] = 'There are ';
$lang['Msg_length_6'] = ' characters left to use.';


//
// Download
//
$lang['Directly_linked'] = 'You can not download this file directly from another site!';

//
//Permission
//
$lang['Sorry_auth_view'] = 'Sorry, but only %s can view files and sub category in this category.';
$lang['Sorry_auth_file_view'] = 'Sorry, but only %s can view this file in this category.';
$lang['Sorry_auth_upload'] = 'Sorry, but only %s can upload file in this category.';
$lang['Sorry_auth_download'] = 'Sorry, but only %s can download files in this category.';
$lang['Sorry_auth_rate'] = 'Sorry, but only %s can rate files in this category.';
$lang['Sorry_auth_view_comments'] = 'Sorry, but only %s can view comments in this category.';
$lang['Sorry_auth_post_comments'] = 'Sorry, but only %s can post comments in this category.';
$lang['Sorry_auth_edit_comments'] = 'Sorry, but only %s can edit comments in this category.';
$lang['Sorry_auth_delete_comments'] = 'Sorry, but only %s can delete comments in this category.';
$lang['Sorry_auth_edit'] = 'Sorry, but you cannot edit files in this category.';
$lang['Sorry_auth_viewall'] = 'Sorry, but you cannot view viewall in this category.';

//
// New
//
$lang['Deletefile'] = 'Delete file';
$lang['Editfile'] = 'Edit file';
$lang['pub_MCP'] = '[ModeratorCP]';
$lang['Click_return_not_validated'] = 'Click %sHere%s to return to the previous page';
$lang['Fileadded_not_validated'] = 'The new file has been successfully added, but a moderator (admin) need to validate the file before approval.';

$lang['Quickdl_back'] = '&laquo; Back';

$lang['Quickdl'] = 'Default Pa Cat';
$lang['Quickdl_explain'] = 'This is the default publisher category to display, if no mapping is activated';

$lang['Pa_updated_return_settings'] = 'Pa quickdl configuration updated successfully.<br /><br />Click %shere%s to return to main page.'; // %s's for URI params - DO NOT REMOVE
$lang['Pa_update_error'] = 'Couldn\'t update Pa quickdl configuration.<br /><br />This mod is designed for MySQL so please contact the author if you have troubles. If you can offer a translation of the SQL into other database formats, please send them to:<br />';

$lang['Pa_settings'] = 'Pa mapping settings';
$lang['Pa_settings_short_explain'] = 'Settings for mapping pa cats and dynamic blocks.';
$lang['Pa_settings_explain'] = 'Here you can edit the configuration for the pa module. This panel lets you associate pa cats and dynamic blocks for the quickdl block.';

//
// Notification
//
$lang['PUB_title'] = 'Projects Database';
$lang['PUB_prefix'] = '[ File ]';

$lang['PUB_goto_file'] = '<br />View File';

$lang['PUB_notify_subject_new'] = 'New file!';
$lang['PUB_notify_subject_edited'] = 'Edited file!';
$lang['PUB_notify_subject_approved'] = 'Approved file!';
$lang['PUB_notify_subject_unapproved'] = 'Unapproved file!';
$lang['PUB_notify_subject_deleted'] = 'Removed file!';
$lang['PUB_notify_subject_unapproved'] = '<br />Fife Un-Approved!';
$lang['PUB_notify_body'] = '<br />One file has been uploaded or updated:';
$lang['PUB_no_ratings'] = '<br />Dezactivated in this category';

$lang['PUB_notify_new_body'] = 'A new file was uploaded in the download manager.';
$lang['PUB_notify_edited_body'] = 'A file has been edited in the download manager.';
$lang['PUB_notify_approved_body'] = 'A file has been approved in the download manager.';
$lang['PUB_notify_unapproved_body'] = 'A file has been unapproved in the download manager.';
$lang['PUB_notify_deleted_body'] = 'A file has been removed from the download manager.';
$lang['Edited_Article_info'] = 'The file was updated by ';

$lang['PUB_goto'] = '>>View file';

//
// Auth Can
//
$lang['PUB_Rules_upload_can'] = 'You <b>can</b> upload new files in this category';
$lang['PUB_Rules_upload_cannot'] = 'You <b>cannot</b> upload new files in this category';
$lang['PUB_Rules_download_can'] = 'You <b>can</b> download files in this category';
$lang['PUB_Rules_download_cannot'] = 'You <b>cannot</b> download files in this category';
$lang['PUB_Rules_post_comment_can'] = 'You <b>can</b> comment files in this category';
$lang['PUB_Rules_post_comment_cannot'] = 'You <b>cannot</b> comment files in this category';
$lang['PUB_Rules_view_comment_can'] = 'You <b>can</b> view comments in this category';
$lang['PUB_Rules_view_comment_cannot'] = 'You <b>cannot</b> view comments in this category';
$lang['PUB_Rules_view_file_can'] = 'You <b>can</b> see files in this category';
$lang['PUB_Rules_view_file_cannot'] = 'You <b>cannot</b> see files in this category';
$lang['PUB_Rules_edit_file_can'] = 'You <b>can</b> edit your files in this category';
$lang['PUB_Rules_edit_file_cannot'] = 'You <b>cannot</b> edit your files in this category';
$lang['PUB_Rules_delete_file_can'] = 'You <b>can</b> delete your files in this category';
$lang['PUB_Rules_delete_file_cannot'] = 'You <b>cannot</b> delete your files in this category';
$lang['PUB_Rules_rate_can'] = 'You <b>can</b> rate files in this category';
$lang['PUB_Rules_rate_cannot'] = 'You <b>cannot</b> rate files in this category';
$lang['PUB_Rules_moderate'] = 'You <b>can</b> %smoderate this category%s'; // %s replaced by a href links, do not remove!
$lang['PUB_Rules_moderate_can'] = 'You <b>can</b> moderate this category'; // %s replaced by a href links, do not remove!

//
// Toplist
//
$lang['Toplist'] = 'Toplist';
$lang['Select_list'] = 'Select the type of list to show';
$lang['Latest_downloads'] = 'The Newest Files';
$lang['Most_downloads'] = 'Most Popular Files';
$lang['Rated_downloads'] = 'Top Rated Files';
$lang['Total_new_files'] = 'Total New Downloads';
$lang['Show'] = 'Show';
$lang['One_week'] = 'One Week';
$lang['Two_week'] = 'Two Week';
$lang['30_days'] = '30 Days';
$lang['New_Files'] = 'Total new files for last %d days';
$lang['Last_week'] ='Last Week';
$lang['Last_30_days'] = 'Last 30 Days';
$lang['Show_top'] = 'Show Top';
$lang['Or_top'] = 'or Top';
$lang['Popular_num'] = 'Top %d out of %d files in the database';
$lang['Popular_per'] = 'Top %d %% of all %d files in the database';
$lang['General_Info'] = 'General Information';
$lang['Downloads_stats'] = 'User\'s Downloads Stats';
$lang['Rating_stats'] = 'User\'s Rating Stats';
$lang['Os'] = 'Operating System';
$lang['Browsers'] = 'Browsers';

//
// Toplists mx blocks
//
$lang['Recent_Public_Files'] = 'Latest dls';
$lang['Random_Public_Files'] = 'Random dls';
$lang['Toprated_Public_Files'] = 'Toprated dls';
$lang['Most_Public_Files'] = 'Most downloaded';

$lang['File_Title'] = 'Title';
$lang['File_Desc'] = 'Description';
$lang['Rating'] = 'Rating';
$lang['Dls'] = 'Downloaded';


//
// Menu
//
$lang['sd_Project'] = 'Project';
$lang['sd_Management'] = 'Management';
$lang['sd_Doc_view'] = 'View Document';
$lang['sd_Options'] = 'Options';
$lang['sd_Help'] = 'Help';
$lang['sd_Contents'] = 'Contents *';
$lang['sd_About'] = 'About *';

//
// Tree
//
$lang['sd_Tree_View'] = 'Tree View';
$lang['sd_Toc'] = 'Table of Contents';
$lang['sd_Where'] = 'Where';
$lang['sd_Before'] = 'Before';
$lang['sd_After'] = 'After';
$lang['sd_Type'] = 'Type';
$lang['sd_Name'] = 'Name';
$lang['sd_Document'] = 'Document';
$lang['sd_Folder'] = 'Folder';


//
// Index
//
$lang['sd_Doc_info'] = 'Document Info';
$lang['sd_Doc_preview'] = 'Preview Document';
$lang['sd_Edit_content'] = 'Edit content';
$lang['sd_Default_edit'] = 'open Edit Content by default';
$lang['sd_Loading'] = 'Loading data ..';
$lang['sd_Saving'] = 'Saving data ..';

//
// Quickdl
//
$lang['Quickdl_back'] = 'Back';

//
// Generic Type strings
// - Types are matched against these lang keys...where 'NAME' is the db defined type name
//
$lang['PUB_type_NAME'] = 'Example Type';
?>