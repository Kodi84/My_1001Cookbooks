                             <form action="" method="POST">
                                <div class="form-group">
                                   <label for="cat_title">Edit Categories</label>
                                   <?php
                                    if (isset($_GET['edit'])){
                                        $cat_id = $_GET['edit'];
                                        try{
                                            $readQuery = "SELECT * FROM categories WHERE cat_id=$cat_id";
                                            $statement = $connection->query($readQuery);

                                            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                                                $cat_id  = $row['cat_id'];
                                                $cat_title  = $row['cat_title'];
                                        ?>
                                        <input  value = "<?php if(isset($cat_title)){echo $cat_title;} ?>" type="text" class="form-control" name="cat_title">
                                        <?php
                                            }
                                        }catch(PDOException $e){
                                            echo ("Error has occured".$e->getMessage());
                                        }

                                    }?>

                                    <?php //UPDATE categories
                                    if(isset($_POST['update_categories'])){
                                        $cat_title = $_POST['cat_title'];
                                        try{
                                            //build query
                                            $update = "UPDATE categories SET cat_title = :cat_title WHERE cat_id = :cat_id";

                                            //prepare query
                                            $statement = $connection->prepare($update);

                                            //execute the statement
                                            $statement->execute(array(":cat_title"=>$cat_title,":cat_id"=>$cat_id));

                                            if($statement){
                                                echo "Record Updated";
                                            }
                                        }catch(PDOException $e){
                                            echo ("Error has occured".$e->getMessage());
                                        }
                                    }
                                    ?>
                                    </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="update_categories" value="Update Categories" >
                                </div>
                            </form>