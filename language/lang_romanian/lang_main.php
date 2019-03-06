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
$lang['PUB_title'] = 'Bază de Articole';

$lang['Category'] = 'Categorie';
$lang['Sub_categories'] = 'Subcategorii';
$lang['Article'] = 'Articol';
$lang['Articles'] = 'Articole';
$lang['Article_description'] = 'Descriere';
$lang['Article_type'] = 'Tip';
$lang['Article_keywords'] = 'Cuvinte cheie';
$lang['Add_article'] = 'Adaugă articol';
$lang['Click_cat_to_add'] = 'Apasă pe categorie pentru a adăuga articol';
$lang['PUB_Home'] = 'Pagina de start - Bază de Articole';
$lang['No_articles'] = 'Nici un articol';
$lang['Article_title'] = 'Nume articol';
$lang['Article_text'] = 'Text articol';
$lang['Add_article'] = 'Trimite articol';
$lang['Read_article'] = 'Citeşte articol';
$lang['Article_not_exsist'] = 'Articolul nu există';
$lang['Category_not_exsist'] = 'Categoria nu există';
$lang['Last_article'] = 'Ultimul Articol';
$lang['Quick_jump'] = 'Selectează Categoria';



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
$lang['Edit'] = 'Modifică';
$lang['Click_cat_to_add'] = 'Click on Category to add Article';
$lang['Standalone_Not_Supported'] = 'This module does not support standalone usage. In the AdminCP, add the KB block to a portal page.';

$lang['Article_submitted_Approve'] = 'Articol transmis cu succes.<br />Un administrator va revizui articolul şi va decide dacă va fi lăsat la dispoziţia utilizatorilor.';
$lang['Article_submitted'] = 'Articol transmis cu succes.';
$lang['Click_return_pub'] = 'Apasă %saici%s pentru a reveni la ' . $lang['PUB_title'];
$lang['Click_return_article'] = 'Apasă %saici%s pentru a reveni la ' . $lang['Article'];

$lang['Article_Edited_Approve'] = 'Articolul a fost modificat cu succes.<br />Va fi necesar ca să fie aprobat din nou înainte ca utilizatorii să-l poată vedea.';
$lang['Article_Edited'] = 'Articolul a fost modificat cu succes.';
$lang['Edit_article'] = 'Modifică articol';


$lang['Article_Deleted'] = 'Articolul a fost şters cu succes.';

//
// Notification
//
$lang['PUB_prefix'] = '[ PUB ]';
$lang['PUB_notify_subject_new'] = 'Articol Nou!';
$lang['PUB_notify_subject_edited'] = 'Articol Editat!';
$lang['PUB_notify_subject_approved'] = 'Articol Aprobat!';
$lang['PUB_notify_subject_unapproved'] = 'Articol Dez-Aprobat!';
$lang['PUB_notify_subject_deleted'] = 'Articol Şters!';

$lang['PUB_notify_new_body'] = 'Un nou articol a fost adăugat!';
$lang['PUB_notify_edited_body'] = 'Un articol a fost modificat!';
$lang['PUB_notify_approved_body'] = 'Un articol a fost aprobat!';
$lang['PUB_notify_unapproved_body'] = 'Un articol a fost dez-aprobat.';
$lang['PUB_notify_deleted_body'] = 'Un articol a fost şters.';
$lang['Edited_Article_info'] = 'Articol actualizat de ';

$lang['Read_full_article'] = '>> Citeşte articolul întreg';

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

$lang['Options'] = 'Opţiuni';

$lang['L_Options'] = 'Options:';
$lang['L_Formatting'] = 'Formatting:';

$lang['Default_article_id'] = 'Set default article, for the article viewer';

$lang['Click_here'] = 'Apăsaţi aici';
$lang['never'] = 'Nu s-a efectuat încă';
$lang['publisher_disable'] = 'Baza de download-uri este dezactivată';
$lang['jump'] = 'Selectaţi o categorie';
$lang['viewall_disabled'] = 'Această funcţionalitate este dezactivată de către administrator.';
$lang['New_file'] = 'Fişier nou';
$lang['No_new_file'] = 'Nici un fişier nou';
$lang['None'] = 'Nu are';
$lang['No_file'] = 'Nici un fişier';
$lang['View_latest_file'] = 'Vizualizarea ultimului fişier';

$lang['Error_no_download'] = 'Fişierul selectat nu mai există';

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
$lang['Click_return'] = 'Apasaţi %saici%s pentru a reveni la pagina anterioară';

