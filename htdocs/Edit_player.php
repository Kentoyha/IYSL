<?php
include("db_connect.php");

if (isset($_GET['Player_id'])) {
    $Player_id = mysqli_real_escape_string($conn, $_GET['Player_id']);

    $sql = "SELECT * FROM Players WHERE Player_id = '$Player_id'";
    $query = mysqli_query($conn, $sql);
    $player = mysqli_fetch_assoc($query);

    if (!$player) {
        echo "<script>alert('Player not found'); window.location='Player_list.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No player selected'); window.location='Player_list.php';</script>";
    exit();
}

if (isset($_GET['Player_id'])) {
    $Player_id = mysqli_real_escape_string($conn, $_GET['Player_id']);

    $sql = "SELECT * FROM Players WHERE Player_id = '$Player_id'";
    $query = mysqli_query($conn, $sql);
    $player = mysqli_fetch_assoc($query);

    if (!$player) {
        echo "<script>alert('Player not found'); window.location='Player_list.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No player selected'); window.location='Player_list.php';</script>";
    exit();
}

if (isset($_POST['update_player'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $team_id = mysqli_real_escape_string($conn, $_POST['Team']);

    
    $file_path = $player['file_path'];
    $file_name = $player['file_name'];
    $valid_file = true;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = $_FILES['photo'];

       
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($photo['type'], $allowed_types)) {
            echo "<script>alert('Invalid file type. Only .jpg and .png files are allowed.');</script>";
            $valid_file = false;
        } elseif ($photo['size'] > 2 * 1024 * 1024) { 
            echo "<script>alert('File size is too large. Maximum size is 2MB.');</script>";
            $valid_file = false;
        } else {
          
            $new_file_name = uniqid() . '.' . pathinfo($photo['name'], PATHINFO_EXTENSION);
            $upload_dir = 'uploads/';
            $file_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($photo['tmp_name'], $file_path)) {
                $file_name = $new_file_name;

               
                if (!empty($player['file_path']) && file_exists($player['file_path'])) {
                    unlink($player['file_path']);
                }
            } else {
                echo "<script>alert('Error uploading the photo.');</script>";
                $valid_file = false;
            }
        }
    }

  
    if ($valid_file) {
        $sql = "UPDATE Players SET 
                    First_name = '$first_name', 
                    Middle_name = '$middle_name', 
                    Last_name = '$last_name', 
                    Date_of_birth = '$date_of_birth', 
                    Email = '$email', 
                    Contact_number = '$contact_number', 
                    Team_id = '$team_id', 
                    file_path = '$file_path', 
                    file_name = '$file_name' 
                WHERE Player_id = '$Player_id'";

        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo "<script>alert('Player updated successfully'); window.location='Player_list.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Player</title>
    <link rel="stylesheet" href="ediplayer.css">
    <?php include("header.php"); ?>
</head>
<body>
    <?php include("menu.php"); ?>

    <h1>Edit Player</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <table align="center" cellpadding="10">
            <tr>
                <td><label for="first_name">First Name:</label></td>
                <td><input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($player['First_name']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="middle_name">Middle Name:</label></td>
                <td><input type="text" name="middle_name" id="middle_name" value="<?php echo htmlspecialchars($player['Middle_name']); ?>"></td>
            </tr>
            <tr>
                <td><label for="last_name">Last Name:</label></td>
                <td><input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($player['Last_name']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="contact_number">Contact Number:</label></td>
                <td><input type="text" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($player['Contact_number']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="date_of_birth">Date of Birth:</label></td>
                <td><input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo htmlspecialchars($player['Date_of_birth']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" id="email" value="<?php echo htmlspecialchars($player['Email']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="Team">Team:</label></td>
                <td>
                    <select name="Team" required>
                        <?php
                            $team_sql = "SELECT * FROM Team";
                            $team_query = mysqli_query($conn, $team_sql);
                            while ($team = mysqli_fetch_assoc($team_query)) {
                                $selected = $player['Team_id'] == $team['Team_id'] ? 'selected' : '';
                                echo "<option value='{$team['Team_id']}' $selected>{$team['Team_name']}</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label for="photo">Profile Photo:</label></td>
                <td>
                    <?php if (!empty($player['file_path'])): ?>
                        <img src="<?php echo $player['file_path']; ?>" alt="Player Photo" style="max-width: 150px; max-height: 150px;">
                        <p>Current Photo</p>
                    <?php endif; ?>
                    <input type="file" name="photo" id="photo" accept="image/jpeg, image/png">
                    <p>(Only .jpg and .png allowed, max size 2MB)</p>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <div style="text-align: center;">
                        <button type="submit" name="update_player" class="button green">Save Changes</button>
                        <button type="button" onclick="window.location.href='Player_list.php';" class="button red">Cancel</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
