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

<div class="s-content">
	<div class="searchArea">
		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link" href="#">User Search</a>
			</li>
			<li >
				<input class="form-control mr-sm-2" type="text" id="keyword" name='keyword' placeholder="Search" value="">
				<input type='hidden' placeholder="Search"/>
			</li>
			<li >
                <button class="btn btn-secondary my-2 my-sm-0" type="button" onclick="fn_search(1);">Search</button>	
			</li>
		</ul>
	</div>
    <div id="divUser" class="divList" >
        <table
            id='tbUser' 
            class="table table-sm table-striped table-borderless"
            data-toggle="table"
            data-click-to-select="true"
            data-pagination="true">
            <thead>
                <tr >
                    <th data-field="user_id" 	data-align="left" data-sortable="false" class='10' data-width-unit="%" >ID</th>
                    <th data-field="user_nm" 	data-align="left" data-sortable="false" data-width="10" data-width-unit="%">User Name </th>
                    <th data-field="org_nm" 	data-align="left" data-sortable="false" data-width="10" data-width-unit="%">User Name </th>
                    <th data-field="org_dept_nm" 	data-align="left" data-sortable="false" data-width="10" data-width-unit="%">User Name </th>
                    <th data-field="org_position" 	data-align="left" data-sortable="false" data-width="10" data-width-unit="%">User Name </th>
                    <th data-field="user_hp" 	data-align="left" data-sortable="false" data-width="10" data-width-unit="%">User Name </th>
                    <th data-field="user_email" 	data-align="left" data-sortable="false" data-width="10" data-width-unit="%">User Name </th>
                    <th data-field="use_yn" 	data-align="left" data-sortable="false" data-width="10" data-width-unit="%">User Name </th>
                </tr>
            </thead>
        </table>
    </div>
</div> <!--// s-content -->

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
var $table = $('#tbUser');
var ps;

// 화면 오픈시 발생 
$(document).ready(function() {    
	fn_search(1);
    // $table.bootstrapTable('destroy').bootstrapTable();
	$table.on('post-body.bs.table', function () {
		if (ps) ps.destroy();
		var objTable = document.querySelector("#divUser div.fixed-table-body");
		ps = new PerfectScrollbar(objTable);
		$table.bootstrapTable('resetView');
	});
});
function queryParams(params) {
    params = gfn_GetData($(".searchArea"));
	params.searchType = "userList";
    // alert('queryParams: ' + JSON.stringify(params));
    return params;
}

function fn_search(page){
	// 검색 조건 가져오기
	var param = gfn_GetData($(".searchArea"));
	param.searchType = "userList";
	var sUrl = "<?php echo base_url(); ?>usermng";

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
				} else {
					$table.bootstrapTable('removeAll');
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
		height: 600,
		undefinedText: 'N/A',
		singleSelect : true,
		data : objData, // rownum
		columns: [
		{
          field: 'state',
          checkbox: true,
          align: 'center',
          valign: 'middle',
		  class:'hidden'
        },{
			title: 'No.',
			field: 'rownum',
			align: 'center',
			valign: 'middle'

		},{
			title: 'ID',
			field: 'user_id',
			align: 'left',
			valign: 'middle'
		},{
			title: 'User Name',
			field: 'user_nm',
			align: 'left',
			valign: 'middle'
		},{
			title: 'org Name',
			field: 'org_nm',
			align: 'left',
			valign: 'middle'
		},{
			title: 'dept Name',
			field: 'org_dept_nm',
			align: 'left',
			valign: 'middle'
		},{
			title: 'posotopm Name',
			field: 'org_position',
			align: 'left',
			valign: 'middle'
		},{
			title: 'Phone',
			field: 'user_hp',
			align: 'center',
			valign: 'middle'
		},{
			title: 'E-mail',
			field: 'user_email',
			align: 'left',
			valign: 'middle'
		},{
			title: 'use',
			field: 'use_yn',
			align: 'center',
			valign: 'middle'
		}
		]
	});

	$table.on('click-row.bs.table', function (field, value, row, $element) {
			var objRowData = value ; 
			if( !gfn_isNull(objRowData.user_id  ) ) {
                // $('#exampleModalLong').modal('toggle');                
			}
	}); 
	objData = null;

}
</script>