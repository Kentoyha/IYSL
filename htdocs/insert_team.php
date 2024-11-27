<?php
include("db_connect.php");
include("menu.php");
?>

<head>
<link rel="stylesheet" href="addt.css">  
</head>

<body>
<h1>Register a Team</h1>

    <form method="post" enctype="multipart/form-data">
        <table border=1 align="center" cellspacing="0" cellpadding="10">
            <tr>
                <td> Team Name </td>
                <td> <input type="text" name="team_name" required> </td>
            </tr>
            <tr>
                <td> City </td>
                <td> <input type="text" name="city" required > </td>
            </tr>
            <tr>
                <td> Manager's Last Name </td>
                <td> <input type="text" name="Manager_lastname" required > </td>
            </tr>
            <tr>
                <td> Manager's First name </td>
                <td> <input type="text" name="Manager_firstname" required > </td>
            </tr>
            <tr>
                <td> Manager's Middle Name </td>
                <td> <input type="text" name="Manager_middlename" > </td>
            </tr>
            <tr>
                <td> Team Logo (Max 2MB) </td>
                <td><input type="file" name="Team_logo" accept=".jpg, .png" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="Insert"> Submit</button>
                </td>
            </tr>
        </table>
    </form>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>

    <?php
        if (isset($_POST['Insert'])) {

            $team_name = $_POST['team_name'];
            $city = $_POST['city'];
            $Manager_Lname = $_POST['Manager_lastname'];
            $Manager_Fname = $_POST['Manager_firstname'];
            $Manager_Mname = $_POST['Manager_middlename'];

            $Team_logo = $_FILES['Team_logo'];
            $logo_name = $Team_logo['name'];
            $logo_tmp = $Team_logo['tmp_name'];
            $logo_error = $Team_logo['error'];
            $logo_size = $Team_logo['size'];

            $allowed_extension = ['jpg', 'png'];
            $file_extension = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));

            if ($logo_error === 0) {
                if (in_array($file_extension, $allowed_extension) && $logo_size <= 2 * 1024 * 1024) {
                    $logo_new_name = uniqid('', true) . "." . $file_extension;
                    $upload_path = "uploads/" . $logo_new_name;

                    if (move_uploaded_file($logo_tmp, $upload_path)) {
                        $upload_date = date("Y-m-d H:i:s");

                        $sql = "INSERT INTO Team (Team_name, City, Manager_Lastname, Manager_Firstname, Manager_Middlename, File_path1, File_name1, date_upload)
                                VALUES ('$team_name', '$city', '$Manager_Lname', '$Manager_Fname', '$Manager_Mname', '$upload_path', '$logo_new_name', '$upload_date')";
                        $query = mysqli_query($conn, $sql);

                        if ($query) {
                            echo "<script> alert('Team is successfully registered'); window.location='Teams.php';</script>";
                        } else {
                            echo "<script> alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); </script>";
                        }
                    }
                } else {
                    if (!in_array($file_extension, $allowed_extension)) {
                        echo "<script> alert('Invalid file type. Only JPG and PNG files are allowed.'); </script>";
                    } elseif ($logo_size > 2 * 1024 * 1024) {
                        echo "<script> alert('File size exceeds 2MB limit.'); </script>";
                    }
                }
            } else {
                echo "<script> alert('Error uploading the team logo.'); </script>";
            }
        }
    ?>
</body>
