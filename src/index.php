<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//cấu hình
$FIELDS_MAP_CONFIG = [
    'seller_id' => 'liên_kết',
    'msku' => 'tiêu_đề',
    'mô_tả' => 'mô_tả',
    'product_code' => 'id',
    'sales_price' => 'mã_số_sản_phẩm_thương_mại_toàn_cầu',
    'operation_model' => 'ẩn_hiện',
    'warehouse' => 'tình_trạng_còn_hàng',
    'quantity' => 'số_lượng',
    'mincode' => 'thương_hiệu',
    'is_warranty_applied' => 'loại_sản_phẩm',
    'warranty_time_period' => 'đo_lường_định_giá_theo_đơn_vị',
    'warranty_time_unit' => 'thuộc_tính',
    'is_warranty_forever' => 'giá_ưu_đãi',
    'warranty_service_type' => 'giá',
    'warranty_form' => 'liên_kết_hình_ảnh',
    'liên_kết_hình_ảnh_bổ_sung' => 'liên_kết_hình_ảnh_bổ_sung',
    'id_sản_phẩm_gốc' => 'id_sản_phẩm_gốc',
    'nhiều_phiên_bản' => 'nhiều_phiên_bản',
    'nhiều_phiên_bản' => 'nhiều_phiên_bản',
];

$spreadsheet = new Spreadsheet();
$spreadsheet_output = new Spreadsheet();
$inputFileType = 'Xlsx';
$inputFileName = '../file/tiki.xlsx';
$inputFileOutput = '../file/file_onshop_tiki.xlsx';

//đọc file excel A
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->getActiveSheet();
$header_row = $worksheet->toArray()[0];
$rowCount = 0;

//validate
$missFields = array_diff(array_keys($FIELDS_MAP_CONFIG), $header_row);
$unique = array_unique(array_diff_assoc($header_row, array_unique($header_row)));
if (($key = array_search("", $unique)) !== false) {
    unset($unique[$key]);
}

if ($missFields != null) {
    $error = implode(', ', $missFields);
    echo  "Error !!! ". $error . "\nCould not be found in the file :" .$inputFileName;
    exit;
} elseif ($unique != null) {
    $error = implode(', ', $unique);
    echo "2 columns already exist : " . $error;
    exit;
}

foreach ($worksheet->toArray() as $row) {
    $data_fill = array_combine($header_row, $row);
    foreach ($data_fill as $col => $df) {
        if (!in_array($col, array_keys($FIELDS_MAP_CONFIG))) {
            unset($data_fill[$col]);
        }
    }
    // order column
    $data_fill = array_merge(array_flip(array_keys($FIELDS_MAP_CONFIG)), $data_fill);
    // write file B
    $sheet = $spreadsheet_output->getActiveSheet();
    $spreadsheet->setActiveSheetIndex(0);
    $colAlphabet = 'A';
    foreach ($FIELDS_MAP_CONFIG as $toHeader) {
        $spreadsheet_output->getActiveSheet()->setCellValue("{$colAlphabet}1", $toHeader);
        if (substr($colAlphabet, strlen($colAlphabet) - 1) === 'Z') {
            $colAlphabet = substr($colAlphabet, 0, strlen($colAlphabet) - 1) . 'AA';
        } else {
            $colAlphabet++;
        }
    }
    $sheet = $spreadsheet_output->getActiveSheet();
    $colAlphabet = 'A';
    $rowCount++;
    foreach ($data_fill as $key => $data) {
        // Add some data
        $spreadsheet_output->getActiveSheet()->setCellValue($colAlphabet . $rowCount, $data);
        if (substr($colAlphabet, strlen($colAlphabet) - 1) === 'Z') {
            $colAlphabet = substr($colAlphabet, 0, strlen($colAlphabet) - 1) . 'AA';
        } else {
            $colAlphabet++;
        }
    }
}

//save
$writer = new Xlsx($spreadsheet_output);
$writer->save($inputFileOutput);

