<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $con->real_escape_string($_GET['id']);


    $sql = "SELECT * FROM uncle_ceremony WHERE id='$id'";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $swaminame = $row['swaminame'];
        $date = $row['date'];
        $mahal = $row['mahal'];
        $name = $row['name'];
        $ceremony = $row['ceremony'];
        $amount = $row['amount'];
    } else {
        echo "<p>Record not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid ID.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Function Invoice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 800px;
            padding: 20px;
            background-color: #ffffff;
            border: 2px solid #6a1b9a;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin: auto;
            position: relative;
        }
        .logo {
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
            height: auto;
        }
        .header {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        .subheader {
            font-size: 20px;
            color: #555;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .details {
            margin-bottom: 20px;
            font-size: 18px;
            color: #333;
            text-align: center;
            line-height: 1.5;
        }
        .details p {
            margin: 10px 0;
        }
        .table-container {
            margin-bottom: 20px;
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #6a1b9a;
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }
        th {
            background-color: #6a1b9a;
            color: #ffffff;
            font-weight: 700;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e9e9e9;
        }
        .footer {
            font-size: 16px;
            color: #777;
            margin-top: 20px;
            text-align: center;
            line-height: 1.6;
        }
        .footer i {
            margin-right: 10px;
            color: #555;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            position: relative;
        }
        button:hover {
            background-color: #0056b3;
        }
        .print-button {
            display: inline-block;
        }
        .cancel-btn {
            background: #dc3545;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }
        .cancel-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(220, 53, 69, 0.4);
        }
        @media print {
            #google_translate_element,
            .print-button,
            .cancel-btn,
            .skiptranslate {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="logo">
            <img src="https://c4.wallpaperflare.com/wallpaper/45/360/53/lord-shiva-hindu-gods-hinduism-india-hd-wallpaper-preview.jpg" alt="Logo">
        </div>
        <div id="google_translate_element"></div> 
        <div class="header">
            Ceremony Function Invoice
        </div>
        <div class="details">
            <p><strong>Swami Name:</strong> <?php echo htmlspecialchars($swaminame); ?></p>
            <p><strong>Ceremony Name:<?php echo htmlspecialchars($row['ceremony']); ?></p>
            <p><strong>Mahal:</strong> <?php echo htmlspecialchars($mahal); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
        </div>
       
        <div class="account-info">***MOI ACCOUNT***</div>
        <br>
        <div class="table-container">
            <table>
                <tr>
                    <th>Maternal Uncle</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($name); ?></td>
                    <td><?php echo htmlspecialchars($amount); ?></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <i class="fas fa-thumbs-up"></i> Thank you for your visit
            <br><i class="fas fa-info-circle"></i> ACCESS MOI ACCOUNT SOFTWARE IS AVAILABLE ON DEMAND
            <br><i class="fa fa-phone" aria-hidden="true"></i> 8300793360
        </div>
        <br>
        <button class="print-button" onclick="print_invoice()">Print</button>
        <a href="uncle_ceremony_display.php" class="cancel-btn">Cancel</a>
    </div>

    <script>
        function print_invoice() {
            window.print();
        }
    </script>
        
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,ta,ml,kn,hi', 
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>