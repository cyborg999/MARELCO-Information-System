
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
        <h1 class="blog-title">Announcements</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-10 blog-main">
          <!-- other content goes here -->
          <?php $announcement = new Model(); $announcement = $announcement->getAllAnnouncement(); ?>
          <?php foreach($announcement as $idx => $a): ?>
            <div class="blog-post">
              <a href="" data-id="<?= $a['id'];?>" class="cancelNews control data-hidden hidden pull-right"><span class="glyphicon glyphicon-remove"></span></a>
              <a href="" data-id="<?= $a['id'];?>" class="saveNews control data-hidden hidden pull-right"><span class="glyphicon glyphicon-ok"></span></a>
              <a href="" data-id="<?= $a['id'];?>" class="deleteNews control data-init pull-right"><span class="glyphicon glyphicon-trash"></span></a>
              <a href="" data-id="<?= $a['id'];?>" class="editNews control data-init pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
              
              <h2 class="blog-post-title data-init"><?= $a['title']?></h2>
              <input type="text" class="title data-hidden hidden form-control" value="<?= $a['title']?>">
              <p class="blog-post-meta "><?= $a['dateadded']?> <a href="#"><?= $a['username']?></a></p>
              <blockquote >
                <p class="data-init"> <?= $a['description']?></p>
                <textarea class="data-hidden hidden form-control description"><?= $a['description']?></textarea>
              </blockquote>
            </div>
            <hr>
          <?php endforeach ?>
              
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
          var deleteNews = $(".deleteNews");
          var editNews = $(".editNews");
          var saveNews = $(".saveNews");
          var cancel = $(".cancelNews");

          cancel.on("click", function(e){
            var me = $(this);

            e.preventDefault();

            me.parents(".blog-post").find(".data-init").removeClass("hidden");
            me.parents(".blog-post").find(".data-hidden").addClass("hidden");
          });

          saveNews.on("click", function(e){
            var me = $(this);
            var id = me.data("id");
            var title = me.parents(".blog-post").find(".title").first().val();
            var desc = me.parents(".blog-post").find(".description").first().val();

            console.log(id,title,desc);
            $.ajax({
              url   : "backend/process.php",
              data  : {
                updateNews : true,
                id : id,
                title : title,
                desc : desc
              },
              type  : 'post',
              dataType  : 'JSON',
              success   : function(response){

                me.parents(".blog-post").find("h2").first().html(title).removeClass("hidden");
                me.parents(".blog-post").find("p.data-init").html(desc).removeClass("hidden");
                me.parents(".blog-post").find(".data-hidden").addClass("hidden");
                me.parents(".blog-post").find(".data-init").removeClass("hidden");
                console.log(response);
              },
              error     : function(){
                console.log("err");
              }
            });

            e.preventDefault();
          });

          editNews.on("click", function(e){
            e.preventDefault();
            var me = $(this);

            me.parents(".blog-post").find(".data-init").addClass("hidden");
            me.parents(".blog-post").find(".data-hidden").removeClass("hidden");
          });

          deleteNews.on("click", function(e){
            var id = $(this).data("id");
            var target = $(this).parents(".blog-post");

            $.ajax({
              url   : "backend/process.php",
              data  : {deleteNews:false, id:id},
              type  : 'POST',
              dataType  : 'JSON',
              success   : function(response){
                console.log(response);
                target.fadeOut().remove();
              },
              error   : function(){
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
