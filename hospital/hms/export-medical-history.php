<?php
session_start();
include('include/config.php');

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=medical_history.xls");
header("Pragma: no-cache");
header("Expires: 0");

$uid = $_SESSION['id'];

$sql = mysqli_query($con,"
    SELECT tblpatient.*
    FROM tblpatient
    JOIN users ON users.email = tblpatient.PatientEmail
    WHERE users.id='$uid'
");

echo "
<table border='1'>
<tr>
    <th>#</th>
    <th>Patient Name</th>
    <th>Contact Number</th>
    <th>Gender</th>
    <th>Creation Date</th>
    <th>Updation Date</th>
</tr>
";

$count = 1;

while($row = mysqli_fetch_assoc($sql)) {

    echo "
    <tr>
        <td>".$count."</td>
        <td>".$row['PatientName']."</td>
        <td>".$row['PatientContno']."</td>
        <td>".$row['PatientGender']."</td>
        <td>".$row['CreationDate']."</td>
        <td>".$row['UpdationDate']."</td>
    </tr>";

    $count++;
}

echo "</table>";
?>
