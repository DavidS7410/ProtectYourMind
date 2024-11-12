<?php
//ingreso.php 
include 'conexion.php';
include 'header.php';
//echo '<h3>Ingreso</h3>';

//first, check if the user is already signed in. If that is the case, there is no need to display this page 
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'Ya ha ingresado anteriormente, puede <a href="salir.php">salir</a> si lo desea.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		/*the form hasn't been posted yet, display it 
note that the action="" will cause the form to post to the same page it is on */

echo '<form method="post" action=""> 
Username: <input type="text" name="user_name" /> 
Password: <input type="password" name="user_pass"> 
<input type="submit" value="Ingresar" /> 
</form>';
	}
	else
	{
		/* so, the form has been posted, we'll process the data in three steps: 
1. Check the data 
2. Let the user refill the wrong fields (if necessary) 
3. Varify if the data is correct and return the correct response 
*/
		$errors = array(); /* declare the array for later use */

		if(!isset($_POST['user_name']))
		{
			$errors[] = 'El usuario no puede estar vacio.';
		}

		if(!isset($_POST['user_pass']))
		{
			$errors[] = 'La clave no puede estar vacio.';
		}
		
        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
		{
			echo 'Algunos campos pueden estar incorrectos..';
			echo '<ul>';
			foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
			{
				echo '<li>' . $value . '</li>'; /* this generates a nice error list */
			}
			echo '</ul>';
		}
		else
		{
			//the form has been posted without errors, so save it 
			//notice the use of mysql_real_escape_string, keep everything safe! 
			//also notice the sha1 function which hashes the password 
			$sql = "SELECT user_id, user_name, user_level FROM users WHERE user_name = ? AND user_pass = ?";

            $stmt = mysqli_prepare($conn, $sql);
            $user2 = sha1($_POST['user_pass']);
            mysqli_stmt_bind_param($stmt, 'ss', $_POST['user_name'], $user2);

            $result = mysqli_stmt_execute($stmt);

            if(!$result)
			{
				//something went wrong, display the error 
				echo 'Algo salio mal en el ingreso. Por favor trate mas tarde.';
				//echo mysql_error(); //debugging purposes, uncomment when needed 
			}
			else
			{
				//the query was successfully executed, there are 2 possibilities 
				//1. the query returned data, the user can be signed in 
				//2. the query returned an empty result set, the credentials were wrong 
                $result = mysqli_stmt_get_result($stmt);
				if (mysqli_num_rows($result) == 0) 
				{
					echo 'Ha suministrado una combinacion usuario/clave no valida. Por favor trate de nuevo.';
				}
				else
				{
					//set the $_SESSION['signed_in'] variable to TRUE 
					$_SESSION['signed_in'] = true;

					//we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages 
					while ($row = mysqli_fetch_assoc($result)) 
					{
						$_SESSION['user_id'] 	= $row['user_id'];
						$_SESSION['user_name'] 	= $row['user_name'];
						$_SESSION['user_level'] = $row['user_level'];
					}

					//echo 'Bienvenido, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceeda al foro general</a>.';
				}
			}
		}
	}
}

include 'footer.php';
?>