//
// Main
//
$lang['Files'] = 'Fişiere';
$lang['Viewall'] = 'Toate fişierele';
$lang['Vainfo'] = 'Toate fişierele din baza de date';
$lang['Quick_nav'] = 'Navigare Rapidă';
$lang['Quick_jump'] = 'Selectaţi o categorie';
$lang['Quick_go'] = 'Dute';
$lang['Sub_category'] = 'Subcategorie';
$lang['Last_file'] = 'Ultimul fişier';

//
// Sort
//
$lang['Sort'] = 'Sortare';
$lang['Name'] = 'Nume';
$lang['Update_time'] = 'Ultima actualizare';

//
// Category
//
$lang['No_files'] = 'Nu a fost gasit nici un fişier';
$lang['No_files_cat'] = 'Nu există fişier în această categorie.';
$lang['Cat_not_exist'] = 'Categoria pe care aţi selectat-o nu există.';
$lang['File_not_exist'] = 'Fişierul pe care l-aţi selectat nu există.';
$lang['License_not_exist'] = 'Licenţa pe care aţi selectat-o nu există.';

//
// File
//
$lang['File'] = 'Fişier';
$lang['Desc'] = 'Descriere';
$lang['Creator'] = 'Creator';
$lang['Submited'] = 'Trimis de';
$lang['Version'] = 'Versiune';
$lang['Scrsht'] = 'Exemplu';
$lang['Docs'] = 'Site web';
$lang['Lastdl'] = 'Ultima descărcare';
$lang['Never'] = 'Niciodată';
$lang['Votes'] = ' Voturi';
$lang['Date'] = 'Data';
$lang['Update_time'] = 'Ultima actualizare';
$lang['DlRating'] = 'Votare';
$lang['Dls'] = 'Număr descărcări';
$lang['Downloadfile'] = 'Descarcă fişier';
$lang['File_size'] = 'Dimensiune fişier';
$lang['Not_available'] = 'Nu este disponibil !';
$lang['Bytes'] = 'Bytes';
$lang['KB'] = 'Kilo Byte';
$lang['MB'] = 'Mega Byte';
$lang['Mirrors'] = 'Mirror-uri';
$lang['Mirrors_explain'] = 'Aici puteţi adăuga sau modifica mirror-urile pentru acest fişier; asiguraţi-vă ca aţi verificat toate informaţiile deoarece fişierul va fi trimis către baza de date';
$lang['Click_here_mirrors'] = 'Apăsaţi aici pentru a adăuga mirror-uri';
$lang['Mirror_location'] = 'Locaţie mirror';
$lang['Add_new_mirror'] = 'Adaugă un nou mirror';
$lang['Save_as'] = 'Salvează Ca...';

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
// User Upload
//
$lang['User_upload'] = 'Încarcă';


//
// License
//
$lang['License'] = 'Licenţă';
$lang['Licensewarn'] = 'Trebuie să fiţi de acord cu condiţiile licenţei pentru a descărca fisierul';
$lang['Iagree'] = 'Sunt de acord';
$lang['Dontagree'] = 'Nu sunt de acord';

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
$lang['Search'] = 'Căutare';
$lang['Search_for'] = 'Caută pentru';
$lang['Results'] = 'Rezultate pentru';
$lang['No_matches'] = 'Nu au fost găsite rezultate pentru';
$lang['Matches'] = 'rezultate au fost găsite pentru';
$lang['All'] = 'Toate categoriile';
$lang['Choose_cat'] = 'Alegeţi categoria:';
$lang['Include_comments'] = 'Caută şi în comentarii';
$lang['Submiter'] = 'Trimis de';


//
// Comments
//
$lang['Comments'] = 'Comentarii';
$lang['Comments_title'] = 'Titlul comentariului';
$lang['Comment_subject'] = 'Subiectul comentariului';
$lang['Comment'] = 'Comentariu';
$lang['Comment_explain'] = 'Folosiţi căsuţa de text de mai jos pentru a vă face cunoscută opinia vis a vis de acest fişier!';
$lang['Comment_add'] = 'Adaugă comentariu';
$lang['Comment_edit'] = 'Editează';
$lang['Comment_delete'] = 'Şterge';
$lang['Comment_posted'] = 'Comentariul dumneavoastră  a fost introdus cu succes';
$lang['Comment_deleted'] = 'Comentariul pe care l-aţi selectat a fost şters cu succes';
$lang['Comment_desc'] = 'Titlu';
$lang['No_comments'] = 'Nici un comentariu nu a fost scris.';
$lang['Links_are_ON'] = 'Link-urile sunt <u>Activate</u>';
$lang['Links_are_OFF'] = 'Link-urile sunt <u>Dezactivate</u>';
$lang['Images_are_ON'] = 'Imaginile sunt <u>Activate</u>';
$lang['Images_are_OFF'] = 'Imaginile sunt <u>Dezactivate</u>';
$lang['Check_message_length'] = 'Verifică lungimea mesajului';
$lang['Msg_length_1'] = 'Mesajul dumneavoastră are o lungime de ';
$lang['Msg_length_2'] = ' caractere.';
$lang['Msg_length_3'] = 'Limita mesajului este de ';
$lang['Msg_length_4'] = ' caractere.';;
$lang['Msg_length_5'] = 'Mai puteţi scrie ';
$lang['Msg_length_6'] = ' caractere.';


