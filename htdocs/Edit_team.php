

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
    <form method="post" enctype="multipart/form-data">
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

            </tr>
            <tr>
                <td><label for="logo">Team Logo:</label></td>
                <td>
                    <?php if (!empty($Team['file_path'])): ?>
                        <img src="<?php echo $Team['file_path']; ?>" alt="Team Logo" style="max-width: 150px; max-height: 150px;">
                        <p>Current Logo</p>
                    <?php endif; ?>
                    <input type="file" name="logo" id="logo" accept="image/jpeg, image/png">
                    <p>(Only .jpg and .png allowed, max size 2MB)</p>
                </td>
            </tr>
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
            $file_path = ''; 
            $file_name = ''; 
            $valid_file = true;
            
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
                $logo = $_FILES['logo'];
    
                
                $allowed_types = ['image/jpeg', 'image/png'];
                if (!in_array($logo['type'], $allowed_types)) {
                    echo "<script>alert('Invalid file type. Only .jpg and .png files are allowed.');</script>";
                    $valid_file = false;
                } else {
                    
                    if ($logo['size'] > 2 * 1024 * 1024) {
                        echo "<script>alert('File size is too large. Maximum size is 2MB.');</script>";
                        $valid_file = false;
                    } else {
                        
                        $new_file_name = uniqid() . '.' . pathinfo($logo['name'], PATHINFO_EXTENSION);
                        $upload_dir = 'uploads/'; 
                        $file_path = $upload_dir . $new_file_name;
    
                      
                        if (move_uploaded_file($logo['tmp_name'], $file_path)) {
                            $file_name = $new_file_name;
    
                           
                            if (!empty($Team['File_path1']) && file_exists($Team['File_path1'])) {
                                unlink($Team['File_path1']);
                            }
                        } else {
                            echo "<script>alert('Error uploading the photo.');</script>";
                            $valid_file = false;
                        }
                    }
                } if($valid_file) {
                    $sql = "UPDATE Team SET Team_name = '$Team_name', City = '$City', manager_lastname = '$lastname', manager_firstname = '$firstname', manager_middlename = '$middlename', File_path1 = '$file_path', File_name1 = '$file_name', date_upload = NOW() WHERE Team_id = $Team_id";
                        $query = mysqli_query($conn, $sql);
                        if($query) {
                            echo "<script> alert('Team updated successfully'); window.location='Teams.php';</script>";
                        } else {
                            echo "<script> alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); </script>";
                        }
                    }
                        
            }

            
           
        }
    ?>


</body>
