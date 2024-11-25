<?php
include("db_connect.php");   

if (isset($_GET['Player_id'])) {
    $Player_id = $_GET['Player_id'];

    // Fetch player details along with team name
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
                $file_path = !empty($player['file_path']) ? 'uploads/' . $player['file_path'] : 'default.jpg';
                if (file_exists($file_path)): ?>
                    <img src="<?php echo htmlspecialchars($file_path); ?>" alt="Player Photo" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                <?php else: ?>
                    <img src="default.jpg" alt="Default Player Photo" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                   
                <?php endif; ?>
            </div>

            <div class="profile-details" style="text-align: center; margin-top: 20px;">
                <h2 style="font-size: 24px; color: #333;"><?php echo htmlspecialchars($player['First_name'] . " " . $player['Last_name']); ?></h2>
                <p style="font-size: 18px; color: #666;"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($player['Date_of_birth']); ?></p>
                <p style="font-size: 18px; color: #666;"><strong>Email:</strong> <?php echo htmlspecialchars($player['Email']); ?></p>
                <p style="font-size: 18px; color: #666;"><strong>Contact Number:</strong> <?php echo htmlspecialchars($player['Contact_number']); ?></p>
                <p style="font-size: 18px; color: #666;"><strong>Team:</strong> <?php echo htmlspecialchars($player['Team_name']); ?></p>
            </div>
        </div>
        <a href="Player_list.php" class="back-btn" style="text-align: center; display: block; margin-top: 20px; font-size: 18px; color: #007BFF; text-decoration: none;">Back to Player List</a>
    </div>
</body>
</html>
