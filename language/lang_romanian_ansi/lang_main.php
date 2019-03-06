<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: lang_main.php,v 1.4 2011/03/30 01:47:33 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, FlorinCB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

// Translated by Romanian phpBB online community
// Web: http://www.phpbb.ro
// Autor: Bogdan Toma
// Email: bogdan@phpbb.ro
// Date: January 07, 2004
// MOD Web Address: http://mohd.vraag-en-antwoord.nl/main

// Traducere efectuata de Romanian phpBB online community
// Web: http://www.phpbb.ro
// Autor: Bogdan Toma
// Email: bogdan@phpbb.ro
// Data: 07 ianuarie 2004
// Adresa Web MOD: http://mohd.vraag-en-antwoord.nl/main

//
// General
//
$lang['PUB_title'] = 'Baza de Articole';

$lang['Category'] = 'Categorie';
$lang['Sub_categories'] = 'Subcategorii';
$lang['Article'] = 'Articol';
$lang['Articles'] = 'Articole';
$lang['Article_description'] = 'Descriere';
$lang['Article_type'] = 'Tip';
$lang['Article_keywords'] = 'Cuvinte cheie';
$lang['Add_article'] = 'Adauga articol';
$lang['Click_cat_to_add'] = 'Apasa pe categorie pentru a adauga articol';
$lang['PUB_Home'] = 'Pagina de start - Baza de Articole';
$lang['No_articles'] = 'Nici un articol';
$lang['Article_title'] = 'Nume articol';
$lang['Article_text'] = 'Text articol';
$lang['Add_article'] = 'Trimite articol';
$lang['Read_article'] = 'Citeste articol';
$lang['Article_not_exsist'] = 'Articolul nu exista';
$lang['Category_not_exsist'] = 'Categoria nu exista';
$lang['Last_article'] = 'Ultimul Articol';
$lang['Quick_jump'] = 'Selecteaza Categoria';



$lang['Error_no_download'] = 'The selected File does not exist anymore';
$lang['Options'] = 'Options';
$lang['Click_return'] = 'Click %sHere%s to return to the previous page';
$lang['Click_here'] = 'Click Here';
$lang['never'] = 'None';
$lang['publisher_disable'] = 'Catalogul de Articole este dezactivat';
$lang['jump'] = 'Select a category';
$lang['viewall_disabled'] = 'This feature is disabled by the admin.';
$lang['New_file'] = 'New file';
$lang['No_new_file'] = 'No new file';
$lang['None'] = 'None';
$lang['No_file'] = 'No Files';
$lang['View_latest_file'] = 'View Latest File';
$lang['Edit'] = 'Modifica';
$lang['Click_cat_to_add'] = 'Click on Category to add Article';
$lang['Standalone_Not_Supported'] = 'This module does not support standalone usage. In the AdminCP, add the KB block to a portal page.';

$lang['Article_submitted_Approve'] = 'Articol transmis cu succes.<br />Un administrator va revizui articolul si va decide daca va fi lasat la dispozitia utilizatorilor.';
$lang['Article_submitted'] = 'Articol transmis cu succes.';
$lang['Click_return_kb'] = 'Apasa %saici%s pentru a reveni la ' . $lang['PUB_title'];
$lang['Click_return_article'] = 'Apasa %saici%s pentru a reveni la ' . $lang['Article'];

$lang['Article_Edited_Approve'] = 'Articolul a fost modificat cu succes.<br />Va fi necesar ca sa fie aprobat din nou înainte ca utilizatorii sa-l poata vedea.';
$lang['Article_Edited'] = 'Articolul a fost modificat cu succes.';
$lang['Edit_article'] = 'Modifica articol';


$lang['Article_Deleted'] = 'Articolul a fost sters cu succes.';

//
// Notification
//
$lang['PUB_prefix'] = '[ CA ]';
$lang['PUB_notify_subject_new'] = 'Articol Nou!';
$lang['PUB_notify_subject_edited'] = 'Articol Editat!';
$lang['PUB_notify_subject_approved'] = 'Articol Aprobat!';
$lang['PUB_notify_subject_unapproved'] = 'Articol Dez-Aprobat!';
$lang['PUB_notify_subject_deleted'] = 'Articol Sters!';

$lang['PUB_notify_new_body'] = 'Un nou articol a fost adaugat!';
$lang['PUB_notify_edited_body'] = 'Un articol a fost modificat!';
$lang['PUB_notify_approved_body'] = 'Un articol a fost aprobat!';
$lang['PUB_notify_unapproved_body'] = 'Un articol a fost dez-aprobat.';
$lang['PUB_notify_deleted_body'] = 'Un articol a fost sters.';
$lang['Edited_Article_info'] = 'Articol actualizat de ';

