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
$lang['Click_return'] = 'Klicka %shär%s för att återgå till föregående sida';
$lang['Click_here'] = 'Klicka här';
$lang['never'] = 'Aldrig';
$lang['publisher_disable'] = 'Fildatabasen är inaktiverad';
$lang['jump'] = 'Välj en kategori';
$lang['viewall_disabled'] = 'Denna funktion är inaktiverad av admin.';
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
$lang['Click_return'] = 'Klicka %shär%s för att återgå till föregående sida.';

//
// Main
//
$lang['Files'] = 'Filer';
$lang['Viewall'] = 'Visa alla filer';
$lang['Vainfo'] = 'Visa alla filer i databasen';
$lang['Quick_nav'] = 'Snabbnavigering';
$lang['Quick_jump'] = 'Välj kategori';
$lang['Quick_go'] = 'Gå';
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
$lang['Votes'] = ' röster';
$lang['Date'] = 'Datum';
$lang['Update_time'] = 'Senast uppdaterad';
$lang['DlRating'] = 'Betyg';
$lang['Dls'] = ' Nerladdningar';
$lang['Downloadfile'] = 'Ladda hem fil';
$lang['File_size'] = 'Filstorlek';
$lang['Not_available'] = 'Inte tillgänglig!';
$lang['Bytes'] = 'Bytes';
$lang['KB'] = 'Kilo Byte';
$lang['MB'] = 'Mega Byte';
$lang['Mirrors'] = 'Mirrorsajt';
$lang['Mirrors_explain'] = 'Här kan du skapa och ändra mirrorsajter. Kontrollera all information för filen laddas upp till databasen';
$lang['Click_here_mirrors'] = 'Klicka här för att lägga till en mirrorsajt';
$lang['Mirror_location'] = 'Mirrorsajtens plats';
$lang['Add_new_mirror'] = 'Lägg till mirrorsajt';
$lang['Save_as'] = 'Spara som...';

//
// Admin Panels - File
//
$lang['File_manage_title'] = 'Filhantering';

