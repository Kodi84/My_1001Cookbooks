<?php
function confirm($result){
    global $connection;
    if(!$result){
        die("Query failed".mysqli_error($connection));
    }
}
function insert_categories(){
    global $connection;
    if(isset($_POST['submit'])){
        try{
            $cat_title = trim($_POST['cat_title']);
            if(empty($cat_title)){
                echo ("This field should not be empty");
                die();
            }

            //build query
            $insertQuery = "INSERT INTO categories(cat_title) VALUES(:cat_title)";

            //prepare query
            $statement = $connection->prepare($insertQuery);

            //execute the statement
            $statement->execute(array(":cat_title"=>$cat_title));

            if($statement){
                echo "Record inserted";
            }
        }catch(PDOException $e){
            echo ("Error has occured".$e->getMessage());
        }
    }
}

function read_all_categories(){
    global $connection;
    try{
        $readQuery = "SELECT * FROM categories";
        $statement = $connection->query($readQuery);

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];
            echo ("<tr>");
            echo ("<td>$cat_id</td>");
            echo ("<td>$cat_title</td>");
            echo ("<td><a href='categories.php?delete=$cat_id'>Delete</a></td>");
            echo ("<td><a href='categories.php?edit=$cat_id'>Edit</a></td>");
            echo ("</tr>");
        }
    }catch(PDOException $e){
        echo ("Error has occured".$e->getMessage());
    }
}

function delete_categories(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        try{
            //build query
            $delete = "DELETE FROM categories Where cat_id = :the_cat_id ";

            //prepare query
            $statement = $connection->prepare($delete);

            //execute the statement
            $statement->execute(array(":the_cat_id" => $the_cat_id));

            if($statement){
                echo "Record have been deleted";
                header('Location:categories.php');
            }
        }catch(PDOException $e){
            echo ("Error has occured".$e->getMessage());
        }
    }
}
?>