$lang['Read_full_article'] = '>> Citeste articolul întreg';

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

$lang['Options'] = 'Optiuni';

$lang['L_Options'] = 'Options:';
$lang['L_Formatting'] = 'Formatting:';

$lang['Default_article_id'] = 'Set default article, for the article viewer';

$lang['Click_here'] = 'Apasati aici';
$lang['never'] = 'Nu s-a efectuat înca';
$lang['publisher_disable'] = 'Baza de download-uri este dezactivata';
$lang['jump'] = 'Selectati o categorie';
$lang['viewall_disabled'] = 'Aceasta functionalitate este dezactivata de catre administrator.';
$lang['New_file'] = 'Fisier nou';
$lang['No_new_file'] = 'Nici un fisier nou';
$lang['None'] = 'Nu are';
$lang['No_file'] = 'Nici un fisier';
$lang['View_latest_file'] = 'Vizualizarea ultimului fisier';

$lang['Error_no_download'] = 'Fisierul selectat nu mai exista';

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
$lang['Click_return'] = 'Apasati %saici%s pentru a reveni la pagina anterioara';

//
// Main
//
$lang['Files'] = 'Fisiere';
$lang['Viewall'] = 'Toate fisierele';
$lang['Vainfo'] = 'Toate fisierele din baza de date';
$lang['Quick_nav'] = 'Navigare Rapida';
$lang['Quick_jump'] = 'Selectati o categorie';
$lang['Quick_go'] = 'Dute';
$lang['Sub_category'] = 'Subcategorie';
$lang['Last_file'] = 'Ultimul fisier';

//
// Sort
//
$lang['Sort'] = 'Sortare';
$lang['Name'] = 'Nume';
$lang['Update_time'] = 'Ultima actualizare';

//
// Category
//
$lang['No_files'] = 'Nu a fost gasit nici un fisier';
$lang['No_files_cat'] = 'Nu exista fisier în aceasta categorie.';
$lang['Cat_not_exist'] = 'Categoria pe care ati selectat-o nu exista.';
$lang['File_not_exist'] = 'Fisierul pe care l-ati selectat nu exista.';
$lang['License_not_exist'] = 'Licenta pe care ati selectat-o nu exista.';

//
// File
//
$lang['File'] = 'Fisier';
$lang['Desc'] = 'Descriere';
$lang['Creator'] = 'Creator';
$lang['Submited'] = 'Trimis de';
$lang['Version'] = 'Versiune';
$lang['Scrsht'] = 'Exemplu';
$lang['Docs'] = 'Site web';
$lang['Lastdl'] = 'Ultima descarcare';
$lang['Never'] = 'Niciodata';
$lang['Votes'] = ' Voturi';
$lang['Date'] = 'Data';
$lang['Update_time'] = 'Ultima actualizare';
$lang['DlRating'] = 'Votare';
$lang['Dls'] = 'Numar descarcari';
$lang['Downloadfile'] = 'Descarca fisier';
$lang['File_size'] = 'Dimensiune fisier';
$lang['Not_available'] = 'Nu este disponibil !';
$lang['Bytes'] = 'Bytes';
$lang['KB'] = 'Kilo Byte';
$lang['MB'] = 'Mega Byte';
$lang['Mirrors'] = 'Mirror-uri';
$lang['Mirrors_explain'] = 'Aici puteti adauga sau modifica mirror-urile pentru acest fisier; asigurati-va ca ati verificat toate informatiile deoarece fisierul va fi trimis catre baza de date';
$lang['Click_here_mirrors'] = 'Apasati aici pentru a adauga mirror-uri';
$lang['Mirror_location'] = 'Locatie mirror';
$lang['Add_new_mirror'] = 'Adauga un nou mirror';
$lang['Save_as'] = 'Salveaza Ca...';

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
$lang['MCP_title_explain'] = 'Here moderators can approve and manage items';

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

$lang['Sorry_auth_delete'] = 'Sorry, but you cannot delete items in this category.';
$lang['Sorry_auth_mcp'] = 'Sorry, but you cannot moderate this category.';
$lang['Sorry_auth_approve'] = 'Sorry, but you cannot approve items in this category.';
$lang['Sorry_auth_post'] = 'Sorry, but you cannot post articles in this category.';
$lang['Sorry_auth_edit'] = 'Sorry, but you cannot edit articles in this category.';

$lang['Edit_article'] = 'Edit';
$lang['Delete_article'] = 'Delete';

