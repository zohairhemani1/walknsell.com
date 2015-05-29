<?php
session_start();
include 'headers/_user-details.php';

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{	
		$imgFrom = "korks"; // to upload the image in korkImages folder.
		$korkname = $_POST['korkName'];
		$description = $_POST['korkDesc'];
		$price = $_POST['priceinput'];
		$category = $_POST['category'];
		$tags = $_POST['taginput'];
		$tagArr = explode(",", $tags);
		print_r($_FILES["file"]);
		if($korkname==null)
		{
			echo "Enter Korkname.";
		}
		elseif($description==null)
		{
			echo "Enter Description";
		}
		else{
			if(!isset($profilePic))
			{
				$profilePic = "kork.png";
			}
}
		$stmt = $dbh->prepare("INSERT INTO korks(userID,title,detail,image,catID,expirydate,price) VALUES(:userID,:korkTitle,:desc,:profilePic,:category,:expirydate, :price)");
		$stmt->bindValue(':userID',$_userID);
		$stmt->bindValue(':korkTitle',$korkname);
		$stmt->bindValue(':desc',$description);
		$stmt->bindValue(':profilePic',$profilePic);
		$stmt->bindValue(':profilePic',$profilePic);
		$stmt->bindValue(':category',$category);
		$stmt->bindValue(':expirydate',date('Y/m/d H:i:s'));
		$stmt->bindValue(':price',$price);
		$stmt->execute();
		
		$stmt = $dbh->prepare("SELECT max(id) FROM korks WHERE userID = :username");
		$stmt->bindParam(':username', $_userID);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		$id=$result[0];

		for($i = 0; $i < count($tagArr); $i++){
			$dbh->exec("INSERT INTO kork_tags(korkId, tag) VALUES($id[0] ,'$tagArr[$i]')");
		}
		header("Location: cate_desc.php?korkID=$id[0]");
			
} // ending if block of $_POST
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>Create Gig</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-tagsinput.css" type="text/css">

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<!--
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload.css">
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>




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
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/bootstrap-tagsinput.js"></script>

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
  <div id="backgroundPopup"></div>
  <div class="content_inbox">
  <form name="create_gig" action="create_gig.php" id="fileupload" method="post" enctype="multipart/form-data">
  	<!--<form id="fileupload"  method="POST" enctype="multipart/form-data">    action="create_gig.php" -->

  <!--<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">-->
  
    <h2>Create a new gig</h2>
    <div class="left_gig">
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_title">Gig Title</label>
        </div> 
        <div class="input_wrap gig_title">
          <input class="gig_text title" style="width:95%" maxlength="80"  name="korkName"/ required>
        </div>
        <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Describe your Gig.</h3>
              <p>This is your Gig title. Choose wisely, you can only use 80 characters.</p>
            </figcaption>
            <div class="gig-tooltip-img"></div>
          </figure>
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
		<select class="fake-dropdown fake-dropdown-double dropdown-inner " style="width:95%" name="category" required>
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
              <p>This is your Gig category. Choose wisely for better promotion.</p>
            </figcaption>
            <div class="gig-tooltip-img"></div>
          </figure>
        </aside>
      </div>
     <div class="form_row">
        <div class="label_wrap">
          <label for="gig_gallery">gig gallery</label>
        </div>
        <div class="input_wrap" id="gig_gallery_wrap">
			
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    
          <!--<div class="file_input_inner">
            <!--  <button type="file" class="btn_signup" name="file" id="name">Browse</button>  -->
            
            <!--<input id="fileupload" type="file" name="file[]" multiple required>
            
            <p>JPEG file, 2MB Max, <span class="grey_c">you own the copyrights</span></p>
          </div>-->
		  
        </div>
      </div>
      
      <div class="form_row">
        <div class="label_wrap">
          <label for="taginput">Tags</label>
        </div>
        <div class="input_wrap gig_tags">
          <input class="gig_tags_text" type="text" data-role="tagsinput" id="taginput" name="taginput" />
        
        </div>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="priceinput">Price</label>
        </div>
        <div class="input_wrap gig_price">
          <input class="gig_text price" type="number" id="priceinput" name="priceinput" style="width:95%;"/>
        
        </div>
      </div>
      
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_desc">Description</label>
        </div>
        <div class="input_wrap gig_desc">
          <textarea class="gig_text desc" rows="10" maxlength="200" name="korkDesc" required></textarea>
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
      <button type="submit" class="btn_signup">Submit &amp; Continue</button> <!--onclick="submitForm('create_gig.php')"-->
      <button class="btn_signup btn_cancel">Cancel</button>
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
<script src="js/school-list.js"></script>
<!--multiple image upload starts here -->

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->

<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>

<script src="js/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script>
function submitForm(action)
    {
        document.getElementById('form1').action = action;
        document.getElementById('form1').submit();
    }
</script>
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>


</body>
</html>
