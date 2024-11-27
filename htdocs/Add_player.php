<?php
include("db_connect.php");
include("menu.php");
include("header.php");
?>
<html>
<head>
    <link rel="stylesheet" href="addp.css">
</head>
<h1> Register a Player </h1>
<form method="post" enctype="multipart/form-data">

    <table border=1 align="center" cellspacing="0" cellpadding="10">
    <tr>
            <td>Last Name </td>
            <td> <input type="text" name="Lname" required> </td>
        </tr>
        <tr>
            <td>First Name </td>
            <td> <input type="text" name="Fname" required> </td>
        </tr>
        <tr>
            <td>Middle Name </td>
            <td> <input type="text" name="Mname" > </td>
        </tr>
        <tr>
            <td>Profile Photo (Max 2MB)</td>
            <td><input type="file" name="profile_photo" accept=".jpg, .png" required></td>
        </tr>
        <tr>
            <td> Date of Birth </td>
            <td> <input type="date" name="Birthday" required> </td>
        </tr>
        <tr>
            <td> Email </td>
            <td> <input type="text" name="email" required> </td>
        </tr>
        <tr>
            <td> Contact Number </td>
            <td> <input type="number" name="Contact" required> </td>
        </tr>
       
        <tr>
            <td>Team </td>
            <td>
                <select name="Team" required>
                    <?php
                    $sql = "SELECT * FROM Team";
                    $query = mysqli_query($conn, $sql);
                    if (!$query) {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    } else {
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<option value='{$result['Team_id']}'>{$result['Team_name']}</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <button type="submit" name="Insert1"> Submit</button>
            </td>
        </tr>
    </table>
    
</form>
</html>

<?php
if (isset($_POST['Insert1'])) {
    $Birthday = $_POST['Birthday'];
    $Email = $_POST['email'];
    $Contact_number = $_POST['Contact'];
    $Last_name = $_POST['Lname'];
    $First_name = $_POST['Fname'];
    $Middle_name = $_POST['Mname'];
    $Team_id = $_POST['Team'];

    
    $profile_photo = $_FILES['profile_photo'];
    $photo_name = $profile_photo['name'];
    $photo_tmp = $profile_photo['tmp_name'];
    $photo_error = $profile_photo['error'];
    $photo_size = $profile_photo['size'];

    $allowed_ext = ['jpg', 'png'];
    $file_ext = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));

    
    if ($photo_error === 0) {
        if (in_array($file_ext, $allowed_ext) && $photo_size <= 2 * 1024 * 1024) {
            $photo_new_name = uniqid('', true) . "." . $file_ext;
            $upload_path = "uploads/" . $photo_new_name;

          
            if (move_uploaded_file($photo_tmp, $upload_path)) {
                $upload_date = date("Y-m-d H:i:s");
                $sql = "INSERT INTO Players (Date_of_birth, Email, Contact_number, Last_name, First_name, Middle_name, Team_id, file_path, file_name, upload_date)
                        VALUES ('$Birthday', '$Email', '$Contact_number', '$Last_name', '$First_name', '$Middle_name', '$Team_id', '$upload_path', '$photo_new_name', '$upload_date')";
                $query = mysqli_query($conn, $sql);

                if ($query) {
                    echo "<script> alert('Player is successfully registered'); window.location='Player_list.php';</script>";
                } else {
                    echo "<script> alert('Database Error: " . $sql . "<br>" . mysqli_error($conn) . "'); </script>";
                }
            } else {
                echo "<script> alert('Error uploading the profile photo'); </script>";
            }
        } else {
            if (!in_array($file_ext, $allowed_ext)) {
                echo "<script> alert('Invalid file type. Only JPG and PNG files are allowed.'); </script>";
            } elseif ($photo_size > 2 * 1024 * 1024) {
                echo "<script> alert('File size exceeds 2MB limit.'); </script>";
            }
        }
    } else {
        echo "<script> alert('Error: Invalid photo file'); </script>";
    }
}
?>
