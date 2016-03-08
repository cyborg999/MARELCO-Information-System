
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
        <h1 class="blog-title">Add Consumer Complaint</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <!-- other content goes here -->
          <form id="complaints">
            <input type="hidden" class="form-control" name="type" value="complaint">
            <input type="hidden" class="form-control" name="complaintAdd" value="true">
            <div class="form-group">
                <input type="text" class="form-control hidden" name="consumer_name" placeholder="Name of Consumer...">
            </div>
            <div class="row">
              <div class="form-group col-sm-4">
                <input type="text" class="form-control" required name="firstname" placeholder="Firstname..."/>
              </div>
              <div class="form-group col-sm-4">
                <input type="text" class="form-control" required name="middlename" placeholder="Middlename..."/>
              </div>
              <div class="form-group col-sm-4">
                <input type="text" class="form-control" required name="lastname" placeholder="Lastname..."/>
              </div>
              <div class="form-group">
                  <input type="text"  class="form-control hidden" name="address" placeholder="Address...">
              </div>
              <div class="form-group col-sm-4">
                <select class="select form-control" id="municipality" name="municipality">
                    <option value="boac">Boac</option>
                    <option value="mogpog">Mogpog</option>
                    <option value="gasan">Gasan</option>
                    <option value="stacrus">Sta. Cruz</option>
                    <option value="buenavista">Buenavista</option>
                    <option value="torrijos">Torrijos</option>
                </select>
              </div>
              <div class="form-group col-sm-4">  
                <?php $brgy = $model->getBrgyByMunicipality();?>
                <select class="form-control" name="brgy" id="brgy">
                  <?php foreach($brgy as $idx => $b) : ?>
                  <option value="<?= $b['id']?>"><?= $b['name'];?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-sm-4">
                <input type="text" class="form-control" readonly name="province" placeholder="Province..." value="Marinduque"/>
              </div>
            </div>
            <div class="form-group">
                <input type="text"  class="form-control"name="contact_number" placeholder="Contact Number...">
            </div>
            <div class="form-group">
                <select class="select form-control" name="complaint_nature">
                    <?php $nature = $model->getNatureByType("complaint"); ?>
                    <?php foreach($nature as $idx => $n): ?>
                        <option value="<?= $n['name'];?>"><?= $n['name'];?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group hidden">
                <input type="text"  class="input-sm form-control mask-date_time" name="complaint_datetime" placeholder="Date & Time Receipt of Complaints...">
            </div>
            <div class="form-group hidden">
                <input type="text"  class="form-control"name="action_desired" placeholder="Action Desired...">
            </div>
            <div class="form-group hidden">
                <input type="text"  class="form-control"name="action_taken" placeholder="Action/S Taken/Recommendation...">
            </div>
            <div class="form-group hidden">
                <input type="text"  class="form-control mask-date_time" name="action_datetime" placeholder="Date & Time of Action/s...">
            </div>
            <div class="form-group hidden">
                <input type="text"  class="form-control" name="or_number" placeholder="OR Number...">
            </div>
            <div class="form-group">
                <input type="submit" id="submitbtn" class="btn btn-lg btn-success" value="Add"/>
            </div>
            <ul id="errors"></ul>
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
      <option value="[ID]">[MUNICIPALITY]</option>
    </script>

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
            for(var i in error){
              $("#errors").append("<li>"+error[i]+"</li>");
            }
        },
        __listen : function(){
          var me  = this;
          var save    = $("#complaints");
          var municipality = $("#municipality");

          municipality.on("change", function(e){
            var m = $(this).val();
            var target = $("#brgy");

            target.html("");

            $.ajax({
              url   : "backend/process.php",
              data  : {ajaxMunicipality : m},
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){
                for(var i in response){
                  var tpl = $("#tpl").html();

                  tpl = tpl.replace("[ID]", response[i].id).
                    replace("[MUNICIPALITY]", response[i].name);

                    target.append(tpl);
                }
                console.log(response);
              },
              error     : function(){
                console.log("err");
              }
            });
          });

          save.on("submit", function(e){
              var form = $(this);
              var btn = $("#submitbtn");

              btn.attr("disabled", "disabled");

              $.ajax({
                  url     : "backend/process.php",
                  data    : $(this).serialize(),
                  type    : 'POST',
                  dataType : 'JSON',
                  success  : function(response){
                      $("#errors").html("");
                      console.log(response);
                      if(response.added != null){
                        if(response.added == true){
                          alert("Consumer complaint is sucesfully added.");
                        } else {
                          alert("Failed to add this complaint.");
                        }
                      } else {
                          console.log("err");
                          if(response.error.length > 0){
                              me.__error(response.error, form);
                          }    
                      }
                  },
                  error    : function(){
                      console.log("err");
                  },
                  complete  : function (){
                    btn.removeAttr("disabled");
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
