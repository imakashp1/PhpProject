<html>
<head>
<title>Airline Reservation</title>
<style>
.error {
color: red;
}
#ticket
{
border-style: dashed;
border-color: red;
background-color: DodgerBlue;
width: 50%;
text-align: center;
}
</style>
</head>
<body>
<?php
$nameErr = $ageErr = $sourceErr = $destErr = $classErr = $mobileErr = $emailErr = "";
$ok = 0;
if (isset($_POST["submit"])) {
$name = $_POST['name'];
$age = $_POST['age'];
$clas = $_POST['clas'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$ok = 1;
if (empty($_POST["name"])) {
$nameErr = "Name is required!!!";
$ok = 0;
} else {
if (!preg_match("/^[a-zA-Z- ]+$/", $name)) {
$nameErr = "Only letters and white spaces are allowed!!!";
$ok = 0;
}
}
if (empty($_POST["age"])) {
$ageErr = "Age is required!!!";
$ok = 0;
} else {
if (!preg_match("/[0-9]+/", $age)) {
$ageErr = "numerical value is allowed!!!";
$ok = 0;
if (!($age >= 18)) {
$ageErr = "Age must be above 18!!!";
}
}
}
if (empty($_POST["clas"])) {
$classErr = "Select class!!!";
$ok = 0;
}
if (empty($_POST["mobile"])) {
$mobileErr = "Mobile is required!!!";
$ok = 0;
} else {
if (!preg_match("/[0-9]{10}/", $mobile)) {
$mobileErr = "Mobile number should be of 10 digits !!!";
$ok = 0;
}
}
if (empty($_POST["email"])) {
$emailErr = "Email is required!!!";
$ok = 0;
} else {
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$emailErr = "Invalid email format!!!";
$ok = 0;
}
}
}
?>
<h1>Airline Reservation</h1>
<p><span class="error">* required field</span></p>
<form method="post" action="">
<table>
<tr>
<td>
<label>Name</label>
</td>
<td>
<input type="text" name="name" />
<span class="error">*<?php echo $nameErr; ?></span>
</td>
</tr>
<tr>
<td>
<label>Age</label>
</td>
<td>
<input type="text" name="age" />
<span class="error">*<?php echo $ageErr; ?></span>
</td>
</tr>
<tr>
<td>
<label>Mobile No.</label>
</td>
<td>
<input type="text" name="mobile" />
<span class="error">*<?php echo $mobileErr; ?></span>
</td>
</tr>
<tr>
<td>
<label>Email</label>
</td>
<td>
<input type="text" name="email" />
<span class="error">*<?php echo $emailErr; ?></span>
</td>
</tr>
<tr>
<td>
<label>Date</label>
</td>
<td>
<input type="date" name="d" />
</td>
</tr>
</table> <br />
<label>Source</label>
<select name="source">
<option value="0|Bangalore">Bangalore</option>
<option value="1|Kolkata">Kolkata</option>
<option value="2|Mumbai">Mumbai</option>
</select>
<span class="error">*<?php echo $sourceErr; ?></span> <br/><br/>
<label>Destination</label>
<select name="destination">
<option value="0|Istanbul">Istanbul</option>
<option value="1|Chennai">Chennai</option>
<option value="2|Kerala">Kerala</option>
</select>
<span class="error">*<?php echo $destErr; ?></span> <br/><br/>
<label>Type of class</label><br/>
<input type="radio" name="clas" value="3000|Economy"/> Economy <br/>
<input type="radio" name="clas" value="5000|Business"/> Business <br/>
<input type="radio" name="clas" value="7000|First"/> First
<span class="error">*<?php echo $classErr; ?></span> <br/><br/>
<input type="submit" value="Book Ticket" name="submit" />
</form>
</body>
</html>
<?php
if ($ok == 1) {
$c = explode('|',$_POST["clas"]);
$cValue = $c[0];
$cText = $c[1];
$s = explode('|',$_POST['source']);
$sValue = $s[0];
$sText = $s[1];
$d = explode('|',$_POST['destination']);
$dValue = $d[0];
$dText = $d[1];
$rate = array(
array(5000, 6000, 7000),
array(3000, 4000, 5000),
array(2000, 4000, 8000));
$totalFare = $rate[$sValue][$dValue] + $cValue;
$conn = mysqli_connect("localhost", "root", "", "sample2");
if ($conn)
echo "MySQL is connected<br/>";
else
echo "Error!<br/>";
$q1 = "insert into info(Name, Age, Source, Destination, Class, Mobile, Email)
values('$name','$age','$sText','$dText','$cText','$mobile','$email' );";
if ($conn->query($q1)) {
echo "Row Inserted<br/><br/>";
echo "<center><h3>Boarding Pass</h3>";
} else
echo "Insertion error!!!<br/>";
$q2 = "select * from info ORDER BY SeatNo DESC LIMIT 1";
$result = $conn->query($q2);
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
echo "<div id='ticket'>";
echo "Seat Number : " . $row['SeatNo'] .
"<br/>Name : " . $row['Name'] .
"<br/>Source : " . $row['Source'] .
"<br/>Destination : " . $row['Destination'] .
"<br/>Type of Class : " . $row['Class'];
echo "<br/>Date of Journey : " . $_POST['d'];
echo "<br /> Total Fare: " . $totalFare;
echo "</div></center>";
}
}
}
?>

