<?php
    include("db_connect.php");
    
?>
<!DOCTYPE html>
<?php
include("menu.php");
include("header.php");
?>
<!DOCTYPE html>
<html>
    <head><link rel="stylesheet" href="teams.css"></head>
    

    <body>
        
    <table border="1" align="center" cellspacing="0" cellpadding="10">
        <h1>TEAMS</h1>
<div class="buanga" >
    <a href="insert_team.php"><button>Add team</button></a>
</div>
        
        <tr>
            <th> Team Logo </th>
            <th> Team Name </th>
            <th> City </th>
            <th> Manager's Full name</th>
            <th> Action </th>

           
            
        </tr>
        
        <?php
        
         $sql = "SELECT * FROM Team ORDER BY Team_Name ASC";
         $query = mysqli_query($conn, $sql);
         if(!$query) {
             echo "Error: " . $sql . "<br>" . mysqli_error($conn);
         } else {
             while($result = mysqli_fetch_assoc($query)) {
                 echo "<tr>";
                 echo "<td><a href='team_players.php?team_id=" . $result["Team_id"] . "' style='text-decoration: none;'><img src='{$result['File_path1']}' width='100' height='100' style='border-radius: 50%;'></a></td>";
                 echo "<td>" . $result["Team_name"] . "</td>";
                 echo "<td>" . $result["City"] . "</td>";
                 echo "<td>" . $result["Manager_Lastname"] . ", " . $result["Manager_Firstname"] . " " . $result["Manager_Middlename"] . "</td>";
                    echo "<td>";
                    echo "<a class='actbutton' href='Edit_team.php?action=edit&Team_id={$result['Team_id']}'>Edit</a> ";
                    echo "<a class='actdelete' href='Teams.php?action=delete&Team_id={$result['Team_id']}'>Delete</a>";
                    echo"</td>";
                    
                echo "</tr>";
             }
         }

         

     ?>
      <?php
    if (isset($_GET['action']) && isset($_GET['Team_id'])) {
        $action = trim($_GET['action']);
        $Team_id = trim($_GET['Team_id']);

        if ($action == 'delete') {
            $sql = "DELETE FROM Team WHERE Team_id = $Team_id";
            if (mysqli_query($conn, $sql)) {
                echo "<script> alert('Team has been removed'); window.location='Teams.php'; </script>";
            }
        }
    }
    ?>


     </table>
         </body>
</html>