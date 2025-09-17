<?php
include "config.php";


if(isset($_POST["submit"])){

    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);


    if(empty($name)){
        $err = "Enter your name";
    }
    elseif(empty($email)){
        $err = "Enter your email";
    }
    elseif(!preg_match('/^[a-zA-Z\s]+$/',$name)){
        $err = "Invalid name";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $err = "Enter a valid email";
    }else{

        $stmt = $pdo->prepare("INSERT INTO users(name, email) 
                                VALUES(:name,:email)");
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt){
            echo "Registered Successfully";
        }

    

    }
}




// DELETE USERS
if(!empty($_GET["userid"])){

    $id = intval($_GET["userid"]);

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt){
        echo "User Deleted";
    }

}


//UPDATE USERS
if(!empty($_GET["userid"])){

$id = intval($_GET["userid"]);

$stmt = $pdo->prepare("UPDATE FROM users WHERE id = :id");
$stmt->bindparam(":id", $id, PDO::PARAM_INT);
$stmt->execute();

if($stmt){
    echo "User Updated";
}
}else{
    $id = $stmt->fetchAll($users);
    print_r($users);
}

?>


<style>
body{
    margin:0;
    font-family:arial;
}
form{
    border:1px solid #bbb;
    padding:20px;
    border-radius:10px;
    width:400px;
    margin:auto;
    margin-top:60px;
}

input{
    border:1px solid #bbb;
    padding:15px;
    border-radius:10px;
    width:100%;
    outline:none;
}


button{
    border:none;
    padding:15px;
    border-radius:10px;
    width:100%;
    background:blue;
    color:#fff;
    cursor: pointer;
    transition:0.5s;
}

.err{
    color:red;
    margin:5px 5px 5px 0px;
}
table{
    min-width:400px;
    margin:auto;
}

table td a:nth-child(1){
background:red;
color:#fff;
border-radius:5px;
padding:5px 8px;
text-decoration:none;
} 

table td a:nth-child(2){
background:green;
color:#fff;
border-radius:5px;
padding:5px 8px;
text-decoration:none;
} 
</style>




<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

<?php if(isset($err)){?>
<div class="err"><?php echo $err;?></div>
<?php };
?>


<input type="text" name="name" placeholder="Enter Name" 
value="<?php if(!empty($name)){echo  htmlspecialchars($name);}?>">
<p>
<input type="text" name="email" placeholder="Enter Email" 
value="<?php if(!empty($email)){echo  htmlspecialchars($email);}?>">

<p>
<button name="submit" type="submit">Register</button>
</form>





<p>
<br>


<?php

try{

    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll();
    $num = 1;

    echo "<table border cellpadding='10px'>
        <tr>
        <th>S/N</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
        </tr>";

    foreach($users as $user){ 

echo "<tr>
    <td>".$num."</td>
    <td>".$user['name']."</td>
    <td>".$user['email']."</td>
    <td>
    <a href='index.php?userid=".$user['id']."'>Delete</a> 
    <a href='index.php?userid=".$user['id']."'>Update</a>
    </td>
    </tr>";

    $num ++;
} 
echo "</table>";




}catch(PDOException $e){
    echo "Error fetching users: " . $e->getMessage();
};
?>