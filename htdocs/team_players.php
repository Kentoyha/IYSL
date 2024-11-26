<?php
include "db_connect.php";
include "menu.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="team_player.css">
    <title>Team Player Lineup</title>
</head>
<body>
    <?php 
    if (isset($_GET['team_id'])) {
        $team_id = mysqli_real_escape_string($conn, $_GET['team_id']);
        $team_query = mysqli_query($conn, "SELECT * FROM Team WHERE Team_id = '$team_id'");
        $team = mysqli_fetch_assoc($team_query);

        if (!$team) {
            echo "<script>alert('Team not found!'); window.location='teams.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No team selected!'); window.location='teams.php';</script>";
        exit();
    }
    ?>

    <h1 align="center"><?php echo htmlspecialchars($team['Team_name']); ?> Player Lineup</h1>
    
    <div align="center">
        <?php if (!empty($team['File_path1']) && file_exists($team['File_path1'])): ?>
            <img src="<?php echo htmlspecialchars($team['File_path1']); ?>" alt="Team Logo" width="100" height="100" style="border-radius: 50%;">
        <?php else: ?>
            <p>No team logo available</p>
        <?php endif; ?>
    </div>
    
    <table class="player-table" border="1" align="center" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT 
                        p.Player_id,
                        p.Last_name, 
                        p.First_name, 
                        p.Middle_name, 
                        p.Date_of_birth, 
                        p.Email, 
                        p.Contact_number, 
                        p.File_path 
                    FROM Players p
                    INNER JOIN Team t ON p.Team_id = t.Team_id
                    WHERE p.Team_id = '$team_id'
                    ORDER BY p.Last_name ASC";

            $query = mysqli_query($conn, $sql);

            if (!$query) {
                echo "<tr><td colspan='5'>Error: " . mysqli_error($conn) . "</td></tr>";
            } elseif (mysqli_num_rows($query) > 0) {
                while ($result = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    
                    // Player Photo
                    if (!empty($result['File_path']) && file_exists($result['File_path'])) {
                        echo "<td><a href='Player_profile.php?Player_id=" . htmlspecialchars($result['Player_id']) . "'>";
                        echo "<img src='" . htmlspecialchars($result['File_path']) . "' alt='Player Photo' width='100' height='100'>";
                        echo "</a></td>";
                    } else {
                        echo "<td><p>No photo available</p></td>";
                    }

                    // Full Name
                    echo "<td>" . htmlspecialchars($result["Last_name"]) . ", " . htmlspecialchars($result["First_name"]) . " " . htmlspecialchars($result["Middle_name"]) . "</td>";
                    
                    // Date of Birth
                    echo "<td>" . date("F d, Y", strtotime($result["Date_of_birth"])) . "</td>";
                    
                    // Email
                    echo "<td>" . htmlspecialchars($result["Email"]) . "</td>";
                    
                    // Contact Number
                    echo "<td>" . htmlspecialchars($result["Contact_number"]) . "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' align='center'>No players found for this team</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
