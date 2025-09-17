<?php
// show error
ini_set('display_errors', 1);
include("config.php");






//CREATE USER
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
    



    // Delete User
    if(isset($_GET["delid"])){

        // user id
        $userid = $_GET["delid"];

        $stmt = $pdo->prepare("DELETE FROM users WHERE userid = :userid");
        $stmt->bindParam(":userid", $userid, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt){
        $delete = "<font color='red'>USER WAS DELETED</font>";
        }
    }

?>

<link rel="stylesheet" href="style.css">
<!-- <meta name="viewport" content="width=device-width, initial-content=1"> -->































<!-- USERS LIST -->
<h2>REGISTERED USERS</h2>

<?php 
if(isset($delete)){
    echo "<h2>" .$delete."</h2>";
}
?>

<?php
//Select all users in DB  - (R)
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
$count = 1;

echo "<table border cellpadding='20' class='tab'>";
echo "

<tr>
<th>S/N</th>
<th>Firstname</th>
<th>Surname</th>
<th>Email</th>
<th>Password</th>
<th>Action</th>
</tr>";

foreach($users as $user){
?>

<tr>
<td><?php echo $count;?></td>
<td><?php echo $user["fname"];?></td>
<td><?php echo $user["lname"];?></td>
<td><?php echo $user["email"];?></td>
<td><?php echo $user["password"];?></td>
<td>
    <div style="display:flex">
    <a href="update.php?userid=<?php echo $user["userid"];?>" class="update">Update User</a>
    <a href="dashboard.php?delid=<?php echo $user["userid"];?>" class="delete">Delete User</a>
    </div>
</tr>


<?php $count++; }?>
</table>










<!-- FORM -->

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