
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
        <h1 class="blog-title">Update Requisition</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <!-- other content goes here -->
          <input type="hidden" id="supplyId" value="<?= $_GET['id'];?>">
          <?php $supplies = $model->getSupplyById($_GET['id']); ?>
          <table class="table" id="supplies">
              <tbody>
               <tr rowspan="4">
                  <td>
                    <label>Form No.</label>
                    <br>
                    <img src="img/marelco.jpg" style="width: 70px; float: left; position: relative; left: -10px;">
                  </td>
                  <td colspan="4" style="text-align:center;">
                    <b style="font-size:14px;">MARINDUQUE ELECTRIC COOPERATIVE, INC.</b>
                    <p>(MARELCO)</p>
                    <b>Marinduque</b>
                    <br>
                    <b>MATERIALS REQUISITION VOUCHER</b>
                  </td>
                </tr> 
                  <tr>
                      <td colspan="4">
                          <label>Requesting Department: <?= $supplies['supply']['branch'];?>
                          </label>
                      </td>
                      <td>
                          <label>Date: <?= $supplies['supply']['date'];?>
                          </label>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="4">
                          <label>Purpose: <?= $supplies['supply']['purpose'];?>
                          </label>
                      </td>
                      <td>
                          <label>Work Order Ref No: <?= $supplies['supply']['work_order_ref_no'];?>
                          </label>
                      </td>
                  </tr>
                  <tr>
                      <td>Class Code No.</td>
                      <td>Description</td>
                      <td>Quantity</td>
                      <td>Unit</td>
                      <td>Remarks</td>
                  </tr>
                  <?php if(isset($supplies['materials'])): ?>
                      <?php foreach($supplies['materials'] as $idx => $material): ?>
                          <tr class="data">
                            <td><?= $material['class_code'];?></td>
                            <td><?= $material['description'];?></td>
                            <td><?= $material['quantity'];?></td>
                            <td><?= $material['unit'];?></td>
                            <td><?= $material['remarks'];?></td>
                          </tr>
                      <?php endforeach ?>
                  <?php endif ?>
              </tbody>
              <tfoot>
               <tr>
                  <td colspan="6">
                    <label>CHARGE TO:</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label>CWO NO:</label>
                  </td>
                  <td>
                    <label>J.O NO:</label>
                  </td>
                  <td colspan="2">
                  <label>M.W.O NO:</label></td>
                  <td colspan="2">
                  <label>M.C.T NO:</label></td>
                </tr>
                <tr>
                  <td colspan="6">
                    <p style="text-align:center;">I hereby certify that the materials/supplies requested above are inventory and will be use solely for the above stated purpose.</p>
                  </td>
                </tr>
                  <tr>
                      <td colspan="2"><label>Requested By: </label>
                      <br>
                      <?= $supplies['supply']['requested_by'];?>
                      </td>
                      <td colspan="2"><label>Approved By:
                      </label>
                      <br>
                      <?= $supplies['supply']['approved_by'];?>
                      </td>
                      <td><label>MRV No:
                      </label>
                      <br>
                      <?= $supplies['supply']['muv_no'];?>
                      </td>
                  </tr>
                  <tr><td colspan="5">
                    <a  class="btn btn-xs btn-success" id="export" href="preview_requisition_export.php?id=<?= $_GET['id'];?>">PDF Export</a>
                    <?php 
                      $currentUserType = $_SESSION['user']['type'];
                      // $currentUserType = "warehouse_personnel";
                    if($currentUserType == "warehouse_personnel"){ ?>
                    
                    <a  class="btn btn-xs btn-primary"  href="add_stock.php?id=<?= $_GET['id'];?>">Add Stock</a>
                    <?php } ?>
                  </td></tr>
              </tfoot>
          </table>
          <ul id="errors"></ul>
        </div><!-- /.blog-main -->

        
      </div><!-- /.row -->

    </div><!-- /.container -->
   
    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
    <script type="text/html" id="tr">
        <tr class="data">
            <td><input class="form-control" value="[CLASS_CODE]" name="class_code_no"/></td>
            <td><input class="form-control" value="[DESCRIPTION]" name="description"/></td>
            <td><input class="form-control" value="[QUANTITY]" name="quantity"/></td>
            <td><input class="form-control" value="[UNIT]" name="unit"/></td>
            <td><input class="form-control" value="[REMARKS]" name="remarks"/></td>
            <td><button class="btn btn-primary remove-supply"><span class="glyphicon glyphicon-remove"></span></button></td>
        </tr>
    </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    (function($){
      var Supply = {
        __init  : function(){
            this.__listen();
            this.initListener();
        },
        __error : function(error){
            for(var i in error){
              $("#errors").append("<li>"+error[i]+"</li>");
            }
        },
        __listen    : function(){
            var me = this;
            var addSupply       = $(".add-supply").first();
            var saveSupply      = $("#save");
            var target          = addSupply.parents("tr");
            
            function Popup(data) { //$("html")
               var style = '<style>  </style>';
               var mywindow = window.open('', 'my div', '');
               window.innerWidth =2000;
               mywindow.document.write('<html>');
               mywindow.document.write('<head>');
               mywindow.document.write('</head>');
               mywindow.document.write('<body>');
               mywindow.document.write(data);
               mywindow.document.write('</body>');
               mywindow.document.write('</html>');
               mywindow.document.close(); // necessary for IE >= 10
               mywindow.focus(); // necessary for IE >= 10

               mywindow.print();
               mywindow.close();

               return true;
            }

            $("#export").on("click", function(e){
              var url = $(this).attr("href");
              e.preventDefault();

              $.ajax({
                url     : url, 
                type    : 'GET',
                dataType  : 'html',
                success   : function(res){
                  Popup(res);
                  console.log(res)
                },
                error     : function(){
                  console.log("err");
                }
             });
            });

            saveSupply.on("click", function(){
                var data = Array();
                var r_dept      = $("#requesting_department").val();
                var date        = $("#date").val();
                var purpose     = $("#purpose").val();
                var refNo       = $("#work_order_ref_no").val();
                var requestedBy = $("#requestedBy").val();
                var approvedBy  = $("#approvedBy").val();
                var mrvNo       = $("#mrvNo").val();
                
                $("#supplies tbody").find("tr.data").each(function(){
                    var me          = $(this);
                    var classCode   = me.find("input[name='class_code_no']").val();
                    var description = me.find("input[name='description']").val();
                    var quantity    = me.find("input[name='quantity']").val();
                    var unit        = me.find("input[name='unit']").val();
                    var remarks     = me.find("input[name='remarks']").val();

                    if(classCode != ""){
                        if(description != ""){
                            if(quantity != ""){
                                data.push(Array(classCode,description,quantity,unit,remarks));
                            }
                        }
                    }
                });

                $("#errors").html("");
                if(data.length > 0){
                    $.ajax({
                        url     : "backend/process.php",
                        data    : {
                            id          : $("#supplyId").val(),
                            r_dept      : r_dept,
                            date        : date,
                            purpose     : purpose,
                            ref_no      : refNo,
                            requestedBy : requestedBy,
                            approvedBy  : approvedBy,
                            mrvNo       : mrvNo,
                            materials   : data,
                            updateSupply   : true
                        },
                        type    : 'POST',
                        dataType    : 'JSON',
                        success     : function(response){
                           alert("Record is sucesfully updated.");
                            console.log(response);
                        },
                        error       : function(){
                            console.log("err");
                        }
                    });
                } else {
                  me.__error(Array("Add atleast 1 material."));
                }
            });

            addSupply.on("click", function(){
                var classCode   = target.find("input[name='class_code_no']").val();
                var description = target.find("input[name='description']").val();
                var quantity    = target.find("input[name='quantity']").val();
                var unit        = target.find("input[name='unit']").val();
                var remarks     = target.find("input[name='remarks']").val();
                var tr          = $("#tr").html();

                tr = tr.replace("[CLASS_CODE]", classCode).
                    replace("[DESCRIPTION]", description).
                    replace("[QUANTITY]", quantity).
                    replace("[UNIT]", unit).
                    replace("[REMARKS]", remarks);

                target.before(tr);
                me.initListener();
            });
        },
        initListener    : function(){
            var removeSupply    = $(".remove-supply");

            removeSupply.off().on("click", function(){
                $(this).parents("tr").remove();
            });

        }
    }

    Supply.__init();

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

        }
      }

      Page.__init();
    })(jQuery);
    </script>
  </body>
</html>