//
// Statistics
//
$lang['Statistics'] = 'Statistici';
$lang['Stats_text'] = "Sunt {total_files} fişiere în {total_categories} categorii<br>";
$lang['Stats_text'] .= "S-au efectuat în total {total_downloads} descărcări<br><br>";
$lang['Stats_text'] .= "Cel mai nou fişier este <a href={u_newest_file}>{newest_file}</a><br>";
$lang['Stats_text'] .= "Cel mai vechi fişier este <a href={u_oldest_file}>{oldest_file}</a><br><br>";
$lang['Stats_text'] .= "Evaluarea medie este {average}/10<br>";
$lang['Stats_text'] .= "Cel mai popular fişier bazat pe aprecierile făcute este <a href={u_popular}>{popular}</a> cu o evaluare de {most}/10<br>";
$lang['Stats_text'] .= "Cel mai puţin popular fişier bazat pe aprecierile făcute este <a href={u_lpopular}>{lpopular}</a> cu o evaluare de {least}/10<br><br>";
$lang['Stats_text'] .= "Numărul mediu a descărcărilor pe fiecare fişier este {avg_dls}<br>";
$lang['Stats_text'] .= "Cel mai popular fişier bazat pe numărul de descărcări este <a href={u_most_dl}>{most_dl}</a> cu {most_no} descărcări<br>";
$lang['Stats_text'] .= "Cel mai puţin popular fişier bazat pe numărul de descărcări este <a href={u_least_dl}>{least_dl}</a> cu {least_no} descărcări<br>";
$lang['Select_chart_type'] = 'Selectaţi tipul de grafic';
$lang['Bars'] = 'Bare';
$lang['Lines'] = 'Linii';
$lang['Area'] = 'Arie';
$lang['Linepoints'] = 'Linii cu puncte';
$lang['Points'] = 'Puncte';
$lang['Chart_header'] = 'Fişiere statistice - Fişiere adăugate în fiecare lună la baza de date';
$lang['Chart_legend'] = 'Fişiere';
$lang['X_label'] = 'Luni';
$lang['Y_label'] = 'Număr de fişiere';

//
// Rate
//
$lang['Votes_label'] = 'Rating';
$lang['Votes'] = 'Votes';
$lang['No_votes'] = 'No votes';
$lang['Rate'] = 'Evaluare';
$lang['ADD_RATING'] = '[Rate Article]';
$lang['Do_rate'] = '[Rate File]';
$lang['Rerror'] = 'Aţi evaluat deja acest fişier.';
$lang['Rateinfo'] = 'Doriţi să evaluaţi fişierul <i>{filename}</i>.<br>Selectaţi o notă de mai jos. 1 este cel mai slab, 10 este cel mai bun.';
$lang['Rconf'] = 'Aţi ales să daţi fişierului <i>{filename}</i> nota {rate}.<br>Astfel nota generală a acestui fişier a devenit {newrating}.';
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
$lang['Not_rated'] = 'Fără notă';

//
// Email
//
$lang['Emailfile'] = 'Trimite un email cu acest fişier la un prieten';
$lang['Emailinfo'] = 'Dacă doriţi ca un prieten să ştie mai multe despre acest fişier, trebuie să completaţi şi să trimiteţi un e-mail ce conţine toate informaţiile despre fişier!<br>Câmpurile marcate cu caracterul * sunt obligatorii';
$lang['Yname'] = 'Numele dumneavoastră';
$lang['Yemail'] = 'Adresa de E-mail';
$lang['Fname'] = 'Numele prietenului';
$lang['Femail'] = 'Adresa de E-mail a prietenului';
$lang['Esub'] = 'Subiectul mesajului';
$lang['Etext'] = 'Textul mesajului';
$lang['Defaultmail'] = 'Cred că ar putea să te intereseze descărcarea fişierului localizat la adresa';
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
$lang['Directly_linked'] = 'Nu puteţi descărca acest fişier direct de pe alt site!';

