<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Role;

$s = new Spreadsheet();
$sheet = $s->getActiveSheet();
$sheet->setCellValue('A1', 'name');
$sheet->setCellValue('B1', 'mobile_number');
$sheet->setCellValue('C1', 'email');
$sheet->setCellValue('D1', 'role_id');
$sheet->setCellValue('E1', 'status');
$sheet->setCellValue('F1', 'address');

$sheet->setCellValue('A2', 'Bulk Test User');
$sheet->setCellValue('B2', '0987654321');
$sheet->setCellValue('C2', 'bulktest@example.com');

$role = Role::first();
$sheet->setCellValue('D2', $role ? $role->id : 1);
$sheet->setCellValue('E2', 1);
$sheet->setCellValue('F2', '456 Excel Ave');

$writer = new Xlsx($s);
$writer->save(public_path('dummy_resources.xlsx'));
echo 'Saved to public/dummy_resources.xlsx';
