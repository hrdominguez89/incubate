<?php

/*
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('callback','FrontendController@callback');
//-- uploads images --//
Route::post('upload-image', 'UploadController@postUpload');
Route::post('upload-thumb','UploadController@upload_thumb');
Route::post('upload-docs','UploadController@upload_docs');
//--login cms--//
Route::resource('cms', 'LoginController');
Route::get('login','LoginController@login');
Route::get('verifylogin','LoginController@index');
Route::post('verifylogin','LoginController@callback');

//--logout cms--//
Route::get('logout', 'LoginController@logout');
//--recover password--//
Route::get('recover-password', 'LoginController@recovery');
// store recovery //
Route::post('store_recovery', 'LoginController@store_recovery');
//--dashboard cms---//
Route::resource('dashboard', 'DashboardController');
//-- account ---//
Route::get('my-account', 'DashboardController@account');
Route::get('email', 'DashboardController@email');
//--Analytics---//
Route::get('analytics', 'DashboardController@analytics');
Route::get('analytics-date/{init}/{end}','DashboardController@analytics_date');
Route::get('views_pages_listing', 'DashboardController@pages_listing');
Route::get('views_pages_listing_date/{init}/{end}', 'DashboardController@pages_listing_date');
Route::get('pdf/analytics/{init}/{end}', 'DashboardController@pdf_analytics');
//---users cms ----//
Route::resource('user', 'UserController');
// --- users lists--//
Route::get('user_lists', 'UserController@lists');
//---roles ----//
Route::resource('rol', 'RolController');
// -- roles lists--//
Route::get('rol_lists', 'RolController@lists');
//-- permissions --//
Route::get('permission/{id}', 'RolController@permission');
// -- list permissions --//
Route::get('permission_lists/{id}', 'RolController@permission_lists');
// --assing permission --//
Route::post('assign', 'RolController@assign');
// --remove permission --//
Route::post('remove', 'RolController@remove');
//----site options----//
Route::get('options', 'OptionsController@index')->middleware('role:5');
Route::get('seo', 'OptionsController@seo')->middleware('role:7');
Route::get('contact', 'OptionsController@contact')->middleware('role:6');
//---update options --//
Route::post('update_options', 'OptionsController@update');
/************************ AUDITS ********************/
Route::resource('audits','AuditsController');
Route::get('audits_listing','AuditsController@listing');
Route::get('audits_search_listing/{type}/{init}/{end}','AuditsController@search_listing');
// ----banners----//
Route::resource('banners', 'BannerController');
// --banner list--//
Route::get('banners_lists', 'BannerController@lists');
// -- list photo banner --//
Route::post('lists-photo-banner', 'BannerController@lists_photo');
// --delete photo banner --//
Route::post('delete-photo-banner', 'BannerController@delete_photo');
// ----informations----//
Route::resource('information', 'InformationController');
// --information list--//
Route::get('informations_lists', 'InformationController@lists');
// -- list photo information --//
Route::post('lists-photo-information', 'InformationController@lists_photo');
// --delete photo information --//
Route::post('delete-photo-information', 'InformationController@delete_photo');
//---move information---//
Route::post('move-information', 'InformationController@move_information');
// ----posts----//
Route::resource('post', 'PostController');
// --post list--//
Route::get('posts_lists', 'PostController@lists');
// -- list photo post --//
Route::post('lists-photo-post', 'PostController@lists_photo');
// --delete photo post --//
Route::post('delete-photo-post', 'PostController@delete_photo');
//---move post---//
Route::post('move-post', 'PostController@move_post');
// ----menu ----//
Route::resource('menu', 'MenuController');
// --menu lists--//
Route::get('menu_lists', 'MenuController@lists');
// --move menu-- //
Route::post('move-menu', 'MenuController@move_menu');
// --update status-- //
Route::post('up-status-menu', 'MenuController@up_status');
// -- list photo menu --//
Route::post('lists-photo-menu', 'MenuController@lists_photo');
// --delete photo menu --//
Route::post('delete-photo-menu', 'MenuController@delete_photo');
// ----menu ----//
Route::resource('menu-footer', 'FooterController');
// --menu lists--//
Route::get('menu_footer_lists', 'FooterController@lists');
// --move menu-- //
Route::post('move-menu-footer', 'FooterController@move_menu');
// --update status-- //
Route::post('up-status-footer', 'FooterController@up_status');
// ----events----//
Route::resource('event', 'EventController');
// --event list--//
Route::get('events_lists', 'EventController@lists');
// -- list photo event --//
Route::post('lists-photo-event', 'EventController@lists_photo');
// --delete photo event --//
Route::post('delete-photo-event', 'EventController@delete_photo');
//---move event---//
Route::post('move-event', 'EventController@move_event');
// ----projects----//
Route::resource('project', 'ProjectController');
// --project list--//
Route::get('projects_lists', 'ProjectController@lists');
// -- list photo project --//
Route::post('lists-photo-project', 'ProjectController@lists_photo');
// --delete photo project --//
Route::post('delete-photo-project', 'ProjectController@delete_photo');
//---move project---//
Route::post('move-project', 'ProjectController@move_project');
// ----sections----//
Route::resource('section', 'SectionController');
// --section list--//
Route::get('sections_lists', 'SectionController@lists');
// -- list photo section --//
Route::post('lists-photo-section', 'SectionController@lists_photo');
// --delete photo section --//
Route::post('delete-photo-section', 'SectionController@delete_photo');
//---move section---//
Route::post('move-section', 'SectionController@move_section');
// ----banners----//
Route::resource('banner', 'BannerController');
// --banner list--//
Route::get('banners_lists', 'BannerController@lists');
// -- list photo banner --//
Route::post('lists-photo-banner', 'BannerController@lists_photo');
// --delete photo banner --//
Route::post('delete-photo-banner', 'BannerController@delete_photo');
//---move banner---//
Route::post('move-banner', 'BannerController@move_banner');
// ----documents----//
Route::resource('documents', 'DocumentsController');
// --document list--//
Route::get('documents_lists', 'DocumentsController@lists');
// -- list photo document --//
Route::post('lists-archive-document', 'DocumentsController@lists_archive');
// --delete photo document --//
Route::post('delete-archive-document', 'DocumentsController@delete_archive');
//---move document---//
Route::post('move-document', 'DocumentsController@move_document');
// ----faq----//
Route::resource('faq', 'FaqController');
// --faq list--//
Route::get('faq_lists', 'FaqController@lists');
//---move faq ---//
Route::post('move-faq', 'FaqController@move_faq');
//---types----//
Route::resource('types', 'TypesController');
// -- types hives lists--//
Route::get('types_lists', 'TypesController@lists');
//---move types ---//
Route::post('move-types', 'TypesController@move_types');
//---categories----//
Route::resource('categories', 'CategoriesController');
// -- categories hives lists--//
Route::get('categories_lists', 'CategoriesController@lists');
//---move categories ---//
Route::post('move-categories', 'CategoriesController@move_categories');
//---categories----//
Route::resource('event-categories', 'CategoriesEventController');
// -- categories hives lists--//
Route::get('categories_event_lists', 'CategoriesEventController@lists');
//---move categories ---//
Route::post('move-categories-event', 'CategoriesEventController@move_categories');
//---categories----//
Route::resource('information-categories', 'CategoriesInformationController');
// -- categories hives lists--//
Route::get('categories_information_lists', 'CategoriesInformationController@lists');
//---move categories ---//
Route::post('move-categories-information', 'CategoriesInformationController@move_categories');
//---categories----//
Route::resource('post-categories', 'CategoriesPostController');
// -- categories hives lists--//
Route::get('categories_post_lists', 'CategoriesPostController@lists');
//---move categories ---//
Route::post('move-categories-post', 'CategoriesPostController@move_categories');
//---categories----//
Route::resource('project-categories', 'CategoriesProjectController');
// -- categories hives lists--//
Route::get('categories_project_lists', 'CategoriesProjectController@lists');
//---move categories ---//
Route::post('move-categories-project', 'CategoriesProjectController@move_categories');
//---categories----//
Route::resource('job-categories', 'CategoriesJobController');
// -- categories hives lists--//
Route::get('categories_job_lists', 'CategoriesJobController@lists');
//---move categories ---//
Route::post('move-categories-job', 'CategoriesJobController@move_categories');


