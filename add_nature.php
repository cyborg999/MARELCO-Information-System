
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
        <?php include_once "header.php"; ?>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Add Nature of Complaint/Request</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <!-- other content goes here -->
           <form id="saveNatureForm" class="form-horizontal">
            <input type="hidden" name="addNature" value="true">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td><label>Name:</label></td>
                  <td>
                    <input type="text" name="name" class="form-control"> 
                  </td>
                </tr>
                 <tr>
                  <td><label>Level of Emergency:</label></td>
                  <td>
                    <select name="emergency_level" class="form-control">
                        <option value="Low">Low</option>
                        <option  value="Medium">Medium</option>
                        <option selected value="High">High</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label>Type:</label></td>
                  <td>
                    <label>
                        <input type="radio" name="nature" value="request">
                        Request
                    </label>
                    <label>
                      <input type="radio" name="nature" checked value="complaint">
                      Complaint
                    </label>
                  </td>
                </tr>
                <tr>
                  <td>
                   <label>Alloted Time(minutes): </label>
                  </td>
                  <td>
                    <input type="number" min="20" max="300" class="form-control" name="alloted_time"   id="alloted_time" >
                  </td>
                </tr>
                 <tr>
                  <td>
                   <label>Description</label>
                  </td>
                  <td>
                  <textarea class="form-control" name="description" placeholder="Description..."></textarea>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label>Requirements:</label>
                  </td>
                  <td>
                    <input type="hidden" name="requirements" id="allRequirements">
                    <ul id="requirements">
                      <li class="last">
                      <br>
                        <input type="text" class=" pull-lesft form-control add-requirement-text"  width="200" placeholder="add requirement.."/>
                      <br>
                        <button class="btn add-requirement"><span class="glyphicon glyphicon-plus"></span> </button>
                      </li>
                    </ul>
                  </td>
                </tr>
              </tbody>
            </table>
              <?php $materials = $model->getMaterialByBranchId(); ?>
  
                 <label>Supply Requirements:</label>
                <table class="table">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Class Code</th>
                      <th>Description</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($materials as $idx => $m){ ?>
                    <tr>
                      <td>
                        <input type="checkbox" name="supply[chkId][]" value="<?= $m['id'];?>"/>
                      </td>
                      <td><?= $m['class_code'];?></td>
                      <td><?= $m['description'];?></td>
                      <td>
                      <input type="number" min="1" class="form-control" name="supply[quantity][]" />
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <input  type="submit" id="Save" class="btn btn-success btn-lg" value="Save"/>
            </form>
           
        </div><!-- /.blog-main -->

        
      </div><!-- /.row -->

    </div><!-- /.container -->
   
    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
    <script type="text/html" id="tpl">
    <li class="label label-primary" style="margin:5px;font-size:12px;" data-content="[CONTENT]">[VAL]
    <a href=""><span class="remove glyphicon glyphicon-remove"></span></a>
    </li>
    
    </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script> <!-- jQuery Library -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    (function($){
      var Nature = {
        __init : function(){
          this.__listen();
        },
        __defaultListener : function(){
          $(".remove").on("click", function(e){
            $(this).parents("li").remove();
            e.preventDefault();
          });

        },
        __listen : function(){
          var saveNature = $("#Save");
          var me = this;
          
          $("#alloted_time").on("keyup", function(){
              var val  = parseInt($(this).val());
              var max = parseInt($(this).attr("max"));

              console.log(val,max);
              if(val > max){
                  $(this).val(max);
              }

              if(val <0){
                  $(this).val(0);
              }
          });

          $(".add-requirement").on("click", function(e){
            var val = $(".add-requirement-text").val();

            if(val !=""){
              var tpl = $("#tpl").html();
              tpl = tpl.replace("[VAL]", val).
                replace("[CONTENT]", val);
              $("#requirements .last").before(tpl);
              me.__defaultListener();

              $(".add-requirement-text").val("");
            }

            e.preventDefault();
          });

          saveNature.on("click", function(e){
            var req = Array();
              e.preventDefault();

        
              $("#requirements li:not(.last)").each(function(){
                var txt = $(this).data("content");
                req.push(txt);
              });

              req = req.join(",");

              $("#allRequirements").val(req);

              $.ajax({
                  url     : "backend/process.php",
                  data    : $("#saveNatureForm").serialize(),
                  type    : 'POST',
                  dataType    : 'JSON',
                  success     : function(response){
                      if(response.added == false){
                        alert("Name already exists");
                      } else {
                        alert("Record is sucesfully saved.");
                        window.location.href = window.location.href;
                      }
                  },
                  error       : function(){
                      console.log("err");
                  }
              });

          });
        }
      }

      Nature.__init();
    })(jQuery);
    </script>
  </body>
</html>