//
// License
//
$lang['License'] = 'Licenta';
$lang['Licensewarn'] = 'Trebuie sa fiti de acord cu conditiile licentei pentru a descarca fisierul';
$lang['Iagree'] = 'Sunt de acord';
$lang['Dontagree'] = 'Nu sunt de acord';

//
// Added for v. 2.0
//
$lang['Addtional_field'] = 'More information (optional)';
$lang['No_cat_comments_forum_id'] = 'Comments are enabled but you have not specified the target phpBB forum category in the KB adminCP - Categories';

//
// User Upload
//
$lang['User_upload'] = 'Incarca';
//
// License
//
$lang['License'] = 'License Agreement';
$lang['Licensewarn'] = 'You must agree to this license agreement to download';
$lang['Iagree'] = 'I Agree';
$lang['Dontagree'] = 'I Dont Agree';

//
// Quick Nav
//
$lang['Quick_nav'] = 'Quick Navigation';
$lang['Quick_jump'] = 'Select Category';
$lang['Quick_go'] = 'Go';




//
// Search
//
$lang['Search'] = 'Cautare';
$lang['Search_for'] = 'Cauta pentru';
$lang['Results'] = 'Rezultate pentru';
$lang['No_matches'] = 'Nu au fost gasite rezultate pentru';
$lang['Matches'] = 'rezultate au fost gasite pentru';
$lang['All'] = 'Toate categoriile';
$lang['Choose_cat'] = 'Alegeti categoria:';
$lang['Include_comments'] = 'Cauta si în comentarii';
$lang['Submiter'] = 'Trimis de';


//
// Comments
//
$lang['Comments'] = 'Comentarii';
$lang['Comments_title'] = 'Titlul comentariului';
$lang['Comment_subject'] = 'Subiectul comentariului';
$lang['Comment'] = 'Comentariu';
$lang['Comment_explain'] = 'Folositi casuta de text de mai jos pentru a va face cunoscuta opinia vis a vis de acest fisier!';
$lang['Comment_add'] = 'Adauga comentariu';
$lang['Comment_edit'] = 'Editeaza';
$lang['Comment_delete'] = 'Sterge';
$lang['Comment_posted'] = 'Comentariul dumneavoastra  a fost introdus cu succes';
$lang['Comment_deleted'] = 'Comentariul pe care l-ati selectat a fost sters cu succes';
$lang['Comment_desc'] = 'Titlu';
$lang['No_comments'] = 'Nici un comentariu nu a fost scris.';
$lang['Links_are_ON'] = 'Link-urile sunt <u>Activate</u>';
$lang['Links_are_OFF'] = 'Link-urile sunt <u>Dezactivate</u>';
$lang['Images_are_ON'] = 'Imaginile sunt <u>Activate</u>';
$lang['Images_are_OFF'] = 'Imaginile sunt <u>Dezactivate</u>';
$lang['Check_message_length'] = 'Verifica lungimea mesajului';
$lang['Msg_length_1'] = 'Mesajul dumneavoastra are o lungime de ';
$lang['Msg_length_2'] = ' caractere.';
$lang['Msg_length_3'] = 'Limita mesajului este de ';
$lang['Msg_length_4'] = ' caractere.';;
$lang['Msg_length_5'] = 'Mai puteti scrie ';
$lang['Msg_length_6'] = ' caractere.';


//
// Statistics
//
$lang['Statistics'] = 'Statistici';
$lang['Stats_text'] = "Sunt {total_files} fisiere în {total_categories} categorii<br>";
$lang['Stats_text'] .= "S-au efectuat în total {total_downloads} descarcari<br><br>";
$lang['Stats_text'] .= "Cel mai nou fisier este <a href={u_newest_file}>{newest_file}</a><br>";
$lang['Stats_text'] .= "Cel mai vechi fisier este <a href={u_oldest_file}>{oldest_file}</a><br><br>";
$lang['Stats_text'] .= "Evaluarea medie este {average}/10<br>";
$lang['Stats_text'] .= "Cel mai popular fisier bazat pe aprecierile facute este <a href={u_popular}>{popular}</a> cu o evaluare de {most}/10<br>";
$lang['Stats_text'] .= "Cel mai putin popular fisier bazat pe aprecierile facute este <a href={u_lpopular}>{lpopular}</a> cu o evaluare de {least}/10<br><br>";
$lang['Stats_text'] .= "Numarul mediu a descarcarilor pe fiecare fisier este {avg_dls}<br>";
$lang['Stats_text'] .= "Cel mai popular fisier bazat pe numarul de descarcari este <a href={u_most_dl}>{most_dl}</a> cu {most_no} descarcari<br>";
$lang['Stats_text'] .= "Cel mai putin popular fisier bazat pe numarul de descarcari este <a href={u_least_dl}>{least_dl}</a> cu {least_no} descarcari<br>";
$lang['Select_chart_type'] = 'Selectati tipul de grafic';
$lang['Bars'] = 'Bare';
$lang['Lines'] = 'Linii';
$lang['Area'] = 'Arie';
$lang['Linepoints'] = 'Linii cu puncte';
$lang['Points'] = 'Puncte';
$lang['Chart_header'] = 'Fisiere statistice - Fisiere adaugate în fiecare luna la baza de date';
$lang['Chart_legend'] = 'Fisiere';
$lang['X_label'] = 'Luni';
$lang['Y_label'] = 'Numar de fisiere';

