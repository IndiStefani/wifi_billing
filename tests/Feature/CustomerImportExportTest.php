<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class CustomerImportExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_import_supports_excel_files(): void
    {
        $user = User::factory()->create();
        $branch = Branch::create(['nama' => 'Cabang Demo', 'kode' => 'CD1']);
        $area = Area::create(['branch_id' => $branch->id, 'kode_area' => 'AD1', 'nama_area' => 'Area Demo', 'status' => 'active']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray([
            ['cust_code', 'branch_name', 'area_name', 'nama', 'email', 'telepon', 'alamat', 'register_date', 'status'],
            ['CUST-100', 'Cabang Demo', 'Area Demo', 'Budi Import', 'budi@example.com', '08123456789', 'Jl. Demo', '2026-01-01', 'active'],
        ], null, 'A1');

        $tempFile = tempnam(sys_get_temp_dir(), 'customer-import');
        $xlsxPath = $tempFile . '.xlsx';
        rename($tempFile, $xlsxPath);

        $writer = new Xlsx($spreadsheet);
        $writer->save($xlsxPath);

        $uploadedFile = new UploadedFile($xlsxPath, 'customers.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);

        $this->actingAs($user);

        $response = $this->post(route('customers.import'), ['file' => $uploadedFile]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('customers', ['cust_code' => 'CUST-100', 'nama' => 'Budi Import']);

        unlink($xlsxPath);
    }
}
