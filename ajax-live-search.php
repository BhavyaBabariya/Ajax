<?php
    $search_value = $_POST['search'];

    $conn = mysqli_connect("localhost","root","","test") or die("Connection Failed");

    $sql = "SELECT * FROM students WHERE `first_name` LIKE '%{$search_value}%' OR `last_name` LIKE '%{$search_value}%'";

    $result = mysqli_query($conn,$sql) or die("SQL Query Failed");
    $output = "";
    if(mysqli_num_rows($result) > 0){
        $output = '<table border = "1" width = "100%" cellspacing="0" cellpadding = "10px">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Last Name</th>
                <th width="100px">Edit</th>
                <th width="100px">Delete</th>
            </tr>';
            while($row = mysqli_fetch_assoc($result)){
                $output .= "<tr>
                    <td>{$row["id"]}</td>
                    <td>{$row["first_name"]}</td>
                    <td>{$row["last_name"]}</td>
                    <td><button class = 'edit-btn' data-eid='{$row["id"]}' >Edit</button></td>
                    <td><button class = 'delete-btn' data-id='{$row["id"]}' >Delete</button></td>
                </tr>";
            } 
            $output.= '</table>';

            echo $output;
    }else{
        echo "<h2>Record Not Found</h2>";
    }
?>