<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\File;

$s = new Spreadsheet();
$sheet = $s->getActiveSheet();

// Expected order of columns:
// name, tag_number, client_id, description, valve_type, actual_size, estimated_size, pressure_class, sector_id, plant_id, room_id, work_center, latitude, longitude, special_tools, scaff_crane

$headers = [
    'Customer Asset Name',
    'Asset Type/Tag',
    'Client ID (Optional)',
    'Description',
    'Valve Type',
    'Actual Size',
    'Estimated Size',
    'Pressure Class',
    'Sector ID (Optional)',
    'Plant ID (Optional)',
    'Room ID (Optional)',
    'Work Center',
    'Latitude',
    'Longitude',
    'Special Tools',
    'Scaffolding/Crane'
];

foreach ($headers as $colIndex => $header) {
    $sheet->setCellValueByColumnAndRow($colIndex + 1, 1, $header);
}

// Dummy Row
$row = [
    'Main Steam Control Valve', 
    'CV-1001', 
    '', // Client default empty
    'Regulates steam to main turbine',
    'Globe Valve',
    '8 Inch',
    '8.2 Inch',
    'Class 900',
    '', // Sector
    '', // Plant
    '', // Room
    'WC-Area-A',
    '25.3211',
    '55.1221',
    'Torque Wrench 500Nm',
    'Scaffolding + Crane'
];

foreach ($row as $colIndex => $val) {
    $sheet->setCellValueByColumnAndRow($colIndex + 1, 2, $val);
}

$writer = new Xlsx($s);
if (!File::isDirectory(resource_path('sample'))) {
    File::makeDirectory(resource_path('sample'), 0755, true);
}
$writer->save(resource_path('sample/asset_bulk_sample.xlsx'));
echo "Saved to " . resource_path('sample/asset_bulk_sample.xlsx');
