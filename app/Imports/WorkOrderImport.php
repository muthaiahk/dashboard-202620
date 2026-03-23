<?php

namespace App\Imports;

use App\Models\WorkOrder;
use App\Models\Asset;
use App\Models\Client;
use App\Models\Procedure;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WorkOrderImport implements ToCollection, WithHeadingRow
{
    protected $created = 0;
    protected $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Row index in Excel (heading is 1, data starts at 2)
            $excelRow = $index + 2;

            // Skip empty rows (must at least have a title)
            if (empty(trim($row['title'] ?? ''))) continue;

            try {
                // Resolve Asset by Tag Number
                $assetTag = trim($row['asset_tag'] ?? '');
                $asset = Asset::where('tag_number', $assetTag)->first();
                if (!$asset && !empty($assetTag)) {
                    $this->errors[] = "Row {$excelRow}: Asset Tag '{$assetTag}' not found.";
                    continue;
                }

                // Resolve Client by Company Name
                $clientName = trim($row['client_name'] ?? '');
                $client = Client::where('company_name', 'like', '%' . $clientName . '%')->first();
                if (!$client && !empty($clientName)) {
                    $this->errors[] = "Row {$excelRow}: Client '{$clientName}' not found.";
                    continue;
                }

                // Resolve Procedure by Title
                $procedureTitle = trim($row['procedure_title'] ?? '');
                $procedure = Procedure::where('title', 'like', '%' . $procedureTitle . '%')->first();
                if (!$procedure && !empty($procedureTitle)) {
                    $this->errors[] = "Row {$excelRow}: Procedure '{$procedureTitle}' not found.";
                    continue;
                }

                // Prepare Data
                $data = [
                    'title'                  => trim($row['title']),
                    'asset_id'               => $asset ? $asset->id : null,
                    'client_id'              => $client ? $client->id : null,
                    'procedure_id'           => $procedure ? $procedure->id : null,
                    'status'                 => trim($row['status'] ?? 'pending'),
                    'order_type'             => trim($row['order_type'] ?? ''),
                    'priority'               => trim($row['priority'] ?? 'Medium'),
                    'scheduled_date'         => $this->transformDate($row['scheduled_date'] ?? null),
                    'compliance_date'        => $this->transformDate($row['compliance_date'] ?? null),
                    'assigned_date'          => $this->transformDate($row['assigned_date'] ?? null),
                    'tentative_removal_date' => $this->transformDate($row['tentative_removal_date'] ?? null),
                    'description'            => trim($row['description'] ?? ''),
                    'abc_ind'                => trim($row['abc_indicator'] ?? $row['abc_ind'] ?? ''),
                    'scheduling_grp'         => trim($row['scheduling_group'] ?? $row['scheduling_grp'] ?? ''),
                    'haz_area'               => trim($row['hazard_area'] ?? $row['haz_area'] ?? ''),
                    'act_type'               => trim($row['activity_type'] ?? $row['act_type'] ?? ''),
                    'cnfn_no'                => trim($row['confinement_no'] ?? $row['cnfn_no'] ?? ''),
                    'no_men'                 => trim($row['number_of_men'] ?? $row['no_men'] ?? ''),
                    'dur_hrs'                => trim($row['duration_hours'] ?? $row['dur_hrs'] ?? ''),
                    'st_txt_key'             => trim($row['standard_text_key'] ?? $row['st_txt_key'] ?? ''),
                    'oper_no'                => trim($row['operation_no'] ?? $row['oper_no'] ?? ''),
                    'catalog_profile'        => trim($row['catalog_profile'] ?? ''),
                    'om_manual_doc_no'       => trim($row['om_manual_no'] ?? $row['om_manual_doc_no'] ?? ''),
                    'material_no_desc'       => trim($row['material_description'] ?? $row['material_no_desc'] ?? ''),
                    'recurrence'             => trim($row['recurrence'] ?? ''),
                    'scaff_crane'            => trim($row['scaff_crane'] ?? ''),
                    'wizard_current_step'    => 0,
                    'wizard_status'          => 'pending',
                ];

                // Create Work Order
                WorkOrder::create($data);

                $this->created++;

            } catch (\Exception $e) {
                Log::error("Bulk Upload Error at row {$excelRow}: " . $e->getMessage());
                $this->errors[] = "Row {$excelRow}: " . $e->getMessage();
            }
        }
    }

    private function transformDate($value)
    {
        if (empty($value)) return null;
        
        try {
            // Handle numeric dates from Excel
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            // Handle strings
            return Carbon::parse(trim($value))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getCreatedCount()
    {
        return $this->created;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
