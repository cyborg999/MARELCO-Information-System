<?php
session_start();
   $currentUserType = $_SESSION['user']['type'];
    // $currentUserType = "warehouse_personnel";
    $currentBranch = $_SESSION['user']['branch_id'];
    // $currentBranch = 6;
      if($currentUserType != "warehouse_personnel"){
        header("Location:index.php");
      }
?>
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
      <!-- <link rel="stylesheet" href="docsupport/style.css"> -->
    <link href="css/blog.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php include_once "header.php"; 

    ?>

    <div class="container">
      <div class="blog-header">
        <h1 class="blog-title">Add Supply Stock</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>
      <div class="row">
        <div class="columns col-sm-12">
          <div role="tabpanel" class="tab-pane active">
                  <br>
                  <div class="row">
                      <div class="col-sm-12 blog-main">
                      <?php
                        $supply = $model->getSupplyInfoById($_GET['id']);
                      ?>
                      <blockquote>
                      <label>Branch :<?= $supply['branch'];?></label>
                      <label>Purpose:</label>
                      <p><?= $supply['purpose'];?></p>
                      <i><?= $supply['date'];?></i> 
                      </blockquote>
                       <table data-id="<?= $_GET['id'];?>" class="table table-bordered" id="supplies">
                          <thead>
                              <tr>
                                  <th>Class Code No.</th>
                                  <th  width="150">Description</th>
                                  <th width="130">Quantity</th>
                                  <th>Unit</th>
                                  <th>Remarks</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php $materials = $model->getMaterialsBySupplyId($_GET['id']); 
                              ?>
                              <?php foreach($materials as $idx => $m): ?>
                              <tr data-parentid="<?= $m['parent_id'];?>" data-id="<?= $m['id'];?>" class="this <?= ($m['limit'] == true) ? "limit" : "";?>">
                                  <td><input class="form-control" readonly name="class_code_no" value="<?= $m['class_code'];?>" /></td>
                                  <td><input class="form-control" readonly name="description" value="<?= $m['description'];?>"/></td>
                                  <td width="300">
                                    <input class="form-control not-this" min="0" type="number" max="<?= $m['max'];?>" name="quantity" value="<?= $m['quantity'];?>"/>
                                  </td>
                                  <td><input class="form-control" readonly name="unit" value="<?= $m['unit'];?>"/></td>
                                  <td><input class="form-control" readonly name="remarks" value="<?= $m['remarks'];?>"/></td>
                              </tr>
                              <?php endforeach ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td>
                              <?php if($supply['approved'] != 1){?>
                                <a href="" class="btn btn-sm btn-success save">Save</a>
                                <?php } ?>
                              </td>
                            </tr>
                          </tfoot>
                      </table>
                        <ul id="errors"></ul>
                      </div><!-- /.blog-main -->
                  </div>

          </div>
        </div>
      </div>
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
           $("input[name='quantity']").on("keyup", function(){
                var val  = $(this).val();
                var max = parseInt($(this).attr("max"));

                if(val > max){
                    $(this).val(max);
                }

                if(val <0){
                    $(this).val(0);
                }
            });

          $(".save").on("click", function(e){
            e.preventDefault();
            var supplies = Array();

            $("#supplies tr.this").each(function(){
              var id = $(this).data("id");
              var parentId = $(this).data("parentid");
              var quantity = $(this).find("input[name='quantity']").first().val();

              supplies.push(Array(id,quantity,parentId));
            });

            $.ajax({
              url   : "backend/process.php",
              data  : {addStock:true,supplies:supplies, id:$("#supplies").data("id")},
              type  : 'POST',
              dataType : 'JSON',
              success   : function(response){
                console.log(response);
                alert('Record is sucesfully updated');
                window.location.href=window.location.href;
              },
              error   : function(){
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
