<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Login;
use App\Http\Controllers\RolePermission;
use App\Http\Controllers\ManageAssets;
use App\Http\Controllers\manage_client\ManageClient;
use App\Http\Controllers\ManageResources;
use App\Http\Controllers\ManageInventory;
use App\Http\Controllers\ManageProcedure;
use App\Http\Controllers\ManageWorkOrder;
use App\Http\Controllers\ToolsAndEquipment;
use App\Http\Controllers\settings\GeneralSettings;
use App\Http\Controllers\settings\Sector;
use App\Http\Controllers\settings\Plant;
use App\Http\Controllers\settings\Room;

// Main Menu Starts 


Route::get('/manage_asset', [ManageAssets::class, 'index'])->name('asset');
Route::get('/manage_client', [ManageClient::class, 'index'])->name('client');
Route::get('/manage_resources', [ManageResources::class, 'index'])->name('resources');

Route::get('/resource_availability', [ManageResources::class, 'availability_list'])->name('resources');
Route::get('/manage_inventory', [ManageInventory::class, 'index'])->name('inventory');
Route::get('/manage_inventory_valve', [ManageInventory::class, 'valve'])->name('inventory');
Route::get('/manage_inventory_spare_parts', [ManageInventory::class, 'spare_part'])->name('inventory');
Route::get('/manage_inventory_calibration', [ManageInventory::class, 'calibration'])->name('inventory');
Route::get('/store_management', [ManageInventory::class, 'store'])->name('inventory');
Route::get('/manage_procedure', [ManageProcedure::class, 'index'])->name('procedure');
Route::get('/manage_work_order', [ManageWorkOrder::class, 'index'])->name('work-order');
Route::get('manage_work_order/calendar_view', [ManageWorkOrder::class, 'calendar_list'])->name('work-order');
Route::get('/manage_tools_equipments', [ToolsAndEquipment::class, 'index'])->name('tool-equipment');
Route::get('/manage_vehicle', [ToolsAndEquipment::class, 'vehicle_list'])->name('tool-equipment');

// Main Menu End

// Settings Menu Starts
Route::get('/settings/general_settings', [GeneralSettings::class, 'index'])->name('settings-general-settings');
Route::get('/settings/sector', [Sector::class, 'index'])->name('settings-sector');
Route::get('/settings/plant', [Plant::class, 'index'])->name('settings-plant');
Route::get('/settings/room', [Room::class, 'index'])->name('settings-room');
// Settings Menu End


// Main Page Route
Route::get('/', [Login::class, 'index'])->name('login');
Route::post('/otp_screen', [Login::class, 'get_otp'])->name('otp_screen');
Route::post('/send-otp', [Login::class, 'sendOtp']);
Route::post('/verify-otp', [Login::class, 'verifyOtp']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboards', [Login::class, 'dashboards'])->name('dashboards');
    Route::get('/client_dashboard', [Login::class, 'client_dashboard'])->name('client-dashboard');
    Route::get('/manage_resources', [ManageResources::class, 'index'])->name('resources');
    Route::post('/resources/store', [ManageResources::class, 'store'])->name('resources.store');
    Route::post('/resources/update/{id}', [ManageResources::class, 'update'])->name('resources.update');
    Route::get('/resources/show/{id}', [ManageResources::class, 'show']);
    Route::delete('/resources/delete/{id}', [ManageResources::class, 'destroy'])->name('resources.delete');

    Route::post('/resources/bulk-upload', [ManageResources::class, 'bulkUpload'])
        ->name('resources.bulkUpload');

    Route::post('/assets/store', [ManageAssets::class, 'store'])->name('assets.store');
    Route::post('/assets/bulk-upload', [ManageAssets::class, 'bulkUpload'])->name('assets.bulkUpload');
    Route::get('/assets/download-sample', [ManageAssets::class, 'downloadSample'])->name('assets.downloadSample');
    Route::get('/assets/show/{id}', [ManageAssets::class, 'show'])->name('assets.show');
    Route::post('/assets/update/{id}', [ManageAssets::class, 'update'])->name('assets.update');

    Route::get('/manage_procedures', [ManageProcedure::class, 'index'])->name('procedures');
    Route::post('/procedures/store', [ManageProcedure::class, 'store'])->name('procedures.store');
    Route::get('/procedures/show/{id}', [ManageProcedure::class, 'show'])->name('procedures.show');
    Route::post('/procedures/update/{id}', [ManageProcedure::class, 'update'])->name('procedures.update');

    Route::get('/download-sample', function () {
        return response()->download(
            resource_path('sample/resource_bulk_sample.xlsx')
        );
    });
    Route::get('/roles_permissions', [RolePermission::class, 'index'])->name('role-permission');
    Route::post('/roles/store', [RolePermission::class, 'store'])->name('roles.store');
    Route::post('/permissions/update', [RolePermission::class, 'update'])->name('permissions.update');
    Route::post('/roles/update', [RolePermission::class, 'Roleupdate'])->name('roles.update');
    Route::post('/roles/delete', [RolePermission::class, 'destroy'])->name('roles.delete');

    Route::get('/manage_team', [ManageResources::class, 'team_list'])->name('teams.list');
    // API endpoint for Select2 to load users
    Route::get('/api/users', [ManageResources::class, 'getUsers'])
        ->name('api.users');

    // Store team (POST)
    Route::post('/teams/store', [ManageResources::class, 'storeTeam'])
        ->name('teams.store');
    Route::post('/teams/update/{id}', [ManageResources::class, 'team_update'])->name('teams.update');
    Route::get('/teams/show/{id}', [ManageResources::class, 'team_show']);
    Route::delete('/teams/delete/{id}', [ManageResources::class, 'team_delete']);
});