$lang['Afile'] = 'Fil: Lägg till';
$lang['Efile'] = 'Fil: Ändra';
$lang['Dfile'] = 'Fil: Ta bort';
$lang['Afiletitle'] = 'Lägg till fil';
$lang['Efiletitle'] = 'Ändra fil';
$lang['Dfiletitle'] = 'Ta bort fil';
$lang['Fileexplain'] = 'Använd filhanteringen för att lägga till, ändra och ta bort filer.';
$lang['Upload'] = 'Ladda upp fil';
$lang['Uploadinfo'] = 'Ladda upp denna fil';
$lang['Uploaderror'] = 'Filen finns redan. Använd annat namn.';
$lang['Uploaddone'] = 'Filen laddades upp. Filens URL är ';
$lang['Uploaddone2'] = 'Klicka här för att placera URLn i nerladdningsfältet.';
$lang['Upload_do_done'] = 'Laddades upp...';
$lang['Upload_do_not'] = 'Laddades INTE upp';
$lang['Upload_do_exist'] = 'Filen finns';
$lang['Filename'] = 'Filnamn';
$lang['Filenameinfo'] = 'Detta är filnamnet, t ex \'My Picture.\'';
$lang['Filesd'] = 'Kort beskrivning';
$lang['Filesdinfo'] = 'Detta är en kort filbeskrivning, som visas på kategorisidan. Tänk på att skriva kort och informativt.';
$lang['Fileld'] = 'Fullständig beskrivning';
$lang['Fileldinfo'] = 'Detta är en fullständig filbeskrivning, som endast visas på filens egna sida.';
$lang['Filecreator'] = 'Skapare/författare';
$lang['Filecreatorinfo'] = 'Detta är namnet på den som skapade filen.';
$lang['Fileversion'] = 'Filversion';
$lang['Fileversioninfo'] = 'Detta är filversionen, t ex 3.0 eller 1.3 Beta';
$lang['Filess'] = 'Screenshot URL';
$lang['Filessinfo'] = 'Detta är URLn till en bild (screenshot) som representerar filen. Exemplevis, om du laddar upp en logotype, kan du här ladda upp en miniatyr av logotypen.';
$lang['Filess_upload'] = 'Ladda upp Screenshot';
$lang['Filessinfo_upload'] = 'Du kan välja screenshot genom att \'bläddra\'';
$lang['Filess_link'] = 'Screen Shot som länk';
$lang['Filess_link_info'] = 'Om du vill att din screenshot skall vara en länk, välj \'ja\'.';
$lang['Filedocs'] = 'Dokumentation/manual URL';
$lang['Filedocsinfo'] = 'Detta är URLn till dokumentation eller en manual för filen';
$lang['Fileurl'] = 'Fil URL';
$lang['Fileurlinfo'] = 'Detta är URLn till filen som kommer laddas upp. Du kan antingen ange URLn manuellt eller \'bläddra\'.';
$lang['File_upload'] = 'Filuppladdning';
$lang['Fileinfo_upload'] = 'Välj fil genom att \bläddra\'';
$lang['Uploaded_file'] = 'Uppladdad fil';
$lang['Filepi'] = 'Filikon';
$lang['Filepiinfo'] = 'Du kan associera en ikon med filen, som visas i fillistan bredvid filen.';
$lang['Filecat'] = 'Kategori';
$lang['Filecatinfo'] = 'Filen laddas nupp i denna kategori.';
$lang['Filelicense'] = 'Licens';
$lang['Filelicenseinfo'] = 'Detta licensavtal måste godkännas innan du kan ladda ner filen.';
$lang['Filepin'] = 'Nåla filer';
$lang['Filepininfo'] = 'Välja om du vill \'nåla fast\' filer överst i fillistan.';
$lang['Filedisable'] = 'Inaktivera filen';
$lang['Filedisableinfo'] = 'Filen syns men kan inte laddas ner. Ett popupmeddelande informerar användaren att filen inte är tillgänglig för tillfället.';
$lang['Filedisablemsg'] = 'Inaktiveringsmeddelande';
$lang['Filedisablemsginfo'] = 'Det som visas i popupmeddelandet';
$lang['Fileadded'] = 'Filen laddades upp...';
$lang['Filedeleted'] = 'Filen togs bort...';
$lang['Fileedited'] = 'Filen (filerna) ändrades...';
$lang['Fderror'] = 'Du valde ingen fil (inga filer) att ta bort';
$lang['Filesdeleted'] = 'Filerna togs bort...';
$lang['Filetoobig'] = 'Filen är för stor!';
$lang['Approved'] = 'Godkänd';
$lang['Not_approved'] = '(Underkänd)';
$lang['Approved_info'] = 'Godkänn filer för att göra dem tillgängliga för andra.';

$lang['Filedls'] = 'Nerladdningar totalt';
$lang['Addtional_field'] = 'Extra fält';
$lang['File_not_found'] = 'Filen du valde hittas inte';
$lang['SS_not_found'] = 'Bilden (screenshot) du valde hittas inte';

//
// MCP
//
$lang['MCP_title'] = 'Moderator Kontrollpanel';
$lang['MCP_title_explain'] = 'Här kan admin (eller moderatorer) godkänna filer';

$lang['View'] = 'Visa';

$lang['Approve_selected'] = 'Godkänn valda';
$lang['Unapprove_selected'] = 'Underkänn valda';
$lang['Delete_selected'] = 'Ta bort valda';
$lang['No_item'] = 'Det finns inga filer';
$lang['No_file'] = 'Det finns inga filer';
$lang['All_items'] = 'Alla filer';
$lang['All_files'] = 'Alla filer';
$lang['Approved_items'] = 'Godkända filer';
$lang['Unapproved_items'] = 'Underkända filer';
$lang['Unapproved_files'] = 'Underkända filer';
$lang['Broken_items'] = 'Skadade filer';
$lang['Broken_files'] = 'Skadade filer';
$lang['Item_cat'] = 'Fil i kategori';
$lang['File_cat'] = 'Fil i kategori';
$lang['Approve'] = 'Godkänn';
$lang['Unapprove'] = 'Underkänn';

