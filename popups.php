<div id="backgroundPopup"></div>
    

    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

              <div class="modal-dialog">

                <div class="modal-content">

                  <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>

                    <h1 class="modal-title" id="myModalLabel">WalknSell Login</h1>

                    <p>Please Enter valid Id and password for Signin!</p>

                  </div>

                  <div class="modal-body">

              		<form id="login-form" method="post">

                    <div id="error-login"></div>

                    	<input type="text" class="form-control txt_boxes" placeholder="Username" name="username-login" id="username-login" required= "true">
                        <input type="password" class="form-control txt_boxes" placeholder="Password" name="password-login" id="password-login" required>

						<div id="loading-login"></div>

                        <input type="submit" class="btn_signup" value="login"/>

                        <div class="forg_pass">

                        	<input type="checkbox" name="remember" class="">

                            <p><a href="#">REMEMBER ME</a> / <a href="#">FORGET PASSWORD</a> ?</p>

                            <div class="clearfix"></div>

                        </div>

                    </form>

                     <div class="clearfix"></div>

                  </div>

                  <div class="modal-footer">

                  	<a href="#"><img src="img/join_via_fb.png" width="251" alt="join using facebook" id="login_fb"></a>
                    
						<script>
									(function ($) {
									$(function () {
										$("#login_fb").on("click", function () {
											FB.login(function(response) {
												if (response.authResponse) {
													//_wdfb_notifyAndRedirect();
													LoginFormFB(_userID);
												}
											});
										});
									});
									})(jQuery);
    					</script>

                    <p>IF PROBLEM SIGNING IN THEN <a href="#">CLICK HERE »</a></p>

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

                    

                    	<input type="text" class="form-control txt_boxes" placeholder="First Name" name="firstName" id="firstName" required>

                        <input type="text" class="form-control txt_boxes" placeholder="Last Name" name="lastName" id="lastName" required>

                        <input type="email" class="form-control txt_boxes" placeholder="Email Address" name="email" id="email" required>

                        	<input type="text" class="form-control txt_boxes" name="regcollege" placeholder="School" size="" id="regsearch" onKeyUp="regfindmatch();" autocomplete="off" required>

                     <ul id ="regresults" name="school" >

                    </ul>

                <div class="regclear"></div>

                        <input type="text" class="form-control txt_boxes" placeholder="Create your Username" name="username" id="username" required>

                        <input type="password" class="form-control txt_boxes" placeholder="Create a Password" name="password" id="password" required>

                        <input type="password" class="form-control txt_boxes" placeholder="Confirm Password" name="verifyPassword" id="verifyPassword" required>

                      

                        <center>

                        <div id="loading"></div>

                        <input type="submit" class="btn_signup" value="submit" />

                        <p class="terms">By signing up, I agree to WalknSell <a href="#" class="terms_link">terms of service.</a></p>
</center>
                    </form>

                     <div class="clearfix"></div>

                  </div>

                  <div class="modal-footer">

                  	<a href="#"><img src="img/join_via_fb.png" width="251" alt="join using facebook" id="register_fb"></a>
                    
                    <script>
									(function ($) {
									$(function () {
										$("#register_fb").on("click", function () 
										{
											FB.login(function(response) {
												if (response.authResponse) {
													//_wdfb_notifyAndRedirect();
													signupFormFB(_userID,_fname,_lname,_email,_profilePic);
												}
											});
										});
									});
									})(jQuery);
    					</script>

                    <p>ALREADY A MEMBER? <a href="#">SIGN IN »</a></p>

                  </div>

                </div>

               

              </div>

</div>
