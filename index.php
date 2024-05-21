<?php
    include("connect.php");

    $SELECT_VENDOR = "SELECT v_name FROM vendors";
    $SELECT_CATEGORY = "SELECT c_name FROM category";
    $SELECT_PRICE = "SELECT MIN(price), MAX(price) FROM items;";
    try {
        $stmt = $dbh->prepare($SELECT_VENDOR);
        $stmt->execute();
        $resVendor = $stmt->fetchAll();

        $stmt = $dbh->prepare($SELECT_CATEGORY);
        $stmt->execute();
        $resCategory = $stmt->fetchAll();

        $stmt = $dbh->prepare($SELECT_PRICE);
        $stmt->execute();

        $res = $stmt->fetchAll();

        $minPrice = $res[0][0];
        $maxPrice = $res[0][1];
    } catch (PDOException $ex) {
        echo $ex->GetMessage();
    }
    $dbh = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
    <link rel="stylesheet" href="./style.css">
    <script src="code.js"></script>
</head>
<body>
    <div class="container">
    <form onsubmit="processText(event)">
        <h2>Goods from vendor</h2>
        <label for="vendor">Vendor</label> <br>
        <select name="vendor" id="vendor">
            <?php
            foreach ($resVendor as $row) {
                echo("<option value='$row[0]'>$row[0]</option>");
            }
            ?>
        </select>
        <input type="submit" value="Submit">
    </form>

    <form id="categoryForm" onsubmit="processJson(event)">
        <h2>Goods in Category</h2>
        <label for="category">Category</label> <br>
        <select name="category" id="category">
            <?php
            foreach ($resCategory as $row) {
                echo("<option value='$row[0]'>$row[0]</option>");
            }
            ?>
        </select>
      <input type="submit" value="Submit">
    </form>

    <form id="priceForm" onsubmit="processXML(event)">
        <h2>Price range</h2>
        <p>Price range: <span id="priceValue"></p>
        <input placeholder="<?php echo($minPrice)?>" type="number" id="minPrice" name="minPrice" value="<?php echo $minPrice ?>" min="<?php echo $minPrice ?>" max="<?php echo $maxPrice ?>" step="5"/>
        <input placeholder="<?php echo($maxPrice)?>" type="number" id="maxPrice" name="maxPrice" value="<?php echo $maxPrice ?>" min="<?php echo $minPrice ?>" max="<?php echo $maxPrice ?>" step="5"/>
        <br>
        <br>
        <input type="submit" value="Submit">
    </form>
    </div>
    

    <table id="dataTable">
        <thead>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Quality</th>
            <th>Vendor</th>
            <th>Category</th>
        </thead>
        <tbody id="tableBody">
        </tbody>
</table>
</body>
</html>