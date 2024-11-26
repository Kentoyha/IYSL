<?php
include 'db_connect.php';
include 'menu.php';
?>
<!DOCTYPE html>
<html>
<body>
 <style>
   
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

    .button.red {
        background-color: #f44336;
        color: white;
    }

    .button.green:hover {
        background-color: #45a049;
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
        <h1 align="center">International Youth Soccer League</h1>
        <h2 align="center">Latest Games </h2>
        <div class="container">
        <div class="buanga">
        <div class="addplayer">
            <a href="Add_game.php"><button>Add New Game</button></a>
        </div>
        </div>
        </div>
        
        <?php
        
        ?>
        <table align="center" cellspacing="0" cellpadding="10">
        <tr>
           <th>Game ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Home team </th>
            <th>Away team </th>
            <th>Home score</th>
            <th>Away score</th>
            <th>Winner</th>

        </tr>
        <?php
        
?>
        <?php
       
    $sql = "SELECT 
                Game.Game_id, 
                Game.Date, 
                Game.Time, 
                Game.Location, 
                Game.Home_team_id, 
                Game.Away_team_id, 
                HomeTeam.Team_name as Home_team, 
                AwayTeam.Team_name as Away_team, 
                Game.home_score, 
                Game.away_score 
            FROM Game 
            INNER JOIN Team as HomeTeam ON Game.Home_team_id = HomeTeam.Team_id 
            INNER JOIN Team as AwayTeam ON Game.Away_team_id = AwayTeam.Team_id"
            ;
    $query = mysqli_query($conn, $sql);
    if (!$query){
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } else {
        
    }

    while($result = mysqli_fetch_assoc($query)) {
        echo "<tr>";
        echo "<td>" . $result["Game_id"] . "</td>";
        echo "<td>" . $result["Date"] . "</td>";
        echo "<td>" . $result["Time"] . "</td>";
        echo "<td>" . $result["Location"] . "</td>";
        echo "<td><a href='team_players.php?team_id=" . $result["Home_team_id"] . "' style='text-decoration: none;'>" . $result["Home_team"] . "</a></td>";
        echo "<td><a href='team_players.php?team_id=" . $result["Away_team_id"] . "' style='text-decoration: none;'>" . $result["Away_team"] . "</a></td>";
        echo "<td>" . $result["home_score"] . "</td>";
        echo "<td>" . $result["away_score"] . "</td>";
        
        if ($result["home_score"] > $result["away_score"]) {
            echo "<td>" . $result["Home_team"] . "</td>";
        } elseif ($result["home_score"] < $result["away_score"]) {
            echo "<td>" . $result["Away_team"] . "</td>";
        } else {
            echo "<td>Draw</td>";
        }
        
    }
    
    ?>
    </table>
 <style>
        .actdelete {
            color: white;
            background-color: red;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .actdelete:hover {
            background-color: darkred;
        }
   </style>
    
    <?php
    ?> 
    <?php
    if (isset($_GET['action']) && isset($_GET['Game_id'])) {
        $action = trim($_GET['action']);
        $Game_id = trim($_GET['Game_id']);

        if ($action == 'delete') {
            $sql = "DELETE FROM Game WHERE Game_id = $Game_id";
            if (mysqli_query($conn, $sql)) {
                echo "<script> alert('Game has been removed'); window.location='Games.php'; </script>";
            }
        }
    }
    ?>
    </body>
</html>
