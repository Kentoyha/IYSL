<?php
    include("db_connect.php");
?>
<?php
   include("menu.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>On going Schedules</title>
    <style>
     h1{
            text-align: center;
            color: black;
            margin-top: 30px;
        }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .title {
        text-align: center;
        color: #333;
        margin-top: 20px;
    }

    .addplayer {
        text-align: center;
        margin: 20px 0;
    }

    .addplayer button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
    }

    .addplayer button:hover {
        background-color: #45a049;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .button {
        padding: 10px 15px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        border-radius: 5px;
    }

    .button.green {
        background-color: #4CAF50;
        color: white;
    }

    .button.blue {
        background-color: #1cc6ff;
        color: white;
    }

    .button.red {
        background-color: #f44336;
        color: white;
    }

    .button.green:hover {
        background-color: #45a049;
    }

    .button.blue:hover {
        background-color: #32b6e3;
    }

    .button.red:hover {
        background-color: #e53935;
    }

    select {
        padding: 10px;
        font-size: 16px;
        margin-right: 10px;
    }

    img {
        border-radius: 50%;
    }
    </style>
</head>
<body>
    <h1 class="title">Latest Schedules</h1>
    
    
    <div class="addplayer">
        <a href="Add_player.php">
            <button>Edit Schedules</button>
        </a>
    </div>

    <table>
        <form method="post" action="Player_list.php">
            <tr>
                <th style="text-align: center;">
                    <select name="Player_id" id="Player_id" required>
                        <option value=""> -- SELECT A DATE --</option>
                        
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
           
                        <button type="submit" name="process_edit" class="button blue">Edit</button>
                    <button type="submit" name="process_delete" class="button red">Delete</button>
                </th>
          
        </form>

    <div style="text-align: center;">
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
    </div>

    <table class="grabe">
        <thead>
        <tr>
            <th>Laundry Amount</th>
            <th>Laundry Type</th>
            <th>Cleaning Type</th>
            <th>Place</th>
            <th>Contact info</th>
            <th>Status</th>
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
                echo "<td><a href='Player_profile.php?Player_id=" . $result["Player_id"] . "'><img src='{$result['File_path']}' width='100' height='100' style='border-radius: 50%;'></a></td>";
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
