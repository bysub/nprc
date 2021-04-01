<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>NPRC</title>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>js/bootstrap/css/bootstrap.css" >	
	<link rel="stylesheet" href="<?php echo base_url(); ?>js/bootstrap-table/bootstrap-table.min.css" >	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/addStyle.css">  
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style_size.css">  

	<script src="<?php echo base_url(); ?>js/lib/jquery-3.5.1.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap-table/bootstrap-table.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap-table/bootstrap-table-locale-all.min.js"></script>
	
	<script src="<?php echo base_url(); ?>js/common/common.js"></script>
	
	<style>
		#tbgenomi {
			border : 0 ;
		}
		#tbgenomi td{
			border : 0 ;
			margin: 0 4px;
		}
	</style>
</head>
<body>
	<div id="wrap">
		<div id="header">
			<div class="visual">
				<div class="visual-inner">
					<p><a href="<?php echo base_url(); ?>"><img src="images/logo.png" alt="국가영장류센터 로고"></a></p>
					<dl>
						<dt>
							NPRC<br/>Primate Genome Database
						</dt>
						<dd class="line"><span class="blind">line</span></dd>
						<dd>
							Innovation of Biomedical Research with<br/>Nonhuman Primates
						</dd>
					</dl>
				</div>
			</div>

			<div class="searchwrap">
				<div class="search-inner">
					<div class="search">						
						<p>National Primate Reseaarch Center <span>SEARCH</span></p>
						<p class="form">
							<label for="search"><span class="blind">검색</span></label>
							<input type="text" id="search" class="sform"> <!--placeholder="검색할 내용을 입력해 주세요" -->
							<button type="button" class="sbtn" onclick="fn_ReSearch();"><span class="blind" >검색</span></button>
						</p>
						<script>
							function fn_ReSearch(){
								if( !gfn_isNull($("#search").val())) {
									window.location.href = "<?php base_url(); ?>" + 'research/'+$("#search").val();
								} else {
									return false;
								}								
							}
							$("#search").on("keydown",function(event){
								if(event.keyCode == 13){
									fn_ReSearch();
								}
							});
						</script>
						
					</div>
				</div>
			</div>

			<div class="sect1">
				<h3>Species</h3>
                <a href="<?php echo base_url(); ?>overview/agm" >
				<dl class="pic1" >
					<dt><span class="blind">African green monkey</span></dt>
					<dd>African green monkey &#40;Chlorocebus aethiops&#41;</dd>
				</dl>
                </a>
                <a href="<?php echo base_url(); ?>overview/cem" >
				<dl class="pic2">
					<dt><span class="blind">Crab-eating monkey</span></dt>
					<dd>Crab-eating monkey &#40;Macaca fascicularis&#41;</dd>
				</dl>
                </a>
                <a href="<?php echo base_url(); ?>overview/phm" >
				<dl class="pic3">
					<dt><span class="blind">Rhesus monkey</span></dt>
					<dd>Rhesus monkey &#40;Macaca mulatta&#41;</dd>
				</dl>
                </a>
			</div> <!--// sect1 -->
		</div> <!--// header 슬라이드 영역 -->

		<div id="container">
			<h3>Genomic data</h3>
			<div class="content">
				<table id='tbgenomi'>
					<colgroup>						
						<col width="33%">
						<col width="34%">
						<col width="33%">
					</colgroup>
					<tr>
						<td>
							<div class="card text-white bg-info mb-3" style="max-width: 99%;" onclick="fn_ReSearchType('WGRS');">
								<div class="card-body">
									<h4 class="card-title">Genome(WGRS)</h4>
									<p class="card-text">Variant information</p>
								</div>
							</div>
						</td>
						<td>
							<div class="card text-white bg-info mb-3" style="max-width: 99%;" onclick="fn_ReSearchType('RNA');">
								<div class="card-body">
									<h4 class="card-title">Expression(RNA-Seq)</h4>
									<p class="card-text">Expression information</p>
								</div>
							</div>
						</td>
						<td>
							<div class="card text-white bg-info mb-3" style="max-width: 99%;" onclick="fn_ReSearchType('Methyl');">
								<div class="card-body">
									<h4 class="card-title">Methylation(Methyl-Seq)</h4>
									<p class="card-text">Methylation information</p>
								</div>
							</div>

						</td>
					</tr>
				</table>
				<script>
					function fn_ReSearchType(sType){
						if( !gfn_isNull(sType)) {
							window.location.href = "<?php base_url(); ?>" + 'research?stp='+sType;
						} else {
							return false;
						}								
					}
				</script>
				
				<!--
				<dl class="block left w30p">
					
				</dl>
				<dl class="block left w30p">
					<div class="card text-white bg-primary mb-3" style="max-width: 20rem;">
						<div class="card-body">
							<h4 class="card-title">Expression(RNA-Seq)</h4>
							<p class="card-text">Expression information</p>
						</div>
					</div>
				</dl>
				
				<dl class="block left w30p">
					<div class="card text-white bg-primary mb-3" style="max-width: 20rem;">
						<div class="card-body">
							<h4 class="card-title">Methylation(Methyl-Seq)</h4>
							<p class="card-text">Methylation information</p>
						</div>
					</div>
				</dl>
						-->
			</div>
			<!--
			<dl class="block-full block">
				<dt class="tit">Genomes</dt>
				<dd>컨텐츠영역</dd>
			</dl>
			-->
		</div> <!--// container -->
	</div> <!--// wrap -->
</body>
</html>