<?php
// show error
ini_set('display_errors', 1);

// Add config file
include("config.php");




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

// validate password
elseif(empty($_POST["password"])){
    $error = "Enter password";
}
elseif(strlen($_POST["password"]) < 6){
    $error = "Password must be upto 6 characters";
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
    $password = htmlspecialchars($_POST["password"]);


    // INSERT STATEMENT  - (C)
    $stmt = $pdo->prepare("INSERT INTO users(fname, lname, email, password) VALUES (:fname, :lname, :email, :password)");
    $stmt->bindParam(":fname", $fname, PDO::PARAM_STR);
    $stmt->bindParam(":lname", $lname, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt){
    // redirect if everything is fine
    // header("location: dashboard.php");
    echo "<font color='green'>User Registered</font>";

    echo "<script>
            setTimeout(()=>{
                location.href='dashboard.php'
            }, 2000);
        </script>";
    
    }


}




}


?>





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

</style>


<form method="POST">
<h2 align="center">Register</h2>

<?php if(!empty($error)){?>
<div class="error"><?php echo $error;?></div>
<?php }?>

<input value="<?php if(!empty($_POST["fname"])){echo $_POST["fname"];}?>" type="text" name="fname" placeholder="First Name">
<p>
<input value="<?php if(!empty($_POST["lname"])){echo $_POST["lname"];}?>"  type="text" name="lname" placeholder="Last Name">
<p>
<input type="text" name="email" value="<?php if(!empty($_POST["email"])){echo $_POST["email"];}?>"  placeholder="Email Address">
<p>
<input value="<?php if(!empty($_POST["password"])){echo $_POST["password"];}?>"  type="password" name="password" placeholder="Password">
<p>
<button class="btn" type="submit" name="submit">Register</button>
</form>
