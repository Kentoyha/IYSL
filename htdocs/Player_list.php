<?php
    include("db_connect.php");
    
   
?>

<DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Player List</title>
    <link rel="stylesheet" href="playerlist.css">
    <?php include("header.php"); ?>
</head>
<body>
    <?php
    include("menu.php");
    ?>
    <h1 class="title">PLAYERS</h1>
    <hr>
    
    <table border="1" align="center" cellspacing="0" cellpadding="5">
        <form method="post" action="Player_list.php">
            <tr>
                <th style="text-align: center; ">
                    <select name="Player_id" id="Player_id" required>
                        <option value=""> -- SELECT A PLAYER --</option>
                        
                        <?php
                            $sql = "SELECT * FROM Players ORDER BY Last_name ASC";
                            $query = mysqli_query($conn, $sql);
                            if (!$query) {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            } else {
                                while ($result = mysqli_fetch_assoc($query)) {
                                    echo "<option value='{$result['Player_id']}'>{$result['Last_name']}, {$result['First_name']}</option>";
                                }
                            }
                        ?>
                    </select>
                    <button type="submit" name="process_edit" class="button green">Edit</button>
                    <button type="submit" name="process_delete" class="button red">Delete</button>
                </th>
            </tr>
        </form>
           
    <?php
       
        if (isset($_POST['process_delete'])) {
            
            if (!empty($_POST['Player_id'])) {
                $Player_id = mysqli_real_escape_string($conn, $_POST['Player_id']);
                $sql = "DELETE FROM Players WHERE Player_id = $Player_id";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Player has been removed'); window.location='Player_list.php';</script>";
                } else {
                    echo "<script>alert('Error deleting player');</script>";
                }
            } else {
                echo "<script>alert('Please select a player to delete.');</script>";
            }
        }

       
        if (isset($_POST['process_edit']) && !empty($_POST['Player_id'])) {
            $Player_id = mysqli_real_escape_string($conn, $_POST['Player_id']);
            echo "<script>window.location='Edit_player.php?Player_id=$Player_id';</script>";
        }
    ?>
    <div class="crazy">
    <div class="buanga">
    <a href="Add_player.php"><button>Add player</button></a>
    </div>
    </div>
    <table class="player-table" border="1" align="center" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Player Image</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $sql = "SELECT * FROM Players ORDER BY Last_name ASC";
        $query = mysqli_query($conn, $sql);
        if (!$query) {
            echo "<tr><td colspan='4'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</td></tr>";
        } else {
            while ($result = mysqli_fetch_assoc($query)) {
                $player_id = $result['id']; 
                echo "<tr>";
                echo "<td><a href='toyken.php?Player_id=" . $result["Player_id"] . "'><img src='{$result['File_path']}' width='100' height='100' style='border-radius: 50%;'></a></td>";
                echo "<td>" . $result["Last_name"] . ", " . $result["First_name"] . " " . $result["Middle_name"] . "</td>";
                echo "<td>" . date("F d, Y", strtotime($result['Date_of_birth'])) . "</td>";
                echo "<td>{$result['Email']}</td>";
                echo "<td>{$result['Contact_number']}</td>";
                echo "</tr>";
            }
        }
    ?>
        </tbody>
    </table>
</body>
</html>

