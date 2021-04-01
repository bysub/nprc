<?php
	class Common_model extends CI_Model{
		public function __construct(){
			$this->load->database(); 
		}
		/*
		$sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";
$this->db->query($sql, array(3, 'live', 'Rick'));
		*/
		public function get_menu(){
			$sql = "WITH RECURSIVE v_tree_menu(menu_cd , menu_nm , menu_url , menu_gb , sort_ord , up_menu_cd , admin_menu , lvl, path) AS (
				SELECT X.menu_cd , X.menu_nm , X.menu_url , X.menu_gb , X.sort_ord , X.up_menu_cd , X.admin_menu
							 , 1 AS LVL 
							 , CAST(CONCAT( LPAD( X.sort_ord ,3 ,'0') , RPAD( IFNULL(X.MENU_CD,'0'),6 ,'0')   ) AS CHAR(100)) AS PATH
				FROM tb_menu X
				WHERE X.up_menu_cd IS NULL 
				 UNION ALL 
				SELECT C.menu_cd , C.menu_nm , C.menu_url , C.menu_gb , C.sort_ord , C.up_menu_cd , C.admin_menu
					  , R.LVL+1 AS LVL
					   , CONCAT( IFNULL(R.PATH,'') , LPAD( C.sort_ord ,3 ,'0') , RPAD( IFNULL(C.MENU_CD,'0'),6 ,'0')   ) AS PATH
				FROM tb_menu C
					  INNER JOIN v_tree_menu R ON R.MENU_CD = C.UP_MENU_CD  	 
			)
			SELECT A.menu_cd 
			     , A.menu_nm 
				 , A.menu_url 
				 , A.menu_gb 
				 , A.sort_ord 
				 , A.up_menu_cd 
				 , A.admin_menu 
				 , A.lvl
				 , A.path
				 , ( SELECT COUNT(1) FROM tb_menu T WHERE t.up_menu_cd = A.menu_cd ) AS child_cnt
			FROM v_tree_menu A
			WHERE A.admin_menu = 'N' 
			   OR  A.admin_menu = ( SELECT ( case when max(user_auth) = 'admin' then 'Y' ELSE 'N' END ) FROM tb_user WHERE user_id = '1234' )
			ORDER BY A.path";

			$query = $this->db->query($sql);
			
			return $query->result_array();
		}
		public function get_code($grpCd){
			$sql = "SELECT a.grp_cd , b.dtl_cd , b.dtl_nm , b.sort_ord
			FROM tb_code_mst a 
				 INNER JOIN tb_code_dtl b ON a.grp_cd = b.grp_cd 
			WHERE b.use_yn ='Y'
			  AND a.grp_cd = ?
			ORDER BY b.sort_ord , b.dtl_cd";
			$query = $this->db->query($sql,array($grpCd));// $this->db->query($sql, array(3, 'live', 'Rick'));
			return $query->result_array();
		}

		public function get_keyword($keyword){
			$sql = "with recursive
						input as (
							select  REPLACE( ? ,'-',' ' )  as keyword
						),
						recurs as (
							select  1 as pos, keyword as remain, substring_index( keyword, ' ', 1 ) as word
								from input
							union all
							select  pos + 1, substring( remain, char_length( word ) + 2 ),
								substring_index( substring( remain, char_length( word ) + 2 ), ' ', 1 )
								from recurs
								where char_length( remain ) > char_length( word )
						)
						, tbl_keywork_score AS (
					SELECT A.GRP_CD , A.DTL_CD , SUM( CASE WHEN A.REF_NM = b.word then 5 
														WHEN A.REF_NM LIKE CONCAT( b.word , '%' ) THEN 3
														WHEN A.REF_NM LIKE CONCAT( '%',b.word,'%' ) THEN 1 
														ELSE 0 END ) AS keyword_score
					FROM TB_CODE_REF A 
						, recurs b
					WHERE A.REF_CD = 'keyword'
					AND A.REF_NM LIKE CONCAT( '%', b.word , '%' )
					GROUP BY A.GRP_CD , A.DTL_CD
						)
					SELECT XXX.grp_cd ,XXX.dtl_cd 
					FROM (
					SELECT X.grp_cd ,X.dtl_cd , X.keyword_score
							,@RANKT := IF(@LAST > X.keyword_score, @RANK := @RANK + 1, @RANK) AS RANKING
							,@LAST := X.keyword_score AS LAST_COLUMN
					FROM tbl_keywork_score X
					, (SELECT @RANK := 0) XX
					) XXX
					WHERE RANKING = 0 ";
			$query = $this->db->query($sql,array($keyword));
			return $query->result_array();
		}
	}