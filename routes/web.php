<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SectionController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{id}', [CourseController::class, 'show']);
Route::get('sections', [SectionController::class, 'index']);
Route::get('sections/{id}', [SectionController::class, 'show']);

Route::prefix('teachers')->middleware('role:teacher')->group(function () {
    Route::post('courses', [CourseController::class, 'store']);
    Route::put('courses/{id}', [CourseController::class, 'update']);
    Route::delete('courses/{id}', [CourseController::class, 'destroy']);
    Route::post('sections', [SectionController::class, 'store']);
    Route::put('sections/{id}', [SectionController::class, 'update']);
    Route::delete('sections/{id}', [SectionController::class, 'destroy']);

});
