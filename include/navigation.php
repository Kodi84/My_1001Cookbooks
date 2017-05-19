<?php include "db.php"?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">1001 COOKBOOKS</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php

                try{
                    $readQuery = "SELECT * FROM categories";
                    $statement = $connection->query($readQuery);

                    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                        $category_class= "";

                        if(isset($_GET['category']) && $_GET['category'] == $cat_id ){
                            $category_class='active';
                        }
                        echo ("<li class='$category_class'><a href='category.php?category=$cat_id'>{$cat_title}</a></li>");
                    }
                }catch(PDOException $e){
                    echo ("Error has occured".$e->getMessage());
                }
                ?>

            </ul>
            <ul class="nav navbar-right top-nav">
                <li>
                    <a href="admin/index.php">ADMIN</a>
                </li>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