$lang['Sorry_auth_delete'] = 'Tyvärr, du kan inte ta bort filer i denna kategori.';
$lang['Sorry_auth_mcp'] = 'Tyvärr, du kan inte hantera filer i denna kategori.';
$lang['Sorry_auth_approve'] = 'Tyvärr, du kan inte godkänna filer i denna kategori.';
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
$lang['License'] = 'Licensgodkännande';
$lang['Licensewarn'] = 'Du måste godkänna denna licens innan du laddar ner filen';
$lang['Iagree'] = 'Jag godkänner';
$lang['Dontagree'] = 'Jag godkänner inte';
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
$lang['Search'] = 'Sök';
$lang['Search_for'] = 'Sök efter';
$lang['Results'] = 'Resultaten för';
$lang['No_matches'] = 'Tyvärr, inga träffar';
$lang['Matches'] = 'träffar hittades för';
$lang['All'] = 'Alla kategorier';
$lang['Choose_cat'] = 'Välj kategori:';
$lang['Include_comments'] = 'Inkludera kommentarer';
$lang['Submiter'] = 'Sänd av';
//
// Comments
//
$lang['Comments'] = 'Comentarii';
$lang['Comments_title'] = 'Titlul comentariului';
$lang['Comment_subject'] = 'Subiectul comentariului';
$lang['Comment'] = 'Comentariu';
$lang['Comment_explain'] = 'FolosiÅ£i cÄƒsuÅ£a de text de mai jos pentru a vÄƒ face cunoscutÄƒ opinia vis a vis de acest fiÅŸier!';
$lang['Comment_add'] = 'AdaugÄƒ comentariu';
$lang['Comment_edit'] = 'EditeazÄƒ';
$lang['Comment_delete'] = 'Åžterge';
$lang['Comment_posted'] = 'Comentariul dumneavoastrÄƒ  a fost introdus cu succes';
$lang['Comment_deleted'] = 'Comentariul pe care l-aÅ£i selectat a fost ÅŸters cu succes';
$lang['Comment_desc'] = 'Titlu';
$lang['No_comments'] = 'Nici un comentariu nu a fost scris.';
$lang['Links_are_ON'] = 'Link-urile sunt <u>Activate</u>';
$lang['Links_are_OFF'] = 'Link-urile sunt <u>Dezactivate</u>';
$lang['Images_are_ON'] = 'Imaginile sunt <u>Activate</u>';
$lang['Images_are_OFF'] = 'Imaginile sunt <u>Dezactivate</u>';
$lang['Check_message_length'] = 'VerificÄƒ lungimea mesajului';
$lang['Msg_length_1'] = 'Mesajul dumneavoastrÄƒ are o lungime de ';
$lang['Msg_length_2'] = ' caractere.';
$lang['Msg_length_3'] = 'Limita mesajului este de ';
$lang['Msg_length_4'] = ' caractere.';;
$lang['Msg_length_5'] = 'Mai puteÅ£i scrie ';
$lang['Msg_length_6'] = ' caractere.';

