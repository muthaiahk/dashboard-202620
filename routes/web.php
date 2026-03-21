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
use App\Http\Controllers\settings\common\Country;
use App\Http\Controllers\settings\common\State;
use App\Http\Controllers\settings\common\City;
use App\Http\Controllers\EquipmentMaintenanceController;

// Main Menu Starts 


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
Route::post('/manage_work_order/store', [ManageWorkOrder::class, 'store'])->name('work-order.store');
Route::get('/manage_work_order/show/{id}', [ManageWorkOrder::class, 'show'])->name('work-order.show');
Route::post('/manage_work_order/update/{id}', [ManageWorkOrder::class, 'update'])->name('work-order.update');
Route::post('/manage_work_order/update_wizard/{id}', [ManageWorkOrder::class, 'updateWizard'])->name('work-order.updateWizard');
Route::delete('/manage_work_order/delete/{id}', [ManageWorkOrder::class, 'destroy'])->name('work-order.delete');
Route::get('/manage_tools_equipments', [ToolsAndEquipment::class, 'index'])->name('tool-equipment');


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

    Route::get('/manage_asset', [ManageAssets::class, 'index'])->name('asset');
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
    Route::post('/equipments', [ToolsAndEquipment::class, 'store'])->name('equipments.store');
    Route::post('/update-equipment', [ToolsAndEquipment::class, 'update']);


    Route::get('/settings/general_settings', [GeneralSettings::class, 'index'])->name('settings-general-settings');
    Route::match(['get', 'post'], '/settings/general_settings/add', [GeneralSettings::class, 'Add'])->name('general_settings_add');

    Route::get('/settings/sector', [Sector::class, 'index'])->name('settings-sector');
    Route::post('/settings/sector/add_sector', [Sector::class, 'add']);
    Route::get('/settings/sector/edit_sector/{id}', [Sector::class, 'edit']);
    Route::post('/settings/sector/update_sector', [Sector::class, 'update']);
    Route::post('/settings/sector/sector_status/{id}', [Sector::class, 'status']);
    Route::delete('/settings/sector/delete_sector/{id}', [Sector::class, 'delete']);
    Route::match(['get', 'post'], '/settings/sector/sector_list', [Sector::class, 'list']);

    Route::get('/settings/plant', [Plant::class, 'index'])->name('settings-plant');
    Route::post('/settings/plant/add_plant', [Plant::class, 'add']);
    Route::get('/settings/plant/edit_plant/{id}', [Plant::class, 'edit']);
    Route::post('/settings/plant/update_plant', [Plant::class, 'update']);
    Route::post('/settings/plant/plant_status/{id}', [Plant::class, 'status']);
    Route::delete('/settings/plant/delete_plant/{id}', [Plant::class, 'delete']);
    Route::match(['get', 'post'], '/settings/plant/plant_list', [Plant::class, 'list']);

    Route::get('/settings/room', [Room::class, 'index'])->name('settings-room');
    Route::post('/settings/room/add_room', [Room::class, 'add']);
    Route::get('/settings/room/edit_room/{id}', [Room::class, 'edit']);
    Route::post('/settings/room/update_room', [Room::class, 'update']);
    Route::post('/settings/room/room_status/{id}', [Room::class, 'status']);
    Route::delete('/settings/room/delete_room/{id}', [Room::class, 'delete']);
    Route::match(['get', 'post'], '/settings/room/room_list', [Room::class, 'list']);

    Route::match(['get', 'post'], '/settings/country/list', [Country::class, 'List']);
    Route::match(['get', 'post'], '/settings/state/list', [State::class, 'List']);
    Route::match(['get', 'post'], '/settings/city/list', [City::class, 'List']);


    Route::get('/manage_vehicle', [ToolsAndEquipment::class, 'vehicle_list'])->name('tool-equipment');
    Route::post('/vehicles/store', [ToolsAndEquipment::class, 'store_vehicle'])->name('vehicles.store');
    Route::post('/update-vehicle/{id}', [ToolsAndEquipment::class, 'update_vehicle']);
    Route::post('/maintenance/add', [EquipmentMaintenanceController::class, 'store'])->name('maintenance.add');
    Route::get('/maintenance/list/{equipment}', [EquipmentMaintenanceController::class, 'list'])->name('maintenance.list');
    Route::post('/vehicle/maintenance/add', [EquipmentMaintenanceController::class, 'addMaintenance']);
    Route::get('/vehicle/maintenance/{id}', [EquipmentMaintenanceController::class, 'getMaintenance']);

    Route::get('/manage_client', [ManageClient::class, 'index'])->name('client');
    Route::post('/manage_client/add_client', [ManageClient::class, 'Add'])->name('add_manage_client');
    Route::match(['get', 'post'], '/manage_client/edit_client/{id}', [ManageClient::class, 'Edit']);
    Route::post('/manage_client/update_client', [ManageClient::class, 'Update'])->name('update_manage_client');
    Route::delete('/manage_client/delete_client/{id}', [ManageClient::class, 'Delete']);
});