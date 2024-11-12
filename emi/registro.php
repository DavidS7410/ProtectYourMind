<?php
//registro.php 
include 'conexion.php';
include 'header.php';

echo '<h3>Iniciar</h3>';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it 
note that the action="" will cause the form to post to the same page it is on */

echo '<form method="post" action=""> 
Usuario: <input type="text" name="user_name" /> 
Clave: <input type="password" name="user_pass"> 
Clave +: <input type="password" name="user_pass_check"> 
E-mail: <input type="email" name="user_email">
<input type="submit" class="button" value="Agregar Usuario" /> 
</form>';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps: 
1. Check the data 
2. Let the user refill the wrong fields (if necessary) 
3. Save the data 
*/

    $errors = array(); /* declare the array for later use */

	if(isset($_POST['user_name']))
	{
		//the user name exists 
		if(!ctype_alnum($_POST['user_name']))
		{
			$errors[] = 'El nombre de usuario puede contener solamewnte letras y digitos.';
		}
		if(strlen($_POST['user_name']) > 30)
		{
			$errors[] = 'El nombre de usario no puede tener más de  30 caracteres.';
		}
	}
	else
	{
		$errors[] = 'El nombre de usuario no debe estar vacio.';
	}

	if(isset($_POST['user_pass']))
	{
		if($_POST['user_pass'] != $_POST['user_pass_check'])
		{
			$errors[] = 'Las dos claves no coinciden.';
		}
	}
	else
	{
		$errors[] = 'El campo de clave no puede estar vacio.';
	}

	if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
	{
		echo 'Algunos de los campos no estan llenados correctamente..';
		echo '<ul>';

		foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
		{
			echo '<li>' . $value . '</li>'; /* this generates a nice error list */
		}
		echo '</ul>';
	}
	else
	{
		//the form has been posted without, so save it 
		//notice the use of mysql_real_escape_string, keep everything safe! 
		//also notice the sha1 function which hashes the password 
		// Prepare the SQL statement with placeholders 
        $sql = "INSERT INTO users(user_name, user_pass, user_email, user_date, user_level) 
VALUES (?, ?, ?, NOW(), 0)";

        // Create a prepared statement 
        $stmt = mysqli_prepare($conn, $sql);
		
        // Bind parameters to the prepared statement 
        mysqli_stmt_bind_param($stmt, 'sss', $_POST['user_name'], sha1($_POST['user_pass']), $_POST['user_email']);
        
        // Execute the prepared statement 
        $result = mysqli_stmt_execute($stmt);
       
        if(!$result)
		{
			//something went wrong, display the error 
			echo 'Algo salio mal. Por favor  trate de nuevo mas atrde.';
			//echo mysql_error(); //debugging purposes, uncomment when needed 
		}
		else
		{
			echo 'ususario correctamente registrado, ahora puede ingresar <a href="ingreso.php">sign in</a> y comenzar a postear! :-)';
		}
	}
}

include 'footer.php';
?>