

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editeam.css">
    
    <title>Edit Team</title>
    <hr>
</head>
<?php
include "db_connect.php";
?>
<body>
    <?php
    include("menu.php");
    include("header.php");
    ?>
    <?php 
    if (isset($_GET['action']) && isset($_GET['Team_id'])) {
        $action = trim($_GET['action']);
        $Team_id = trim($_GET['Team_id']);

        if($action == 'edit') {
            $sql = mysqli_query($conn,"SELECT Team_id, Team_name, City, manager_lastname, manager_firstname, manager_middlename FROM Team WHERE Team_id = $Team_id");
            $Team = mysqli_fetch_assoc($sql);
        }
    }
    
?>
    <h1> EDIT TEAM </h1>
    <form method="post">
        <table border=1 align="center" cellspacing="0" cellpadding="10">
            <tr>
                <td> Team Name </td>
                <td> <input type="text" name="Team_name" value="<?php echo $Team['Team_name']; ?>" required> </td>
            </tr>
            <tr>
                <td> City </td>
                <td> <input type="text" name="City" value="<?php echo $Team['City']; ?>" required> </td>
            </tr>
            <tr>
                <td> Manager Last Name </td>
                <td> <input type="text" name="lastname" value="<?php echo $Team['manager_lastname']; ?>" required> </td>
            </tr>
            <tr>
                <td> Manager First Name </td>
                <td> <input type="text" name="firstname" value="<?php echo $Team['manager_firstname']; ?>" required> </td>
            </tr>
            <tr>
                <td> Manager Middle Name </td>
                <td> <input type="text" name="middlename" value="<?php echo $Team['manager_middlename']; ?>" required> </td>

            <tr>
                <input type="hidden" name="Team_id" value="<?php echo $Team_id; ?>">
                <td colspan="2">
                    <div style="text-align: center;">
                        <button type="submit" name="edit_team" class="button green"> Save Changes  </button>
                        <button type="button" onclick="window.location.href='Teams.php';" class="button red">Cancel</button>
                    </div>
                </td>
            </tr>
    </form>
    </table>
    <?php
        if(isset($_POST['edit_team'])) {
            $Team_name = $_POST['Team_name'];
            $City = $_POST['City'];
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $Team_id = $_POST['Team_id'];

            $sql = "SELECT * FROM Team WHERE Team_id = $Team_id";
            $query = mysqli_query($conn, $sql);
            
            if($query) {
                $sql = "UPDATE Team SET Team_name = '$Team_name', City = '$City', manager_lastname = '$lastname', manager_firstname = '$firstname', manager_middlename = '$middlename' WHERE Team_id = $Team_id";
                $query = mysqli_query($conn, $sql);
                if($query) {
                    echo "<script> alert('Team updated successfully'); window.location='Teams.php';</script>";
                } else {
                    echo "<script> alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); </script>";
                }
            }
                
        }
    ?>


</body>