//
// Rate
//
$lang['Votes_label'] = 'Rating';
$lang['Votes'] = 'Votes';
$lang['No_votes'] = 'No votes';
$lang['Rate'] = 'Evaluare';
$lang['ADD_RATING'] = '[Rate Article]';
$lang['Do_rate'] = '[Rate File]';
$lang['Rerror'] = 'Ati evaluat deja acest fisier.';
$lang['Rateinfo'] = 'Doriti sa evaluati fisierul <i>{filename}</i>.<br>Selectati o nota de mai jos. 1 este cel mai slab, 10 este cel mai bun.';
$lang['Rconf'] = 'Ati ales sa dati fisierului <i>{filename}</i> nota {rate}.<br>Astfel nota generala a acestui fisier a devenit {newrating}.';
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
$lang['Not_rated'] = 'Fara nota';

//
// Email
//
$lang['Emailfile'] = 'Trimite un email cu acest fisier la un prieten';
$lang['Emailinfo'] = 'Daca doriti ca un prieten sa stie mai multe despre acest fisier, trebuie sa completati si sa trimiteti un e-mail ce contine toate informatiile despre fisier!<br>Câmpurile marcate cu caracterul * sunt obligatorii';
$lang['Yname'] = 'Numele dumneavoastra';
$lang['Yemail'] = 'Adresa de E-mail';
$lang['Fname'] = 'Numele prietenului';
$lang['Femail'] = 'Adresa de E-mail a prietenului';
$lang['Esub'] = 'Subiectul mesajului';
$lang['Etext'] = 'Textul mesajului';
$lang['Defaultmail'] = 'Cred ca ar putea sa te intereseze descarcarea fisierului localizat la adresa';
$lang['Semail'] = 'Trimite E-mail';
$lang['Econf'] = 'Mesajul a fost trimis cu succes.';

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
$lang['Directly_linked'] = 'Nu puteti descarca acest fisier direct de pe alt site!';

//
//Permission
//
$lang['Sorry_auth_view'] = 'Doar %s poate sa vada fisierele si subcategoriile din aceasta categorie.';
$lang['Sorry_auth_file_view'] = 'Doar %s poate sa vada fisierele din aceasta categorie.';
$lang['Sorry_auth_upload'] = 'Doar %s poate sa publice fisiere în aceasta categorie.';
$lang['Sorry_auth_download'] = 'Doar %s poate descarca fisiere în aceasta categorie.';
$lang['Sorry_auth_rate'] = 'Doar %s poate evalua fisiere în aceasta categorie.';
$lang['Sorry_auth_view_comments'] = 'Doar %s poate sa vada comentariile din aceasta categorie.';
$lang['Sorry_auth_post_comments'] = 'Doar %s poate sa scrie comentarii în aceasta categorie.';
$lang['Sorry_auth_edit_comments'] = 'Doar %s poate sa modifice comentariile din aceasta categorie.';
$lang['Sorry_auth_delete_comments'] = 'Doar %s poate sa stearga comentariile din aceasta categorie.';
$lang['Sorry_auth_edit'] = 'Sorry, but you cannot edit files in this category.';
$lang['Sorry_auth_viewall'] = 'Sorry, but you cannot view viewall in this category.';

//
// New
//
$lang['Deletefile'] = 'Sterge Fisier';
$lang['Editfile'] = 'Editeaza fisier';
$lang['pub_MCP'] = '[ModeratorCP]';
$lang['Click_return_not_validated'] = 'Click %sAici%s pentru a reveni la pagina anterioara';
$lang['Fileadded_not_validated'] = 'Fisierul nou a fost adaugat cu success, dar un moderator sau admin trebuie sa evelueze fisierul înainte de a fi aprobat.';

