<?php
// create_cat.php 
include 'conexion.php';
include 'header.php';
$sql = "SELECT 
cat_id, 
cat_name, 
cat_description 
FROM 
categories";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo 'Las categorias, nopuedenser listadas. Por favor intente mas tarde.';
} else {
    if (mysqli_num_rows($result) == 0) {
        echo 'No hay categorias definidas aún.';
    } else {
        // Prepare the table 
        echo '<table border="1"> 
<tr> 
<th>Category</th> 
<th>Last topic</th> 
</tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td class="leftpart">';
            echo '<h3><a href="category.php?id">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
            echo '</td>';
            echo '<td class="rightpart">';
            echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
            echo '</td>';
            echo '</tr>';
        }
    }
}
include 'footer.php';
?>