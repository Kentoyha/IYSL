<?php
include("db_connect.php");
include("menu.php");
?>

<head>
<link rel="stylesheet" href="addt.css">  
</head>

<body>
<h1>Place Order</h1>

    <form method="post" enctype="multipart/form-data">
        <table border=1 align="center" cellspacing="0" cellpadding="10">
           
            <tr>
                <td> Laundry Type </td>
                <td> <select name="Laundry_Type">
                    <option value="0">Select</option>
                    <option value="1">Beddings</option>
                    <option value="2">Curtains</option>
                    <option value="3">Towel</option>
                    <option value="4">Topper</option>
                    <option value="5">Table Cloth</option>
                    <option value="6">Mixed</option>
                </select> </td>
            </tr>
            <tr>
                <td> Laundry Quantity </td>
                <td> <input type="text" name="Laundry_Quantity" required> </td>
            </tr>
            <tr>
                <td> Cleaning Type </td>
                <td> <select name="Cleaning_Type">
                    <option value="0">Select</option>
                    <option value="1">Dry Cleaning</option>
                    <option value="2">Wet Cleaning</option>
                    <option value="3">Spot Cleaning</option>
                    <option value="4">Mixed</option>
                </select> </td>
            </tr>
            <tr>    
                <td> Place </td>
                <td> <input type="text" name="team_name" required> </td>
            </tr>
            <tr>
                <td> Order Note (optional) </td>
                <td> <textarea name="order_note" rows="4" cols="50"></textarea> </td>
            <input type="hidden" name="Status" value="1">
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

            $Order_date = date('Y-m-d');
            $Laundry_Type = $_POST['Laundry_Type'];
            $Laundry_Quantity = $_POST['Laundry_Quantity'];
            $Cleaning_Type = $_POST['Cleaning_Type'];
            $Place = $_POST['team_name'];
            $Ordernote = !empty($_POST['order_note']) ? $_POST['order_note'] : null;
            $Status = isset($_POST['Status']) ? $_POST['Status'] : null;
            $Status = isset($_POST['Status']) ? $_POST['Status'] : null;
            

            $sql = "INSERT INTO Orders (Laundry_Type, Laundry_Quantity, Cleaning_Type, Place, Ordernote, Status, Order_date)
             VALUES ('$Laundry_Type', '$Laundry_Quantity', '$Cleaning_Type', '$Place', '$Ordernote', '$Status', '$Order_date')";
            $query = mysqli_query($conn, $sql);

            if ($query) {
                echo "<script> alert('Error: " . mysqli_error($conn) . "'); </script>";
            }
        }
    ?>
</body>
</html>