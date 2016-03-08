
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
  <link rel="stylesheet" href="docsupport/prism.css">
  <link rel="stylesheet" href="css/chosen.min.css">
    <link href="css/blog.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php include_once "header.php"; 
    $currentUserType = $_SESSION['user']['type'];
    // $currentUserType = "warehouse_personnel";
    $currentBranch = $_SESSION['user']['branch_id'];
    // $currentBranch = 6;

    ?>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Add/Edit Supply</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>
      <div class="row">
        <div class="columns col-sm-12">
            <div>
              <!-- Nav tabs -->
              <?php
                    if($currentUserType == "warehouse_personnel"){ ?>
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#branch" aria-controls="home" role="tab" data-toggle="tab">Branches</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Main Inventory</a></li>
              </ul>
                <?php } ?>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="branch">
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <?php $branches = $model->getAllBranches();
                                  $userType = $currentUserType;
                                if($userType == "warehouse_personnel"){  ?>
                                 <select class="form-control" id="branches">
                                    <?php foreach($branches as $idx => $b){?>
                                        <option value="<?= $b['id'];?>" 
                                        <?= isset($_GET['id']) ? ($_GET['id'] == $b["id"]) ? "selected" : "": ""?> >
                                          <?= $b['name'];?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <br>
                            <br>
                                <?php } else { ?>
                                 <select class="form-control hidden" id="branches">
                                        <option value="<?= $currentBranch;?>"></option>
                                 </select>
                                <?php }?>
                            </div>
                            
                            <?php $materials2 = $model->getMaterialByBranchId(true,true); ?>

                            <div class="col-sm-12 blog-main">
                              <table class="table table-bordered" id="supplies">
                                <thead>
                                    <tr>
                                        <th>Send Notification</th>
                                        <th>Default</th>
                                        <th>Class Code No.</th>
                                        <th  width="150">Description
                                        <?php if($userType == "warehouse_personnel"){  ?>

                                        <select class="form-control classCodes">
                                            <option></option>
                                            <?php foreach($materials2 as $idx => $m): ?>
                                                <option data-desc="<?= $m['description'];?>" 
                                                data-remark="<?= $m['remarks'];?>"
                                                data-unit="<?= $m['unit'];?>" data-qty="<?= $m['quantity'];?>" 
                                                value="<?= $m['id'];?>"><?= $m['description'];?></option>
                                            <?php endforeach ?>        
                                        </select>
                                      <?php }?>
                                        </th>
                                        <th width="130">Quantity 
                                            <span class="glyphicon glyphicon-arrow-up pull-right sort" style="cursor:pointer;"></span>
                                            <span class="glyphicon glyphicon-arrow-down pull-right sort" style="cursor:pointer;"></span>
                                        </th>
                                        <th>Unit</th>
                                        <th>Remarks</th>
                                        <?php
                                        if($currentUserType != "consumer_service_coordinator"){ ?>
                                        <th>Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if($currentUserType == "consumer_service_coordinator"){ ?>
                                <tr class="first">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php 
                                } else { ?>
                                 <tr class="first">
                                    <td></td>
                                    <td>
                                        <input type="checkbox" id="is_default" name="is_default"/>
                                    </td>
                                    <td><input class="form-control" readonly name="class_code_no"/></td>
                                    <td><input class="form-control" readonly name="description"/></td>
                                    <td><input  type="number" min="0" class="form-control" name="quantity"/></td>
                                    <td><input class="form-control" readonly name="unit"/></td>
                                    <td><input class="form-control" readonly name="remarks"/></td>
                                    <td><button class="btn btn-primary add-supply"><span class="glyphicon glyphicon-plus"></span></button></td>
                                </tr>
                                    <?php 
                                }
                                ?>
                                   
                                    <?php $materials = $model->getMaterialByBranchId(); ?>
                                    <?php foreach($materials as $idx => $m): ?>
                                    <tr data-parentid="<?= $m['parent_id'];?>" data-id="<?= $m['id'];?>" class="<?= ($m['limit'] == true) ? "limit" : "";?>">
                                        <td>
                                            <input type="checkbox"  class="quantityNotif" value="<?= $m['class_code'];?>[<?= $m['quantity'];?>]"/>
                                        </td>
                                        <td>
                                            <input type="checkbox" readonly name="is_default" <?= ($m['is_default'] == 1) ? "checked" : "";?>/>
                                        </td>
                                        <td><input class="form-control" readonly name="class_code_no" value="<?= $m['class_code'];?>" /></td>
                                        <td><input class="form-control" readonly name="description" value="<?= $m['description'];?>"/></td>
                                        <td width="300">
                                          <input class="form-control not-this" min="0" type="number" readonly name="quantity" value="<?= $m['quantity'];?>"/>
                                          <?php if($currentUserType == "warehouse_personnel"){ ?>
                                            <input type="number" class="form-control  pull-left add-stock hidden"  min="0" value="1"/>
                                          <?php } ?>
                                        </td>
                                        <td><input class="form-control" readonly name="unit" value="<?= $m['unit'];?>"/></td>
                                        <td><input class="form-control" readonly name="remarks" value="<?= $m['remarks'];?>"/></td>
                                        <?php
                                            if($currentUserType != "consumer_service_coordinator"){ ?>
                                        <td width="200">
                                            <button class="btn pull-left edit-supply"><span class="glyphicon glyphicon-pencil"></span></button>
                                            <button class="btn hidden pull-left save-supply main"><span class="glyphicon glyphicon-ok"></span></button>
                                            <button style="margin-left:2px;" class="btn hidden pull-left close-supply"><span class="glyphicon glyphicon-remove"></span></button>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                              <a href=""  id="sendStock" data-user="<?=$currentUserType;?>" class="btn btn-primary">Send</a>
                              <ul id="errors"></ul>
                            </div><!-- /.blog-main -->
                        </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="profile">
                    <div class="row">
                    <br>
                        <div class="columns col-sm-12">
                            <table class="table table-hovered">
                                <thead>
                                    <tr>
                                        <th width="150">Class Code</th>
                                        <th width="300">Description</th>
                                        <th>Quantity</th>
                                        <th width="100">Unit</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="first">
                                        <td><input class="form-control" name="class_code_no"/></td>
                                        <td><input class="form-control" name="description"/></td>
                                        <td><input  type="number" min="0" class="form-control" name="quantity"/></td>
                                        <td><input class="form-control" name="unit"/></td>
                                        <td><input class="form-control" name="remarks"/></td>
                                        <td><button class="btn btn-primary add-supply main"><span class="glyphicon glyphicon-plus"></span></button></td>
                                    </tr>
                                    <?php $materials3 = $model->getMaterialByBranchId(true); ?>
                                    <?php foreach($materials3 as $idx => $m): ?>
                                        <tr data-id="<?= $m['id'];?>" class="<?= ($m['limit'] == true) ? "limit" : "";?>">
                                            <td><input class="form-control" readonly name="class_code_no" value="<?= $m['class_code'];?>" /></td>
                                            <td><input class="form-control" readonly name="description" value="<?= $m['description'];?>"/></td>
                                            <td><input class="form-control" min="0" type="number" readonly name="quantity" value="<?= $m['quantity'];?>"/></td>
                                            <td><input class="form-control" readonly name="unit" value="<?= $m['unit'];?>"/></td>
                                            <td><input class="form-control" readonly name="remarks" value="<?= $m['remarks'];?>"/></td>
                                            <td width="200">
                                                <button class="btn pull-left edit-supply"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button class="btn hidden pull-left save-supply"><span class="glyphicon glyphicon-ok"></span></button>
                                                <button style="margin-left:2px;" class="btn hidden pull-left close-supply"><span class="glyphicon glyphicon-remove"></span></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <!-- <a href=""  id="sendStock2" class="btn btn-primary">Send Stock Notification</a> -->
                        </div>
                    </div>
                </div>
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
    <script type="text/html" id="tr">
      <tr class="data" data-id=[ID]>
          <td>
            <input type="checkbox"  readonly class="quantityNotif" value="[CLASS_CODE][[QUANTITY]]"/>
        </td>
          <td>
              <input type="checkbox" readonly style="opacity:1;" readonly name="is_default" [CHECKED]/>
          </td>
          <td><input class="form-control" readonly value="[CLASS_CODE]" name="class_code_no"/></td>
          <td><input class="form-control" readonly value="[DESCRIPTION]" name="description"/></td>
          <td><input class="form-control" min="0"  type="number" readonly value="[QUANTITY]" name="quantity"/></td>
          <td><input class="form-control" readonly value="[UNIT]" name="unit"/></td>
          <td><input class="form-control" readonly value="[REMARKS]" name="remarks"/></td>
          <td width="200">
              <button class="btn pull-left edit-supply"><span class="glyphicon glyphicon-pencil"></span></button>
              <button class="btn hidden pull-left save-supply"><span class="glyphicon glyphicon-ok"></span></button>
              <button style="margin-left:2px;" class="btn hidden pull-left close-supply"><span class="glyphicon glyphicon-remove"></span></button>
          </td>
      </tr>
    </script>
    <script type="text/html" id="tr2">
      <tr class="data" data-id=[ID]>
          <td><input class="form-control" readonly value="[CLASS_CODE]" name="class_code_no"/></td>
          <td><input class="form-control" readonly value="[DESCRIPTION]" name="description"/></td>
          <td><input class="form-control" min="0"  type="number" readonly value="[QUANTITY]" name="quantity"/></td>
          <td><input class="form-control" readonly value="[UNIT]" name="unit"/></td>
          <td><input class="form-control" readonly value="[REMARKS]" name="remarks"/></td>
          <td width="200">
              <button class="btn pull-left edit-supply"><span class="glyphicon glyphicon-pencil"></span></button>
              <button class="btn hidden pull-left save-supply"><span class="glyphicon glyphicon-ok"></span></button>
              <button style="margin-left:2px;" class="btn hidden pull-left close-supply"><span class="glyphicon glyphicon-remove"></span></button>
          </td>
      </tr>
    </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chosen.jquery.min.js" type="text/javascript"></script>
  <script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    (function($){
      var Supply = {
                opt : null,
                __init  : function(){
                    this.__listen();
                    this.initListener();
                    var me = this;

                    var config = {
                      '.classCodes'           : {}
                    }
                    for (var selector in config) {
                      $(selector).chosen(config[selector]);
                    }

                    $("input[name='quantity']").first().on("keyup", function(){
                        var val  = parseInt($(this).val());
                        var max = parseInt($(this).attr("max"));

                        if(val > max){
                            $(this).val(max);
                        }

                        if(val <0){
                            $(this).val(0);
                        }
                    });

                    var that = this;
                    $(".classCodes").chosen().change(function(){
                        var me = $(this);
                        var id = me.val();
                        var opt = me.find("option:selected");
                        var qty = opt.data("qty");
                        var desc = opt.data("desc");
                        var unit = opt.data("unit");
                        var rem = opt.data("remark");

                        var tr = $("tr.first").first();

                        that.opt = opt;
                        tr.find("input[name='class_code_no']").val(opt.text());
                        tr.find("input[name='description']").val(desc);
                        tr.find("input[name='quantity']").attr("max",qty);
                        tr.find("input[name='quantity']").val(0);
                        tr.find("input[name='unit']").val(unit);
                        tr.find("input[name='remarks']").val(rem);

                        tr.attr("data-parentid", id);
                        console.log(id,qty,desc,unit,rem);
                    });
                },
                __listen    : function(){
                    var me = this;
                    var addSupply       = $(".add-supply");
                    var saveSupply      = $("#save");
                    var target          = $("#supplies tbody");
                    var branch = $("#branches");
                    var sort = $(".sort");
                    var sendStock = $("#sendStock");


                    sendStock.on("click", function(e){
                        var checked = Array();
                        var qty = $(".quantityNotif:checked");
                        var branchId = $("#branches").val();
                        var branch = $("#branches option:selected").text();
                        var type = $(this).data("user");
                  
                        qty.each(function(){
                            var val = $(this).val();
                            checked.push(val);            
                        });

                        if(checked.length == 0 ){
                            return false;
                        }

                        var message = "the ff. item/s are currently low in stock: " + checked;

                        $.ajax({
                            url     : "backend/process.php",
                            data    : {
                              sendNotif : true, 
                              message   : message,
                              branchId  : branchId,
                              type      : type
                            },
                            type    : 'POST',
                            dataType    : 'JSON',
                            success     : function(response){
                                console.log(response);
                            },
                            error   : function(){
                                console.log("err");
                            }
                        });

                        e.preventDefault();
                    });

                    sort.on("click", function(){
                        var up = $(this).hasClass("glyphicon-arrow-up");
                        var order = (up == true) ? 'ASC' : 'DESC';
                        var href = window.location.href;
                        var exists = href.search('&sort');

                        if(exists > 0){
                            href = href.replace("&sort=ASC", "&sort="+order);
                            href = href.replace("&sort=DESC", "&sort="+order);
                        } else {
                            href = href + "&sort="+order;
                        }

                        window.location.href= href;

                    });

                    branch.on("change", function(e){
                        var val = $(this).val();
                        var url = window.location.origin+window.location.pathname+"?active=supply&id="+val;

                        window.location.href = url;
                    });
                    

                    $(".main-search").off().on("keyup", function(){
                        var txt = $(this).val();
                        var target = $("#supplies tbody");
                        var all = (txt.length == 0) ? true : false;
                        target.find("tr:not(.first)").remove();

                        var target = $("#supplies tbody");
                        $.ajax({
                            url     : "backend/process.php",
                            data    : {searchMaterial:true, txt:txt, all:all},
                            type    : 'POST',
                            dataType    : 'JSON',
                            success     : function(response){
                                if(response.materials.length == 0){
                                    return false;
                                }
                                
                                var tpl = $("#tr").html();

                                for(var i in response.materials){
                                      tpl = tpl.replace("[CLASS_CODE]", response.materials[i].class_code).
                                        replace("[DESCRIPTION]", response.materials[i].description).
                                        replace("[CHECKED]", (response.materials[i].is_default == 1) ? "checked" : "").
                                        replace("[QUANTITY]", response.materials[i].quantity).
                                        replace("[UNIT]", response.materials[i].unit).
                                        replace("[ID]", response.materials[i].id).
                                        replace("[REMARKS]", response.materials[i].remarks);

                                    target.find("tr").last().after(tpl);
                                }
                                
                                me.initListener();
                            },
                            error   : function(){
                                console.log("err");
                            }
                        });
                    });
                    
                    var that = this;
                    addSupply.off().on("click", function(){
                        var target          = $(this).parents("tbody");

                        var checked     = $(this).parents("tr").find("input[name='is_default']").is(":checked");
                        // var checked     = target.find("input[name='is_default']");
                        var classCode   = target.find("input[name='class_code_no']").val();
                        var description = target.find("input[name='description']").val();
                        var quantity    = target.find("input[name='quantity']").val();
                        var unit        = target.find("input[name='unit']").val();
                        var remarks     = target.find("input[name='remarks']").val();
                        var tr          = $("#tr").html();
                        var branchId    = $("#branches").val();
                        var parentId = null;


                        if(description == ""){
                            alert("Description is required.");
                            return false;
                        }

                        var isMain = $(this).hasClass("main");

                        if(isMain == true){
                            tr = $("#tr2").html();
                            tr = tr.replace("[CLASS_CODE]", classCode).
                            replace("[CLASS_CODE]", classCode).
                            replace("[DESCRIPTION]", description).
                            replace("[CHECKED]", (checked == true) ? "checked" : "").
                            replace("[QUANTITY]", quantity).
                            replace("[QUANTITY]", quantity).
                            replace("[UNIT]", unit).
                            replace("[REMARKS]", remarks);
                        } else {

                        parentId = $("tr.first").data("parentid");
                            tr = tr.replace("[CLASS_CODE]", classCode).
                            replace("[CLASS_CODE]", classCode).
                            replace("[DESCRIPTION]", description).
                            replace("[CHECKED]", (checked == true) ? "checked" : "").
                            replace("[QUANTITY]", quantity).
                            replace("[QUANTITY]", quantity).
                            replace("[UNIT]", unit).
                            replace("[REMARKS]", remarks);
                        }

                        var btn = $(this);
                        btn.attr("disabled", "disabled");
                        $.ajax({
                            url     : "backend/process.php",
                            data    : {

                                addMaterial     : true,
                                checked         : checked,
                                classCode       : classCode,
                                description     : description,
                                quantity        : quantity,
                                unit            : unit,
                                remarks         : remarks,
                                parentId        : parentId,
                                branchId        : branchId,
                                isMain          : $(this).hasClass("main")
                            },
                            type    : 'POST',
                            dataType    : 'JSON',
                            success     : function(response){
                                btn.removeAttr("disabled");
                                target.append(tr);
                                me.initListener();

                                $
                                $("tr.first").find("input").val("");
                                 me.opt.remove();
                                $(".classCodes").trigger("chosen:updated");

                            },
                            error       : function(){
                                console.log("err");
                            }
                        });

                    });
                },
                initListener    : function(){
                    var editSupply      = $(".edit-supply");
                    var cancelSupply    = $(".close-supply");
                    var saveSupply      = $(".save-supply");

                    saveSupply.on("click", function(){
                        var target      = $(this).parents("tr");
                        var id          = target.data("id");
                        var checked     = $(this).parents("tr").find("input[name='is_default']").is(":checked");
                        var classCode   = target.find("input[name='class_code_no']").val();
                        var description = target.find("input[name='description']").val();
                        var addStock = target.find("input.add-stock").val();
                        var quantity    = target.find("input[name='quantity']").val();
                        var parentId = target.data("parentid");
                        var additional = parseInt(target.find("input.add-stock").val());
                        //add added stock to quantity first
                        if(addStock != null){
                          quantity = parseInt(addStock) + parseInt(quantity);
                        }

                        if(additional == null){
                          additional = 0;
                        }

                        var unit        = target.find("input[name='unit']").val();
                        var remarks     = target.find("input[name='remarks']").val(); 

                       var isMain = $(this).hasClass("main");

                        $(this).addClass("hidden");
                        $(this).parents("td").find(".close-supply").addClass("hidden");
                        $(this).parents("td").find(".edit-supply").removeClass("hidden");
                        $(this).parents("tr").find("input").attr("readonly","readonly");
                        target.find("input[name='quantity']").val(quantity);
                        target.find("input.add-stock").addClass("hidden");


                         $.ajax({
                            url     : "backend/process.php",
                            data    : {
                                updateMaterial     : true,
                                id              : id,
                                checked         : checked,
                                classCode       : classCode,
                                description     : description,
                                quantity        : quantity,
                                unit            : unit,
                                remarks         : remarks,
                                additional         : additional,
                                parentId         : parentId,
                                updateQty       : isMain
                            },
                            type    : 'POST',
                            dataType    : 'JSON',
                            success     : function(response){
                                console.log("success");
                            },
                            error       : function(){
                                console.log("err");
                            }
                        });
                    });

                    editSupply.on("click", function(){
                      var parentId = $(this).parents("tr").data("parentid");
                      //get remaining stock from warehouse inventory
                      $(this).addClass("hidden");
                      $(this).parents("td").find(".save-supply, .close-supply").removeClass("hidden");
                      $(this).parents("tr").find("input:not(.not-this)").removeAttr("readonly");
                      
                      var addStock = $(this).parents("tr").find("input.add-stock");
                      $.ajax({
                        url   : "backend/process.php",
                        data  : {
                          getRemainingStock : true,
                          parentId  : parentId
                        },
                        type  : 'POST',
                        dataType  : 'JSON',
                        success   : function(response){
                          addStock.removeClass("hidden").attr("max",response);
                        },
                        error     : function(){
                          console.log("err");
                        }
                      });
                        
                    });

                    cancelSupply.on("click", function(){
                      var addStock = $(this).parents("tr").find("input.add-stock");

                      addStock.addClass("hidden");
                        $(this).addClass("hidden");
                        $(this).parents("td").find(".save-supply").addClass("hidden");
                        $(this).parents("td").find(".edit-supply").removeClass("hidden");
                        $(this).parents("tr").find("input").attr("readonly","readonly");
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
