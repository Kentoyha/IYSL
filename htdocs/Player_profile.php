<?php
include("db_connect.php"); 
include("menu.php");       
include("header.php");    

if (isset($_GET['Player_id'])) {
    $Player_id = $_GET['Player_id'];

    
    $sql = "SELECT p.*, t.Team_name 
            FROM Players p
            LEFT JOIN Team t ON p.Team_id = t.Team_id
            WHERE p.Player_id = '$Player_id'";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $player = mysqli_fetch_assoc($query);
    } else {
        echo "<script>alert('Player not found'); window.location='Player_list.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No player ID provided'); window.location='Player_list.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Player Profile</title>
    <link rel="stylesheet" href="profile.css"> 
</head>
<body>
    <div class="profile-container" style="display: flex; justify-content: center; align-items: center; flex-direction: column; height: 80vh;">
        <h1>Player Profile</h1>
        <div class="profile-card" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            
            <div class="profile-photo">
                <?php 
                echo "<img src='" . htmlspecialchars($player['File_path']) . "' width='100' height='100' style='border-radius: 50%;'>";
                 ?>
            </div>

            <div class="profile-details" style="text-align: center;">
                <h2><?php echo htmlspecialchars($player['First_name'] . " " . $player['Last_name']); ?></h2>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($player['Date_of_birth']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($player['Email']); ?></p>
                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($player['Contact_number']); ?></p>
                <p><strong>Team:</strong> <?php echo htmlspecialchars($player['Team_name']); ?></p>
            </div>
        </div>
        <a href="Player_list.php" class="back-btn" style="text-align: center;">Back to Player List</a>
    </div>
</body>
</html>
