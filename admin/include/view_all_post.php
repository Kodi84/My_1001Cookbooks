<?php 
include("delete_modal.php");
?>
       <table class="table table-bordered table-hover">
        <thead >
            <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comment</th>
            <th>Date</th>
            <th>Delete</th>
            </tr>
        </thead>
    <tbody>

<?php
    //read posts
    try{
        $readQuery = "SELECT * FROM posts JOIN categories ON post_category_id = cat_id ";
        $statement = $connection->query($readQuery);


    if($statement->rowCount()===0) {
        echo "<h1 class='al'>NO POSTS</h1>";
        die();
    }

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
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>$post_id</td>";
        echo "<td>$post_author</td>";
        echo "<td>$post_title</td>";
        echo "<td>$cat_title</td>";
        echo "<td>$post_status</td>";
        echo "<td><img width='100' src='../images/$post_image'></td>";
        echo "<td>$post_tags</td>";
        echo "<td>$post_comment</td>";
        echo "<td>$post_date</td>";
        echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
        echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link' href='posts.php?delete=$post_id'>Delete</a></td>";
        echo "</tr>";
    }
    }catch(PDOException $e){
        echo ("Error has occured".$e->getMessage());
    }
?>
<?php
    if(isset($_GET['delete'])){
        $post_id = $_GET['delete'];
        try{
            //build query
            $delete = "DELETE FROM posts 
                        Where post_id = :post_id ";

            //prepare query
            $statement = $connection->prepare($delete);

            //execute the statement
            $statement->execute(array(":post_id" => $post_id));

            if($statement){
                header('Location: posts.php');
                echo "Record have been deleted";
            }
        }catch(PDOException $e){
            echo ("Error has occured".$e->getMessage());
        }
    }
?>
 <script>

    $(document).ready(function(){
        $(".delete_link").on('click',function(){
            var id = $(this).attr('rel');
            var delete_url = "posts.php?delete=" + id +"";
            $(".modal_delete_link").attr('href', delete_url);
            $("#myModal").modal('show');
        });
    });
</script>
</tbody>
</table>    