// ----mentors----//
Route::resource('mentor', 'MentorsController');
// --mentor list--//
Route::get('mentors_lists', 'MentorsController@lists');
// -- list photo mentor --//
Route::post('lists-photo-mentor', 'MentorsController@lists_photo');
// --delete photo mentor --//
Route::post('delete-photo-mentor', 'MentorsController@delete_photo');
//---move mentor---//
Route::post('move-mentor', 'MentorsController@move_mentor');

//---categories----//
Route::resource('mentors-categories', 'CategoriesMentorController');
// -- categories hives lists--//
Route::get('categories_mentors_lists', 'CategoriesMentorController@lists');
//---move categories ---//
Route::post('move-categories-mentors', 'CategoriesMentorController@move_categories');







//---members----//
Route::resource('members', 'MembersController');
// -- members hives lists--//
Route::get('members_lists', 'MembersController@lists');
//---move members ---//
Route::post('move-members', 'MembersController@move_members');
//---persons----//
Route::resource('persons', 'PersonController');
// -- persons hives lists--//
Route::get('persons_lists', 'PersonController@lists');
//---move persons ---//
Route::post('move-persons', 'PersonController@move_persons');
//---interes----//
Route::resource('interests', 'InterestController');
// -- interes hives lists--//
Route::get('interests_lists', 'InterestController@lists');
//---move interes ---//
Route::post('move-interests', 'InterestController@move_interests');
//---dedicated----//
Route::resource('dedicated', 'DedicatedController');
// -- dedicated hives lists--//
Route::get('dedicated_lists', 'DedicatedController@lists');
//---move dedicated ---//
Route::post('move-dedicated', 'DedicatedController@move_dedicated');
//---states----//
Route::resource('states', 'StateController');
// -- states hives lists--//
Route::get('states_lists', 'StateController@lists');
//---move estadios ---//
Route::post('move-states', 'StateController@move_states');
Route::get('presentations','PresentationsController@index');
Route::get('{id}/details-presentations','PresentationsController@show');
Route::get('list_presentations','PresentationsController@listing');
/************************ EXCEL ********************/
Route::get('excel/users/{ini}/{end}','ExcelController@users');
Route::get('excel/administrators/{ini}/{end}','ExcelController@administrators');
Route::get('excel/informations/{ini}/{end}','ExcelController@informations');
Route::get('excel/projects/{ini}/{end}','ExcelController@projects');
Route::get('excel/events/{ini}/{end}','ExcelController@events');
Route::get('excel/faqs/{ini}/{end}','ExcelController@faq');
Route::get('excel/posts/{ini}/{end}','ExcelController@posts');
Route::get('excel/messages/{ini}/{end}','ExcelController@messages');
Route::get('excel/presentations/{ini}/{end}','ExcelController@presentations');
Route::get('excel/audits/{user}/{ini}/{end}','ExcelController@activities');
//---comments ----//
Route::resource('comments', 'CommentsController');
Route::get('comments_lists', 'CommentsController@listing');
Route::get('list_comment/{id}','CommentsController@list_comment');



