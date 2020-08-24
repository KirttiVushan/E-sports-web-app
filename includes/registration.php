
<?php

    session_start();

    $error = "";    

    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: ../user/loggedinpage.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        
        $link = mysqli_connect("localhost", "root", "", "sigil");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
        
        
        
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {

                    $error = "That email address is taken.";

                } else {

                    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";

                    } else {

                        $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";

                        mysqli_query($link, $query);

                        $_SESSION['id'] = mysqli_insert_id($link);

                        if ($_POST['stayLoggedIn'] == '1') {

                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24);

                        } 

                        header("Location: ../user/loggedinpage.php");

                    }

                } 
                
            } else {
                    
                    $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: ../user/loggedinpage.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }


?>
<div class="col-6"">
	    <div id="error"><?php echo $error; ?></div>
	</div>

<div id="wrapper">
	<button id="button"><b>Enter The Arena</b></button></div>
	<div id="register">
	     <button id="log">login</button>
	     <button id="sign">signin</button>
    </div>
</div>

<div id="center">
	<form class="forms" id="login"  method="post">
		<label>Email</label>
		<p><input type="text" name="email" placeholder="Your Email"></p>
		<label>Password</label>
		<p><input type="password" name="password" placeholder="Password"></p>
		<input type="hidden" name="signUp" value="0">
		<input type="checkbox" name="stayLoggedIn" value=1>
		<input type="submit" name="submit" value="Log In!">
	</form>


	<form class="forms" id="signin" method="post" >
	
		<label>Email</label>
		<p><input type="text" name="email" placeholder="Your Email"></p>
		<label>Password</label>
		<p><input type="password" name="password" placeholder="Password"></p>
		<label>Confirm password</label>
		<p><input type="password" name="password2" placeholder="password" ></p>
		<input type="hidden" name="signUp" value="1">
		<input type="checkbox" name="stayLoggedIn" value=1>
		<p><input type="submit" name="submit" value="Sign Up!"></p>

	</form>
</div>
