<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\DiscussionController;
use App\Http\Controllers\UserController;

Route::get('/', [FrontendController::class,'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::middleware(['auth','canAccessDashboard'])->group(function () {
   


 Route::get('dashboard/home',[DashboardController::class,'home'])->name('dashboard.home');

 

 // Categories
 Route::get('dashboard/category/new',[CategoryController::class,'create'])->name('category.new');
 Route::post('dashboard/category/new',[CategoryController::class,'store'])->name('category.store');
 Route::get('dashboard/categories',[CategoryController::class,'index'])->name('categories');
 Route::get('dashboard/categories/{id}',[CategoryController::class,'show'])->name('category.single');

 Route::get('dashboard/categories/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
 Route::get('dashboard/categories/delete/{id}',[CategoryController::class,'delete'])->name('category.delete');
 Route::put('dashboard/categories/{category}',[CategoryController::class,'update'])->name('category.update');


 //Forums
 Route::get('dashboard/forum/new',[ForumController::class,'create'])->name('forum.new');
 Route::post('dashboard/forum/new',[ForumController::class,'store'])->name('forum.store');
 Route::get('dashboard/forums',[ForumController::class,'index'])->name('forums');

 Route::get('dashboard/forums/{id}',[ForumController::class,'show'])->name('forum.single');
 Route::get('dashboard/forums/edit/{forum}',[ForumController::class,'edit'])->name('forum.edit');
 Route::get('dashboard/forums/delete/{id}',[ForumController::class,'delete'])->name('forum.delete');
 Route::put('dashboard/forums/{category}',[ForumController::class,'update'])->name('forum.update');

// Users
Route::get('/dashboard/users',[DashboardController::class,'users'])->name('users');
 Route::get('/dashboard/users/{id}',[DashboardController::class,'show'])->name('user.show');
 Route::delete('dashboard/users/{id}',[DashboardController::class,'destroy'])->name('user.delete');

});

 //Topics
 Route::get('client/topic/new/{id}',[DiscussionController::class,'create'])->name('topic.new');
 Route::post('client/topic/new',[DiscussionController::class,'store'])->name('topic.store');
 Route::get('client/topic/{id}',[DiscussionController::class,'show'])->name('topic');
 Route::post('client/topic/reply/{id}',[DiscussionController::class,'reply'])->name('topic.reply');
 Route::post('client/topic/delete/{id}',[DiscussionController::class,'remove'])->name('topic.delete');
 Route::post('topic/reply/delete/{id}',[DiscussionController::class,'destroy'])->name('reply.delete');
 Route::get('/c-overview/{id}',[FrontendController::class,'categoryOverView'])->name('client.category');
 Route::get('/forum/overview/{id}', [FrontendController::class,'forumOverView'])->name('forum.overview');
 //Telegram

 Route::get('/updates',[DiscussionController::class,'updates']);
 Route::put('user/update/{id}',[UserController::class,'update'])->name('user.update');
 Route::get('/dashboard/notification',[DashboardController::class,'notifications'])->name('notifications');
 Route::get('/dashboard/notification/mark-as-read/{id}',[DashboardController::class,'markAsRead'])->name('notification.read');
 Route::get('/dashboard/notification/delete/{id}',[DashboardController::class,'notificationDelete'])->name('notification.delete');
 Route::get('/dashboard/settings/form',[DashboardController::class,'settingsForm'])->name('settings.form');
 Route::post('/dashboard/settings/new',[DashboardController::class,'newSetting'])->name('settings.new');

 Route::get('/client/user/{id}',[FrontendController::class,'profile'])->name('client.user.profile');
 Route::get('/client/users',[FrontendController::class,'users'])->name('client.users');
 Route::post('/user/photo/update/{id}',[FrontendController::class,'photoUpdate'])->name('user.photo.update');

 Route::get('reply/like/{id}',[DiscussionController::class,'like'])->name('reply.like');
 Route::get('reply/dislike/{id}',[DiscussionController::class,'dislike'])->name('reply.dislike');
 Route::post('category/search',[CategoryController::class,'search'])->name('category.search');