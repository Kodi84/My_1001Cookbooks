<?php
if(isset($_GET['p_id'])){
    $post_id = $_GET['p_id'];

    $readQuery = "SELECT * FROM posts Where post_id=$post_id";
    $statement = $connection->query($readQuery);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = html_entity_decode($row['post_content']);
    }
}

if(isset($_POST['edit_post'])){
    $post_title =trim($_POST['title']);
    $post_author =trim($_POST['author']);
    $post_category_id =$_POST['post_category_id'];
    $post_status =trim($_POST['post_status']);

    $post_image_update = $_FILES['image']['name'];
//    $post_image_temp = $_FILES['image']['tmp_name'];
    if(empty($post_image_update)){
        $post_image_update = $post_image;
    }else{
        $post_image_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($post_image_temp, "../images/$post_image_update " );
    }

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
        echo "<a href='http://myapplication.dev/cms_project/CMS/admin/posts.php?source=add_post'>Back to Form</a>";
        die();
    }
    try{
        //build query
        $update = "UPDATE posts SET post_category_id = :post_category_id,
            post_title = :post_title,
            post_author = :post_author,
            post_date = :post_date,
            post_image = :post_image,
            post_content = :post_content,
            post_tags = :post_tags,
            post_comment_count = :post_comment_count,
            post_status = :post_status
            WHERE post_id=$post_id";

        //prepare query
        $statement = $connection ->prepare($update);

        //execute the statement
        $statement->execute(array(":post_category_id"=>$post_category_id,":post_title"=>$post_title,":post_author"=>$post_author,":post_date"=>$post_date,":post_image"=>$post_image_update,":post_content"=>$post_content,":post_tags"=>$post_tags,":post_comment_count"=>$post_comment_count,":post_status"=>$post_status,));

        if($statement->rowCount()===1){
            echo "Succefully Updated Post Record";
        }else{
            echo "No Changes Has Been Made";
        }
    }catch(PDOException $e){
        echo ("Error has occured".$e->getMessage());
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
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
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="author">
    </div>
    
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image?>">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" rows="5" id="mytextarea"><?php echo $post_content; ?></textarea>
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_post" value="Confirm Edit">
    </div>
</form>