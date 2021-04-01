
var gvTotalRowCount = 0; // 전체 데이터 건수
var gvRowCount = 25;	// 한 페이지에서 보여줄 행 수
var gvPageButtonCount = 10;		// 페이지 네비게이션에서 보여줄 페이지의 수
var gvCurrentPage = 1;	// 현재 페이지
var gvTotalPage = Math.ceil(gvTotalRowCount / gvRowCount);	// 전체 페이지 계산
var gvSearchFunc = "";

/*
null 체크 
*/
function gfn_isNull(str) {
	if (str == null)
		return true;
	if (str == "NaN")
		return true;
	if (new String(str).valueOf().replace(/-/g,"").search("undef") > -1)
		return true;
	var chkStr = new String(str);
	if (chkStr.valueOf().replace(/-/g,"").search("undef") > -1)
		return true;
	if (chkStr == null)
		return true;
	if (chkStr.toString().length == 0)
		return true;
	return false;
}
/*
 * 특정 영역의 정보 가져오기 
 */
function gfn_GetData($area){
	var rtn = {};
	// disabled 삭제
	var disabled = $area.find(':input:disabled').removeAttr('disabled');
	// 해당 영역의 컴퍼넌트를 선언
	$area.find("input,select").each(function(i,obj){

		var sValue = obj.value;
		if( !gfn_isNull( obj.value )){
			rtn[obj.name] = obj.value; 

			var sClass = obj.className;
			if( sClass.indexOf('date-select-input') >-1 ){
				rtn[obj.name] = gfn_isReplace(rtn[obj.name] , '-');
			}
		}
	});
	// disabled 처리
	disabled.attr('disabled','disabled');
	return rtn;
}

function replaceNumberWithCommas(number) {
    if (typeof (number) !== "undefined" && number !== null) {
        var n = number.toString().split(".");
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return n.join(".");
    }
    else { 
        return 0;
    }
};


//페이징 네비게이터를 동적 생성합니다.
function gfn_createPagingNavigator(obj, goPage,searchFunc) {
	if( gfn_isNull(goPage)) return false;
	debugger;
	var retStr = "<ul class='pagination'>";
	var prevPage = parseInt((goPage - 1)/gvPageButtonCount) * gvPageButtonCount;
	var nextPage = ((parseInt((goPage - 1)/gvPageButtonCount)) * gvPageButtonCount) + gvPageButtonCount + 1;
	var objId = "";
	
	prevPage = Math.max(0, prevPage);
	nextPage = Math.min(nextPage, gvTotalPage);
	
	gvSearchFunc = searchFunc;
			
	//pageing 출력될 Div object
	if(!gfn_isNull(obj)){
		if(typeof obj == "object"){
			objId = obj.attr("id");
		}else{
			objId = obj;
		}
	}
	

	// 처음
	retStr += "<li class='page-item'><a class='page-link' href='javascript:gfn_moveToPage(\""+ objId +"\",1);'>&laquo;</a></li>";
	
	for (var i=(prevPage+1), len=(gvPageButtonCount+prevPage); i<=len; i++) {
		if (goPage == i) {
			retStr += "<li class='page-item active'><a class='page-link' href='#'>"+ i + "</a></li>"; 
		} else {
			retStr += "<li class='page-item'><a class='page-link' href='javascript:gfn_moveToPage(\""+ objId + "\"," + i + ");'>" + i + "</a></li>"; // <a href='javascript:gfn_moveToPage(\""+ objId + "\"," + i + ")'><span class='aui-grid-paging-number'>";
// 			retStr += i;
//			retStr += "</span></a>";
		}
		
		if (i >= gvTotalPage) {
			break;
		}		
	}                    
                  
	// 마지막
	retStr += "<li class='page-item'><a class='page-link' href='javascript:gfn_moveToPage(\""+ objId +"\"," + gvTotalPage + ");'>&raquo;</a></li>";
	retStr += "</ul>"
	if(gvTotalPage > 0){
		$("#" + objId).html(retStr);
	
	}else{
		$("#" + objId).html("");
	}
	
	$("#" + objId).show();
}

function gfn_moveToPage(obj, goPage) {
	
	if(goPage < 1) goPage = 1;
	
	if(!gfn_isNull(obj)){
		if(typeof obj == "string"){
			obj = $("#" + obj);
		}
	}
				
	// 페이징 네비게이터 업데이트
	gfn_createPagingNavigator(obj, goPage,gvSearchFunc);
	
	// 현재 페이지 보관
	gvCurrentPage = goPage;
	
	//gvRowCount 만큼 데이터 요청
	if(!gfn_isNull(gvSearchFunc)){
		if(typeof(window[gvSearchFunc]) == "function"){
			eval(gvSearchFunc + "(goPage)");
		}
	}
}