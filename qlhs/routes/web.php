<?php

use App\Http\Controllers\AuthenController;
use App\Http\Controllers\ClassessController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\GiaovienController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\studentGradeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenController::class, 'index'])->name('login');
Route::post('/login', [AuthenController::class, 'login']);
Route::get('/logout', [AuthenController::class, 'logout']);
Route::get('/registration', [AuthenController::class, 'registration']);
Route::post('/register', [AuthenController::class, 'register'])->name('register_user');

Route::get('/dashboard', [dashboardController::class, 'index'])->middleware('auth');
  Route::get('fetch-teachers', [GiaovienController::class, 'fetchteacher']);
  Route::get('danhsachgiaovien', [GiaovienController::class, 'index'])->middleware('auth');
  Route::post('/add-teacher', [GiaovienController::class, 'store']);
  Route::get('/edit-teacher/{id}', [GiaovienController::class, 'edit'])->middleware('auth');
  Route::put('/update-teacher/{id}', [GiaovienController::class, 'update']);
  Route::delete('/delete-teacher/{id}', [GiaovienController::class, 'destroy']);
  Route::get('/search_teacher', [GiaovienController::class, 'search']);


  Route::get('danhsachlop', [ClassessController::class, 'index'])->middleware('auth');
  Route::get('fetch-classes', [ClassessController::class, 'fetchclasses']);
  Route::post('add-classes', [ClassessController::class, 'store']);
  Route::get('/edit-classes/{id}', [ClassessController::class, 'edit'])->middleware('auth');
  Route::put('/update-classes/{id}', [ClassessController::class, 'update']);
  Route::get('/search_class', [ClassessController::class, 'search']);

  Route::get('/class_student/{id}', [ClassessController::class, 'detail']);
  Route::get('/fetch-student/{id}', [StudentController::class, 'fetchstudent'])->name('classStudent');
  Route::post('add-student/{id}', [StudentController::class, 'store']);
  Route::get('/edit-student/{class_id}/{id}', [StudentController::class, 'edit'])->middleware('auth');
  Route::put('/update-student/{id}', [StudentController::class, 'update']);
  Route::delete('/delete-student/{id}', [StudentController::class, 'destroy']);
  Route::get('/search_student/{id}', [StudentController::class, 'search']);
  Route::post('/upload_student/{id}', [StudentController::class, 'uploadStudent']);
  Route::get('/export_student/{id}', [StudentController::class, 'exportStudent']);

  Route::get('user', [UserController::class, 'index'])->middleware('auth');
  Route::get('fetch-user', [UserController::class, 'fetch_user']);

  Route::get('student_list', [studentGradeController::class, 'index'])->middleware('auth');
  Route::get('/fetch_studentgrade/{id}', [studentGradeController::class, 'fetchstudentgrade']);
  Route::get('/student_detail/{id}', [studentGradeController::class, 'student_detail']);
  Route::post('add-studentgrade/{id}', [studentGradeController::class, 'store']);
  Route::get('/edit-studentgrade/{class_id}/{student_id}/{id}', [studentGradeController::class, 'edit'])->middleware('auth');
  Route::put('/update-studentgrade/{student_id}/{id}', [studentGradeController::class, 'update']);
  Route::delete('/delete-studentgrade/{id}', [studentGradeController::class, 'destroy']);

  Route::post('add-hsktgrade/{id}', [studentGradeController::class, 'ktkl_store']);
  Route::get('/edit-hsktgrade/{class_id}/{student_id}/{id}', [studentGradeController::class, 'ktkl_edit'])->middleware('auth');
  Route::put('/update-hsktgrade/{student_id}/{id}', [studentGradeController::class, 'ktkl_update']);
  Route::delete('/delete-hsktgrade/{id}', [studentGradeController::class, 'ktkl_destroy']);
  Route::get('/search', [studentGradeController::class, 'search'])->name('search');
  Route::get('/search_grade/{id}', [studentGradeController::class, 'search_grade'])->name('search_grade');
  Route::get('/search_ktkl/{id}', [studentGradeController::class, 'search_ktkl']);

  Route::get('/dashboardClass', [dashboardController::class, 'class_index'])->middleware('auth');






