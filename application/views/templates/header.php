<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon">
    <title>NPRC</title>
    
	<link rel="stylesheet" href="<?php echo base_url(); ?>js/bootstrap/css/bootstrap.css" >	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/addStyle.css">  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style_size.css">  

	<script src="<?php echo base_url(); ?>js/lib/jquery-3.5.1.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap/js/bootstrap.min.js"></script>
	
	<script src="<?php echo base_url(); ?>js/common/common.js"></script>
  
    <style>
      #header{
        position: absolute;
        top: 0;
        width:100%;
        z-index: 1031;
        background-color: #fff;
      }
      #s-header ul.login-area{
        display: table;
        position: relative;
        margin-top: -30px;
        margin-right: 10px;
        /*right: 20%;top: 50%;*/
        
        text-align: right;
        display: table; 
        font-size: 15px;
        font-weight: 400;
        float: right;
      }
      #s-header ul.login-area li{
        display: table-cell;
        padding-left: 10px;
      }
      
      #s-header ul.login-area a{
        color:#fff;
      }
      .gnb .nav-link{
        padding: 0;
      }
      .gnb li{
        height:50px;
      }
      .gnb .dropdown-toggle{
        content: none;
      }
      .gnb .dropdown-toggle::after{
        content: none;
      }
      .gnb .dropdown-menu{
        width: inherit;
      }
      .login-area a.btn{
        font-size: 14px;
        padding: 4px 12px;
      }
    </style>
	</head>
	<body> 
    <div id="wrap">
      
      <div id="s-header">
        <div class="s-visual">
          <div class="visual-inner">
            <p><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo.png" alt="국가영장류센터 로고"></a></p>
            <ul class="mouse hidden">
              <li class="img"><a href="#"><img src="<?php echo base_url(); ?>images/mouse.png" alt="click and full" /></a></li>
              <li>CLICK AND PULL</li>
            </ul>
            <ul class="login-area navbar-right">
              <?php if(!$this->session->userdata('logged_in')) : ?>
                <li><a href="<?php echo base_url(); ?>users/login">Login</a></li>
              <?php endif; ?>
              <?php if($this->session->userdata('logged_in')) : ?>
                <li><a herf='#'>Welcome! <?php echo $this->session->userdata('user_nm') ;?> </a></li>
                
                <li><a herf="#" onclick="fn_LogOut();"  class='btn btn-info '>Logout</a></li>
                <?php if($this->session->userdata('user_auth') == 'Y' ) : ?>
                  <li><a herf="#" onclick="fn_UserMng();" class='btn btn-primary'>User Mng</a></li>                
                <?php endif; ?>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div> <!--// s-header 슬라이드 영역 -->
      <!--메뉴 영역 시작-->
      <div class="menu-area">
        <div class="gnb">
          <ul>
          <?php
          $request_path = explode( '/' , $_SERVER['REQUEST_URI'] );
          // $request_uri = $_SERVER['REQUEST_URI'];
          $first = true ; 
			    $menus = $this->common_model->get_menu();
          foreach($menus as $menu) :
            if($menu['lvl'] == 1 ){
              if($first  == true){
                echo "<li class='first'>";
                $first = false;
              } else { 
                echo "<li >";
              }
              $parentAddClass = "";
              // echo $request_path[2].'/'.$menu['menu_url'];
              if($request_path[2] == $menu['menu_url']) {
                $parentAddClass = " on ";
              }

              if($menu['child_cnt'] > 0 ) {
                $parentAddClass = $parentAddClass." dropdown-toggle' data-toggle='dropdown'";
              } else {
                $parentAddClass = $parentAddClass."'";
              }
              
              echo "<a id='".$menu['menu_cd']."' href=".base_url().$menu['menu_url']." aria-expanded='false' class='nav-link $parentAddClass >".$menu['menu_nm']."</a>";
              
              if($menu['child_cnt'] > 0 ) {
                echo "<div class='dropdown-menu' style=''>"; 
                foreach($menus as $menu2) :
                  if($menu['menu_cd'] == $menu2['up_menu_cd'] ){
                    echo "<a id='".$menu2['menu_cd']."' href=".base_url().$menu2['menu_url']." class='dropdown-item' >".$menu2['menu_nm']."</a>";
                  }
                endforeach;
                
                echo "</div>"; 
              }
            }
            
            echo "</li >";
            // print_r( $menu).'<br/>';
          endforeach;
          // print_r( $menu);
          // get_menu();
        ?>
            
          </ul>
        </div>
      </div> <!--// menu-area -->
      <!--메뉴 영역 종료-->
      
      <!--콘텐츠 영역 시작-->
      <div id="container" class="container" >


      
      <!-- Flash messages -->
    <div class="container" >
      <?php if($this->session->flashdata('user_registered')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('login_failed')): ?>
        <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('login_failed').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('user_loggedin')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedin').'</p>'; ?>
      <?php endif; ?>

       <?php if($this->session->flashdata('user_loggedout')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedout').'</p>'; ?>
      <?php endif; ?>
      
    </div>
    
    <script>
      function fn_LogOut(){
        var sUrl = "<?php echo base_url(); ?>";
        location.href = sUrl+"users/logout"; 
      }
      function fn_UserMng(){
        var sUrl = "<?php echo base_url(); ?>";
        location.href = sUrl+"usermng"; 
      }
    </script>