<?php

include 'headers/client-details.php';

		$upgrade = $_GET['upgrade'];
if($_GET['active'])
{
	$error = "Your account has been successfully activated";	
}

	if($_POST)
	{	
		include 'headers/connect_to_mysql.php';
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$query = "SELECT * FROM registeration WHERE username like '$username' AND password like '$password'";
		$result = mysqli_query($con,$query);
		$row = mysqli_fetch_array($result);
		
		if(mysqli_num_rows($result) == 1)
		{
			
			if($row['active']==1){
				session_start();
				$_SESSION['username'] = $username;
				if($upgrade==1)
				{
					header('Location: select-template.php?upgrade=1');
				}
				else
				{
					header('Location: select-template.php');
				}
			}
			else{
				$error="You have not activated your account yet.";	
			}
			
		}
		else
		{
			$error = "Username and password do not match or you do not have an account yet.";
			
		}
		
	}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="generator" content="Joomla! - Open Source Content Management" />
  <title>Login</title>
  <link rel="stylesheet" href="http://www.bizsocialetc.info/plugins/system/rokbox/themes/clean/rokbox-style.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/libraries/gantry/css/grid-12.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/gantry-core.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/joomla-core.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/community-a.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/community-a-extensions.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/utilities.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/typography.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/demo-styles.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/template.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/template-webkit.css" type="text/css" />
  <link rel="stylesheet" href="http://www.bizsocialetc.info/templates/rt_fresco/css/fusionmenu.css" type="text/css" />
  <link rel="stylesheet" href="css/custom.css" type="text/css" />
  <style type="text/css"></style>
  <script src="http://www.bizsocialetc.info/media/system/js/mootools-core.js" type="text/javascript"></script>
  <script src="http://www.bizsocialetc.info/media/system/js/core.js" type="text/javascript"></script>
  <script src="http://www.bizsocialetc.info/media/system/js/mootools-more.js" type="text/javascript"></script>
  <script src="http://www.bizsocialetc.info/plugins/system/rokbox/rokbox.js" type="text/javascript"></script>
  <script src="http://www.bizsocialetc.info/plugins/system/rokbox/themes/clean/rokbox-config.js" type="text/javascript"></script>
  <script src="http://www.bizsocialetc.info/templates/rt_fresco/js/gantry-totop.js" type="text/javascript"></script>
  <script src="http://www.bizsocialetc.info/templates/rt_fresco/js/load-transition.js" type="text/javascript"></script>
  <script src="http://www.bizsocialetc.info/modules/mod_roknavmenu/themes/fusion/js/fusion.js" type="text/javascript"></script>
  <script src="http://www.bizsocialetc.info/modules/mod_rokajaxsearch/js/rokajaxsearch.js" type="text/javascript"></script>
  </head>
  <body  class="mainstyle-community-a backgroundlevel-high font-family-fresco font-size-is-default logo-type-fresco menu-type-fusionmenu typography-style-light col12 option-com-users menu-login">
  <div id="rt-page-surround">
    <div class="main-bg">
      <div class="rt-container">
        <div id="rt-drawer">
          <div class="clear"></div>
        </div>
        
        <?php include 'headers/navigation.php';?>
        
        <div id="rt-transition" class="rt-hidden">
          <div id="rt-main" class="mb8-sa4">
            <div class="rt-container">
              <div class="rt-grid-8">
                <div class="rt-block component-block">
                  <div class="component-content">
                    <div class="login">
                      <h1> Login </h1>
                      <?php
	
	if(isset($error)){
	
    echo "<div id='system-message-container'>
				<dl id='system-message'>
				<dt class='error'>Error</dt>
				<dd class='error message'>
					<ul>
						<li>$error</li>
					</ul>
				</dd>
				</dl>
			</div>";
	}
	
			?>
                      <form action="login.php?upgrade=<?php echo $upgrade;?>" method="post">
                        <fieldset>
                          <div class="login-fields">
                            <label id="username-lbl" for="username" class="">User Name</label>
                            <input type="text" name="username" id="username" class="validate-username" size="25"/>
                          </div>
                          <div class="login-fields">
                            <label id="password-lbl" for="password" class="">Password</label>
                            <input type="password" name="password" id="password"  class="validate-password" size="25"/>
                          </div>
                          <div class="login-fields">
                            <label id="remember-lbl" for="remember">Remember me</label>
                            <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="Remember me" />
                          </div>
                          <button type="submit" class="button" style="height:40px;">Log in</button>
                          <input type="hidden" name="return" value="Z29vZ2xlLmNvbQ==" />
                          <input type="hidden" name="3e6db9ec6f650b7fa6c4a00595126676" value="1" />
                        </fieldset>
                      </form>
                    </div>
                    <div>
                      <ul>
                        <li> <a href="forget-password.php"> Forgot your password?</a> </li>
                        <li> <a href="reset-username.php"> Forgot your username?</a> </li>
                      </ul>
                    </div>
                  </div>
                  <div class="clear"></div>
                </div>
              </div>
              <div class="rt-grid-4 sidebar-right">
                <div id="rt-sidebar-a">
                  <div class="bg3 mediumheader">
                    <div class="rt-block">
                      <div class="module-surround">
                        <div class="custom-header" style="background-image:url(http://www.bizsocialetc.info/images/rocketlauncher/frontpage/module-title-bg/bg3.jpg)">
                          <div class="module-title">
                            <h2 class="title">Social Card</h2>
                          </div>
                        </div>
                        <div class="module-content">
                          <div>
                            <h4 class="nomarginbottom medmargintop">Share With Your Friends</h4>
                            <p>Once you have created your Free <?php echo $username_client; ?>, you can send to all of your friends and social media contacts. Have fun sharing all day long – All in one place!!</p>
                          </div>
                          <!-- <p><a class="readon" href="#"><span>See More</span></a></p> -->
                          <div class="clear"></div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clear"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="rt-footer-surround">
      <div class="rt-container">
        <div class="rt-footer-inner">
          <div id="rt-copyright">
            <div class="rt-grid-4 rt-prefix-4 rt-alpha">
              <div class="rt-block"> <span class="copytext">&copy; 2013 - Developed by <a href="http://www.mobipowerapps.com">MobiPowerApps</a></span> </div>
            </div>
            <div class="rt-grid-4 rt-omega"> <a href="#" class="rt-totop"></a> </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
