
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
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
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
        <h1 class="blog-title">Material Requisition</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <!-- other content goes here -->
          <table class="table"  id="supplies">
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
                          <?php $branches = $model->getAllBranches(); ?>
                          <label>Requesting Department 
                            <select class="form-controls pull-lseft" id="branches">
                                <?php foreach($branches as $idx => $b):?>
                                    <option value="<?= $b['id'];?>" <?= isset($_GET['id']) ? ($_GET['id'] == $b["id"]) ? "selected" : "": ""?> ><?= $b['name'];?></option>
                                <?php endforeach ?>
                            </select>
                          </label>
                    
                          <label class="hidden">Requesting Department:
                              <input id="requesting_department" class="hidden form-controls" name="requesting_department" />
                          </label>
                      </td>
                      <td>
                          <label>Date:
                              <input id="date" class="form-controls" name="date"/>
                          </label>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="4">
                          <label>Purpose:
                              <input id="purpose" class="form-controls" name="purpose" />
                          </label>
                      </td>
                      <td>
                          <label>Work Order Ref No:
                              <input id="work_order_ref_no" class="form-controls" name="work_order_ref_no"/>
                          </label>
                      </td>
                  </tr>
                  <tr>
                      <td>Class Code No.</td>
                      <td>Description</td>
                      <td width="100">Quantity</td>
                      <td>Unit</td>
                      <td>Remarks</td>
                  </tr>
                  <?php $defaultMaterials = $model->getDefaultMaterial();?>
                  <?php foreach($defaultMaterials as $idx => $m): ?>
                   <tr class="data default clone" data-parent="<?= $m['id']; ?>">
                      <td>
                        <input class="form-controls" readonly value="<?= $m['class_code'];?>" name="class_code_no"/></td>
                      <td><input class="form-controls" readonly value="<?= $m['description'];?>" name="description"/></td>
                      <td><input class="form-controls"  value="<?= $m['quantity'];?>"  max="<?= $m['quantity'];?>" min="1" type="number" name="quantity"/></td>
                      <td><input class="form-controls" readonly value="<?= $m['unit'];?>" name="unit"/></td>
                      <td><input class="form-controls" readonly value="<?= $m['remarks'];?>" name="remarks"/></td>
                      <td><button class="btn remove-supply"><span class="glyphicon glyphicon-remove"></span></button></td>
                  </tr>
                  <?php endforeach ?>
                  <?php $materials = $model->getMaterialByBranchId(); ?>
                  <tr id="target">
                    <td colspan="6">
                    </td>
                  </tr>
                  <tr id="target">
                    <td colspan="6">
                      <hr>
                    </td>
                  </tr>
                  <?php foreach($materials as $idx => $m): ?>
                  <tr class="d<?= $m['id'];?> list" data-class="d<?= $m['id'];?>" data-parent="<?= $m['id']; ?>">
                      <td><input class="form-controls" readonly value="<?= $m['class_code'];?>" name="class_code_no"/></td>
                      <td><input class="form-controls" readonly value="<?= $m['description'];?>" name="description"/></td>
                      <td><input class="form-controls" value="<?= $m['quantity'];?>" type="number" max="<?= $m['quantity'];?>" min="1" name="quantity"/></td>
                      <td><input class="form-controls" readonly value="<?= $m['unit'];?>" name="unit"/></td>
                      <td><input  class="form-controls" readonly value="<?= $m['remarks'];?>" name="remarks"/></td>
                      <td>
                        <?php if($m['quantity'] == 0) { ?>
                        No Stock
                        <?php } else{ ?>
                        <button class="btn btn-primary add-supply"><span class="glyphicon glyphicon-plus"></span></button>
                        <?php  } ?>
                        <button class="btn btn-default remove-supply"><span class="glyphicon glyphicon-remove"></span></button>
                      </td>
                  </tr>
                  <?php endforeach ?>
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
                      <td colspan="2"><label>Requested By:
                      <br> <input class="form-controls" id="requestedBy" name="requested_by"/></label></td>
                      <td colspan="2"><label>Approved By: 
                        <br>
                        <input class="form-controls" id="approvedBy" name="approved_by"/>
                        <hr>
                        <p style="margin-top:-20px;text-align:center; padding:0px;">Department Manager</p>
                      </label></td>
                      <td><label>MRV No: <br><input class="form-controls" id="mrvNo" name="mrv_no"/></label></td>
                  </tr>
                  <tr><td colspan="5"><button id="save" class="btn btn-lg btn-success">Save</button></td></tr>
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
            <td><input class="form-controls" readonly value="[CLASS_CODE]" name="class_code_no"/></td>
            <td><input class="form-controls" readonly value="[DESCRIPTION]" name="description"/></td>
            <td><input class="form-controls" value="[QUANTITY]" name="quantity"/></td>
            <td><input class="form-controls" readonly value="[UNIT]" name="unit"/></td>
            <td><input class="form-controls" readonly value="[REMARKS]" name="remarks"/></td>
            <td><button data-class="[DCLASS]"class="btn btn-default remove-supply"><span class="glyphicon glyphicon-remove"></span></button></td>
        </tr>
    </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <script src="js/jquery-ui.min.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    (function($){
        var Supply = {
          __init  : function(){
              this.__listen();
              this.initListener();
          },
          __listen    : function(){
              var me = this;
              var addSupply       = $(".add-supply");
              var saveSupply      = $("#save");
              var target          = addSupply.parents("tr");
              var branch = $("#branches");

            

              branch.on("change", function(e){
                var val = $(this).val();
                var url = window.location.origin+window.location.pathname+"?active=supply&id="+val;

                window.location.href = url;
              });

              saveSupply.on("click", function(){
                var href = window.location.href;
                  var data = Array();
                  var r_dept      = $("#requesting_department").val();
                  var date        = $("#date").val();
                  var purpose     = $("#purpose").val();
                  var refNo       = $("#work_order_ref_no").val();
                  var requestedBy = $("#requestedBy").val();
                  var approvedBy  = $("#approvedBy").val();
                  var mrvNo       = $("#mrvNo").val();
                  var branchId    = $("#branches").val();

                  if(refNo == ""){
                      alert("Work Order Ref No. is required");
                      return false;
                  }

                  $("#supplies tbody").find("tr.clone").each(function(){
                      var me          = $(this);
                      var classCode   = me.find("input[name='class_code_no']").val();
                      var description = me.find("input[name='description']").val();
                      var quantity    = me.find("input[name='quantity']").val();
                      var unit        = me.find("input[name='unit']").val();
                      var remarks     = me.find("input[name='remarks']").val();

                      data.push(Array(classCode,description,quantity,unit,remarks, me.data("parent")));

                      // if(classCode != ""){
                      //     if(description != ""){
                      //         if(quantity != ""){
                      //             data.push(Array(classCode,description,quantity,unit,remarks, me.data("parent")));
                      //         }
                      //     }
                      // }
                  });
                  console.log(data.length);
                  if(data.length > 0){
                      $.ajax({
                          url     : "backend/process.php",
                          data    : {
                              r_dept      : r_dept,
                              branchId    : branchId,
                              date        : date,
                              purpose     : purpose,
                              ref_no      : refNo,
                              requestedBy : requestedBy,
                              approvedBy  : approvedBy,
                              mrvNo       : mrvNo,
                              materials   : data,
                              addSupply   : true
                          },
                          type    : 'POST',
                          dataType    : 'JSON',
                          success     : function(response){
                             alert("Record is sucesfully added.");
                              console.log(response);
                              $("tr.data:not(.default)").remove();
                              $("#supplies .data:not(.default) input").val("");
                              window.location.href = href;
                          },
                          error       : function(){
                              console.log("err");
                          }
                      });
                  }
              });

              addSupply.on("click", function(){
                var that = $(this);
                var clone = that.parents("tr").clone();
                clone = clone.addClass("clone").removeClass("list");
                console.log(clone.prop("outerHTML"));
    
                $("#target").after(clone);
                $(this).parents("tr").addClass("hidden");
                
                me.initListener();
              });
          },
          initListener    : function(){
              var removeSupply    = $(".remove-supply");

               $("input[name='quantity']").off().on("keyup", function(){
                  var val  = $(this).val();
                  var max = $(this).attr("max");

                  if(val > max){
                      $(this).val(max);
                  }

                  if(val <0){
                      $(this).val(0);
                  }
              });

              removeSupply.off().on("click", function(){
                var tr = $(this).parents("tr");
                var id = tr.data("class");
                var target = $(".list."+id);
                // console.log(target.length);
                target.show().removeClass("hidden");
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

          $("#date").datepicker();
        }
      }

      Page.__init();
    })(jQuery);
    </script>
  </body>
</html>
