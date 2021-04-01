

<style>
    .fileList{
        display: table;  
        margin-top:20px;
        margin-bottom: 10px;
    }
    .fileList span{
        line-height: 36px;
        font-size:24px;
    }
    .fileList ul.upfilelist{
        display: table-cell;
        line-height: 36px;
        font-size:24px;
    }
    /*
    .fileList ul.upfilelist span{
    }*/
    .fileList ul.upfilelist li{
        display: table-cell;
    }
    .fileLevel1{
        margin-left: 20px;
    }
    .fileLevel2{
        margin-left: 30px;
    }
    .fileLevel3{
        margin-left: 40px;
    }
    .fileLevel4{
        margin-left: 50px;
    }
    .fileLevel5{
        margin-left: 60px;
    }
</style>

<div id="fileDownList" style="table-row"> 
<?php
$dir_path = "./uploads/fastq";
$lvl = 1;
fn_ReadDirList($dir_path,$lvl);
?>
</div>

<iframe id='frmdownload' style='display:none;' >
</iframe>

<script type="text/javascript">


// 화면 오픈시 발생 
$(document).ready(function() {
    
    $("a.filepath").click(function(obj){
        var fileUrl =  encodeURIComponent($(this).data('file-url'));
        var fileNm =  encodeURIComponent($(this).data('file-nm'));
        var sLink = "<?php echo base_url() ?>" + "fastq/download?filenm=" + fileNm + "&filepath="+fileUrl;
        $("#frmdownload").attr("src",sLink ) ;
        // var mineType = "application/octet-stream"; 
        
         // download(fileUrl, fileNm, mineType);
    });    
    
});
</script>
