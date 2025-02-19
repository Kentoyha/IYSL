<?php
include "db_connect.php";
include "menu.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="toyken.css">
    <title>Team Player Lineup</title>
</head>
<style>
   body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

h1 {
    color: #333;
    margin-top: 20px;
}

.player-table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse; /* Ensures borders collapse into one */
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.player-table th, .player-table td {
    padding: 12px; /* Added padding for better spacing */
    text-align: center;
    border: 1px solid #ddd; /* Border for each cell */
}

.player-table th {
    background-color: #f2f2f2;
    color: black;
    font-weight: bold;
}

.player-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.player-table tr:hover {
    background-color: #ddd;
}

.player-table img {
    border-radius: 50%;
}

.player-table p {
    margin: 0;
}

</style>

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
            <img src="<?php echo htmlspecialchars($team['File_path1']); ?>" alt="Team Logo" width="150" height="150" style="border-radius: 50%;">
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
                    
                   
                    if (!empty($result['File_path']) && file_exists($result['File_path'])) {
                        echo "<td><a href='Player_profile.php?Player_id=" . htmlspecialchars($result['Player_id']) . "'>";
                        echo "<img src='" . htmlspecialchars($result['File_path']) . "' alt='Player Photo' width='100' height='100' style='border-radius: 50%;'>";
                        echo "</a></td>";
                    } else {
                        echo "<td><p>No photo available</p></td>";
                    }

                    
                    echo "<td>" . htmlspecialchars($result["Last_name"]) . ", " . htmlspecialchars($result["First_name"]) . " " . htmlspecialchars($result["Middle_name"]) . "</td>";
                    
                  
                    echo "<td>" . date("F d, Y", strtotime($result["Date_of_birth"])) . "</td>";
                    
                  
                    echo "<td>" . htmlspecialchars($result["Email"]) . "</td>";
                    
                   
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
