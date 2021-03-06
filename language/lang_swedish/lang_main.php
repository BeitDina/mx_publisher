<?php
/**
*
* @package MX-Publisher Module - mx_publisher
* @version $Id: lang_main.php,v 1.3 2008/06/03 20:16:03 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, FlorinCB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// General
//
$lang['PUB_title'] = 'Article Base';

$lang['Category'] = 'Kategori';
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

$lang['Error_no_download'] = 'Den valda filen finns inte';
$lang['Options'] = 'Alternativ';
$lang['Click_return'] = 'Klicka %sh�r%s f�r att �terg� till f�reg�ende sida';
$lang['Click_here'] = 'Klicka h�r';
$lang['never'] = 'Aldrig';
$lang['publisher_disable'] = 'Fildatabasen �r inaktiverad';
$lang['jump'] = 'V�lj en kategori';
$lang['viewall_disabled'] = 'Denna funktion �r inaktiverad av admin.';
$lang['New_file'] = 'Ny fil';
$lang['No_new_file'] = 'Ingen ny fil';
$lang['None'] = 'Ingen';
$lang['No_file'] = 'Inga filer';
$lang['View_latest_file'] = 'Visa senaste fil';

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
$lang['Click_return'] = 'Klicka %sh�r%s f�r att �terg� till f�reg�ende sida.';

//
// Main
//
$lang['Files'] = 'Filer';
$lang['Viewall'] = 'Visa alla filer';
$lang['Vainfo'] = 'Visa alla filer i databasen';
$lang['Quick_nav'] = 'Snabbnavigering';
$lang['Quick_jump'] = 'V�lj kategori';
$lang['Quick_go'] = 'G�';
$lang['Sub_category'] = 'Subkategori';
$lang['Last_file'] = 'Senaste fil';

//
// Sort
//
$lang['Sort'] = 'Sortera';
$lang['Name'] = 'Namn';
$lang['Update_time'] = 'Senast uppdaterad';

//
// Category
//
$lang['No_files'] = 'Inga filer hittades';
$lang['No_files_cat'] = 'Det finns inga filer i denna kategori.';
$lang['Cat_not_exist'] = 'Kategorin du valde finns inte.';
$lang['File_not_exist'] = 'Filen du valde finns inte.';
$lang['License_not_exist'] = 'Licensen du valde finns inte.';

//
// File
//
$lang['File'] = 'Fil';
$lang['Desc'] = 'Beskrivning';
$lang['Creator'] = 'Skapare';
$lang['Submited'] = 'Submited by';
$lang['Version'] = 'Version';
$lang['Scrsht'] = 'Screenshot';
$lang['Docs'] = 'Dokumentation/Manual';
$lang['Lastdl'] = 'Senaste nedladdning';
$lang['Never'] = 'Aldrig';
$lang['Votes'] = ' r�ster';
$lang['Date'] = 'Datum';
$lang['Update_time'] = 'Senast uppdaterad';
$lang['DlRating'] = 'Betyg';
$lang['Dls'] = ' Nerladdningar';
$lang['Downloadfile'] = 'Ladda hem fil';
$lang['File_size'] = 'Filstorlek';
$lang['Not_available'] = 'Inte tillg�nglig!';
$lang['Bytes'] = 'Bytes';
$lang['KB'] = 'Kilo Byte';
$lang['MB'] = 'Mega Byte';
$lang['Mirrors'] = 'Mirrorsajt';
$lang['Mirrors_explain'] = 'H�r kan du skapa och �ndra mirrorsajter. Kontrollera all information f�r filen laddas upp till databasen';
$lang['Click_here_mirrors'] = 'Klicka h�r f�r att l�gga till en mirrorsajt';
$lang['Mirror_location'] = 'Mirrorsajtens plats';
$lang['Add_new_mirror'] = 'L�gg till mirrorsajt';
$lang['Save_as'] = 'Spara som...';

//
// Admin Panels - File
//
$lang['File_manage_title'] = 'Filhantering';

$lang['Afile'] = 'Fil: L�gg till';
$lang['Efile'] = 'Fil: �ndra';
$lang['Dfile'] = 'Fil: Ta bort';
$lang['Afiletitle'] = 'L�gg till fil';
$lang['Efiletitle'] = '�ndra fil';
$lang['Dfiletitle'] = 'Ta bort fil';
$lang['Fileexplain'] = 'Anv�nd filhanteringen f�r att l�gga till, �ndra och ta bort filer.';
$lang['Upload'] = 'Ladda upp fil';
$lang['Uploadinfo'] = 'Ladda upp denna fil';
$lang['Uploaderror'] = 'Filen finns redan. Anv�nd annat namn.';
$lang['Uploaddone'] = 'Filen laddades upp. Filens URL �r ';
$lang['Uploaddone2'] = 'Klicka h�r f�r att placera URLn i nerladdningsf�ltet.';
$lang['Upload_do_done'] = 'Laddades upp...';
$lang['Upload_do_not'] = 'Laddades INTE upp';
$lang['Upload_do_exist'] = 'Filen finns';
$lang['Filename'] = 'Filnamn';
$lang['Filenameinfo'] = 'Detta �r filnamnet, t ex \'My Picture.\'';
$lang['Filesd'] = 'Kort beskrivning';
$lang['Filesdinfo'] = 'Detta �r en kort filbeskrivning, som visas p� kategorisidan. T�nk p� att skriva kort och informativt.';
$lang['Fileld'] = 'Fullst�ndig beskrivning';
$lang['Fileldinfo'] = 'Detta �r en fullst�ndig filbeskrivning, som endast visas p� filens egna sida.';
$lang['Filecreator'] = 'Skapare/f�rfattare';
$lang['Filecreatorinfo'] = 'Detta �r namnet p� den som skapade filen.';
$lang['Fileversion'] = 'Filversion';
$lang['Fileversioninfo'] = 'Detta �r filversionen, t ex 3.0 eller 1.3 Beta';
$lang['Filess'] = 'Screenshot URL';
$lang['Filessinfo'] = 'Detta �r URLn till en bild (screenshot) som representerar filen. Exemplevis, om du laddar upp en logotype, kan du h�r ladda upp en miniatyr av logotypen.';
$lang['Filess_upload'] = 'Ladda upp Screenshot';
$lang['Filessinfo_upload'] = 'Du kan v�lja screenshot genom att \'bl�ddra\'';
$lang['Filess_link'] = 'Screen Shot som l�nk';
$lang['Filess_link_info'] = 'Om du vill att din screenshot skall vara en l�nk, v�lj \'ja\'.';
$lang['Filedocs'] = 'Dokumentation/manual URL';
$lang['Filedocsinfo'] = 'Detta �r URLn till dokumentation eller en manual f�r filen';
$lang['Fileurl'] = 'Fil URL';
$lang['Fileurlinfo'] = 'Detta �r URLn till filen som kommer laddas upp. Du kan antingen ange URLn manuellt eller \'bl�ddra\'.';
$lang['File_upload'] = 'Filuppladdning';
$lang['Fileinfo_upload'] = 'V�lj fil genom att \bl�ddra\'';
$lang['Uploaded_file'] = 'Uppladdad fil';
$lang['Filepi'] = 'Filikon';
$lang['Filepiinfo'] = 'Du kan associera en ikon med filen, som visas i fillistan bredvid filen.';
$lang['Filecat'] = 'Kategori';
$lang['Filecatinfo'] = 'Filen laddas nupp i denna kategori.';
$lang['Filelicense'] = 'Licens';
$lang['Filelicenseinfo'] = 'Detta licensavtal m�ste godk�nnas innan du kan ladda ner filen.';
$lang['Filepin'] = 'N�la filer';
$lang['Filepininfo'] = 'V�lja om du vill \'n�la fast\' filer �verst i fillistan.';
$lang['Filedisable'] = 'Inaktivera filen';
$lang['Filedisableinfo'] = 'Filen syns men kan inte laddas ner. Ett popupmeddelande informerar anv�ndaren att filen inte �r tillg�nglig f�r tillf�llet.';
$lang['Filedisablemsg'] = 'Inaktiveringsmeddelande';
$lang['Filedisablemsginfo'] = 'Det som visas i popupmeddelandet';
$lang['Fileadded'] = 'Filen laddades upp...';
$lang['Filedeleted'] = 'Filen togs bort...';
$lang['Fileedited'] = 'Filen (filerna) �ndrades...';
$lang['Fderror'] = 'Du valde ingen fil (inga filer) att ta bort';
$lang['Filesdeleted'] = 'Filerna togs bort...';
$lang['Filetoobig'] = 'Filen �r f�r stor!';
$lang['Approved'] = 'Godk�nd';
$lang['Not_approved'] = '(Underk�nd)';
$lang['Approved_info'] = 'Godk�nn filer f�r att g�ra dem tillg�ngliga f�r andra.';

$lang['Filedls'] = 'Nerladdningar totalt';
$lang['Addtional_field'] = 'Extra f�lt';
$lang['File_not_found'] = 'Filen du valde hittas inte';
$lang['SS_not_found'] = 'Bilden (screenshot) du valde hittas inte';

//
// MCP
//
$lang['MCP_short'] = 'ModCP';
$lang['MCP_title'] = 'Moderator Kontrollpanel';
$lang['MCP_title_explain'] = 'H�r kan admin (eller moderatorer) godk�nna filer';
$lang['FCP_short'] = 'FileCP';
$lang['FCP_title'] = 'File Control Panel';
$lang['FCP_title_explain'] = 'Here moderators can approve and manage files';
$lang['TCP_short'] = 'TransCP';
$lang['TCP_title'] = 'Translator Control Panel';
$lang['TCP_title_explain'] = 'Here translators can translate and manage language files and articles';

$lang['View'] = 'Visa';

$lang['Approve_selected'] = 'Godk�nn valda';
$lang['Unapprove_selected'] = 'Underk�nn valda';
$lang['Delete_selected'] = 'Ta bort valda';
$lang['No_item'] = 'Det finns inga filer';
$lang['No_file'] = 'Det finns inga filer';
$lang['All_items'] = 'Alla filer';
$lang['All_files'] = 'Alla filer';
$lang['Approved_items'] = 'Godk�nda filer';
$lang['Approved_files'] = 'Godk�nda filer';
$lang['Unapproved_items'] = 'Underk�nda filer';
$lang['Unapproved_files'] = 'Underk�nda filer';
$lang['Broken_items'] = 'Skadade filer';
$lang['Broken_files'] = 'Skadade filer';
$lang['Item_cat'] = 'Fil i kategori';
$lang['File_cat'] = 'Fil i kategori';
$lang['Approve'] = 'Godk�nn';
$lang['Unapprove'] = 'Underk�nn';

$lang['Sorry_auth_delete'] = 'Tyv�rr, du kan inte ta bort filer i denna kategori.';
$lang['Sorry_auth_mcp'] = 'Tyv�rr, du kan inte hantera filer i denna kategori.';
$lang['Sorry_auth_approve'] = 'Tyv�rr, du kan inte godk�nna filer i denna kategori.';
$lang['Sorry_auth_post'] = 'Sorry, but you cannot post articles in this category.';
$lang['Sorry_auth_edit'] = 'Sorry, but you cannot edit articles in this category.';

$lang['Edit_article'] = 'Edit';
$lang['Delete_article'] = 'Delete';

//
//User Upload
//
$lang['User_upload'] = 'Ladda upp fil';

//
// License
//
$lang['License'] = 'Licensgodk�nnande';
$lang['Licensewarn'] = 'Du m�ste godk�nna denna licens innan du laddar ner filen';
$lang['Iagree'] = 'Jag godk�nner';
$lang['Dontagree'] = 'Jag godk�nner inte';
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
$lang['Search'] = 'S�k';
$lang['Search_for'] = 'S�k efter';
$lang['Results'] = 'Resultaten f�r';
$lang['No_matches'] = 'Tyv�rr, inga tr�ffar';
$lang['Matches'] = 'tr�ffar hittades f�r';
$lang['All'] = 'Alla kategorier';
$lang['Choose_cat'] = 'V�lj kategori:';
$lang['Include_comments'] = 'Inkludera kommentarer';
$lang['Submiter'] = 'S�nd av';
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
$lang['Statistics'] = 'Statistik';
$lang['Stats_text'] = 'Det finns {total_files} filer i {total_categories} kategorier<br>';
$lang['Stats_text'] .= 'Det har nerladdats {total_downloads} filer totalt<br><br>';
$lang['Stats_text'] .= 'Den senaste filen �r <a href={u_newest_file}>{newest_file}</a><br>';
$lang['Stats_text'] .= 'Den �ldsta filen �r <a href={u_oldest_file}>{oldest_file}</a><br><br>';
$lang['Stats_text'] .= 'Medelbetyget f�r filen �r {average}/10<br>';
$lang['Stats_text'] .= 'Den mest popul�ra filen, baserat p� betygs�ttning, �r <a href={u_popular}>{popular}</a> med ett medelbetyg av {most}/10<br>';
$lang['Stats_text'] .= 'Den minst popul�ra filen, baserat p� betygs�ttning, �r <a href={u_lpopular}>{lpopular}</a> med ett medelbetyg av {least}/10<br><br>';
$lang['Stats_text'] .= 'Varje fil har laddats ner i medeltal {avg_dls} g�nger<br>';
$lang['Stats_text'] .= 'Den mest popul�ra filen, baserat p� antal nerladdningar, �r <a href={u_most_dl}>{most_dl}</a> med {most_no} nerladdningar<br>';
$lang['Stats_text'] .= 'Den minst popul�ra filen, baserat p� antal nerladdningar, �r <a href={u_least_dl}>{least_dl}</a> med {least_no} nerladdningar<br>';
$lang['Select_chart_type'] = 'V�lj diagramtyp';
$lang['Bars'] = 'Stolpar';
$lang['Lines'] = 'Linjer';
$lang['Area'] = 'Area';
$lang['Linepoints'] = 'Linjepunkter';
$lang['Points'] = 'Punkter';
$lang['Chart_header'] = 'Filstatistik - filer uppladdade till databasen varje m�nad';
$lang['Chart_legend'] = 'Filer';
$lang['X_label'] = 'M�nader';
$lang['Y_label'] = 'Antal filer';

//
// Rate
//
$lang['Votes_label'] = 'Rating';
$lang['Votes'] = 'Votes';
$lang['No_votes'] = 'No votes';
$lang['Rate'] = 'Betygs�tt fil';
$lang['ADD_RATING'] = '[Rate Article]';
$lang['Do_rate'] = '[Betygs�tt fil]';
$lang['Rerror'] = 'Tyv�rr, du har redan betygsatt den h�r filen.';
$lang['Rateinfo'] = 'Du betygs�tter filen <i>{filename}</i>.<br>V�lj ett betyg. 1 �r s�mst och 10 �r b�st.';
$lang['Rconf'] = 'Du har gett <i>{filename}</i> betyget {rate}.<br>Det ger filen det nya medelbetyget {newrating}.';
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
$lang['Not_rated'] = 'Inte betygsatt';

//
// Email
//
$lang['Emailfile'] = 'E-posta filen till en v�n';
$lang['Emailinfo'] = 'Om du vill att en v�n skall k�nna till den h�r filen, fyll i formul�ret och skicka information till din v�n!<br>F�lt markerade med * m�ste fyllas i.';
$lang['Yname'] = 'Ditt namn';
$lang['Yemail'] = 'Din e-post';
$lang['Fname'] = 'Din v�ns namn';
$lang['Femail'] = 'Din v�ns e-post';
$lang['Esub'] = 'Titel';
$lang['Etext'] = 'Text';
$lang['Defaultmail'] = 'Jag tror du skulle vara intresserad av filen, som finns p� adressen ';
$lang['Semail'] = 'Skicka e-post';
$lang['Econf'] = 'E-postmeddelandet skickades...';

//
// Comments
//
$lang['Comments'] = 'Kommentarer';
$lang['Comments_title'] = 'Kommentartitel';
$lang['Comment_subject'] = 'Kommentar�mne';
$lang['Comment'] = 'Kommentar';
$lang['Comment_explain'] = 'Anv�nd textrutan och skriv din kommentar!';
$lang['Comment_add'] = 'L�gg till kommentar';
$lang['Comment_edit'] = '�ndra';
$lang['Comment_delete'] = 'Ta bort';
$lang['Comment_posted'] = 'Kommentaren skickades...';
$lang['Comment_deleted'] = 'Kommentaren togs bort...';
$lang['Comment_desc'] = 'Titel';
$lang['No_comments'] = 'Inte kommenterad';
$lang['Links_are_ON'] = 'L�nkar �r <u>P�</u>';
$lang['Links_are_OFF'] = 'L�nkar �r <u>AV</u>';
$lang['Images_are_ON'] = 'Bilder �r <u>P�</u>';
$lang['Images_are_OFF'] = 'Bilder �r <u>AV</u>';
$lang['Check_message_length'] = 'Kontrollera meddelandel�ngd';
$lang['Msg_length_1'] = 'Ditt meddelande �r ';
$lang['Msg_length_2'] = ' bokst�ver l�ngt.';
$lang['Msg_length_3'] = 'Du har ';
$lang['Msg_length_4'] = ' bokst�ver tillhanda.';;
$lang['Msg_length_5'] = 'Det finns ';
$lang['Msg_length_6'] = ' bokst�ver kvar att anv�nda.';


//
// Download
//
$lang['Directly_linked'] = 'Du kan inte ladda ner filen direkt fr�n en annan sajt!';

//
// Permission
//
$lang['Sorry_auth_view'] = 'Tyv�rr kan endast %s se filer och subkategorier i denna kategori.';
$lang['Sorry_auth_file_view'] = 'Tyv�rr kan endast %s se filer i denna kategori.';
$lang['Sorry_auth_upload'] = 'Tyv�rr kan endast %s ladda upp filer i denna kategori.';
$lang['Sorry_auth_download'] = 'Tyv�rr kan endast %s ladda ner filer i denna kategori.';
$lang['Sorry_auth_rate'] = 'Tyv�rr kan endast %s betygs�tta filer i denna kategori.';
$lang['Sorry_auth_view_comments'] = 'Tyv�rr kan endast %s se kommentarer i denna kategori.';
$lang['Sorry_auth_post_comments'] = 'Tyv�rr kan endast %s skicka kommentarer i denna kategori.';
$lang['Sorry_auth_edit_comments'] = 'Tyv�rr kan endast %s �ndra kommentarer i denna kategori.';
$lang['Sorry_auth_delete_comments'] = 'Tyv�rr kan endast %s ta bort kommentarer i denna kategori.';
$lang['Sorry_auth_edit'] = 'Tyv�rr, du kan inte �ndra filer i denna kategori.';
$lang['Sorry_auth_viewall'] = 'Sorry, but you cannot view viewall in this category.';

//
// New
//
$lang['Deletefile'] = 'Ta bort fil';
$lang['Editfile'] = '�ndra fil';
$lang['pub_MCP'] = '[Kontrollpanel]';
$lang['Click_return_not_validated'] = 'Klicka %sh�r%s f�r att �terg� till f�reg�ende sida';
$lang['Fileadded_not_validated'] = 'Filen skickades, men en moderator (admin) m�ste godk�nna filen innan andra kan anv�nda den.';

$lang['Quickdl_back'] = '&laquo; Tillbaka';

$lang['Quickdl'] = 'Standard pafile kategori';
$lang['Quickdl_explain'] = 'Denna publisher kategori visas, om ingen mappning �r aktiverad.';

$lang['Pa_updated_return_settings'] = 'Pa quickdl inst�llningarna uppdaterades...<br /><br />Klicka %sh�r%s f�r att �terg� till huvudsidan.'; // %s's for URI params - DO NOT REMOVE
$lang['Pa_update_error'] = 'Lyckades INTE uppdatera Pa quickdl inst�llningarna...';

$lang['Pa_settings'] = 'Pa mapping inst�llningar';
$lang['Pa_settings_short_explain'] = 'Inst�llningar f�r mappning mellan pa kategorier och dynamiska block.';
$lang['Pa_settings_explain'] = 'H�r g�r du inst�llningar f�r pa modulen - quickdl mapping. Panelen l�ter dig associera vilka pa kategorier som visas beroende p� vilket dynamiskt block som visas.';

//
// Notification
//
$lang['PUB_title'] = 'Fildatabas';
$lang['PUB_prefix'] = '[ Fil ]';

$lang['PUB_notify_subject_new'] = 'Ny fil!';
$lang['PUB_notify_subject_edited'] = '�ndrad fil!';
$lang['PUB_notify_subject_approved'] = 'Godk�nd fil!';
$lang['PUB_notify_subject_unapproved'] = 'Underk�nd fil!';
$lang['PUB_notify_subject_deleted'] = 'Borttagen fil!';
$lang['PUB_notify_subject_unapproved'] = '<br />Fişier Ne-Aprobat!';
$lang['PUB_notify_body'] = '<br />Un fişier a fost uploadat sau actualizat:';
$lang['PUB_no_ratings'] = '<br />Dezactivat în aceată categorie';

$lang['PUB_notify_new_body'] = 'En ny fil lades till.';
$lang['PUB_notify_edited_body'] = 'En fil har uppdaterats.';
$lang['PUB_notify_approved_body'] = 'En fil godk�ndes.';
$lang['PUB_notify_unapproved_body'] = 'En fil underk�ndes.';
$lang['PUB_notify_deleted_body'] = 'En fil togs bort.';
$lang['Edited_Article_info'] = 'Filen uppdaterades av ';

$lang['PUB_goto'] = '>>G� till filen';

//
// Auth Can
//
$lang['PUB_Rules_upload_can'] = 'Du <b>kan</b> ladda upp filer i denna kategori';
$lang['PUB_Rules_upload_cannot'] = 'Du <b>kan inte</b> ladda upp filer i denna kategori';
$lang['PUB_Rules_download_can'] = 'Du <b>kan</b> ladda hem filer i denna kategori';
$lang['PUB_Rules_download_cannot'] = 'Du <b>kan inte</b> ladda hem filer i denna kategori';
$lang['PUB_Rules_post_comment_can'] = 'Du <b>kan</b> kommentera filer i denna kategori';
$lang['PUB_Rules_post_comment_cannot'] = 'Du <b>kan inte</b> kommentera filer i denna kategori';
$lang['PUB_Rules_view_comment_can'] = 'Du <b>kan</b> l�sa kommentarer i denna kategori';
$lang['PUB_Rules_view_comment_cannot'] = 'Du <b>kan inte</b> l�sa kommentarer i denna kategori';
$lang['PUB_Rules_view_file_can'] = 'Du <b>kan</b> se filer i denna kategori';
$lang['PUB_Rules_view_file_cannot'] = 'Du <b>kan inte</b> se filer i denna kategori';
$lang['PUB_Rules_edit_file_can'] = 'Du <b>kan</b> �ndra dina filer i denna kategori';
$lang['PUB_Rules_edit_file_cannot'] = 'Du <b>kan inte</b> �ndra dina filer i denna kategori';
$lang['PUB_Rules_delete_file_can'] = 'Du <b>kan</b> ta bort dina filer i denna kategori';
$lang['PUB_Rules_delete_file_cannot'] = 'Du <b>kan inte</b> ta bort dina filer i denna kategori';
$lang['PUB_Rules_rate_can'] = 'Du <b>kan</b> betygs�tta filer i denna kategori';
$lang['PUB_Rules_rate_cannot'] = 'Du <b>kan inte</b> betygs�tta filer i denna kategori';
$lang['PUB_Rules_moderate'] = 'Du <b>kan</b> %smoderate i denna kategori'; // %s replaced by a href links, do not remove!
$lang['PUB_Rules_moderate_can'] = 'Du <b>�r</b> moderator i denna kategori'; // %s replaced by a href links, do not remove!

//
// Toplist
//
$lang['Toplist'] = 'Topplista';
$lang['Select_list'] = 'V�lj vilken typ av lista att visa';
$lang['Latest_downloads'] = 'Senaste filer';
$lang['Most_downloads'] = 'Mest popul�ra';
$lang['Rated_downloads'] = 'Topprankade';

$lang['Total_new_files'] = 'Totalt antal nya filer';
$lang['Show'] = 'Visa';
$lang['One_week'] = 'En vecka';
$lang['Two_week'] = 'Tv� veckor';
$lang['30_days'] = '30 dagar';
$lang['New_Files'] = 'Totalt antal nya filer senaste %d dagarna';
$lang['Last_week'] ='Senaste veckan';
$lang['Last_30_days'] = 'Senaste 30 dagarna';
$lang['Show_top'] = 'Visa topp';
$lang['Or_top'] = 'eller topp';
$lang['Popular_num'] = 'Topp %d av %d filer i databasen';
$lang['Popular_per'] = 'Topp %d %% av alla %d filer i databasen';
$lang['General_Info'] = 'Allm�n information';
$lang['Downloads_stats'] = 'Anv�ndarstatistik - nerladdning';
$lang['Rating_stats'] = 'Anv�ndarstatistik - r�stning';
$lang['Os'] = 'Operativsystem';
$lang['Browsers'] = 'Webbl�sare';

//
// Toplists mx blocks
//
$lang['Recent_Public_Files'] = 'Senaste filer';
$lang['Random_Public_Files'] = 'Slumpade filer';
$lang['Toprated_Public_Files'] = 'Topprankade filer';
$lang['Most_Public_Files'] = 'Popul�ra filer';

$lang['File_Title'] = 'Titel';
$lang['File_Desc'] = 'Beskrivning';
$lang['Rating'] = 'Betyg';
$lang['Dls'] = 'Nerladdade';

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
$lang['Quickdl_back'] = 'Tillbaka';
//
// Generic Type strings
// - Types are matched against these lang keys...where 'NAME' is the db defined type name
//
$lang['PUB_type_NAME'] = 'Example Type';
?>