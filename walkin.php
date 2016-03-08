
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
        <h1 class="blog-title">List of Consumer Request/Complaints (walk in)</h1>
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <table class="table">
            <thead>
              <tr>
                <th>Sender</th>
                <th>Nature</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Middlename</th>
                <th>Barangay</th>
                <th>Date Sent</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $sms = $model->getAllWalkinConsumerRequest();
               ?>
              <?php foreach($sms as $idx => $s): ?>
                <tr>
                  <td><?= $s['contact_number'];?></td>
                  <td><?= $s['firstname'];?></td>
                  <td><?= $s['complaint_nature'];?></td>
                  <td><?= $s['lastname'];?></td>
                  <td><?= $s['middlename'];?></td>
                  <td><?= $s['brgy'];?></td>
                  <td><?= date("Y-m-d H:i", $s['dateadded']);?></td>
                  <td><a href="" data-id="<?= $s['id'];?>" class="btn btn-sm btn-primary approve">Approve <span class="glyphicon glyphicon-ok"></span></a></td>
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
            var target = $(this);

            target.attr("disabled", "disabled");
            $.ajax({
              url   : "backend/process.php",
              data  : {
                approveWalkin    : true, 
                id            : id
              },
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){
                target.parents("tr").remove();
              },
              error     : function(){
                console.log("err");
              },
              complete : function(){
                target.removeAttr("disabled");
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
