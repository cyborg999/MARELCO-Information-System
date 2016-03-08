
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
    <style type="text/css">
    tr {
      cursor: pointer;
    }
    </style>
  </head>

  <body>
    <?php include_once "header.php"; ?>
    <div class="container">
      <br>
      <div class="row">
        <div class="columns col-sm-12 blog-main">
          <h2>List of Accomplishment</h2>
          <br>
          <div class="table-responsive">
            <?php $list = $model->getComplaintSummaryExport(true);
             ?>
            <table class="table table-hovered table-striped" id="result">
              <thead>
                 <tr>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Date Connected</th>
                  <th>Initial Reading</th>
                  <th>Type of Consumer</th>
                  <th>Length of SDW</th>
                  <th colspan="2">Meter</th>
                  <th>OR Number/Date</th>
                  <th>Executed By</th>
                </tr>
              </thead>                
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Serial No.</td>
                  <td>Class/Brand</td>
                  <td></td>
                  <td></td>
                </tr>
                <?php $last=""; foreach($list as $idx => $u){
                    if($last != $u['complaint_nature']){
                      $last = $u['complaint_nature']; ?>
                      <tr>
                        <td colspan="10"><b><?= strtoupper($last);?></b></td>
                      </tr>
                    <?php }
                 ?>
                <tr>
                 <td><?= $u['lastname'].", ".$u['firstname']." ".$u['middlename']." ";?></td>
                  <td><?= $u['brgy'].", ".$u['municipality']." Marinduque";?></td>
                  <td><?= $u['date_attended'];?></td>
                  <td><?= $u['new_reading'];?></td>
                  <td><?= $u['consumerType'];?></td>
                  <td><?= $u['sdw_length'];?></td>
                  <td><?= $u['new_serial'];?></td>
                   <td><?= $u['new_brand'];?></td>
                  <td></td>
                  <td><?= $u['lineman'];?></td> 
                </tr>
                <?php } ?>
                <tr>
                  <td colspan="9">
                    <input type="submit" class="btn btn-primary"  id="preview" value="Preview PDF"/> 
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div><!-- /.container -->
   
    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
    <div class="modal fade" id="export">
      <div class="modal-dialog" style="width:1200px;">
        <div class="modal-content" >
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">PDF Preview</h4>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="pdfExport">Export As PDF</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    (function($){
      function Popup(data) { //$("html")
         var style = '<style>  </style>';
         var mywindow = window.open('', 'my div', '');
         window.innerWidth =2000;
         mywindow.document.write('<html>');
         mywindow.document.write('<head>');
         mywindow.document.write('</head>');
         mywindow.document.write('<body>');
         mywindow.document.write(data.html());
         mywindow.document.write('</body>');
         mywindow.document.write('</html>');
         mywindow.document.close(); // necessary for IE >= 10
         mywindow.focus(); // necessary for IE >= 10

         mywindow.print();
         mywindow.close();

         return true;
      }
      var Page = {
        __init : function(){
          this.__listen();
        },
        __listen : function(){
          var me      = this;

          $("#pdfExport").on("click", function(){
            var html = $(this).parents(".modal").find(".modal-body");
            Popup(html);
          });

          $("#preview").on("click", function(){
             $.ajax({
              url     : "accomplishment_list_report.php", 
              type    : 'GET',
              dataType  : 'html',
              success   : function(res){
                console.log(res)
                var target = $("#export");
                target.find(".modal-body").html(res);

                $("#export").modal("show");
              },
              error     : function(){
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