//
//Permission
//
$lang['Sorry_auth_view'] = 'Doar %s poate să vadă fişierele şi subcategoriile din această categorie.';
$lang['Sorry_auth_file_view'] = 'Doar %s poate să vadă fişierele din această categorie.';
$lang['Sorry_auth_upload'] = 'Doar %s poate să publice fişiere în această categorie.';
$lang['Sorry_auth_download'] = 'Doar %s poate descărca fişiere în această categorie.';
$lang['Sorry_auth_rate'] = 'Doar %s poate evalua fişiere în această categorie.';
$lang['Sorry_auth_view_comments'] = 'Doar %s poate sa vadă comentariile din această categorie.';
$lang['Sorry_auth_post_comments'] = 'Doar %s poate să scrie comentarii în această categorie.';
$lang['Sorry_auth_edit_comments'] = 'Doar %s poate să modifice comentariile din această categorie.';
$lang['Sorry_auth_delete_comments'] = 'Doar %s poate să şteargă comentariile din această categorie.';
$lang['Sorry_auth_edit'] = 'Sorry, but you cannot edit files in this category.';
$lang['Sorry_auth_viewall'] = 'Sorry, but you cannot view viewall in this category.';

//
// New
//
$lang['Deletefile'] = 'Şterge Fişier';
$lang['Editfile'] = 'Editează fişier';
$lang['pub_MCP'] = '[ModeratorCP]';
$lang['Click_return_not_validated'] = 'Click %sAici%s pentru a reveni la pagina anterioară';
$lang['Fileadded_not_validated'] = 'Fişierul nou a fost adăugat cu success, dar un moderator sau admin trebuie să evelueze fişierul înainte de a fi aprobat.';

$lang['Quickdl_back'] = '&laquo; Înapoi';

$lang['Quickdl'] = 'Categorie Pa implicită';
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
$lang['PUB_prefix'] = '[ Fişier ]';

$lang['PUB_goto_file'] = '<br />Vezi Fişier';

$lang['PUB_notify_subject_new'] = '<br />Fişier nou!';
$lang['PUB_notify_subject_edited'] = '<br />Fişier Editat!';
$lang['PUB_notify_subject_approved'] = '<br />Fişier Apobat!';
$lang['PUB_notify_subject_unapproved'] = '<br />Fişier Ne-Aprobat!';
$lang['PUB_notify_subject_deleted'] = '<br />Fişier Şters!';
$lang['PUB_notify_subject_unapproved'] = '<br />Fişier Ne-Aprobat!';
$lang['PUB_notify_body'] = '<br />Un fişier a fost uploadat sau actualizat:';
$lang['PUB_no_ratings'] = '<br />Dezactivat în aceată categorie';

$lang['PUB_notify_new_body'] = '<br />Un fişier nou a fost urcat în Download Manager.';
$lang['PUB_notify_edited_body'] = '<br />Un fişier a fost editat în Download Manager.';
$lang['PUB_notify_approved_body'] = '<br />Un fişier a fost aprobat în Download Manager.';
$lang['PUB_notify_unapproved_body'] = '<br />Un fişier a fost dez-aprobat în Download Manager.';
$lang['PUB_notify_deleted_body'] = '<br />Un fişier a fost şters din Download Manager.';
$lang['Edited_Article_info'] = '<br />Fişierul a fost actualizat de ';

$lang['PUB_goto'] = '>>Vezi fişier';

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
$lang['Select_list'] = 'Selectaţi tipul listei de consultat';
$lang['Latest_downloads'] = 'Cele mai noi fişiere';
$lang['Most_downloads'] = 'Cele mai populare fişiere';
$lang['Rated_downloads'] = 'Cele mai votate fişiere';
$lang['Total_new_files'] = 'Total download-uri noi';
$lang['Show'] = 'Arată';
$lang['One_week'] = 'O săptămână';
$lang['Two_week'] = 'Două săptămâni';
$lang['30_days'] = '30 zile';
$lang['New_Files'] = 'Total fişiere noi în ultimele %d zile';
$lang['Last_week'] ='Ultima săptămână';
$lang['Last_30_days'] = 'Ultimele 30 de zile';
$lang['Show_top'] = 'Arată top';
$lang['Or_top'] = 'sau Top';
$lang['Popular_num'] = 'Top %d din %d fişiere din baza de date';
$lang['Popular_per'] = 'Top %d %% din toate cele %d fişiere din baza de date';
$lang['General_Info'] = 'Informaţii generale';
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
$lang['File_Desc'] = 'Descripţie';
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
$lang['PUB_type_NAME'] = 'Example Type';
?>