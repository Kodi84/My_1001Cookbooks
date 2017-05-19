<?php include "include/header.php" ?>
    <!-- Navigation -->
    <?php include "include/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8 blog_content">
             <?php
             if(isset($_GET['p_id'])){
                 $post_id=$_GET['p_id'];
             }

             try{
                 $readQuery = "SELECT * FROM posts WHERE post_id=$post_id";
                 $statement = $connection->query($readQuery);

                 while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                     $post_id= $row['post_id'];
                     $post_title = $row['post_title'];
                     $post_author = $row['post_author'];
                     $post_date = $row['post_date'];
                     $post_content =$row['post_content'];
                     $post_content = html_entity_decode($post_content);
                     $post_image = $row['post_image'];
                     ?>
                     <!-- First Blog Post -->
                     <h2>
                         <a href="post.php?p_id=<?php echo $post_id?>"> <?php echo $post_title?></a>
                     </h2>
                     <p class="lead">
                         by <a href="index.php"><?php echo $post_author ?></a>
                     </p>
                     <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                     <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                     <p><?php echo $post_content ?></p>
                     <hr>
                     <?php
                 }
             }catch(PDOException $e){
                 echo ("Error has occured".$e->getMessage());
             }
                ?>
                </div>
                
            <!-- Blog Sidebar Widgets Column -->
            <?php include "include/sidebar.php"?>
            </div>
        </div>
        <!-- /.row -->
<?php include "include/footer.php"?>
