<?php include_once "backend/security.php"; ?>
<?php include_once "backend/process.php"; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Marelco</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog.css" rel="stylesheet">
    <link rel="stylesheet" href="css/prism.css">
    <link rel="stylesheet" href="css/chosen.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php include_once "header.php"; ?>

    <div class="container">
      <br>
        <?php
          $profile = $model->getProfile();
          $id = $_SESSION['user']['id'];
          // $id =125;
        ?>
      <div class="row">

        <div class="col-sm-3 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset profile-pic">
              <span  data-id="<?= $id;?>" class="upload glyphicon glyphicon-camera"></span>
            <a  href="edit_user.php?id=<?= $id;?>">
              <img width="100%" src="<?= isset($profile['photo']) ? $profile['photo'] : 'img/user.png';?>">
            </a>
<br>
            <br>
            <label style="margin:0px 5px;"><?= (isset($profile['firstname']) ? $profile['firstname'] : "")." ". (isset($profile['middlename']) ? $profile['middlename'] :"")." ".(isset($profile['lastname']) ? $profile['lastname'] :"");?> </label>
            <p  style="margin:0px 5px;"><?= isset($profile['brgy']) ? $profile['brgy'].", ".$profile['municipality'].", Marinduque" : ""?></p>
            <p  style="margin:0px 5px;"><span class="glyphicon glyphicon-phone"></span> <span style=""><?= isset($profile['contact_number']) ? $profile['contact_number'] : "";?></span></p>
          </div>
        </div><!-- /.blog-sidebar -->

        <div class="col-sm-8 col-sm-offset-1 blog-main">
          <form action="dashboard.php" class="hidden" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="hidden" id="profileId" name="id" value=""/>
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
            <input type="submit" value="Upload Image" id="uploadBtn" name="submit">
        </form>

        <?php
          $target_dir = "uploads/";

          // Check if image file is a actual image or fake image
          if(isset($_POST["submit"])) {

          $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
          $filename = explode(".", basename($_FILES["fileToUpload"]["name"]));
          $filename = end($filename);
          $filename = $_POST['id'].".".$filename;
          $target_file = $target_dir . $filename;

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $model->updatePhotoById($_POST['id'], $filename);
                  // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
              } else {
                  // echo "Sorry, there was an error uploading your file.";
              }
          }
        ?>
        </div><!-- /.blog-main -->

        
      </div><!-- /.row -->

    </div><!-- /.container -->
   
    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
    <script type="text/html" id="tpl">
      <tr>
        <td>
          <h5>title: <b>[TITLE]</b></h5>
          <p>from:<i>[FROM]</i></p>
          <blockquote>
            [MESSAGE]
          </blockquote>
          <hr>
        </td>
      </tr>
    </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="js/prism.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    (function($){
      var Page = {
        __init : function(){
          this.__listen();
        },
        __error : function(error){
            $("#errors").html("");
            for(var i in error){
              $("#errors").append("<li>"+error[i]+"</li>");
            }
        },
        __listen : function(){
          var me = this;
          var config      = {' .chosen-select' : {}};
          var sendMsg   = $("#sendMsg");
          // var viewMsg   = $("#viewMsg");
          var upload = $(".profile-pic .upload");

          upload.on("click", function(e){
            e.preventDefault();
            $("#profileId").val($(this).data("id"));
            $("#fileToUpload").trigger("click");
          });

          $("#fileToUpload").on("change", function(){
            $("#uploadBtn").trigger("click");
          });

          // viewMsg.on("click", function(){

          //   $(this).removeAttr("style");
          //   $(this).find("#allCount").html(0);

          //   $.ajax({
          //     url   : "backend/process.php",
          //     data  : {viewMsg:true},
          //     type  : 'POST',
          //     dataType  : 'JSON',
          //     success   : function(response){
          //       var target = $("#allMessages");
          //       for(var i in response){
          //         // console.log(response[i].title);
          //         var tpl = $("#tpl").html();

          //         tpl = tpl.replace("[TITLE]",response[i].title).
          //           replace("[FROM]", response[i].sender).
          //           replace("[MESSAGE]", response[i].message);

          //           target.append(tpl);
          //       }
          //     },
          //     error     : function(){
          //       console.log("err");
          //     }
          //   });

          // });

          for (var selector in config) {
              $(selector).chosen(config[selector]);
          }

          $(".chosen-container").css("width", "100%");

          sendMsg.on("submit", function(e){
            var selected  = $(".chosen-select").val();
            var message   = $("#message").val();
            var title     = $("#title").val();

            $.ajax({
              url   : "backend/process.php",
              data  : {sendMsg : true, recipients : selected, message : message, title:title},
              type  : "POST",
              dataType  : "JSON",
              success   : function(response){
                console.log(response);
                alert("Message Sent!");
              },
              error     : function(){
                console.log("err");
              }
            });

            e.preventDefault();
          });
        }
      }

      Page.__init();
    })(jQuery);
    </script>
  </body>
</html>
