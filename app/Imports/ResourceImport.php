<?php

namespace App\Imports;

use App\Models\ResourceModel;

class ResourceImport
{
    public function importRow($row)
    {
        // =========================
        // 1. CREATE RESOURCE
        // =========================
        $resource = new ResourceModel();

        $resource->name = $row[0] ?? null;
        $resource->mobile_number = $row[1] ?? null;
        $resource->email = $row[2] ?? null;
        $resource->role_id = $row[3] ?? null;
        $resource->status = $row[4] ?? null;
        $resource->address = $row[5] ?? null;

        // =========================
        // 2. CERTIFICATES (ARRAY STYLE LIKE YOUR CODE)
        // =========================
        $certificates = [];

        $certNames = explode(',', $row[6] ?? '');
        $certDates = explode(',', $row[7] ?? '');
        $certFiles = explode(',', $row[8] ?? '');

        foreach ($certNames as $key => $docName) {

            if (!$docName) continue;

            $filePath = null;

            if (!empty($certFiles[$key])) {
                $filePath = 'resources/docs/' . $certFiles[$key];
            }

            $certificates[] = [
                'name' => $docName,
                'validity_date' => $certDates[$key] ?? null,
                'file' => $filePath,
            ];
        }

        $resource->certificates = $certificates;
        $resource->permits = [];

        $resource->save();

        return $resource;
    }
}