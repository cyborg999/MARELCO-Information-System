
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
        <h1 class="blog-title">List of Consumer Request/Complaints</h1>
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <table class="table">
            <thead>
              <tr>
                <th>Sender</th>
                <th>Message</th>
                <th>Date Sent</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $sms = $model->getSmsRequests(); ?>
              <?php foreach($sms as $idx => $s): ?>
                <tr>
                  <td><?= $s['sender'];?></td>
                  <td><?= $s['message'];?></td>
                  <td><?= date("Y-m-d H:i", $s['date_created']);?></td>
                  <td><a href="" data-realcomplaintid="<?= $s['complaint_id'];?>" data-id="<?= $s['id'];?>" data-complaintid="<?= $s['nature_id'];?>" class="btn btn-sm btn-primary approve">Approve <span class="glyphicon glyphicon-ok"></span></a></td>
                </tr>
              <?php endforeach ?>
              
            </tbody>    
          </table>
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

          $(".approve").on("click", function(e){
            var id = $(this).data("id");
            var complaintId = $(this).data("complaintid");
            var target = $(this);
            var rId = $(this).data("realcomplaintid");

            $.ajax({
              url   : "backend/process.php",
              data  : {
                approveSms    : true, 
                id            : id,
                realComplaintId : rId,
                complaintId   : complaintId
              },
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){
                if(response.failed != false){
                  alert(response.failed);
                } else {
                
                  var trLength = $(".blog-main table tbody").first().find("tr").length;

                  target.parents("tr").remove();

                  if(trLength == 0){
                    $(".service-sms").first().removeClass("smsColor");
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

      Page.__init();
    })(jQuery);
    </script>
  </body>
</html>
