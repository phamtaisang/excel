<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>upload file</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<div class="container pt-5">
    <div class="row">
        <h5>Convert file excel</h5>
        <div class="col-sm-12 text-left pt-2 box">
            <form id="form" method="post" enctype="multipart/form-data">
                <input class="form-control mb-3" type="file" id="excelfile"/>
                <select class="form-control mb-3 form-control-lg tuychon">
                    <option value="tiki">Tiki</option>
                    <option value="kiotviet">kiotviet</option>
                    <option value="custom">Tùy chỉnh</option>
                </select>
                <div class="form-group config">
                    <h5>Config </h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <div id="liên_kết">
                                <label for="exampleFormControlSelect1">liên_kết</label>
                            </div>
                            <div id="tiêu_đề">
                                <label for="exampleFormControlSelect1">tiêu_đề</label>
                            </div>
                            <div id="mô_tả">
                                <label for="exampleFormControlSelect1">mô_tả</label>
                            </div>
                            <div id="id">
                                <label for="exampleFormControlSelect1">id</label>
                            </div>
                            <div id="mã_số_sản_phẩm_thương_mại_toàn_cầu">
                                <label for="exampleFormControlSelect1">mã_số_sản_phẩm_thương_mại_toàn_cầu</label>
                            </div>
                            <div id="ẩn_hiện">
                                <label for="exampleFormControlSelect1">ẩn_hiện</label>
                            </div>
                            <div id="tình_trạng_còn_hàng">
                                <label for="exampleFormControlSelect1">tình_trạng_còn_hàng</label>
                            </div>
                            <div id="số_lượng">
                                <label for="exampleFormControlSelect1">số_lượng</label>
                            </div>
                            <div id="thương_hiệu">
                                <label for="exampleFormControlSelect1">thương_hiệu</label>
                            </div>
                        </div>
                    <div class="col-sm-6">
                        <div id="loại_sản_phẩm">
                            <label for="exampleFormControlSelect1">loại_sản_phẩm</label>
                        </div>
                        <div id="đo_lường_định_giá_theo_đơn_vị">
                            <label for="exampleFormControlSelect1">đo_lường_định_giá_theo_đơn_vị</label>
                        </div>
                        <div id="thuộc_tính">
                            <label for="exampleFormControlSelect1">thuộc_tính</label>
                        </div>
                        <div id="giá_ưu_đãi">
                            <label for="exampleFormControlSelect1">giá_ưu_đãi</label>
                        </div>
                        <div id="giá">
                            <label for="exampleFormControlSelect1">giá</label>
                        </div>
                        <div id="liên_kết_hình_ảnh">
                            <label for="exampleFormControlSelect1">liên_kết_hình_ảnh</label>
                        </div>
                        <div id="liên_kết_hình_ảnh_bổ_sung">
                            <label for="exampleFormControlSelect1">liên_kết_hình_ảnh_bổ_sung</label>
                        </div>
                        <div id="id_sản_phẩm_gốc">
                            <label for="exampleFormControlSelect1">id_sản_phẩm_gốc</label>
                        </div>
                        <div id="nhiều_phiên_bản">
                            <label for="exampleFormControlSelect1">nhiều_phiên_bản</label>
                        </div>
                    </div>
                    </div>
                </div>
                <input type="submit" name="up" value="Upload" class="btn btn-primary mb-3">
            </form>
        </div>
    </div>
