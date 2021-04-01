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
	table{
		font-size: 15px;
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
	tr.selected td{
		background-color: #4582ec !important;
		color:#fff !important;
	}
	/*
	.table-sm th, .table-sm td {
		padding: 0 0.3rem;
	}
	*/
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/bootstrap-table/bootstrap-table.min.css">  
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css">   

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/perfect-scrollbar/css/perfect-scrollbar.css"> 

<script src="<?php echo base_url(); ?>js/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script>

<script src="<?php echo base_url(); ?>js/bootstrap-table/extensions/resizable/bootstrap-table-resizable.min.js"></script>


<script src="<?php echo base_url(); ?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<div class="s-content">
	<div class="searchArea">
		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link" href="#">Primate Species</a>
			</li>
			<li class="nav-item">
				<select class="form-control" id="code_gb" name='code_gb'>
					<option value=''> - select - </option>
					<?php foreach($code1 as $code): ?>
						<option value="<?php echo $code['dtl_cd']; ?>"  > <?php echo $code['dtl_nm']; ?></option>
					<?php endforeach; ?>
				</select>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="#">Type</a>
			</li>
			<li class="nav-item dropdown">
				<select class="form-control" id="code_extp" name='code_extp'>
					<option value=''> - select - </option>
					
					<?php foreach($code3 as $code): ?>
						<option value="<?php echo $code['dtl_cd']; ?>"><?php echo $code['dtl_nm']; ?></option>
					<?php endforeach; ?>
				</select>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="#">Plan</a>
			</li>
			<li class="nav-item dropdown">
				<select class="form-control" id="code_expl" name='code_expl'>
					<option value=''> - select - </option>
					
					<?php foreach($code2 as $code): ?>
						<option value="<?php echo $code['dtl_cd']; ?>"><?php echo $code['dtl_nm']; ?></option>
					<?php endforeach; ?>
				</select>
			</li>
			<li >
				<input class="form-control mr-sm-2" type="text" id="keyword" name='keyword' placeholder="Search" value="<?php echo $setvalue['keyword']; ?>">
				<input type='hidden' placeholder="Search"/>
			</li>
			<li >
                <button class="btn btn-secondary my-2 my-sm-0" type="button" onclick="fn_search(1);">Search</button>	
			</li>
		</ul>
	</div>
	<div id="divGene" class="divList" >

		<table
			id='tbgene' 
			class="table table-sm table-striped table-borderless"
			data-toggle="table"
			data-height="600"
			data-show-refresh="false"
			data-search="false"
			data-show-footer="false"
			data-maintain-meta-data="true"
			data-click-to-select="true"
			

			data-id-field="gene_idx"
			data-page-size="25"
			data-pagination="true"
			data-page-list="[10, 25, 50, 100]"
			>
			<thead>
				<tr class='table-secondary'>
					<th data-field="gene_cd" 	data-align="left" data-sortable="false" data-width="8" data-width-unit="%">GeneAcc</th>
					<th data-field="gene_nm" 	data-align="left" data-sortable="false" data-width="8" data-width-unit="%">GeneName</th>
					<th data-field="gene_gb_nm" data-align="left" data-sortable="false" data-width="10" data-width-unit="%">Primate<br>Species</th>
					<th data-field="gene_tp_nm" data-align="left" data-sortable="false" data-width="8" data-width-unit="%">Type</th>
					<th data-field="gene_pl_nm" data-align="left" data-sortable="false" data-width="8" data-width-unit="%">Plan</th>
					
					<th data-field="chr" 		data-align="left" data-sortable="false" data-width="8" data-width-unit="%">chr</th>
					<th data-field="pos_start" 	data-align="right" data-sortable="false" data-width="8" data-width-unit="%">start</th>
					<th data-field="pos_end" 	data-align="right" data-sortable="false" data-width="8" data-width-unit="%">end</th>
					<th data-field="strand_way" data-align="left" data-sortable="false" data-width="8" data-width-unit="%">strand</th>
					<th data-field="desc" 		data-align="left" data-sortable="false" data-width="25" data-width-unit="%">desc</th>
				</tr>
			</thead>
		</table>
	</div>
</div> <!--// s-content -->

<div class="s-content">
	<div id='divExperiment' class="s-content divList ">		
		<table id='tbExperiment' 
			class="table table-sm table-borderless divExperiment"
			data-toggle="table"
			data-height="100"
			data-show-refresh="false"
			data-search="false"
			data-show-footer="false"
			data-click-to-select="true"
			
			data-id-field="gene_cd" >
			<thead>
				<tr class='table-secondary'>
					<th data-field="gene_cd" 	data-align="left" data-sortable="false" data-width="8" data-width-unit="%">GeneAcc</th>
					<th data-field="gene_nm" 	data-align="left" data-sortable="false" data-width="8" data-width-unit="%">GeneName</th>
				</tr>
			</thead>
		</table>	
	</div>
</div>
				

<script type="text/javascript">
var bTrans = false;
var $table = $('#tbgene');
var $tableExperiment = $('#tbExperiment');
var selections = [];
var ps,ps2;

// 화면 오픈시 발생 
$(document).ready(function() {
	var sSearchGb = "<?php echo $sgb; ?>";
	var sSearchTp = "<?php echo $stp; ?>";
	var sSearchPl = "<?php echo $spl; ?>";
	// Get 방식으로 값이 넘어온 경우 세팅 
	if( !gfn_isNull(sSearchGb)) $("#code_gb").val(sSearchGb);
	if( !gfn_isNull(sSearchTp)) $("#code_extp").val(sSearchTp);
	if( !gfn_isNull(sSearchPl)) $("#code_expl").val(sSearchPl);

	fn_search(1);

	// 콤보 박스 선택시 발생 
	$("select").on('change',function(e){
		// debugger;
		fn_search(1);
	});
	// Input 박스 엔터 시 발생 
	$("input").on('keydown',function(e){
		if(e.keyCode==13){
			e.preventDefault();
			fn_search(1);
		}
	});
	// 스크롤바 변경 
	$table.on('post-body.bs.table', function () {
		if (ps) ps.destroy();
		var objTable = document.querySelector("#divGene div.fixed-table-body");
		ps = new PerfectScrollbar(objTable);
		$table.bootstrapTable('resetView');
	});
	
	$tableExperiment.on('post-body.bs.table', function () {
		if (ps2) ps2.destroy(); 
		var objTableDetail = document.querySelector("#divExperiment div.fixed-table-body") ;		
		if(objTableDetail)
			ps2 = new PerfectScrollbar(objTableDetail);
		$tableExperiment.bootstrapTable('resetView');
	});

	// fixColumn scroll 삭제 처리 
	$tableExperiment.on({
		mouseover: function() {
			$("#divExperiment .fixed-columns .fixed-table-body").removeClass('ps');
			$("#divExperiment .fixed-table-body").removeClass('ps--active-y');
			
		}
	});	
});

function fn_search(page){
	// if( bTrans == true ) return false;

	// $tableExperiment.parents('.fixed-table-container').hide();
	// $("#tbgeneBody").empty();
	// bTrans = true;
	
	$tableExperiment.bootstrapTable('removeAll');
	// 검색 조건 가져오기
	var param = gfn_GetData($(".searchArea"));
	param.searchType = "gene";
	var sUrl = "<?php echo base_url(); ?>research";

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
function fn_searchDetail(paramDetail){
	if( gfn_isNull(paramDetail.gene_cd ) ) return false;
	// 검색 조건 가져오기
	// var paramDetail = new Object();
	// paramDetail.gene_cd = geneCd;
	paramDetail.searchType = "Experiment";
	var sUrl = "<?php echo base_url(); ?>research";// detail
	
	$.ajax({
		url : sUrl , 
		dataType : 'JSON',
		type : 'POST',
		data : paramDetail,
		success : function(rtn) {
			if(rtn.result){
				var objData = rtn.data;
				
				if(objData.length > 0) {	
					initDetailTable(objData);
				} else {
					$tableExperiment.bootstrapTable('removeAll');
					// initDetailTable(null);	
				}
			}
		},
		error : function(xhr, status, error) {
			alert("ERROR : " + error + "\n,status : " + status + "\n,xhr : " +xhr);
		}	
	});
}
/*****************
 * bootstrap table Event
 *********************/
function priceFormatter(value) {
	return replaceNumberWithCommas(value);
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
			title: 'GeneAcc',
			field: 'gene_cd',
			align: 'left',
			valign: 'middle',
			width:8,
			widthUnit:'%'
		},{
			title: 'GeneName',
			field: 'gene_nm',
			align: 'left',
			valign: 'middle',
			width:8,
			widthUnit:'%'
		},{
			title: 'Primate<br>Species',
			field: 'gene_gb_nm',
			align: 'center',
			valign: 'middle',
			width:8,
			widthUnit:'%'
		},{
			title: 'Type',
			field: 'gene_tp_nm',
			align: 'center',
			valign: 'middle',
			width:8,
			widthUnit:'%'
		},{
			title: 'Plan',
			field: 'gene_pl_nm',
			align: 'center',
			valign: 'middle',
			width:8,
			widthUnit:'%'
		},{
			title: 'chr',
			field: 'chr',
			align: 'left',
			valign: 'middle',
			width:8,
			widthUnit:'%'
		},{
			title: 'start',
			field: 'pos_start',
			align: 'right',
			valign: 'middle',
			width:8,
			widthUnit:'%'
			,formatter : priceFormatter
		},{
			title: 'end',
			field: 'pos_end',
			align: 'right',
			valign: 'middle',
			width:8,
			widthUnit:'%'
			,formatter : priceFormatter
		},{
			title: 'strand',
			field: 'strand_way',
			align: 'center',
			valign: 'middle',
			width:8,
			widthUnit:'%'
		},{
			title: 'desc',
			field: 'desc',
			align: 'left',
			valign: 'middle',
			width:25,
			widthUnit:'%'
		}
		
		]
	});

	$table.on('click-row.bs.table', function (field, value, row, $element) {
			var objRowData = value ; 
			if( !gfn_isNull(objRowData.gene_cd  ) ) {
				fn_searchDetail(objRowData );
			}
	}); 
	objData = null;

}

