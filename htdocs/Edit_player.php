<?php
    include("db_connect.php");
    

    
    if (isset($_GET['Player_id'])) {
        $Player_id = mysqli_real_escape_string($conn, $_GET['Player_id']);
        
        
        $sql = "SELECT * FROM Players WHERE Player_id = $Player_id";
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

        
        $update_sql = "UPDATE Players SET 
            First_name = '$first_name', 
            Middle_name = '$middle_name', 
            Last_name = '$last_name', 
            Date_of_birth = '$date_of_birth', 
            Email = '$email', 
            Contact_number = '$contact_number' 
            WHERE Player_id = $Player_id";

        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Player information updated successfully'); window.location='Player_list.php';</script>";
        } else {
            echo "<script>alert('Error updating player information');</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EDIT PLAYER</title>
    <link rel="stylesheet" href="ediplayer.css">
    <?php include("header.php"); ?>
</head>
<body>
<?php
        include("menu.php");
?>    
    <h1>EDIT PLAYER</h1>

    <form method="post" action="">
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
                <td><label for="upload">Contact Number:</label></td>
                <td><input type="text" name="upload" id="contact_number" value="<?php echo htmlspecialchars($player['Contact_number']); ?>" required></td>
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
                <td><label for="contact_number">Contact Number:</label></td>
                <td><input type="text" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($player['Contact_number']); ?>" required></td>
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