</div>
<!--<script src="jquery-1.10.2.min.js" type="text/javascript"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>
<script>
    function ExportToTable() {
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;
        /*Checks whether the file is a valid excel file*/
        if (regex.test($("#excelfile").val().toLowerCase())) {
            var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/
            if ($("#excelfile").val().toLowerCase().indexOf(".xlsx") > 0) {
                xlsxflag = true;
            }
            /*Checks whether the browser supports HTML5*/
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var data = e.target.result;
                    /*Converts the excel data in to object*/
                    if (xlsxflag) {
                        var workbook = XLSX.read(data, { type: 'binary' });
                    }
                    else {
                        var workbook = XLS.read(data, { type: 'binary' });
                    }
                    /*Gets all the sheetnames of excel in to a variable*/
                    var sheet_name_list = workbook.SheetNames;

                    var cnt = 0; /*This is used for restricting the script to consider only first sheet of excel*/
                    sheet_name_list.forEach(function (y) { /*Iterate through all sheets*/
                        /*Convert the cell value to Json*/
                        if (xlsxflag) {
                            var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                        }
                        else {
                            var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);
                        }
                        if (exceljson.length > 0 && cnt == 0) {
                            BindTableHeader(exceljson, '#liên_kết');
                            BindTableHeader(exceljson, '#tiêu_đề');
                            BindTableHeader(exceljson, '#mô_tả');
                            BindTableHeader(exceljson, '#id');
                            BindTableHeader(exceljson, '#mã_số_sản_phẩm_thương_mại_toàn_cầu');
                            BindTableHeader(exceljson, '#ẩn_hiện');
                            BindTableHeader(exceljson, '#tình_trạng_còn_hàng');
                            BindTableHeader(exceljson, '#số_lượng');
                            BindTableHeader(exceljson, '#thương_hiệu');
                            BindTableHeader(exceljson, '#loại_sản_phẩm');
                            BindTableHeader(exceljson, '#đo_lường_định_giá_theo_đơn_vị');
                            BindTableHeader(exceljson, '#thuộc_tính');
                            BindTableHeader(exceljson, '#giá_ưu_đãi');
                            BindTableHeader(exceljson, '#giá');
                            BindTableHeader(exceljson, '#liên_kết_hình_ảnh');
                            BindTableHeader(exceljson, '#liên_kết_hình_ảnh_bổ_sung');
                            BindTableHeader(exceljson, '#id_sản_phẩm_gốc');
                            BindTableHeader(exceljson, '#nhiều_phiên_bản');
                            cnt++;
                        }
                    });
                }
                if (xlsxflag) {/*If excel file is .xlsx extension than creates a Array Buffer from excel*/
                    reader.readAsArrayBuffer($("#excelfile")[0].files[0]);
                }
                else {
                    reader.readAsBinaryString($("#excelfile")[0].files[0]);
                }
            }
            else {
                alert("Sorry! Your browser does not support HTML5!");
            }
        }
        else {
            alert("Please upload a valid Excel file!");
        }
    }

    function BindTableHeader(jsondata, tableid) {/*Function used to get all column names from JSON and bind the html table header*/
        var columnSet = [];
        var headerTr$ = $('<select class="form-control" id="select">');
        for (var i = 0; i < jsondata.length; i++) {
            var rowHash = jsondata[i];
            for (var key in rowHash) {
                if (rowHash.hasOwnProperty(key)) {
                    if ($.inArray(key, columnSet) == -1) {/*Adding each unique column names to a variable array*/
                        columnSet.push(key);
                        headerTr$.append($('<option>').html(key));
                    }
                }
            }
        }
        $(tableid).append(headerTr$);
        return columnSet;
    }

    $(document).ready(function(){
        $("select.tuychon").change(function(){
            var selectedCountry = $(this).children("option:selected").val();
            if (selectedCountry == "custom"){
                $('.config').addClass("show");
                ExportToTable();
            }
            else {
                $(".config").remove();
            }

        });
    });

    var request;
    // Bind to the submit event of our form
    $("#form").submit(function(event){
        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        var file_data = $('#excelfile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        alert(form_data);
        $.ajax({
            url: 'tiki.php', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response){
                alert(php_script_response); // display response from the PHP script, if any
            }
        });
    });

</script>

</body>
<style>
    .config{
        display: none;
    }
    .config.show{
        display: block;
    }
</style>
</html>