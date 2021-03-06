
<?php  

// initialize  the  session

session_start();

// check if the user is already logged in, if yes then redirect them to welcome page

if (isset($_SESSION["loggedin"])  && $_SESSION["loggedin"] === true)              {
    header("location: index.php");
    exit;
}

// include config file

require_once 'config.php';

// Define variables and initialze with empty values

$username=$password = "";
$username_err= $password_err= "";


// Processing  form data when form is  submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if username is empty

    if (empty(trim($_POST["username"]))) {
        
        $username_err= "Please enter username";
    } else {
        $username= trim($_POST["username"]);
    }
    


    // check if password is empty

    if (empty(trim($_POST["password"]))) {
        
        $password_err= "Please enter your password";
    } else {
        $password= trim($_POST["password"]);
    }
    

        // Validate credentials

    if (empty($username_err)  && empty($password_err)) {
        
        // prepare a select statement

         $sql = "SELECT id, username, password FROM users WHERE username = ?";
if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <title>Sign Up</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif;   background-image: url("https://images.pexels.com/photos/1174732/pexels-photo-1174732.jpeg?auto=compress&cs=tinysrgb&h=350");
        background-repeat: no-repeat;
        background-size: cover; 
        background-position: center;}
        .wrapper{ width: 350px; padding: 20px;
            margin-top: 70px;


         }
    </style>
</head>
<body>
    <div class="wrapper container text-center">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>
