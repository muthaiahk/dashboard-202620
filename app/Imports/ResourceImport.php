<?php

namespace App\Imports;

use App\Models\ResourceModel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ResourceImport implements ToCollection
{
    protected $created = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // Skip header row
            if ($index === 0) continue;

            // ✅ ROLE VALIDATION
            if (!Role::find($row[3])) {
                throw new \Exception("Invalid role_id '{$row[3]}' at row " . ($index + 1));
            }

            // ✅ MOBILE VALIDATION
            if (User::where('mobile_number', $row[1])->exists()) {
                throw new \Exception("Mobile number '{$row[1]}' already registered for another user at row " . ($index + 1));
            }

            // =========================
            // CREATE RESOURCE
            // =========================
            $resource = new ResourceModel();

            $resource->name = $row[0] ?? null;
            $resource->mobile_number = $row[1] ?? null;
            $resource->email = $row[2] ?? null;
            $resource->role_id = $row[3] ?? null;
            $resource->status = $row[4] ?? null;
            $resource->address = $row[5] ?? null;

            // =========================
            // CERTIFICATES
            // =========================
            $certificates = [];

            $certNames = explode(',', $row[6] ?? '');
            $certDates = explode(',', $row[7] ?? '');
            $certFiles = explode(',', $row[8] ?? '');

            foreach ($certNames as $key => $docName) {

                if (!$docName) continue;

                $filePath = !empty($certFiles[$key])
                    ? 'resources/docs/' . $certFiles[$key]
                    : null;

                $certificates[] = [
                    'name' => $docName,
                    'validity_date' => $certDates[$key] ?? null,
                    'file' => $filePath,
                ];
            }

            $resource->certificates = $certificates;
            $resource->permits = [];

            $resource->save();

            // =========================
            // SYNC WITH USER TABLE
            // =========================
            User::updateOrCreate(
                ['mobile_number' => $row[1] ?? null],
                [
                    'name' => $row[0] ?? null,
                    'role_id' => $row[3] ?? null,
                    'status' => $row[4] ?? null,
                    'address' => $row[5] ?? null,
                ]
            );

            $this->created++;
        }
    }

    public function getCreatedCount()
    {
        return $this->created;
    }
}