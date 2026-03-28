<?php
session_start();
include('include/config.php');

header("Content-Type: application/xls"); 
header("Content-Disposition: attachment; filename=appointment_history.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

// Fetch user appointments
$sql = mysqli_query($con,"SELECT doctors.doctorName as docname,appointment.*  
FROM appointment 
JOIN doctors ON doctors.id = appointment.doctorId 
WHERE appointment.userId='".$_SESSION['id']."'");

echo "
<table border='1'>
<tr>
    <th>#</th>
    <th>Doctor Name</th>
    <th>Specialization</th>
    <th>Consultancy Fee</th>
    <th>Appointment Date</th>
    <th>Appointment Time</th>
    <th>Creation Date</th>
    <th>Status</th>
</tr>";

$count = 1;

while($row = mysqli_fetch_assoc($sql)) {
    
    if($row['userStatus']==1 && $row['doctorStatus']==1){
        $status = "Active";
    } elseif($row['userStatus']==0 && $row['doctorStatus']==1){
        $status = "Canceled by You";
    } elseif($row['userStatus']==1 && $row['doctorStatus']==0){
        $status = "Canceled by Doctor";
    }

    echo "
    <tr>
        <td>".$count."</td>
        <td>".$row['docname']."</td>
        <td>".$row['doctorSpecialization']."</td>
        <td>".$row['consultancyFees']."</td>
        <td>".$row['appointmentDate']."</td>
        <td>".$row['appointmentTime']."</td>
        <td>".$row['postingDate']."</td>
        <td>".$status."</td>
    </tr>";
    
    $count++;
}

echo "</table>";
