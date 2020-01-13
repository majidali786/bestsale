<!DOCTYPE html>
<html lang="en">    
<!-- BEGIN HEAD -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>





        <meta charset="utf-8" />
        <title>BEST SOLUTIONS | User Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="BEST SOLUTIONS" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/global/plugins/font-awesome/css/font-awesome.min.css")?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/global/plugins/simple-line-icons/simple-line-icons.min.css")?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/global/plugins/bootstrap/css/bootstrap.min.css")?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/pages/css/preloader.css")?>" class="cp-pen-styles" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/global/css/components.min.css")?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?= base_url("assets/pages/css/login.min.css?1")?>" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="<?= base_url("favicon.ico")?>" /> </head>
    <!-- END HEAD -->

    <body class=" login">
		
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="<?= base_url("login")?>">
                <img src="<?= base_url("assets/pages/img/logo_t.png?1")?>" alt="" /></a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
		
        <div class="content">
	
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="<?= base_url("login");?>" method="post">
                <h3 class="form-title font-green">Sign In</h3>
				<div class="login-error">
				
				</div>
                
				<div class="form-group show-error">
                 <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text"  autocomplete="off" placeholder="Username" name="username" />
				</div>
                <div class="form-group show-error">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="pword" />
				</div>
				<div class="form-group show-error">
                    <label class="control-label visible-ie8 visible-ie9">Location</label>
					<select class="form-control form-control-solid placeholder-no-fix" name="branch">
					<option value="">Select Location</option>
					<?php 
					foreach($branches as $row):
					?>
					<option value="<?= $row['BCODE'];?>"><?= $row['BNAME'];?></option>
					<?php 
					endforeach;
					?>
					</select>
				</div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">Login</button>
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Remember
                        <span></span>
                    </label>
                </div>
               </form>
           
         </div>
        <div class="copyright"> <?= date("Y")?> © Best Solutions. Accounting Application. </div>
        <script src="<?= base_url("assets/global/plugins/jquery.min.js")?>" type="text/javascript"></script>
        <script src="<?= base_url("assets/global/plugins/bootstrap/js/bootstrap.min.js")?>" type="text/javascript"></script>
        <script src="<?= base_url("assets/global/plugins/js.cookie.min.js")?>" type="text/javascript"></script>
        <script src="<?= base_url("assets/global/plugins/jquery.blockui.min.js")?>" type="text/javascript"></script>
        <script src="<?= base_url("assets/pages/scripts/preloader.js")?>" type="text/javascript"></script>
        <script src="<?= base_url("assets/pages/scripts/login.js")?>" type="text/javascript"></script>
		<script>
		</script>
        <script type="text/javascript">
            $(window).load(function function_name() 
            {
                $("input[name=username]").focus();
            });
        </script>
		
</body>
</html>