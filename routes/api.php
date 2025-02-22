<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MemberProjectController;

//Member Handlers
Route::post('/members', [MemberController::class, 'addMember']);
Route::put('/updateM/{id}', [MemberController::class, 'updateMember']);
Route::delete('/deleteM', [MemberController::class, 'deleteMember']);

//Project Handlers
Route::post('/projects', [ProjectController::class, 'addProject']);
Route::put('/updateP/{id}', [ProjectController::class, 'updateProject']);
Route::delete('/deleteP', [ProjectController::class, 'deleteProject']);

//Member_Projects Handlers
Route::post('/assignMP', [MemberProjectController::class, 'assign']);
Route::delete('/removeMP',[MemberProjectController::class, 'remove']);
Route::get('/project/{id}/members', [MemberProjectController::class, 'getProjectMembers']);
Route::get('/member/{id}/projects', [MemberProjectController::class, 'getMemberProjects']);
  