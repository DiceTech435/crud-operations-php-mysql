<?php
// show error
ini_set('display_errors', 1);

// Add config file
include("config.php");


if(!isset($_GET["userid"])){
    header("location:dashboard.php");
}
else{


//Get user id
$userid = $_GET["userid"];

// Get user info based on the id 
$stmt = $pdo->prepare("SELECT * FROM users WHERE userid = :userid");
$stmt->bindParam(":userid", $userid, PDO::PARAM_INT);
$stmt->execute();
$userData = $stmt->fetch();



if(isset($_POST["submit"])){
// validate first name
if(empty($_POST["fname"])){
    $error = "Enter firstname";
}
elseif(!preg_match("/^[a-zA-Z]+$/", $_POST["fname"])){
    $error = "Invalid firstname! Only letters allowed";
}
elseif(strlen($_POST["fname"]) < 2){
    $error = "Firstname must be upto two characters";
}

// validate last name
elseif(empty($_POST["lname"])){
    $error = "Enter lastname";
}

// validate email
elseif(empty($_POST["email"])){
    $error = "Enter email";
}
elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    $error = "Enter a valid email address";
}

else{

    //Sanitize
    //escape
    //prepare
    //parameterize
    //Bind
    //execute


    $fname = htmlspecialchars($_POST["fname"]);
    $lname = htmlspecialchars($_POST["lname"]);
    $email = htmlspecialchars($_POST["email"]);


    // INSERT STATEMENT  - (C)
    $stmt = $pdo->prepare("UPDATE users SET fname=:fname, lname=:lname, email=:email WHERE userid = :userid");
    $stmt->bindParam(":fname", $fname, PDO::PARAM_STR);
    $stmt->bindParam(":lname", $lname, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":userid", $userid, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt){
    $success = "<font color='green'>UPDATED SUCCESSFULLY!!</font>";
    }


}

}


}




?>



<meta name="viewport" content="width=device-width, initial-content=1">


<style>
form{
width: 400px;
border:1px solid #bbb;
border-radius: 10px;
padding: 20px;
margin: auto;
margin-top: 50px;
}
input{
width: 100%;
border:1px solid #bbb;
border-radius: 10px;
padding: 20px;
outline: none;
}
.btn{
width: 100%;
border:none;
border-radius: 10px;
padding: 20px;
background: #265bc8;
transition: 0.3s;
color:#fff;
}

.btn:hover{
background: #1f3f7f;
transition: 0.3s;  
cursor:pointer;
}

.error{
    background:#d93939;
    color:#fff;
    font-family: arial;
    border-radius: 10px;
    text-align: center;
    /* width: 100%; */
    padding: 15px;
    margin-bottom: 15px;
}

.link{
    text-decoration: none;
    color: #265bc8;
    text-align: center;
    margin-top: 20px;
    display: block;
}
</style>


<form method="POST">
<h2 align="center">Register</h2>

<?php if(!empty($error)){?>
<div class="error"><?php echo $error;?></div>
<?php }?>

<?php if(isset($success)){?>
<h2 align="center"><?php echo $success;?></h2>
<?php }?>

<input value="<?php if(!empty($_POST["fname"])){echo $_POST["fname"];}else{echo $userData["fname"];}?>" type="text" name="fname" placeholder="First Name">
<p>
<input value="<?php if(!empty($_POST["lname"])){echo $_POST["lname"];}else{echo $userData["lname"];}?>"  type="text" name="lname" placeholder="Last Name">
<p>
<input type="text" name="email" value="<?php if(!empty($_POST["email"])){echo $_POST["email"];}else{echo $userData["email"];}?>"  placeholder="Email Address">

<p>
<button class="btn" type="submit" name="submit">Update User</button>

<p>
<?php if(isset($success)){?>
    <a href="dashboard.php" class="link">Go Back</a>
<?php }?>
</form>
