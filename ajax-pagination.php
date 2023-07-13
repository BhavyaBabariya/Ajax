<?php

$conn = mysqli_connect("localhost","root","","test") or die("Connection Failed");

$limit_per_page = 5;

$page = "";
if(isset($_POST["page_no"])){
    $page = $_POST["page_no"];
}else{
    $page = 1;
}

$offset = ($page - 1) * $limit_per_page;

$sql = "SELECT * FROM students LIMIT {$offset},{$limit_per_page}";
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

    $sql_totle = "SELECT * FROM students";
    $records = mysqli_query($conn,$sql_totle) or die("SQL Query Failed");
    $totle_record = mysqli_num_rows($records);
    $totle_pages = ceil($totle_record/$limit_per_page);
    $output.='<div id="pagination">';
    for($i=1;$i<=$totle_pages;$i++){
        if($i==$page){
            $class_name = "active";
        }else{
            $class_name = "";
        }
        $output.="<a class = '{$class_name}' id = '{$i}' href=''>{$i}</a>";
    }
    $output.= '</div>';
    

    echo $output;
}else{
echo "<h2>Record Not Found</h2>";
}
?>