<?php
session_start();
include 'headers/_user-details.php';
if(empty($_SESSION['username'])){
    header('Location: /?login=false');
}


$query_id = "SELECT max(id)+1 as kork_id from korks";
$result=  mysqli_query($con,$query_id);
$row_id = mysqli_fetch_assoc($result);
$kork_id = $row_id['kork_id'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>Create Deal</title>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/bootstrap-tagsinput.css" type="text/css">
<link rel="stylesheet" href="/css/style.css" type="text/css">
<link rel='shortcut icon' href='img/icon.ico' />
<link rel="stylesheet" href="/css/media.css" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/fontello.css" type="text/css">
<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/css/jquery.sidr.dark.css" type="text/css">
<link href="/css/tooogle.css" rel="stylesheet">

<script src="/js/dropzone.js"></script>
<link href="/css/dropzone.css" rel="stylesheet">

<style>
*, *:before, *:after {
	-webkit-box-sizing: initial;
	-moz-box-sizing: initial;
	box-sizing: initial;
}
img {
	vertical-align: top;
}
input[type="file"] {
display: initial;
}
p {
margin: initial;
}
</style>
<!--<script src="js/jquery.min.js"></script>-->
<script src="/js/jquery-1.10.2.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.sidr.min.js"></script>
<script src="/js/custom.js"></script>
<script src="/js/bootstrap-tagsinput.js"></script>

<script>
$(document).ready(function() {
  $('#simple-menu').sidr();
});
</script>

<!--[if lt IE 9]>
	<script src="js/lib/html5shiv.js"></script>
<![endif]-->
</head>

<body>
<div class="inbox_des create_gig">
  <div class="header_bg">
    <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
      <?php include 'headers/menu-top-navigation.php';?>
    </header>
    <div class="clear"></div>
  </div>
  <!--/.header_bg-->
<?php include 'headers/popup.php';?>
  <div class="content_inbox">
  <form name="create_gig" id="fileupload" method="post" enctype="multipart/form-data">
  	<!--<form id="fileupload"  method="POST" enctype="multipart/form-data">    action="create_gig.php" -->

  <!--<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">-->
  
    <h2>Create a new deal</h2>
    <div class="left_gig">
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_title">Deal Title</label>
        </div> 
        <div class="input_wrap gig_title">
            <input class="gig_text title" style="width:95%" maxlength="81" id="korkName" name="korkName"
            onKeyDown="limitText(this.form.korkName,this.form.em,60);" 
            onKeyUp="limitText(this.form.korkName,this.form.em,60);" required>
            <span id="minimum" class="minmum_1">Minimum 15 characters</span>
            <font class='warning'>You have <input class="limit" style="border: none;padding-left: 3px;width: 13px;" readonly type="text" name="em" size="1" value="60"> characters left.</font>
        </div>
        <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Describe your Deal.</h3>
              <p>This is your Deal title. Choose wisely, you can only use 60 characters.</p>
            </figcaption>
            <div class="gig-tooltip-title"></div>
          </figure>
          <div class="error"></div>
        </aside>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_category">Category</label>
        </div>
        <div class="input_wrap">
          <!--<div class="fake-dropdown fake-dropdown-double"> <a  class="dropdown-toggle category" data-toggle="dropdown" data-autowidth="true" >CATEGORIES</a>
            <div class="dropdown-menu mega_menu" >
              <div class="dropdown-inner">
                <ul>
                  <li>Gifts</li>
                  <li>Graphics & Design</li>
                  <li><a href="#">Video & Animation</a></li>
                  <li><a href="#">Online Marketing</a></li>
                  <li><a href="#">Writing & Translation</a></li>
                  <li><a href="#">Advertising</a></li>
                  <li><a href="#">Business</a></li>
                </ul>
              </div>
            </div>
            <div class="clear"></div>
          </div>-->
		<select class="fake-dropdown fake-dropdown-double dropdown-inner " style="width:95%" name="category" id="gigCategory" required>
        <option value="0">Select Category</option>
		<?php
			$sql = "SELECT category FROM kork_categories";
			$option_num = 1;
			foreach($dbh->query($sql) as $row) {
				$category = $row['category'];
				echo "<option value='$option_num'>$category</option>";
				$option_num++;
			}
		?>
        </select>
        </div>
        <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Select a Category.</h3>
              <p>This is your Deal category. Choose wisely for better promotion.</p>
            </figcaption>
            <div class="gig-tooltip-category"></div>
          </figure>
        </aside>
      </div>
     <div class="form_row">
        <div class="label_wrap">
          <label for="gig_gallery">Deal gallery</label>
        </div>
        <div class="input_wrap">
        <div id="my-dropzone" class="dropzone">
			<div class="dropzone-previews"></div>
		</div>
    
          <!--<div class="file_input_inner">
            <!--  <button type="file" class="btn_signup" name="file" id="name">Browse</button>  -->
            
            <!--<input id="fileupload" type="file" name="file[]" multiple required>
            
            <p>JPEG file, 2MB Max, <span class="grey_c">you own the copyrights</span></p>
          </div>-->
		  
        </div>
        <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Add your deal images .</h3>
              <p>Upload photos that describe or relate to your Gig. They can be samples of your work. Allowed: JPEG | JPG | PNG, Minimum: 550 pixels wide, 370 pixels height, up to 5 MB.</p>
            </figcaption>
            <div class="gig-tooltip-gallery"></div>
          </figure>
        </aside>
      </div>
      
      <div class="form_row">
        <div class="label_wrap">
          <label for="taginput">Tags</label>
        </div>
        <div class="input_wrap gig_tags">
          <input class="gig_tags_text" type="text" data-role="tagsinput" id="taginput"  name="taginput" required />
        </div>
          <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Add tags.</h3>
              <p>You can add upto 5 tags. Use "<b>,</b>"  For tag seperation. Choose wisely for better promotion.</p>
            </figcaption>
            <div class="gig-tooltip-tag"></div>
          </figure>
        </aside>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="priceinput">Price</label>
        </div>
        <div class="input_wrap gig_price">
          <input class="gig_text price" type="number" min="1" max="500000" pattern="^[1-9]\d*$" id="priceinput" name="priceinput" 
                 style="width:92.5%;display:block;padding-left:25px;" required/>
            <span class="unit">Rs</span>
          </div>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_desc">Description</label>
        </div>
        <div class="input_wrap gig_desc">
          <textarea class="gig_text desc" rows="10" maxlength="601" name="korkDesc" id="korkDesc" required
          onKeyDown="limitTextarea(this.form.korkDesc,this.form.countdown,600);" 
          onKeyUp="limitTextarea(this.form.korkDesc,this.form.countdown,600);"></textarea>
        <span id="minimum" class="minmum_2">Minimum 120 character</span>
            <font class='warning'>You have <input class="limit1" style="border: none;padding-left: 3px;width: 19px;" readonly type="text" name="countdown" size="1" value="600"> characters left.</font>

        </div>
       <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Add Description.</h3>
              <p>Describe what you are offering. Be as detailed as possible so buyers will be able to understand if this meets their needs. </p>
            </figcaption>
            <div class="gig-tooltip-description"></div>
          </figure>
        </aside>
      </div>
        <div class="form_row">
        <div class="label_wrap" style="float: left;">
          <label for="status">Deal Status</label>
        </div>
        <div class="input_wrap gig_price">
            <input type="hidden" value="0" name="publish" />
            <input name="publish" id="cmn-toggle-7" class="cmn-toggle cmn-toggle-yes-no" checked type="checkbox">
            <label for="cmn-toggle-7" data-on="Publish" data-off="UnPublish"></label>
          </div>
      </div>
     <!-- <div class="form_row">
        <div class="label_wrap">
          <label for="gig_title">instruction for buyer</label>
        </div>
        <div class="input_wrap gig_title">
          <textarea class="gig_desc_text" rows="2" maxlength="80"></textarea>
        </div>
      </div> -->
    </div>
    <div class="bottom_save_block">
  <div id="shoading" class="genload"></div>
      <button id="submit-all" type="submit" class="btn_signup">Submit &amp; Continue</button>
      <!--<button class="btn_signup btn_cancel">Cancel</button>-->
    </div>
	</form>
    <div class="clear"></div>
  </div>
  <?php include 'headers/menu-bottom-navigation.php' ?>
</div>
<script>
$(function() {      
          $("nav.main_nav li#admin > ul").css("display","none");
        
			       
           			$("nav.main_nav li#admin").hover(function () {   
         							  $( "nav.main_nav li#admin > ul" ).css( "display", "block" );
	            },          
            	function () {      
						$( "nav.main_nav li#admin > ul" ).css( "display", "none" );
				        });   
				     });
					 
</script> 
<script>
	$(document).ready(function(e) {
        $('.input_wrap').on('focus', function(){
			$(this).find('.gig-tooltip').css('background','red');
        });
    });
</script> 
<script src="/js/school-list.js"></script>
<!--multiple image upload starts here -->
<script>
    $('input[type="number"]').keyup(function(){
        var scream = this.value;
        if ( scream.charAt( 0 ) == '0' ) {
            alert('Deal price Cannot start with 0');
        document.getElementById('priceinput').focus();
        document.getElementById("priceinput").value = "";
        }
        else if ( scream.charAt( 0 ) == '-' ) {
        alert('Sorry you cant add your deal price in negative number');
        document.getElementById('priceinput').focus();
        document.getElementById("priceinput").value = "";        
        }
        });
</script>
<script>
    $("#submit-all").on('click',function(){
    if($('#korkName').val() != '')
    {
        if ($("#korkName").val().length < 15)
        {
		$('.genload').css("padding-top", "20px");
		$('.genload').css("padding-bottom", "20px");
		$('.genload').html('<span class=\'alert alert-danger\'><strong></strong>Deal Title Must contain at atleast 10  Characters </strong></span>');
		return false;    
        }
        else if($("#gigCategory option:selected" ).text() == 'Select Category')
        {
		$('.genload').css("padding-top", "20px");
		$('.genload').css("padding-bottom", "20px");
		$('.genload').html('<span class=\'alert alert-danger\'><strong></strong>Please Select any Category to define your Deal</strong></span>');
		return false;    
        }
        else if($('#taginput').val() == ''){
		$('.genload').css("padding-top", "20px");
		$('.genload').css("padding-bottom", "20px");
		$('.genload').html('<span class=\'alert alert-danger\'><strong></strong>Deal Tag field Cannot be left empty!  </strong></span>');
		return false;    
        }
        else if ($("#korkDesc").val().length < 120)
        {
		$('.genload').css("padding-top", "20px");
		$('.genload').css("padding-bottom", "20px");
		$('.genload').html('<span class=\'alert alert-danger\'><strong></strong>Deal Description Must contain at atleast 120 Characters </strong></span>');
		return false;    
        }

    }
        });
</script>
<script>
function submitForm(action)
    {
        document.getElementById('form1').action = action;
        document.getElementById('form1').submit();
    }
function selectionCheck(inputField)
{
	if(inputField==null || inputField=="Select Category")
	{
		error.push(e + "");
        //$('.error').html('<span class=\'alert alert-warning\'><strong>'+nameToPrintOnScreen+' cannot be left empty!</strong></span>');
	}	
}
function nullCheck(inputField)
{
	if(inputField==null || inputField=="")
	{
		error.push(e + "");
        //$('.error').html('<span class=\'alert alert-warning\'><strong>'+nameToPrintOnScreen+' cannot be left empty!</strong></span>');
	}	
}
</script>

<script type="text/javascript">
  
    var myDropzone = new Dropzone("div#my-dropzone", { 
	url: "/creating_gig.php",
	method:"post",
	autoProcessQueue: false,
	paramName: "files",
        acceptedFiles: ".jpg,.png",
        uploadMultiple: true,
        maxFiles: 4,
        maxFilesize: 5,
        parallelUploads: 4,
        addRemoveLinks : true,
        init: function() {
            var submitButton = document.querySelector("#submit-all")
            dropzone = this; // closure
        submitButton.addEventListener("click", function(e) {
        if ($("#korkName").val().length >= 10 && $("#korkDesc").val().length >= 120){
            error = [];
            var korkName = document.getElementById('korkName').value;
            var priceinput = document.getElementById('priceinput').value;
            var korkDesc = document.getElementById('korkDesc').value;
            var taginput = document.getElementById('taginput').value;
            var gigCategory = document.getElementById('gigCategory').value;
            nullCheck(korkName);
            selectionCheck(gigCategory);
            nullCheck(taginput);
            nullCheck(priceinput);
            nullCheck(korkDesc);     
            if(error.length==0) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.processQueue(); // Tell Dropzone to process all queued files.
        
            }
        }
        });
        this.on("maxfilesexceeded", function(file){
            alert("No more files please!");
        });
        this.on("thumbnail", function(file) {
            if(file.width < 550 || file.height < 370){
                dropzone.removeFile(file);
                alert("Minimum image size: 550 X 370 pixels");
            }
        });
            
        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
        // of the sending event because uploadMultiple is set to true.
        this.on("sendingmultiple", function(file, xhr, formData) {
		// Gets triggered when the form is actually being sent.
          // Hide the success button or the complete form.
			var formValues = $('#fileupload').serialize();
			
			$.each(formValues.split('&'), function (index, elem) {
				var vals = elem.split('=');
				formData.append(vals[0],vals[1]);
			});
            $('#shoading').html('<div class =\'alert alert-success\' style=\'margin-left: 5%;width: 87%;\'><strong>Please Wait! images are uploading... </strong>.');
        });
        this.on("successmultiple", function(files, response) {
          // Gets triggered when the files have successfully been sent.
          // Redirect user or notify of success.
			if(response.request == "Deal created!"){
				window.location = "/deals/"+response.id;
			}else{
				window.location = "/deals/<?php echo $_username; ?>";
            }
        });
        this.on("errormultiple", function(files, response) {
          // Gets triggered when there was an error sending the files.
          // Maybe show form again, and notify user of error
        });
		}
	});
        
