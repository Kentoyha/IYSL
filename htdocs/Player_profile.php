<?php
include("db_connect.php"); // Include database connection
include("menu.php");       // Include navigation menu
include("header.php");     // Include header for styling or branding

if (isset($_GET['Player_id'])) {
    $Player_id = $_GET['Player_id'];

    // Fetch player details from the database
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
    <link rel="stylesheet" href="profile.css"> <!-- Link to CSS for styling -->
</head>
<body>
    <div class="profile-container">
        <h1>Player Profile</h1>
        <div class="profile-card">
            <!-- Player Photo -->
            <div class="profile-photo">
                <?php if (!empty($player['file_path'])): ?>
                    <img src="<?php echo $player['file_path']; ?>" alt="Player Photo">
                <?php else: ?>
                    <img src="default_photo.png" alt="Default Photo">
                <?php endif; ?>
            </div>

            <!-- Player Details -->
            <div class="profile-details">
                <h2><?php echo htmlspecialchars($player['First_name'] . " " . $player['Last_name']); ?></h2>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($player['Date_of_birth']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($player['Email']); ?></p>
                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($player['Contact_number']); ?></p>
                <p><strong>Team:</strong> <?php echo htmlspecialchars($player['Team_name']); ?></p>
                <p><strong>Uploaded On:</strong> <?php echo htmlspecialchars($player['upload_date']); ?></p>
            </div>
        </div>
        <a href="Player_list.php" class="back-btn">Back to Player List</a>
    </div>
</body>
</html>