//
// Statistics
//
$lang['Statistics'] = 'Statistik';
$lang['Stats_text'] = 'Det finns {total_files} filer i {total_categories} kategorier<br>';
$lang['Stats_text'] .= 'Det har nerladdats {total_downloads} filer totalt<br><br>';
$lang['Stats_text'] .= 'Den senaste filen är <a href={u_newest_file}>{newest_file}</a><br>';
$lang['Stats_text'] .= 'Den äldsta filen är <a href={u_oldest_file}>{oldest_file}</a><br><br>';
$lang['Stats_text'] .= 'Medelbetyget för filen är {average}/10<br>';
$lang['Stats_text'] .= 'Den mest populära filen, baserat på betygsättning, är <a href={u_popular}>{popular}</a> med ett medelbetyg av {most}/10<br>';
$lang['Stats_text'] .= 'Den minst populära filen, baserat på betygsättning, är <a href={u_lpopular}>{lpopular}</a> med ett medelbetyg av {least}/10<br><br>';
$lang['Stats_text'] .= 'Varje fil har laddats ner i medeltal {avg_dls} gånger<br>';
$lang['Stats_text'] .= 'Den mest populära filen, baserat på antal nerladdningar, är <a href={u_most_dl}>{most_dl}</a> med {most_no} nerladdningar<br>';
$lang['Stats_text'] .= 'Den minst populära filen, baserat på antal nerladdningar, är <a href={u_least_dl}>{least_dl}</a> med {least_no} nerladdningar<br>';
$lang['Select_chart_type'] = 'Välj diagramtyp';
$lang['Bars'] = 'Stolpar';
$lang['Lines'] = 'Linjer';
$lang['Area'] = 'Area';
$lang['Linepoints'] = 'Linjepunkter';
$lang['Points'] = 'Punkter';
$lang['Chart_header'] = 'Filstatistik - filer uppladdade till databasen varje månad';
$lang['Chart_legend'] = 'Filer';
$lang['X_label'] = 'Månader';
$lang['Y_label'] = 'Antal filer';

//
// Rate
//
$lang['Votes_label'] = 'Rating';
$lang['Votes'] = 'Votes';
$lang['No_votes'] = 'No votes';
$lang['Rate'] = 'Betygsätt fil';
$lang['ADD_RATING'] = '[Rate Article]';
$lang['Do_rate'] = '[Betygsätt fil]';
$lang['Rerror'] = 'Tyvärr, du har redan betygsatt den här filen.';
$lang['Rateinfo'] = 'Du betygsätter filen <i>{filename}</i>.<br>Välj ett betyg. 1 är sämst och 10 är bäst.';
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
$lang['Emailfile'] = 'E-posta filen till en vän';
$lang['Emailinfo'] = 'Om du vill att en vän skall känna till den här filen, fyll i formuläret och skicka information till din vän!<br>Fält markerade med * måste fyllas i.';
$lang['Yname'] = 'Ditt namn';
$lang['Yemail'] = 'Din e-post';
$lang['Fname'] = 'Din väns namn';
$lang['Femail'] = 'Din väns e-post';
$lang['Esub'] = 'Titel';
$lang['Etext'] = 'Text';
$lang['Defaultmail'] = 'Jag tror du skulle vara intresserad av filen, som finns på adressen ';
$lang['Semail'] = 'Skicka e-post';
$lang['Econf'] = 'E-postmeddelandet skickades...';

//
// Comments
//
$lang['Comments'] = 'Kommentarer';
$lang['Comments_title'] = 'Kommentartitel';
$lang['Comment_subject'] = 'Kommentarämne';
$lang['Comment'] = 'Kommentar';
$lang['Comment_explain'] = 'Använd textrutan och skriv din kommentar!';
$lang['Comment_add'] = 'Lägg till kommentar';
$lang['Comment_edit'] = 'Ändra';
$lang['Comment_delete'] = 'Ta bort';
$lang['Comment_posted'] = 'Kommentaren skickades...';
$lang['Comment_deleted'] = 'Kommentaren togs bort...';
$lang['Comment_desc'] = 'Titel';
$lang['No_comments'] = 'Inte kommenterad';
$lang['Links_are_ON'] = 'Länkar är <u>PÅ</u>';
$lang['Links_are_OFF'] = 'Länkar är <u>AV</u>';
$lang['Images_are_ON'] = 'Bilder är <u>PÅ</u>';
$lang['Images_are_OFF'] = 'Bilder är <u>AV</u>';
$lang['Check_message_length'] = 'Kontrollera meddelandelängd';
$lang['Msg_length_1'] = 'Ditt meddelande är ';
$lang['Msg_length_2'] = ' bokstäver långt.';
$lang['Msg_length_3'] = 'Du har ';
$lang['Msg_length_4'] = ' bokstäver tillhanda.';;
$lang['Msg_length_5'] = 'Det finns ';
$lang['Msg_length_6'] = ' bokstäver kvar att använda.';


//
// Download
//
$lang['Directly_linked'] = 'Du kan inte ladda ner filen direkt från en annan sajt!';

