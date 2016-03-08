
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
     <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
           <li class="this"><a href="" class="blog-nav-item ">Supply Monitoring and Repair Management System</a></li>
           <li class="this"><a class="blog-nav-item pull-right active" href="login.php">Login</a></li>
           <li class="this"><a class="blog-nav-item pull-right " href="registration.php">Application for Membership</a></li>
           <li class="this"><a class="blog-nav-item pull-right " href="complaints_requirements.php">Services</a>
            <ol class="pull-right" style="left:280px;">
              <li><a href="complaints_requirements.php">Complaints</a></li>
              <li><a href="requests_requirements.php">Requests</a></li>
            </ol>
           </li>
            
           <li class="this "><a class="blog-nav-item pull-right " href="index.php">Home</a></li>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Reset Password</h1>
        <!-- <p class="lead blog-description">Lorem ipsum sit dolor u know the rest...</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <form id="forgotFrm">
            <input type="hidden" name="forgotpassword" value="true"/> 
            <div class="form-group">
              <label for="loginUsername">Username</label>
              <input type="text" name="username"class="form-control" required placeholder="Username">
            </div>
            <div class="form-group">
              <label for="loginPassword">Password</label>
              <input type="password" name="password" class="form-control" required placeholder="Password">
            </div>
               <div class="form-group">
              <label for="loginPassword">Retype Password</label>
              <input type="password" name="password2" class="form-control" required placeholder="Password">
            </div>
            <button type="submit" class="btn btn-success btn-lg">Login</button>
          </form>
          <br>
          <ul id="errors"></ul>
        </div><!-- /.blog-main -->

        
      </div><!-- /.row -->

    </div><!-- /.container -->
   
    <footer class="blog-footer">
      <!-- <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p> -->
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
           var Registration = {
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
                    var me          = this;
                    var login       = $("#box-login");
                    var dataAlert   = $(".my-alert");

                    dataAlert.on("click", function(e){
                        $(this).parents(".my-alert-parent").fadeOut("slow");
                        e.preventDefault();
                    });

                  $("#forgotFrm").on("submit", function(e){
                    $.ajax({
                      url   : "backend/process.php",
                      data  : $(this).serialize(),
                      type  : 'POST',
                      dataType  : 'json',
                      success   : function(response){
                        console.log(response);
                          if(response.added != null){
                                  $("#erros").html("");
                                  alert("Please check your email to reset your password");
                                  // window.location.href = response.redirect;
                              // $("#success").removeClass("hidden").fadeIn("slow");
                          } else {
                              if(response.error.length > 0){
                                  me.__error(response.error);
                              }    
                          }
                      },
                      error     : function(){
                        console.log("err");
                      }
                    });

                    e.preventDefault();
                  }); 
                }
            }

            Registration.__init();
        })(jQuery);
        </script>
  </body>
</html>
