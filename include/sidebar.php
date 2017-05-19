
    <div class="col-md-4">

   
    <!-- Blog Search Well -->
    <div class="well">
       
       
        <h4>Blog Search</h4>
        <form method="POST" action="search.php">
        <div class="input-group">
            <input type="text" class="form-control" name="search">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit" name="submit">
                <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
        </form> <!--seach form -->
        <!-- /.input-group -->
    </div>  

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    try{
                        $readQuery = "SELECT * FROM categories";
                        $statement = $connection->query($readQuery);

                        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                            $cat_title = $row['cat_title'];
                            $cat_id = $row['cat_id'];
                            echo ("<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>");
                        }
                    }catch(PDOException $e){
                        echo ("Error has occured".$e->getMessage());
                    }
                ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "side_widget.php" ?>