$lang['Quickdl_back'] = '&laquo; Inapoi';

$lang['Quickdl'] = 'Categorie Pa implicita';
$lang['Quickdl_explain'] = 'This is the default publisher category to display, if no mapping is activated';

$lang['Pa_updated_return_settings'] = "Pa quickdl configuration updated successfully.<br /><br />Click %shere%s to return to main page."; // %s's for URI params - DO NOT REMOVE
$lang['Pa_update_error'] = "Couldn't update Pa quickdl configuration.<br /><br />This mod is designed for MySQL so please contact the author if you have troubles. If you can offer a translation of the SQL into other database formats, please send them to:<br />";

$lang['Pa_settings'] = "Pa mapping settings";
$lang['Pa_settings_short_explain'] = "Settings for mapping pa cats and dynamic blocks.";
$lang['Pa_settings_explain'] = "Here you can edit the configuration for the pa module. This panel lets you associate pa cats and dynamic blocks for the quickdl block.";

//
// Notification
//
$lang['PUB_title'] = 'Catalog Articole';
$lang['PUB_prefix'] = '[ Fisier ]';

$lang['PUB_goto_file'] = '<br />Vezi Fisier';

$lang['PUB_notify_subject_new'] = '<br />Fisier nou!';
$lang['PUB_notify_subject_edited'] = '<br />Fisier Editat!';
$lang['PUB_notify_subject_approved'] = '<br />Fisier Apobat!';
$lang['PUB_notify_subject_unapproved'] = '<br />Fisier Ne-Aprobat!';
$lang['PUB_notify_subject_deleted'] = '<br />Fisier Sters!';
$lang['PUB_notify_subject_unapproved'] = '<br />Fisier Ne-Aprobat!';
$lang['PUB_notify_body'] = '<br />Un fisier a fost uploadat sau actualizat:';
$lang['PUB_no_ratings'] = '<br />Dezactivat în aceata categorie';

$lang['PUB_notify_new_body'] = '<br />Un fisier nou a fost urcat în Download Manager.';
$lang['PUB_notify_edited_body'] = '<br />Un fisier a fost editat în Download Manager.';
$lang['PUB_notify_approved_body'] = '<br />Un fisier a fost aprobat în Download Manager.';
$lang['PUB_notify_unapproved_body'] = '<br />Un fisier a fost dez-aprobat în Download Manager.';
$lang['PUB_notify_deleted_body'] = '<br />Un fisier a fost sters din Download Manager.';
$lang['Edited_Article_info'] = '<br />Fisierul a fost actualizat de ';

$lang['PUB_goto'] = '>>Vezi fisier';

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
$lang['Toplist'] = 'Topuri';
$lang['Select_list'] = 'Selectati tipul listei de consultat';
$lang['Latest_downloads'] = 'Cele mai noi fisiere';
$lang['Most_downloads'] = 'Cele mai populare fisiere';
$lang['Rated_downloads'] = 'Cele mai votate fisiere';
$lang['Total_new_files'] = 'Total download-uri noi';
$lang['Show'] = 'Arata';
$lang['One_week'] = 'O saptamâna';
$lang['Two_week'] = 'Doua saptamâni';
$lang['30_days'] = '30 zile';
$lang['New_Files'] = 'Total fisiere noi în ultimele %d zile';
$lang['Last_week'] ='Ultima saptamâna';
$lang['Last_30_days'] = 'Ultimele 30 de zile';
$lang['Show_top'] = 'Arata top';
$lang['Or_top'] = 'sau Top';
$lang['Popular_num'] = 'Top %d din %d fisiere din baza de date';
$lang['Popular_per'] = 'Top %d %% din toate cele %d fisiere din baza de date';
$lang['General_Info'] = 'Informatii generale';
$lang['Downloads_stats'] = 'Statisticile de download ale utilizatorului';
$lang['Rating_stats'] = 'Statisticile de votare ale utilizatorului';
$lang['Os'] = 'Sisteme de operare';
$lang['Browsers'] = 'Browsere';

//
// Toplists mx blocks
//
$lang['Recent_Public_Files'] = 'Ultimile dl-uri';
$lang['Random_Public_Files'] = 'Random dl-uri';
$lang['Toprated_Public_Files'] = 'Topvotate dl-uri';
$lang['Most_Public_Files'] = 'Cele mai downloadate';

$lang['File_Title'] = 'Titlu';
$lang['File_Desc'] = 'Descriptie';
$lang['Rating'] = 'Votare';
$lang['Dls'] = 'Downloadate';


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
$lang['KB_type_NAME'] = 'Example Type';
?>