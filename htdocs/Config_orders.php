<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Order</title>
</head>
<?php
include "db_connect.php";
include("menu.php");
?>
<body>
   
    <?php 
    if (isset($_GET['Order_ID'])) {
       
        $Order_id = trim($_GET['Order_ID']);

       
            $sql = "SELECT Order_date, Laundry_type, Laundry_quantity, Cleaning_type, Place , Priority_number , Status 
             FROM `Orders` WHERE Order_id = $Order_id";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $Order = mysqli_fetch_assoc($result);
            } else {
                echo "Order not found or error in query: " . mysqli_error($conn);
                exit;
            }
        
    } else {
        echo "Order ID not provided.";
        exit;
    }
    
?>
    <h1> Edit Order </h1>
    <form method="post">
        <table border=1 align="center" cellspacing="0" cellpadding="10">
            <tr>
                <td> Order Date </td>
                <td> <?php echo isset($Order['Order_date']) ? $Order['Order_date'] : ''; ?> </td>
            </tr>
            <tr>
                <td> Laundry Type </td>
                <td> <?php echo isset($Order['Laundry_type']) ? $Order['Laundry_type'] : ''; ?> </td>
            </tr>
            <tr>
                <td> Laundry Quantity </td>
                <td> <?php echo isset($Order['Laundry_quantity']) ? $Order['Laundry_quantity'] : ''; ?> </td>
            </tr>
            <tr>
                <td> Cleaning Type </td>
                <td> <?php echo isset($Order['Cleaning_type']) ? $Order['Cleaning_type'] : ''; ?> </td>
            </tr>
            <tr>
                <td> Place </td>
                <td> <?php echo isset($Order['Place']) ? $Order['Place'] : ''; ?> </td>
            </tr>
            <tr>
                <td> Priority Number </td>
                <td> <?php echo isset($Order['Priority_number']) ? $Order['Priority_number'] : ''; ?> </td>
            </tr>
            <tr>
                <td> Status </td>
                <td>
                    <select name="Status">
                        <option value="Pending" <?php echo (isset($Order['Status']) && $Order['Status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="To be Delivered"<?php echo (isset($Order['Status']) && $Order['Status'] == 'To be Delivered') ? 'selected' : ''; ?>>To be Delivered</option>
                        <option value="In Progress" <?php echo (isset($Order['Status']) && $Order['Status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Completed" <?php echo (isset($Order['Status']) && $Order['Status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </td>
            </tr>
            
            <input type="hidden" name="Order_id" value="<?php echo $Order_id; ?>">
            <tr>
                <td colspan="2">
                    <div style="text-align: center;">
                        <button type="submit" name="edit_order" class="button green"> Save Changes </button>
                        <button type="button" onclick="window.location.href='Orders.php';" class="button red">Cancel</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <?php
        if(isset($_POST['edit_order'])) {
            
            $Status = $_POST['Status'];
            $Order_id = $_POST['Order_id'];

            $sql = "UPDATE `Orders` SET 
            Status = '$Status' 
            WHERE Order_id = $Order_id";

            $query = mysqli_query($conn, $sql);
            if($query) {
                echo "<script> alert('Order updated successfully'); window.location='Orders.php';</script>";
            } else {
                echo "<script> alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); </script>";
            }
        }
    ?>
</body>
