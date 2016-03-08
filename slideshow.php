
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
        <h1 class="blog-title">Slideshows</h1>
        <!-- <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p> -->
      </div>

      <div class="row">
        <div class="col-sm-12 blog-main">
          <style type="text/css">
          .add-slide img {
              width: 100%;
              height: auto;
          }
          </style>
          <!-- other content goes here -->
          <?php $slides = new Model(); $slides = $slides->getSlideshows(); ?>

          <?php foreach($slides as $idx => $slide): ?>
          <br>
          <div class="row add-slide blog-post">
              <div class="columns col-sm-12">
                  <a href="" data-id="<?= $slide['id'];?>" class="cancel control data-hidden hidden pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                  <a href="" data-id="<?= $slide['id'];?>" class="save control data-hidden hidden pull-right"><span class="glyphicon glyphicon-ok"></span></a>
                  <a href="" data-id="<?= $slide['id'];?>" class="delete control data-init pull-right"><span class="glyphicon glyphicon-trash"></span></a>
                  <a href="" data-id="<?= $slide['id'];?>" class="edit control data-init pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
                <!--   <a href="" class="close remove-slide" data-id="<?= $slide['id'];?>">
                    <button class="btn"><span class="glyphicon glyphicon-remove"></span></button>
                  </a> -->
                   <br>
                  <label class="label">Slide Title:
                  </label>
                    <h2 class="data-init"><?= $slide['title']?></h2>
                    <input type="text" class="data-hidden hidden form-control title" value="<?= $slide['title'];?>" placeholder="Slide Title..."/>
                  <br>
                  <label class="label">Slide Description:
                  </label>
                    <p class="data-init"> <?= $slide['desc']?></p>
<textarea class="data-hidden form-control hidden desc" placeholder="Slide Description...">
<?= $slide['desc'];?>
</textarea>
                    <br>
                  <img class="cover" src="<?= $slide['cover'];?>" />
              </div>
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
          var me = this;
          var deleteNews = $(".delete");
          var editNews = $(".edit");
          var saveNews = $(".save");
          var cancel = $(".cancel");

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
            var desc = me.parents(".blog-post").find(".desc").first().val();

            $.ajax({
              url   : "backend/process.php",
              data  : {
                updateSlideShow : true,
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
            var target = $(this);
            var id = $(this).data("id");

            $.ajax({
                url     : "backend/process.php",
                data    : {deleteSlide:true, id:id},
                type    : 'POST',
                dataType    : 'JSON',
                success     : function(response){
                    console.log(response);

                    target.parents(".add-slide").remove();
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
