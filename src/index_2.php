<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//cấu hình
$FIELDS_MAP_CONFIG = [
    'liên_kết' => 'liên_kết_2',
    'tiêu_đề' => '',
    'id' => 'id_2',
    'mã_số_sản_phẩm_thương_mại_toàn_cầu' => 'mã_số_sản_phẩm_thương_mại_toàn_cầu_2',
    'ẩn_hiện' => 'ẩn_hiện_2',
    'tình_trạng_còn_hàng' => 'tình_trạng_còn_hàng_2',
    'số_lượng' => 'số_lượng_2',
    'thương_hiệu' => 'thương_hiệu_2',
    'loại_sản_phẩm' => 'loại_sản_phẩm_2',
    'đo_lường_định_giá_theo_đơn_vị' => '',
    'thuộc_tính' => 'thuộc_tính_2',
    'giá_ưu_đãi' => 'giá_ưu_đãi_2',
    'giá' => 'giá_2',
    'liên_kết_hình_ảnh' => 'liên_kết_hình_ảnh_2',
    'liên_kết_hình_ảnh_bổ_sung' => 'liên_kết_hình_ảnh_bổ_sung_2',
    'id_sản_phẩm_gốc' => 'id_sản_phẩm_gốc_2',
    'nhiều_phiên_bản' => '',
];

$spreadsheet = new Spreadsheet();
$spreadsheet_output = new Spreadsheet();
$inputFileType = 'Xlsx';
$inputFileName = '../file/hi.xls';
$inputFileOutput = '../file/file_onshop.xlsx';
$sheetname = 'Data Sheet #3';

//đọc file excel A
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->getActiveSheet();
//$worksheetData = $reader->listWorksheetInfo($inputFileName);
$header_row = $worksheet->toArray()[0];
$row = [];
$rowCount = 0;

//validate
$missFields = array_diff(array_keys($FIELDS_MAP_CONFIG), $header_row);
$unique = array_unique(array_diff_assoc($header_row, array_unique($header_row)));
if (($key = array_search("", $unique)) !== false) {
    unset($unique[$key]);
}

if ($missFields != null) {
    $error = implode(', ', $missFields);
    echo "not found : " . $error;
    exit;
} elseif ($unique != null) {
    $error = implode(', ', $unique);
    echo "2 columns already exist : " . $error;
    exit;
}

foreach ($worksheet->toArray() as $row) {
    $data_fill = array_combine($header_row, $row);

    foreach ($data_fill as $col => $df) {
        if (!in_array($col, array_values($FIELDS_MAP_CONFIG))) {
            unset($data_fill[$col]);
        }
    print_r($data_fill);
    }
    // order column
    $data_fill = array_merge(array_flip(array_keys($FIELDS_MAP_CONFIG)), $data_fill);
//    print_r($data_fill);
//    die();
    // write file B
    $sheet = $spreadsheet_output->getActiveSheet();
    $spreadsheet->setActiveSheetIndex(0);
    $colAlphabet = 'A';
    foreach (array_keys($FIELDS_MAP_CONFIG) as $toHeader) {
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

