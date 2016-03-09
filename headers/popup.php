<?php ?><!-- <script src="/js/fb.js"></script> -->
<div id="backgroundPopup"></div>
  <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
          <h1 class="modal-title" id="myModalLabel">WalknSell Login</h1>
        </div>
        <div class="modal-body">
          <form id="login-form" method="post">
            <input type="text" class="form-control txt_boxes" placeholder="Username" name="username-login" id="username-login" required>
            <input type="password" class="form-control txt_boxes" placeholder="Password" name="password-login" id="password-login" required>
            <div id="loading-login" class="genload"></div>
            <input type="submit" class="btn_signup" value="login"/>
            <div class="forg_pass">
              <input type="checkbox" name="remember"><p>Remember me</p>
			  <p><a href="forget_password" style='text-decoration:underline !important;' target="_blank">Forgot Password?</a></p>
              <div class="clearfix"></div>
            </div>
          </form>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer"> <a style="display:none;" href="#"><img src="/img/login_via_fb.png" width="251" alt="join using facebook" id="login_fb"></a> 
            
          <script>
								(function ($) {
									$(function () {
										$("#login_fb").on("click", function () {
											initfb('login');
                                            LoginFormFB();
										});
									});
									})(jQuery);
    					</script>
		<p style="margin-top: -18px;">Not a member yet?<a href="#" data-toggle='modal' onclick="$('#login').modal('toggle')" data-target='#register'>
            Register now »</a></p>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
          <h1 class="modal-title" id="myModalLabel">User Registration Form</h1>
          <p>Register here to become a member of our website</p>
        </div>
        <div class="modal-body">
          <form id="signup" method="post">
            <div id="error"></div>
            <div style="float:left; width:91%; margin: 0 5%;"><input maxlength="15" type="text" class="form-control txt_boxes names" placeholder="First Name" name="firstName" id="firstName" required>
                <input type="text" class="form-control txt_boxes names" maxlength="10" placeholder="Last Name" name="lastName" id="lastName" required></div>
            <input type="email" class="form-control txt_boxes" placeholder="Email Address" name="email" id="email" required>
            <input type="text" class="form-control txt_boxes" name="regcollege" placeholder="School" size="" id="regsearch" onKeyUp="" autocomplete="off" required>
            <ul id ="regresults" style="margin-top: -9px;margin-left: 5%;width: 82.5%;" name="school" >
            </ul>
            <div class="regclear"></div>
            <input type="text" pattern=".{5,15}" class="form-control txt_boxes" placeholder="Create your Username" name="username" id="username" required>
            <input type="password" pattern=".{5,15}" class="form-control txt_boxes" placeholder="Password" name="password" id="password" required>
            <input type="password" pattern=".{5,15}" class="form-control txt_boxes" placeholder="Confirm Password" name="verifyPassword" id="verifyPassword" required>
            <input type="hidden" name="typeAcc" id="typeAcc">
            <center>
              <div id="loading" class="genload"></div>
              <input type="submit" class="btn_signup" value="submit" />
              <p class="terms">By signing up, I agree to WalknSell <a href="/privacy-policy" class="terms_link"><b>Terms of Service.</b></a></p>
            </center>
          </form>
          <div class="clearfix"></div>
        </div>
          <div class="modal-footer"> <a style="display:none;" href="#"><img src="/img/join_via_fb.png" width="251" alt="join using facebook" id="register_fb"></a> 
          <script>
									(function ($) {
									$(function () {
										$("#register_fb").on("click", function () 
										{
											initfb('register');
										});
									});
									})(jQuery);
    					</script>
          <p>Already a member? <a href="#" data-toggle='modal' onclick="$('#login').modal('toggle')" data-target='#register'>Sign in</a></p>
        </div>
      </div>
    </div>
  </div>
  

  
   <div class="modal fade" id="contactus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
          <h1 class="modal-title" id="myModalLabel">WalknSell Contact Us</h1>
          <p>We'd love to help. Feel free to say hello!</p>
        </div>
        <div class="modal-body">
          <form id="contact-form" method="post">
            <div id="error-login"></div>
            <input type="text" class="form-control txt_boxes contact-form" placeholder="Your Name" name="name-contact" id="name-contact" required= "true">
            <input type="email" class="form-control txt_boxes contact-form" placeholder="Your Email" name="email-contact" id="email-contact" required>
            <textarea name="message-contact" id="message-contact" maxlength="250" style="width: 85%; margin-left: auto; margin-right: auto;resize:none;" 
            class="form-control txt_boxes" placeholder="Enter Your Message" required></textarea>
            <div id="loading-contact" class="genload"></div>
            <input type="submit" class="btn_signup" value="send"/>
         </form>
          <div class="clearfix"></div>
        </div>
       
      </div>
    </div>
  </div>


     <div class="modal fade" id="video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
          <h1 class="modal-title" id="myModalLabel">Welcome to WalknSell.com</h1>
          <p></p>
        </div>
        <div class="modal-body">
          <iframe width="505" id='playerid' height="315"
          src="">
          </iframe>
          <div class="clearfix"></div>
        </div>
       
      </div>
    </div>
  </div>
