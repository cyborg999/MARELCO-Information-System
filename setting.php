
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php include_once "header.php"; ?>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">System Setting</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <!-- other content goes here -->
          <?php $setting = new Model(); $setting = $setting->getSetting(); ?>
          <input type="hidden" value="<?= ($setting == null) ? 'null' : $setting['id']; ?>" id="settingId" />
          <br>
          <label>About
<textarea id="about"  class="form-control" rows="10" cols="300" placeholder="about...">
<?= ($setting == null) ? '' : $setting['about']; ?>
</textarea>
          </label>
          <br>

<label>Slogan
<textarea id="slogan" class="form-control" rows="10" cols="300" placeholder="slogan text...">
<?= ($setting == null) ? '' : $setting['slogan']; ?>
</textarea>
</label>
          <br>
          <label>Mission
<textarea id="mission" class="form-control" rows="10" cols="300" placeholder="mission...">
<?= ($setting == null) ? '' : $setting['mission']; ?>
</textarea>
</label>
          <br>
          <label>Vision
<textarea id="vission" class="form-control" rows="10" cols="300" placeholder="vision...">
<?= ($setting == null) ? '' : $setting['vission']; ?>
</textarea>
</label>
          <br>
          <label>Mobile:
              <input type="text" id="mobile" class="form-control" placeholder="mobile..." value="<?= ($setting == null) ? '' : $setting['mobile']; ?>"/>
          </label>            
          <br>
          <label>Phone:
              <input type="text" id="phone" class="form-control" placeholder="phone..." value="<?= ($setting == null) ? '' : $setting['phone']; ?>"/>
          </label>
          <br>
          <label>Fax:
              <input type="text" id="fax" class="form-control" placeholder="fax..." value="<?= ($setting == null) ? '' : $setting['fax']; ?>"/>
          </label>
          <br>
          <label>Email:
              <input type="text" id="email" class="form-control" placeholder="email..." value="<?= ($setting == null) ? '' : $setting['email']; ?>"/>
          </label>
          <br>
          <input type="submit" class="btn btn-lg btn-success" id="updateSetting" value="update"/>
      </div>
          <ul id="errors"></ul>
        </div><!-- /.blog-main -->

        
      </div><!-- /.row -->

    </div><!-- /.container -->
   
    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
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
          var update = $("#updateSetting");

          update.on("click", function(){
              var about   = $("#about").val();
              var mobile  = $("#mobile").val();
              var id      = $("#settingId").val();
              var phone   = $("#phone").val();
              var fax     = $("#fax").val();
              var email   = $("#email").val();
              var slogan  = $("#slogan").val();
              var mission  = $("#mission").val();
              var vission  = $("#vission").val();

              $.ajax({
                  url     : "backend/process.php",
                  data    : {
                      updateSetting   : true,
                      id              : id,
                      slogan          : slogan,
                      about           : about,
                      mobile          : mobile,
                      phone           : phone,
                      fax             : fax,
                      mission             : mission,
                      vission             : vission,
                      email           : email
                  },
                  type        : 'POST',
                  dataType    : 'JSON',
                  success     : function(response){
                      console.log(response);
                      alert("Record is sucesfully updated");
                  },
                  error       : function(){
                      console.log("err");
                  }
              });
          });
        }
      }

      Page.__init();
    })(jQuery);
    </script>
  </body>
</html>
