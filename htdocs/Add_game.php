<?php
include "db_connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="addg.css">
</head>
<?php 
include 'menu.php'; 
include 'header.php';
?>
<body>
<h1> ADD NEW GAME RECORD </h1>
    <form method="post">
        <table border=1 align="center" cellspacing="0" cellpadding="10">
            <tr>
                <td> Date </td>
                <td> <input type="date" name="Date" required> </td>
            </tr>
            <tr>
                <td> Time </td>
                <td> <input type="time" name="Time" required> </td>
            </tr>
            <tr>
                <td> Location </td>
                <td> <input type="text" name="Location" required> </td>
            </tr>
            <tr>
                <td>Home score </td>
                <td> <input type="text" name="Hscore" required> </td>
            </tr>
            <tr>
                <td>Away Score </td>
                <td> <input type="text" name="Ascore" required> </td>
            </tr>
            <tr>
                <td>Home Team</td>
                <td>
                    <select name="Home_team" required>
                        <?php
                        $sql = "SELECT * FROM Team";
                        $query = mysqli_query($conn, $sql);
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<option value='{$result['Team_id']}'>{$result['Team_name']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Away Team</td>
                <td>
                    <select name="Away_team" required>
                        <?php
                        $sql = "SELECT * FROM Team";
                        $query = mysqli_query($conn, $sql);
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<option value='{$result['Team_id']}'>{$result['Team_name']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="New_game"> Submit</button>
                </td>
            </tr>
        </table>
    </form>
    <?php
    if (isset($_POST['New_game'])) {
        $Date = $_POST['Date'];
        $Time = $_POST['Time'];
        $Location = $_POST['Location'];
        $Home_score = $_POST['Hscore'];
        $Away_score = $_POST['Ascore'];
        $Home_team = $_POST['Home_team'];
        $Away_team = $_POST['Away_team'];

        if ($Home_team == $Away_team) {
            echo "<script> alert('A team cannot play against itself.'); </script>";
            exit;
        }

      
        $homeToAwayQuery = "
            SELECT COUNT(*) as count FROM Game 
            WHERE (Home_team_id = '$Home_team' AND Away_team_id = '$Away_team')
        ";
        $awayToHomeQuery = "
            SELECT COUNT(*) as count FROM Game 
            WHERE (Home_team_id = '$Away_team' AND Away_team_id = '$Home_team')
        ";

        $homeToAwayResult = mysqli_query($conn, $homeToAwayQuery);
        $awayToHomeResult = mysqli_query($conn, $awayToHomeQuery);

        $homeToAwayCount = mysqli_fetch_assoc($homeToAwayResult)['count'];
        $awayToHomeCount = mysqli_fetch_assoc($awayToHomeResult)['count'];

        
        if ($homeToAwayCount >= 1 && $awayToHomeCount >= 1) {
            echo "<script> alert('These teams have already played their home and away games against each other.'); </script>";
        } else {
           
            $sql = "INSERT INTO Game (Date, Time, Location, Home_team_id, Away_team_id, home_score, away_score)
                    VALUES ('$Date', '$Time', '$Location', '$Home_team', '$Away_team', '$Home_score', '$Away_score')";
            $query = mysqli_query($conn, $sql);

            if ($query) {
                echo "<script> alert('New game has been recorded'); window.location='Games.php'; </script>";
            } else {
                echo "<script> alert('Error: " . mysqli_error($conn) . "'); </script>";
            }
        }
    }
    ?>
</body>
</html>