//
// Permission
//
$lang['Sorry_auth_view'] = 'Tyvärr kan endast %s se filer och subkategorier i denna kategori.';
$lang['Sorry_auth_file_view'] = 'Tyvärr kan endast %s se filer i denna kategori.';
$lang['Sorry_auth_upload'] = 'Tyvärr kan endast %s ladda upp filer i denna kategori.';
$lang['Sorry_auth_download'] = 'Tyvärr kan endast %s ladda ner filer i denna kategori.';
$lang['Sorry_auth_rate'] = 'Tyvärr kan endast %s betygsätta filer i denna kategori.';
$lang['Sorry_auth_view_comments'] = 'Tyvärr kan endast %s se kommentarer i denna kategori.';
$lang['Sorry_auth_post_comments'] = 'Tyvärr kan endast %s skicka kommentarer i denna kategori.';
$lang['Sorry_auth_edit_comments'] = 'Tyvärr kan endast %s ändra kommentarer i denna kategori.';
$lang['Sorry_auth_delete_comments'] = 'Tyvärr kan endast %s ta bort kommentarer i denna kategori.';
$lang['Sorry_auth_edit'] = 'Tyvärr, du kan inte ändra filer i denna kategori.';
$lang['Sorry_auth_viewall'] = 'Sorry, but you cannot view viewall in this category.';

//
// New
//
$lang['Deletefile'] = 'Ta bort fil';
$lang['Editfile'] = 'Ändra fil';
$lang['pub_MCP'] = '[Kontrollpanel]';
$lang['Click_return_not_validated'] = 'Klicka %shär%s för att återgå till föregående sida';
$lang['Fileadded_not_validated'] = 'Filen skickades, men en moderator (admin) måste godkänna filen innan andra kan använda den.';

$lang['Quickdl_back'] = '&laquo; Tillbaka';

$lang['Quickdl'] = 'Standard pafile kategori';
$lang['Quickdl_explain'] = 'Denna publisher kategori visas, om ingen mappning är aktiverad.';

$lang['Pa_updated_return_settings'] = 'Pa quickdl inställningarna uppdaterades...<br /><br />Klicka %shär%s för att återgå till huvudsidan.'; // %s's for URI params - DO NOT REMOVE
$lang['Pa_update_error'] = 'Lyckades INTE uppdatera Pa quickdl inställningarna...';

$lang['Pa_settings'] = 'Pa mapping inställningar';
$lang['Pa_settings_short_explain'] = 'Inställningar för mappning mellan pa kategorier och dynamiska block.';
$lang['Pa_settings_explain'] = 'Här gör du inställningar för pa modulen - quickdl mapping. Panelen låter dig associera vilka pa kategorier som visas beroende på vilket dynamiskt block som visas.';

//
// Notification
//
$lang['PUB_title'] = 'Fildatabas';
$lang['PUB_prefix'] = '[ Fil ]';

$lang['PUB_notify_subject_new'] = 'Ny fil!';
$lang['PUB_notify_subject_edited'] = 'Ändrad fil!';
$lang['PUB_notify_subject_approved'] = 'Godkänd fil!';
$lang['PUB_notify_subject_unapproved'] = 'Underkänd fil!';
$lang['PUB_notify_subject_deleted'] = 'Borttagen fil!';
$lang['PUB_notify_subject_unapproved'] = '<br />FiÅŸier Ne-Aprobat!';
$lang['PUB_notify_body'] = '<br />Un fiÅŸier a fost uploadat sau actualizat:';
$lang['PUB_no_ratings'] = '<br />Dezactivat Ã®n aceatÄƒ categorie';

$lang['PUB_notify_new_body'] = 'En ny fil lades till.';
$lang['PUB_notify_edited_body'] = 'En fil har uppdaterats.';
$lang['PUB_notify_approved_body'] = 'En fil godkändes.';
$lang['PUB_notify_unapproved_body'] = 'En fil underkändes.';
$lang['PUB_notify_deleted_body'] = 'En fil togs bort.';
$lang['Edited_Article_info'] = 'Filen uppdaterades av ';

