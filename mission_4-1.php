<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
<meta charset="utf-8">
<title></title>
</head>
<body bgcolor="black">

<?php
    $e_password =$_POST['password'];
    
    
    
    //POST data to be used
    $name = $_POST['name']; //name from form
    $comment=$_POST['comment']; //comment from form
    $d_num = $_POST['d_name']; //no that to be deleted
    $e_num = $_POST['e_name']; // no to edit
    $rw_num =$_POST['r_name']; // no to rewrite
    $date = date("Y/m/d H:i"); // data file
    
    
    //SQL connection
    $dsn = 'mysql:dbname=tt**********com;host=localhost';
    $dbusername ="t**********o";
    $dbpassword='***********';
    $tablename = 'mission_4_db';
    
    //try catch the error connecting database
    try {
        $pdo = new PDO($dsn,$dbusername,$dbpassword);
        //create table if doesnot exit
        $c_sql= "CREATE TABLE IF NOT EXISTS $tablename"
        ."("
        ."id INT NOT NULL auto_increment primary key,"
        ."name char(32) NOT NULL,"
        ."comment text NOT NULL,"
        ."date  text NOT NULL"
        .");";
        $pdo->query($c_sql);
        //------------------------
        echo "connection sucess<br>";
    } catch (PDOException $e) {
        echo $e-> getMessage()."<br>";
        die();
    }
    
    
    //check the password
    if(!empty($e_password) && $e_password=='hell'){
        //------------------------------------------logic ------------------------------//
        
        if(!empty($rw_num)&& !empty($name) && !empty($comment)){
            //edite written data
            $sql = "update $tablename set name='$name', comment='$comment' where id=$rw_num";
            $result = $pdo -> query($sql);
            $rw_num = null;
            
        }else
            //edit data
            if(!empty($e_num)){
                $s_sql ='SELECT * from mission_4_db';
                $s_result = $pdo->query($s_sql);
                foreach($s_result as $row){
                    if($row['id'] == $e_num){
                        $rw_num = $row['id'];
                        $ed_name = $row['name'];
                        $ed_comment = $row['comment'];
                    }
                }
            }else
                
                
                
                //delete data from database with the id
                if(!empty($d_num)){
                    $sql = "delete from $tablename where id=$d_num";
                    $result = $pdo -> query($sql);
                }else
                    
                    
                    
                    
                    ///add data to database using sql
                    if(!empty($name) && !empty($comment)){
                        echo $r_count;
                        $pdo = new PDO($dsn,$dbusername,$dbpassword);
                        $sql = $pdo -> prepare("INSERT INTO $tablename(name,comment,date) VALUES(:name,:comment,:date)");
                        //$sql -> bindParam(':id',$r_count,PDO::PARAM_STR);
                        $sql -> bindParam(':name',$name,PDO::PARAM_STR);
                        $sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
                        $sql -> bindParam(':date',$date,PDO::PARAM_STR);
                        $sql -> execute();
                        echo "データ正常に更新しました";
                    }
    }
    else if($e_password != 'hell' && !empty($e_password))
    {
        echo "<font size="."23"." "."font color="."red".">";
        echo "Wrong Password";
        echo "</font>";
    }
    else
    {
        echo   "パースワード入力！";
    }
    function showData($pdo){
        $s_sql ="SELECT * from mission_4_db group by id";
        $s_result = $pdo->query($s_sql);
        //echo "<center>";
        foreach($s_result as $row){
            echo $row['id'].'|'.$row['name'].'|'.$row['comment'].'|'.$row['date']
            ."<hr>";
        }
        //echo "</center>";
        echo $r_count;
    }
    
    ?>


<center>
<table>
<tr>
<td bgcolor="#E7FA07" width="40%">
<form action="" method="post">
<input type="text" name="name" value="<?php echo $ed_name; ?>" placeholder="名前" size="20"><br>
<input type="text" name="comment" value="<?php echo $ed_comment; ?>" placeholder="コメント" size="20"><br>
<input type="hidden" name="r_name" value="<?php echo $rw_num; ?>">
<input type="password" name="password" placeholder="パースワードを入力"><br>
<input type="submit" value="送信">
</form>
<hr>
<h5>削除機能</h5>
<form  action="mission_4.php" method="post">
<input type="text" name="d_name" placeholder="編集番号を入力"><br>
<input type="password" name="password" placeholder="パースワードを入力"><br>
<input type="submit" value="削除"><br>
</form>
<hr>
<h5>編集機能</h5>
<form action="mission_4.php" method="post">
<input type="text" name="e_name" placeholder="削除番号を入力"><br>
<input type="password" name="password" placeholder="パースワードを入力"><br>
<input type="submit" value="編集">
</form>
<hr>
<center>
</td>

<td bgcolor = "#07E6FA">
<?php showData($pdo);  ?>

</td>
</tr>
</table>
</center>


</body>
</html>