function initDetailTable(objData) {
	$tableExperiment.bootstrapTable('destroy');
	if(!gfn_isNull(objData)){
		var objPivotDrawData = [];
		var objPivotVal = {
							gene_cd : objData[0].gene_cd,
							gene_nm : objData[0].gene_nm,
						};
		objPivotDrawData.push({
			title: 'GeneAcc',
			field: 'gene_cd',
			align: 'left',
			valign: 'middle',
			class : 'w160' , 
			fixedColumns : true
		});
		objPivotDrawData.push({
			title: 'GeneName',
			field: 'gene_nm',
			align: 'left',
			valign: 'middle',
			class : 'w160', 
			fixedColumns : true
		});
		for( var i = 0 ;  i < objData.length ; i++ ){
			var objDrawInfo = new Object();
			objDrawInfo.title = objData[i].exp_nm;
			objDrawInfo.field = objData[i].exp_cd;
			objDrawInfo.align = 'right';
			objDrawInfo.valign = 'middle';
			objDrawInfo.class = 'w160';
			// objDrawInfo.width = '120';
			// objDrawInfo.widthUnit = 'px';
			objDrawInfo.formatter ="priceFormatter";
			
			objPivotVal[objData[i].exp_cd] = objData[i].resutl_val;
			objPivotDrawData.push(objDrawInfo);
		}
		
		$tableExperiment.bootstrapTable('destroy').bootstrapTable({
			height: 100,
			undefinedText: '0',
			
			fixedColumns: true,
			fixedNumber: +2,
			data : [objPivotVal],
			columns : objPivotDrawData
		});
		
		$tableExperiment.find(".fixed-columns .fixed-table-body").removeClass('ps');
	} else {
		var objPivotDrawData = [];
		
		objPivotDrawData.push({
			title: 'GeneAcc',
			field: 'gene_cd',
			align: 'left',
			valign: 'middle',
			class : 'w160'
		});
		objPivotDrawData.push({
			title: 'GeneName',
			field: 'gene_nm',
			align: 'left',
			valign: 'middle',
			class : 'w160'
		});
		var objPivotVal = {
				gene_cd : 'No matching records found',
				gene_nm : '',
			};
		// var objData = 
		// 
		$tableExperiment.bootstrapTable('destroy').bootstrapTable({
			height: 100,
			undefinedText: '0',
			clickToSelect : true ,
			data : [objPivotVal],
			columns : objPivotDrawData
		});
	}
}
</script>