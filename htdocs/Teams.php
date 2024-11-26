<?php
include("db_connect.php");
include("menu.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    <style>
        /* Basic Styling for the Page */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: black;        }

        /* Container for Add Team Button */
        .add-team-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        /* Add Team Button Styling */
        .add-team-btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-team-btn:hover {
            background-color: #45a049;
        }

        /* Table Styling */
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Action Buttons */
        .actbutton, .actdelete {
            background-color: #4CAF50;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .actbutton:hover, .actdelete:hover {
            background-color: #45a049;
        }

        .actdelete {
            background-color: #dc3545;
        }

        .actdelete:hover {
            background-color: #c82333;
        }

        /* Image Styling */
        img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        

    </style>
</head>
<body>
    <h1>Teams</h1>

    <div class="add-team-container">
        <a href="insert_team.php">
            <button class="add-team-btn">Add Team</button align="center">
        </a>
    </div>

    <table>
        <tr>
            <th>Team Logo</th>
            <th>Team Name</th>
            <th>City</th>
            <th>Manager's Full Name</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT * FROM Team ORDER BY Team_Name ASC";
        $query = mysqli_query($conn, $sql);
        if (!$query) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        } else {
            while ($result = mysqli_fetch_assoc($query)) {
                echo "<tr>";
                echo "<td><a href='team_players.php?team_id=" . $result["Team_id"] . "' style='text-decoration: none;'><img src='{$result['File_path1']}' alt='Team Logo'></a></td>";
                echo "<td>" . $result["Team_name"] . "</td>";
                echo "<td>" . $result["City"] . "</td>";
                echo "<td>" . $result["Manager_Lastname"] . ", " . $result["Manager_Firstname"] . " " . $result["Manager_Middlename"] . "</td>";
                echo "<td>";
                echo "<a class='actbutton' href='Edit_team.php?action=edit&Team_id={$result['Team_id']}'>Edit</a>";
                echo "<a class='actdelete' href='Teams.php?action=delete&Team_id={$result['Team_id']}'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        }

        if (isset($_GET['action']) && isset($_GET['Team_id'])) {
            $action = trim($_GET['action']);
            $Team_id = trim($_GET['Team_id']);

            if ($action == 'delete') {
                $sql = "DELETE FROM Team WHERE Team_id = $Team_id";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Team has been removed'); window.location='Teams.php';</script>";
                }
            }
        }
        ?>
    </table>
</body>
</html>
