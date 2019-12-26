<?php

use App\Http\Controllers\BackendApi\Headquarters\Admin\BackendAdminUserController;
use App\Http\Controllers\BackendApi\Headquarters\BackendAuthController;

//登录
Route::post('login', [BackendAuthController::class, 'login'])
    ->name('headquarters-api.login');
//退出登录
Route::get('logout', [BackendAuthController::class, 'logout'])
    ->name('headquarters-api.logout');

//管理员相关
Route::group(
    ['prefix' => 'headquarters-admin-user', 'namespace' => 'Admin'],
    static function (): void {
        //生成管理员
        Route::post(
            'create',
            [BackendAdminUserController::class, 'create'],
        )->name('headquarters-api.headquarters-admin-user.create');
        //修改管理员的归属组
        Route::post(
            'update-admin-group',
            [BackendAdminUserController::class, 'updateAdminGroup'],
        )->name('headquarters-api.headquarters-admin-user.update-admin-group');
        //删除管理员
        Route::post(
            'delete-admin',
            [BackendAdminUserController::class, 'deleteAdmin'],
        )->name('headquarters-api.headquarters-admin-user.delete-admin');
        //修改管理员密码
        Route::post(
            'update-password',
            [BackendAdminUserController::class, 'updatePassword'],
        )->name('headquarters-api.headquarters-admin-user.update-password');
        //管理员自己修改密码
        Route::post(
            'self-update-password',
            [BackendAdminUserController::class, 'selfUpdatePassword'],
        )->name('headquarters-api.headquarters-admin-user.self-update-password');
        //模糊查询管理员
        Route::post(
            'search-admin',
            [BackendAdminUserController::class, 'searchAdmin'],
        )->name('headquarters-api.headquarters-admin-user.search-admin');
    },
);
