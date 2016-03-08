
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
        <h1 class="blog-title">Add Announcement</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <!-- other content goes here -->
          <form  id="addAnnouncement" class="form form-label-left">
              <input type="hidden" name="inhabitantAdd" value="true"/>
              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control" required id="title" placeholder="Title...">
                    <br>
                  </div>
              </div>
               <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <textarea id="description" class="form-control" required placeholder="Description..." rowspan="30"></textarea>
                      <!-- <input type="text" class="form-control" id="description" placeholder="lastname..."> -->
                  </div>
              </div>
              <button type="button" id="add-announcement" class="btn btn-success btn-lg">Save</button>
          </form>
          <br>
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
          var save    = $("#add-announcement");

          save.on("click", function(e){
                var title   = $("#title").val();
                var desc    = $("#description").val();

                $("#errors").html("");

                if(title != ""){
                  if(desc !=""){
                      $.ajax({
                        url     : "backend/process.php",
                        data    : {title: title, description:desc, announcement:true},
                        type    : 'POST',
                        dataType : 'JSON',
                        success     : function(response){
                            console.log(response);
                            alert("Record is sucesfully saved.");
                        },
                        error   : function(){
                            console.log("err");
                        }
                    });
                  } else {
                    me.__error(Array("Description is required."));
                    return false;
                  }
                } else {
                    me.__error(Array("Title is required."));
                    console.log(desc);

                  return false;
                }

                

                e.preventDefault(); 
            }); 
        }
      }

      Page.__init();
    })(jQuery);
    </script>
  </body>
</html>
