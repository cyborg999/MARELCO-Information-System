
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
        <h1 class="blog-title">System Users</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <!-- other content goes here -->
          <?php $users = new Model(); $userList = $users->getAllUsers();?>
          <table class="table table-bordered table-hovered">
              <thead>
                  <tr>
                      <th>Active</th>
                      <th>User Role</th>
                      <th>Username</th>
                      <th>Photo</th>
                      <th>Branch</th>
                      <th>Email</th>
                      <th>Firstname</th>
                      <th>Lastname</th>
                      <th>Gender</th>
                      <th>Address</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach($userList as $idx => $user): ?>
                      <tr style="opacity:<?= ($user['deleted'] == 1) ? ".3" : "1"; ?>;">
                          <td>
                              <a href="" data-id="<?= $user[0]; ?>" class="activate label btn"><?= ($user['deleted'] == 1) ? "inactive" : "active"; ?></a>
                          </td>
                          <td><?= $user['type']; ?></td>
                          <td><?= $user['username']; ?></td>
                          <td>
                              <a href="edit_user.php?id=<?= $user['mainId'];?>">
                                  <img width="50" height="50" src="uploads/<?= ($user['photo'] == "") ? 'user.png': $user['photo'] ;?>"/>
                              </a>
                          </td>
                          <td><?= $user['branch']; ?></td>
                          <td><?= $user['email']; ?></td>
                          <td><?= $user['firstname']; ?></td>
                          <td><?= $user['lastname']; ?></td>
                          <td><?= $user['sex']; ?></td>
                          <td><?= $user['brgy'].", ".ucwords($user['municipality']).", Marinduque"; ?></td>
                      </tr>
                  <?php endforeach ?>
              </tbody>
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


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of th
    e document so the pages load faster -->
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
          var activate    = $(".activate");

          activate.on("click", function(e){
              var me          = $(this);
              var val         = me.html();
              var id          = me.data("id");
              var opposite    = "";

              if(val == "active"){
                  opposite = 1;

                  me.html("inactive");
                  me.parents("tr").css("opacity", .3);
              } else {
                  opposite = 0;

                  me.html("active");
                  me.parents("tr").css("opacity", 1);
              }

              $.ajax({
                  url     : "backend/process.php",
                  data    : {id:id,deleted:opposite, updatedDeleted:true},
                  type    : 'POST',
                  dataType    : 'JSON',
                  success     : function(response){
                      console.log(response);
                  },
                  error       : function(){
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