$lang['PUB_goto'] = '>>Gå till filen';

//
// Auth Can
//
$lang['PUB_Rules_upload_can'] = 'Du <b>kan</b> ladda upp filer i denna kategori';
$lang['PUB_Rules_upload_cannot'] = 'Du <b>kan inte</b> ladda upp filer i denna kategori';
$lang['PUB_Rules_download_can'] = 'Du <b>kan</b> ladda hem filer i denna kategori';
$lang['PUB_Rules_download_cannot'] = 'Du <b>kan inte</b> ladda hem filer i denna kategori';
$lang['PUB_Rules_post_comment_can'] = 'Du <b>kan</b> kommentera filer i denna kategori';
$lang['PUB_Rules_post_comment_cannot'] = 'Du <b>kan inte</b> kommentera filer i denna kategori';
$lang['PUB_Rules_view_comment_can'] = 'Du <b>kan</b> läsa kommentarer i denna kategori';
$lang['PUB_Rules_view_comment_cannot'] = 'Du <b>kan inte</b> läsa kommentarer i denna kategori';
$lang['PUB_Rules_view_file_can'] = 'Du <b>kan</b> se filer i denna kategori';
$lang['PUB_Rules_view_file_cannot'] = 'Du <b>kan inte</b> se filer i denna kategori';
$lang['PUB_Rules_edit_file_can'] = 'Du <b>kan</b> ändra dina filer i denna kategori';
$lang['PUB_Rules_edit_file_cannot'] = 'Du <b>kan inte</b> ändra dina filer i denna kategori';
$lang['PUB_Rules_delete_file_can'] = 'Du <b>kan</b> ta bort dina filer i denna kategori';
$lang['PUB_Rules_delete_file_cannot'] = 'Du <b>kan inte</b> ta bort dina filer i denna kategori';
$lang['PUB_Rules_rate_can'] = 'Du <b>kan</b> betygsätta filer i denna kategori';
$lang['PUB_Rules_rate_cannot'] = 'Du <b>kan inte</b> betygsätta filer i denna kategori';
$lang['PUB_Rules_moderate'] = 'Du <b>kan</b> %smoderate i denna kategori'; // %s replaced by a href links, do not remove!
$lang['PUB_Rules_moderate_can'] = 'Du <b>är</b> moderator i denna kategori'; // %s replaced by a href links, do not remove!

//
// Toplist
//
$lang['Toplist'] = 'Topplista';
$lang['Select_list'] = 'Välj vilken typ av lista att visa';
$lang['Latest_downloads'] = 'Senaste filer';
$lang['Most_downloads'] = 'Mest populära';
$lang['Rated_downloads'] = 'Topprankade';

$lang['Total_new_files'] = 'Totalt antal nya filer';
$lang['Show'] = 'Visa';
$lang['One_week'] = 'En vecka';
$lang['Two_week'] = 'Två veckor';
$lang['30_days'] = '30 dagar';
$lang['New_Files'] = 'Totalt antal nya filer senaste %d dagarna';
$lang['Last_week'] ='Senaste veckan';
$lang['Last_30_days'] = 'Senaste 30 dagarna';
$lang['Show_top'] = 'Visa topp';
$lang['Or_top'] = 'eller topp';
$lang['Popular_num'] = 'Topp %d av %d filer i databasen';
$lang['Popular_per'] = 'Topp %d %% av alla %d filer i databasen';
$lang['General_Info'] = 'Allmän information';
$lang['Downloads_stats'] = 'Användarstatistik - nerladdning';
$lang['Rating_stats'] = 'Användarstatistik - röstning';
$lang['Os'] = 'Operativsystem';
$lang['Browsers'] = 'Webbläsare';

//
// Toplists mx blocks
//
$lang['Recent_Public_Files'] = 'Senaste filer';
$lang['Random_Public_Files'] = 'Slumpade filer';
$lang['Toprated_Public_Files'] = 'Topprankade filer';
$lang['Most_Public_Files'] = 'Populära filer';

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