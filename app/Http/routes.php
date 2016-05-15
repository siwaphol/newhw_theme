<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//this route actually accept first incoming request
Route::get('/', 'WelcomeController@index');

Route::get('teststylus', 'WelcomeController@testStylus');

Route::get('home', 'HomeController@firstpage');
Route::get('info', 'HomeController@info');
Route::post('semester', 'HomeController@semester');
Route::get('index', 'HomeController@firstpage');
Route::get('index/preview', 'HomeController@preview');

// Automate First Time Wizard
Route::get('first_time_wizard', 'AutomateController@firstTimeWizard');

//upload section
Route::post('index/uploadFiles', 'CourseHomeworkController@uploadFiles');

//physical homework (In progress)
Route::get('testexcel','ExcelFileController@index');

//Route::get('course/{course_id}', 'CourseHomeworkController@show');

//homework management section
Route::get('coursehomeworkdata/{course_id}', 'CourseHomeworkController@getHomeworkCreateData');
Route::get('homework/create/{course_id}','CourseHomeworkController@homeworkCreate');
Route::get('homework/create2/{course_id}','CourseHomeworkController@create2');
Route::post('homework/create','CourseHomeworkController@homeworkPostCreate');
Route::get('homework/result','CourseHomeworkController@result' );
Route::get('assignment/create/{course_id}', 'CourseHomeworkController@createAssignment');
Route::post('assignment', 'CourseHomeworkController@store');

//homework
Route::post('index/homework/editstatus','Homework1Controller@editstatus');
Route::get('homework','Homework1Controller@index');
Route::delete('homework/delete/{id}','Homework1Controller@destroy');
Route::get('homework/show/{id}','Homework1Controller@show');


//teacher management zone
Route::get('teachers',['as'=>'teachers',
    'uses'=>'TeachersController@index']);
//Route::get('teachers','TeachersController@index');

Route::get('homework/downloadhomework','Homework1Controller@exportzip');

Route::post('homework/create/save','Homework1Controller@store');
Route::patch('homework/update/{id}','Homework1Controller@update');
Route::post('homework/showlist','Homework1Controller@showlist');
Route::get('homework/{id}/edit','Homework1Controller@edit');
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
Route::post('test-post-homework','Homework1Controller@testPost');

Route::get('assign', 'HomeController@assign');
Route::get('course_section/auto', 'Course_SectionController@auto');
Route::get('course', 'CourseController@index');
Route::get('course/create', 'CourseController@create');
Route::post('course/create/save', 'CourseController@addcourse');
Route::get('edit/{id}', 'CourseController@edit');
Route::get('delete/{id}', 'CourseController@delete');

Route::get('course_section', 'Course_SectionController@index');
Route::get('course_section/create', 'Course_SectionController@create');
Route::get('course_section/delete/', 'Course_SectionController@delete');
Route::post('course_section/create/save', 'Course_SectionController@store');
Route::get('course_section/edit/', 'Course_SectionController@edit');
Route::post('course_section/update/','Course_sectionController@update');
Route::get('course_section/selectcreate/', 'Course_SectionController@selectcreate');
Route::post('course_section/createteacher', 'Course_SectionController@createteacher');
Route::post('course_section/createteacher/save', 'Course_SectionController@saveteacher');

Route::post('course_section/check/', 'Course_SectionController@check');

Route::get('test/lis','HomeController@lis');
Route::get('teachers/create','TeachersController@create');
Route::get('teachers/{id}/edit','TeachersController@edit');
Route::get('teachers/show/{id}','TeachersController@show');
Route::post('teachers/delete/{id}','TeachersController@destroy');
Route::post('course','CourseController@addcourse');
Route::post('course/saveedit','CourseController@saveedit');

Route::post('test1', 'HomeController@test1');
Route::post('test2', 'HomeController@test2');
Route::post('teachers/update','TeachersController@update');
Route::post('teachers/create/save','TeachersController@store');

//admin
Route::get('admin',
    ['as'=>'admin',
    'uses'=>'AdminController@managementPage']);