</script>
<script language="javascript" type="text/javascript">
function limitText(limitField, limitCount, limitNum) {
	    $('.minmum_1').css("display", "block");
    if (limitField.value.length > limitNum) {
        $('.limit').css("color", "red");
        $('.limit').css("width", "11px");        
		limitField.value = limitField.value.substring(0, limitNum);
        
	} else {
        $('.limit').css("width", "12px");
        $('.limit').css("color", "black");
		limitCount.value = limitNum - limitField.value.length;
	}
    if (limitField.value.length >= 10) {
    $('.minmum_1').css("color", "green");
    }
    else{
    $('.minmum_1').css("color", "red");
    }
    
}
</script>
<script language="javascript" type="text/javascript">
function limitTextarea(limitField, limitCount, limitNum) {
    $('.minmum_2').css("display", "block");
    if (limitField.value.length > limitNum) {
        $('.limit1').css("color", "red");
        $('.limit1').css("width", "11px");
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
        $('.limit1').css("color", "black");
        $('.limit1').css("width", "19px");
        limitCount.value = limitNum - limitField.value.length;
	}
    if (limitField.value.length >= 120) {
    $('.minmum_2').css("color", "green");
        return false;
    }
    else{
    $('.minmum_2').css("color", "red");
    }
}
</script>
<script src="/js/nav-admin-dropdown.js"></script>
    <script src ="/js/register.js"></script>
<script>
	$(document).ready(function() {
	var maxnum = 500000;
	$("#priceinput").keyup(function(){
		if($(this).val() > maxnum){
			$(this).val(maxnum);
		}
	});
	});
</script>
</body>
</html>
