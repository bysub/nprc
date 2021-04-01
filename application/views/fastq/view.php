<style>
	#container{
		width: 100%;
	}
	.s-content{
		margin-top: 10px;
	}
	.searchArea{
		margin:10px 0 ;
	}
	.searchArea .nav-pills li{
		margin-right:10px;
	}.searchArea .nav-pills li::last{
		margin-right:0;
	}
	.fixed-table-header{
		margin-right: 0 !important;
	}
	.divList{
		height: calc( 100vh - 220px );
	}
	table{
		font-size: 15px;
		position: relative;
	}
	
	table th{
		text-align: center !important;
		vertical-align: middle !important;
	}
	
	table th ,table tr , table td{
		height: 48px;
		border-left: 1px !important;
	}
	table tr>td{
		text-align: left;
		white-space: nowrap ;/*word-wrap:normal;*/
	}
	#divExperiment{
		position: relative;
	}
	table.divExperiment div{
		font-size: 14px !important;
		font-weight: 400 !important;

	}
	.bootstrap-table .fixed-table-container .fixed-table-body {
		overflow: hidden;
		position: relative;
	}
	.treegrid-expander{
		margin-right: 10px;
	}
	.fixed-table-footer,.fixed-table-border{
		display: none;
	}
</style>
<link href="<?php echo base_url(); ?>css/lib/jquery.treegrid.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/bootstrap-table/bootstrap-table.min.css">  
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/perfect-scrollbar/css/perfect-scrollbar.css">  

<script src="<?php echo base_url(); ?>js/lib/jquery.treegrid.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?php echo base_url(); ?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-table/extensions/treegrid/bootstrap-table-treegrid.min.js"></script>

<div class="s-content bs-docs-section">
    <div class='row'>
        <div id="divFolder" class="divList col-lg-5" >
            <table
                id='tbFolder' 
                class="table table-sm table-striped table-borderless"
                data-toggle="table"
                data-click-to-select="true"
				data-resizable="true"
				data-show-footer="false"
                data-id-field="thisId"
                >
                <thead>
                    <tr >
                        <th data-field="filePath" 	data-align="left" data-sortable="false" class='hidden'  >cateNm</th>
                        <th data-field="viewNm" 	data-align="left" data-sortable="false" data-width="100" data-width-unit="%">Category </th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="divFile" class="divList col-lg-7" >
            <table
                id='tbFile' 
                class="table table-sm table-striped table-borderless"
                data-toggle="table"
				data-resizable="true"
				data-show-footer="false"
                data-id-field="fileId" 
                >
                <thead>
                    <tr >
                        <th data-field="filePath" 	data-align="left" data-sortable="false" class='hidden' >filePath</th>
                        <th data-field="fileNm" 	data-align="left" data-sortable="false" data-width="90" data-width-unit="%">File Name</th>
						<th data-field="download" 	data-align="left" data-sortable="false" data-width="10" data-width-unit="%"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div> <!--// s-content -->


<script type="text/javascript">
var $table = $('#tbFolder');
var $tableFile = $('#tbFile');
var ps,ps2;

// 화면 오픈시 발생 
$(document).ready(function() {    
	fn_search();

	$table.on('post-body.bs.table', function () {
		if (ps) ps.destroy();
		var objTable = document.querySelector("#divFolder div.fixed-table-body");
		ps = new PerfectScrollbar(objTable);
		$table.bootstrapTable('resetView');
	});
	$tableFile.on('post-body.bs.table', function () {
		if (ps2) ps2.destroy();
		var objTable = document.querySelector("#divFile div.fixed-table-body");
		ps2 = new PerfectScrollbar(objTable);
		$tableFile.bootstrapTable('resetView');
	});
});
// 폴더 조회 
function fn_search(){
    var param = {'searchType' : 'folder'} ; // new Object();
	var sUrl = "<?php echo base_url(); ?>fastqfile";

    $.ajax({
		url : sUrl , 
		dataType : 'JSON',
		type : 'POST',
		data : param,
		success : function(rtn) {
			if(rtn.result){
				var objData = rtn.data;
				if(objData.length > 0) {	
					initTable(objData);
				}
			}
		},
		error : function(xhr, status, error) {
			alert("ERROR : " + error + "\n,status : " + status + "\n,xhr : " +xhr);
			bTrans = false;
		}	
	});
}
// 파일 조회 
function fn_searchDetail(objRowData ){
    objRowData.searchType = 'file' ;
	var sUrl = "<?php echo base_url(); ?>fastqfile";

    $.ajax({
		url : sUrl , 
		dataType : 'JSON',
		type : 'POST',
		data : objRowData,
		success : function(rtn) {
			if(rtn.result){
				var objData = rtn.data;
				if(objData.length > 0) {	
					initDetailTable(objData);
				}
			}
		},
		error : function(xhr, status, error) {
			alert("ERROR : " + error + "\n,status : " + status + "\n,xhr : " +xhr);
			bTrans = false;
		}	
	});
}

function initTable(objData) {
	$table.bootstrapTable('destroy').bootstrapTable({
		singleSelect : true,
		data : objData, 
		height: 760, 
        showColumns: false,
        idField: 'thisId',
        treeShowField: 'viewNm',
        parentIdField: 'parentId',
        onPostBody: function() {
            var columns = $table.bootstrapTable('getOptions').columns;

            if (columns && columns[0][1].visible) {
                $table.treegrid({
                    treeColumn: 1,
                    onChange: function() {
                        $table.bootstrapTable('resetView');
                    }
                });
            }
        },
		columns: [
		{
          field: 'state',
          checkbox: true,
          align: 'center',
          valign: 'middle',
		  class:'hidden'
        },
        {
          field: 'viewNm',
          title: 'Category '
        }
		]
	});

	$table.on('click-row.bs.table', function (field, value, row, $element) {
			var objRowData = value ; 
			if( !gfn_isNull(objRowData.filePath  ) ) {
				fn_searchDetail(objRowData );
			}
	}); 
}

function initDetailTable(objData) {
	$tableFile.bootstrapTable('destroy').bootstrapTable({
		singleSelect : true,
		data : objData, 
		height: 760, 
        showColumns: false,
		columns: [
		{
          field: 'state',
          checkbox: true,
          align: 'center',
          valign: 'middle',
		  class:'hidden'
        },
        {
          field: 'fileNm',
          title: 'File Name '
        },
        {
          field: 'download',
          title: 'Download',
          align: 'center',
          valign: 'middle',
		  class : 'download'
        }

		]
	});
	
	$tableFile.on('click-row.bs.table', function (field, value, row, $element) {
			var objRowData = value ; 
			if( !gfn_isNull(objRowData.filePath  ) ) {
				// fn_searchDetail(objRowData );
				var fileUrl =  encodeURIComponent(objRowData.filePath);
				var fileNm =  encodeURIComponent(objRowData.fileNm);
				var sLink = "<?php echo base_url() ?>" + "fastq/download?filenm=" + fileNm + "&filepath="+fileUrl;
				$("#frmdownload").attr("src",sLink ) ;
			}
	}); 
}
</script>
<iframe id='frmdownload' style='display:none;' >
</iframe>