//---archives posts----//
Route::resource('posts-archives', 'PostArchivesController');
// -- archives posts lists--//
Route::get('posts_archives_lists/{id}', 'PostArchivesController@lists');

//---archives projects----//
Route::resource('projects-archives', 'ProjectArchivesController');
// -- archives projects lists--//
Route::get('projects_archives_lists/{id}', 'ProjectArchivesController@lists');

//---archives events----//
Route::resource('events-archives', 'EventArchivesController');
// -- archives events lists--//
Route::get('events_archives_lists/{id}', 'EventArchivesController@lists');

// ----widgets----//
Route::resource('widget', 'WidgetController');
// --widget list--//
Route::get('widgets_lists', 'WidgetController@lists');
// -- list photo widget --//
Route::post('lists-photo-widget', 'WidgetController@lists_photo');
// --delete photo widget --//
Route::post('delete-photo-widget', 'WidgetController@delete_photo');
//---move widget---//
Route::post('move-widget', 'WidgetController@move_widget');
Route::get('logging', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
//--home--//
Route::get('/','FrontendController@index');
Route::get('/en','FrontendController@index');
Route::get('/es','FrontendController@index');


$get_menu = DB::table('menus')->find(1);
if (isset($get_menu) != 0) {
	Route::get($get_menu->url,'FrontendController@projects');
	Route::get($get_menu->url_en,'FrontendController@projects');
}

$get_menu = DB::table('menus')->find(2);
if (isset($get_menu) != 0) {
	Route::get($get_menu->url,'FrontendController@news');
	Route::get($get_menu->url_en,'FrontendController@news');
	
}

$get_menu = DB::table('menus')->find(3);
if (isset($get_menu) != 0) {
	Route::get($get_menu->url,'FrontendController@diary');
	Route::get($get_menu->url_en,'FrontendController@diary');

}

$get_menu = DB::table('menus')->find(4);
if (isset($get_menu) != 0) {
	Route::get($get_menu->url,'FrontendController@mentor');
	Route::get($get_menu->url_en,'FrontendController@mentor');
}

$get_menu = DB::table('menus')->find(5);
if (isset($get_menu) != 0) {
	Route::get($get_menu->url,'FrontendController@contact');
Route::get($get_menu->url_en,'FrontendController@contact');

}

$get_menu = DB::table('menus')->find(6);
if (isset($get_menu) != 0) {
	Route::get($get_menu->url,'FrontendController@presentations');
    Route::get($get_menu->url_en,'FrontendController@presentations');
}

foreach(DB::table('projects')->get() as $rs):
	if($rs->url!=""):
		Route::get('es/proyectos/' . $rs->url . '', 'FrontendController@view_projects');
	endif;
	if($rs->url_en!=""):
		Route::get('en/projects/' . $rs->url_en . '', 'FrontendController@view_projects');
	endif;
endforeach;
foreach(DB::table('categories_project')->get() as $rs):
	if($rs->url!=""):
		Route::get('es/proyectos/' . $rs->url . '', 'FrontendController@categories_projects');
	endif;
	if($rs->url_en!=""):
		Route::get('en/projects/' . $rs->url_en . '', 'FrontendController@categories_projects');
	endif;
endforeach;





foreach(DB::table('categories_mentors')->get() as $rs):
	if($rs->url!=""):
		Route::get('es/mentores/' . $rs->url . '', 'FrontendController@categories_mentors');
	endif;
	if($rs->url_en!=""):
		Route::get('en/mentors/' . $rs->url_en . '', 'FrontendController@categories_mentors');
	endif;
endforeach;

Route::get('buscar','FrontendController@search');
Route::get('/en/search','FrontendController@search');
Route::get('/es/buscar','FrontendController@search');

foreach(DB::table('categories_event')->get() as $rs):
	if($rs->url!=""):
		Route::get('es/agenda/' . $rs->url . '', 'FrontendController@categories_diary');
	endif;
	if($rs->url_en!=""):
		Route::get('en/diary/' . $rs->url_en . '', 'FrontendController@categories_diary');
	endif;
endforeach;
foreach(DB::table('events')->get() as $rs):
	if($rs->url!=""):
		Route::get('es/agenda/' . $rs->url . '', 'FrontendController@view_diary');
	endif;
	if($rs->url_en!=""):
		Route::get('en/diary/' . $rs->url_en . '', 'FrontendController@view_diary');
	endif;
endforeach;

foreach(DB::table('posts')->get() as $rs):
	if($rs->url!=""):
		Route::get('es/noticias/' . $rs->url . '', 'FrontendController@view_news');
	endif;
	if($rs->url_en!=""):
		Route::get('en/news/' . $rs->url_en . '', 'FrontendController@view_news');
	endif;
endforeach;
foreach(DB::table('categories_post')->get() as $rs):
	if($rs->url!=""):
		Route::get('es/noticias/' . $rs->url . '', 'FrontendController@categories_news');
	endif;
	if($rs->url_en!=""):
		Route::get('en/news/' . $rs->url_en . '', 'FrontendController@categories_news');
	endif;
endforeach;






/********************API***************************/

Route::get('getEvents/{lang}','ApiEventsController@lists');
Route::get('getEventsByDate/{lang}/{id}/{date}','ApiEventsController@lists_date');
Route::get('getEventsByCategories/{lang}/{id}','ApiEventsController@lists_category');
Route::get('getEventsCategories/{lang}','ApiCategoriesEventsController@lists');


Route::get('getNews/{lang}','ApiNewsController@lists');
Route::get('getNewsByCategories/{lang}/{id}','ApiNewsController@lists_category');
Route::get('getNewsCategories/{lang}','ApiCategoriesNewsController@lists');


Route::get('getMentors/{lang}','ApiMentorsController@lists');
Route::get('getMentorsByCategories/{lang}/{id}','ApiMentorsController@lists_category');



Route::get('getProjects/{lang}','ApiProjectsController@lists');
Route::get('getProjectsByCategories/{lang}/{id}','ApiProjectsController@lists_category');
Route::get('getProjectsCategories/{lang}','ApiCategoriesProjectsController@lists');


Route::get('getFaq/{lang}','ApiFaqController@lists');


Route::get('getSearch/{lang}/{search}/{date}/{type}','ApiSearchController@lists');



Route::post('saveContact','ApiContactController@store');
Route::post('saveMailchimp','ApiMailchimpController@store');
Route::post('saveEmprendimiento','ApiPresentationsController@store');

Route::get('descarga/{id}','FrontendController@download');


Route::get('download/{id}','ApiDownloadController@download');
Route::get('descargar/{id}','ApiDownloadController@download');

Route::get('iniciar-sesion','FrontendController@login');
Route::get('cerrar-sesion','FrontendController@logout');