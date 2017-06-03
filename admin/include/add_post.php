<?php

if(isset($_POST['create_post'])){
    $post_title =trim($_POST['title']);
    $post_author =trim($_POST['author']);
    $post_category_id =$_POST['post_category_id'];
    $post_status =trim($_POST['post_status']);

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags =trim($_POST['post_tags']);
    $post_content = $_POST['post_content'];
    $post_content = htmlentities($post_content);
    $post_date = date('d-m-y');
    $post_comment_count = 4;

    if (empty($post_title)  ||
        empty($post_author) ||
        empty($post_status) ||
        empty($post_tags)   ||
        empty($post_content)
        )
    {
        echo "<div class='alert alert-warning'> Input Missing ! Please fill out inputs. </div>";
        //go back to create post
        echo "<a href='javascript:history.go(-1)'>Back to Form</a>";
        die();
    }

    move_uploaded_file($post_image_temp, "../images/$post_image" );

    try{
        //build query
        $insertQuery = "INSERT INTO posts (post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_comment_count,post_status) VALUES(:post_category_id,:post_title,:post_author,:post_date,:post_image,:post_content,:post_tags,:post_comment_count,:post_status)";

        //prepare query
        $statement = $connection ->prepare($insertQuery);

        //execute the statement
        $statement->execute(array(":post_category_id"=>$post_category_id,":post_title"=>$post_title,":post_author"=>$post_author,":post_date"=>$post_date,":post_image"=>$post_image,":post_content"=>$post_content,":post_tags"=>$post_tags,":post_comment_count"=>$post_comment_count,":post_status"=>$post_status,));

        if($statement){
            echo "Record inserted";
        }
    }catch(PDOException $e){
        echo ("Error has occured".$e->getMessage());
    }
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
     <div class="form-group">
       <label for="categories">Post Categories</label>
        <select class="form-control" name="post_category_id" id="categories">

            <?php
            try{
                $readQuery = "SELECT * FROM categories";
                $statement = $connection->query($readQuery);

                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    echo ("<option value='$cat_id'>$cat_title</option>");
                }
            }catch(PDOException $e){
                echo ("Error has occured".$e->getMessage());
            }
            ?>
          </select>
    </div>
    
    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div>
    
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" rows="5" id="mytextarea"></textarea>
    </div>
       
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="PublicPost">
    </div>
</form>