Route::post('admin','AdminController@managementPageWithSearchResult');
Route::post('admin/add', 'AdminController@addAdmin');
Route::post('admin/delete', 'AdminController@deleteAdmin');
//Route::delete('admin/delete/{id}','AdminController@destroy');
//Route::get('admin/show/{id}','AdminController@show');
//Route::get('admin/create','AdminController@create');
//Route::get('admin/assign','AdminController@assign');
//Route::post('admin/assign/save','AdminController@saveassign');
//Route::get('admin/{id}/edit','AdminController@edit');
//Route::post('admin/create/save','AdminController@store');
//Route::post('admin/update/','AdminController@update');

//ta
Route::get('ta','TasController@index');
Route::delete('ta/delete/{id}','TasController@destroy');
Route::get('ta/show/{id}','TasController@show');
Route::get('ta/create','TasController@create');
Route::get('ta/{id}/edit','TasController@edit');
Route::post('ta/create/save','TasController@store');
Route::patch('ta/update/{id}','TasController@update');

//student
Route::get('students','StudentsController@index');
Route::post('students/delete','StudentsController@destroy');
Route::get('students/show','StudentsController@show');
Route::get('students/create/{id}','StudentsController@create');
Route::get('students/edit/{id}','StudentsController@edit');
Route::get('students/export','StudentsController@export');
Route::post('students/create/save','StudentsController@store');
Route::post('students/showlist','StudentsController@showlist');
Route::post('students/update/','StudentsController@update');
//import student
Route::get('students/import','StudentsController@import');
Route::get('students/insert','StudentsController@insert');
Route::get('students/manualimport','StudentsController@manualimport');
Route::post('students/manualinsert','StudentsController@manualinsert');
Route::get('students/autoimport','StudentsController@autoimport');
Route::get('students/selectexcel','StudentsController@selectexcel');
Route::get('students/auto_import_ajax','StudentsController@auto_import_ajax');

//homework_assignment
//Route::get('homework_assignment','Homework_assignmentController@index');
//Route::delete('homework_assignment/delete/{id}','Homework_assignmentController@destroy');
//Route::get('homework_assignment/show/{id}','Homework_assignmentController@show');
//Route::get('homework_assignment/create/{id}','Homework_assignmentController@create');
//Route::get('homework_assignment/{id}/edit','Homework_assignmentController@edit');
//Route::post('homework_assignment/create/save','Homework_assignmentController@store');
//Route::patch('homework_assignment/update/{id}','Homework_assignmentController@update');
//Route::post('homework_assignment/showlist','Homework_assignmentController@showlist');

//assistant
Route::get('assistants','AssistantsController@index');
Route::post('assistants/delete/','AssistantsController@destroy');
Route::get('assistants/show/{id}','AssistantsController@show');
Route::get('assistants/create','AssistantsController@create');
Route::get('assistants/edit','AssistantsController@edit');
Route::post('assistants/create/save','AssistantsController@store');
Route::post('assistants/update','AssistantsController@update');
Route::get('assistants/showlist','AssistantsController@showlist');
//semester year
Route::get('semesteryear','SemesteryearController@index');
Route::delete('semesteryear/delete/{id}','SemesteryearController@destroy');
Route::get('semesteryear/show/{id}','SemesteryearController@show');
Route::get('semesteryear/create','SemesteryearController@create');
Route::get('semesteryear/{id}/edit','SemesteryearController@edit');
Route::post('semesteryear/create/save','SemesteryearController@store');
Route::patch('semesteryear/update/{id}','SemesteryearController@update');
Route::post('semesteryear/showlist','SemesteryearController@showlist');

Route::group(array('prefix' => 'api/v1'),function()
{
    Route::get('semesters_and_years','SemesteryearController@getAll');
    Route::post('semesters_and_years/edit','SemesteryearController@updateSemesterAndYear');

    Route::get('auto_ajax1', 'Course_SectionController@auto_ajax1');
    Route::post('auto_ajax2', 'Course_SectionController@auto_ajax2');

    Route::get('get_students_xlsx/{semester}/{year}', 'StudentsController@getStudentsXLSX');

    // Route::get('download_xlsx/{semester}/{year}','StudentsController@downloadAllExcelForCourseSection');
    Route::get('user', 'UserController@index');
    Route::post('admin/{id}', 'UserController@update');
});

