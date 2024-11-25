<?php
include("db_connect.php");


?>
 <link rel="stylesheet" href="games.css">

<body>  
    <?php
    include("menu.php");
    include("header.php");
    ?>
    
        <h1>International Youth Soccer League</h1>
        <h2 align="center">Latest Games </h2>
        <div class="container">
        <div class="buanga">
        <a href="Add_game.php" class="buanga"><button >Add New Game</button></a>
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
