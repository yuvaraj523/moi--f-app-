<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
// Include database connection
include('db.php');
// Fetch total amount from addmoi
$total_amount_addmoi_sql = "SELECT SUM(amount) AS total_amount FROM addmoi";
$total_amount_addmoi_result = $con->query($total_amount_addmoi_sql);

if ($total_amount_addmoi_result && $total_amount_addmoi_result->num_rows > 0) {
    $total_amount_addmoi_row = $total_amount_addmoi_result->fetch_assoc();
    $current_total_addmoi = $total_amount_addmoi_row['total_amount'];
} else {
    $current_total_addmoi = 0;
}

// Fetch total amount from uncle
$total_amount_uncle_sql = "SELECT SUM(amount) AS total_amount FROM uncle";
$total_amount_uncle_result = $con->query($total_amount_uncle_sql);

if ($total_amount_uncle_result && $total_amount_uncle_result->num_rows > 0) {
    $total_amount_uncle_row = $total_amount_uncle_result->fetch_assoc();
    $current_total_uncle = $total_amount_uncle_row['total_amount'];
} else {
    $current_total_uncle = 0;
}

// Fetch total wedding count
$count_wedding_sql = "SELECT COUNT(*) AS total FROM wedding";
$count_wedding_result = $con->query($count_wedding_sql);

if ($count_wedding_result && $count_wedding_result->num_rows > 0) {
    $count_wedding_row = $count_wedding_result->fetch_assoc();
    $total_wedding_count = $count_wedding_row['total'];
} else {
    $total_wedding_count = 0;
}

// Fetch total ceremony count
$count_ceremony_sql = "SELECT COUNT(*) AS total FROM ceremony";
$count_ceremony_result = $con->query($count_ceremony_sql);

if ($count_ceremony_result && $count_ceremony_result->num_rows > 0) {
    $count_ceremony_row = $count_ceremony_result->fetch_assoc();
    $total_ceremony_count = $count_ceremony_row['total'];
} else {
    $total_ceremony_count = 0;
}
// Fetch total amount from uncle_ceremony
$total_amount_uncle_ceremony_sql = "SELECT SUM(amount) AS total_amount FROM uncle_ceremony";
$total_amount_uncle_ceremony_result = $con->query($total_amount_uncle_ceremony_sql);

if ($total_amount_uncle_ceremony_result && $total_amount_uncle_ceremony_result->num_rows > 0) {
    $total_amount_uncle_ceremony_row = $total_amount_uncle_ceremony_result->fetch_assoc();
    $current_total_uncle_ceremony = $total_amount_uncle_ceremony_row['total_amount'];
} else {
    $current_total_uncle_ceremony = 0;
}

// Fetch total amount from ceremony_moi
$total_amount_ceremony_moi_sql = "SELECT SUM(amount) AS total_amount FROM ceremony_moi";
$total_amount_ceremony_moi_result = $con->query($total_amount_ceremony_moi_sql);

if ($total_amount_ceremony_moi_result && $total_amount_ceremony_moi_result->num_rows > 0) {
    $total_amount_ceremony_moi_row = $total_amount_ceremony_moi_result->fetch_assoc();
    $current_total_ceremony_moi = $total_amount_ceremony_moi_row['total_amount'];
} else {
    $current_total_ceremony_moi = 0;
}

$combined_total = $current_total_addmoi + $current_total_uncle;
// Fetch total amount from uncle_ceremony
$total_amount_uncle_ceremony_sql = "SELECT SUM(amount) AS total_amount FROM uncle_ceremony";
$total_amount_uncle_ceremony_result = $con->query($total_amount_uncle_ceremony_sql);

if ($total_amount_uncle_ceremony_result && $total_amount_uncle_ceremony_result->num_rows > 0) {
    $total_amount_uncle_ceremony_row = $total_amount_uncle_ceremony_result->fetch_assoc();
    $current_total_uncle_ceremony = $total_amount_uncle_ceremony_row['total_amount'];
} else {
    $current_total_uncle_ceremony = 0;
}

// Fetch total amount from ceremony_moi
$total_amount_ceremony_moi_sql = "SELECT SUM(amount) AS total_amount FROM ceremony_moi";
$total_amount_ceremony_moi_result = $con->query($total_amount_ceremony_moi_sql);

if ($total_amount_ceremony_moi_result && $total_amount_ceremony_moi_result->num_rows > 0) {
    $total_amount_ceremony_moi_row = $total_amount_ceremony_moi_result->fetch_assoc();
    $current_total_ceremony_moi = $total_amount_ceremony_moi_row['total_amount'];
} else {
    $current_total_ceremony_moi = 0;
}

// Calculate overall total
$overall_total = $current_total_uncle_ceremony + $current_total_ceremony_moi;
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #343a40;
            display: flex;
            height: 100vh;
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .sidebar {
            width: 200px;
            background-color: #ffffff;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            height: 100vh;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
            overflow-y: auto; 
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        .main-content {
            flex: 1;
            margin-left: 200px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: margin-left 0.3s ease-in-out;
            animation: fadeInUp 0.7s ease-in-out;
        }

        .main-content.shifted {
            margin-left: 0;
        }

        .sidebar i {
            color: #002856;
        }

        .sidebar h2 {
            font-size: 20px;
            margin: 0;
            color: #002856;
            text-align: center;
            animation: slideInLeft 0.5s ease-in-out;
        }

        @keyframes slideInLeft {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(0); }
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin:0;
            flex:1;
            display: flex;
            flex-direction: column;
            margin-top: 30px;
        }

        .sidebar ul li {
            margin: 15px 0;
            position: relative;
        }

        .sidebar ul li a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 18px;
            padding: 12px;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar ul li a:hover {
            color: #002856;
            background-color: #f1f1f1;
        }

        .sidebar ul li i {
            margin-right: 15px;
            font-size: 15px;
        }

        .dropdown-menu {
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            width: 100%;
            border-radius: 8px;
            transition: opacity 0.3s ease, max-height 0.3s ease;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
        }

        .dropdown-menu.show {
            opacity: 1;
            max-height: 700px;
        }

        .dropdown-menu li {
            margin: 0;
        }

        .dropdown-menu li a {
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #e9ecef; 
            transition: background-color 0.3s ease;
        }

        .dropdown-menu li a:last-child {
            border-bottom: none; 
        }

        .dropdown-menu li a:hover {
            background-color: #e9ecef;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(90deg, #002856, #002856);
            padding: 15px 30px;
            color: #FFFFFF;
            font-size: 18px;
            border-bottom: 2px solid #D21F2D;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header .header-left {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .header .header-left .toggle-btn {
            background: none;
            border: none;
            color: #FFFFFF;
            font-size: 20px;
            cursor: pointer;
            margin-right: 20px;
        }

        .header .header-left .trans {
            margin: 0;
            text-align: center;
            flex: 1;
        }

        .header .header-right {
            display: flex;
            align-items: center;
        }

        .admin-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #FFFFFF;
            margin-right: 20px;
        }

        .admin-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #FFFFFF;
            margin-bottom: 5px;
            margin-left:10px;
        }

        .admin-name {
            font-size: 14px;
            color: #FFFFFF;
            margin-left:10px;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo img {
            width: 150px;
            height: 150px;
        }

.dashboard-cards {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}


.card {
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    flex: 1;
    min-width: 220px;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    border: 2px solid transparent; 
}


.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}


.card-wedding {
    background-color:whitesmoke; 
    color: #25476A;


}
.card-wedding i{
    color:red;
}
.card-wedding_moi {
    background-color: whitesmoke;
    color:  #25476A;

}
.card-wedding_moi i{

    color:#03a9f4;
}
.card-wedding_uncle {
    background-color: whitesmoke; 
    color:   #25476A;
   
}
.card-wedding_uncle i{

    color:#03a9f4;
}
.card-overallwedding {
    background-color:whitesmoke;
    color:  #25476A;

}
.card-overallwedding i{
    color:#03a9f4;
}
.card-ceremony {
    background-color: whitesmoke;
    color:   #25476A; 

}

.card-ceremony i {
    color:orange;
}
.card-ceremony_moi {
    background-color:whitesmoke;
    color:   #25476A;
}

.card-ceremony_moi i {

    color:#03a9f4;
}
.card-ceremony_uncle {
    background-color: whitesmoke;
    color:  #25476A;

}

.card-ceremony_uncle i{
    color:#03a9f4;
}

.card-overall.ceremony {
    background-color: whitesmoke;
    color:  #25476A;
   }

   .card-overall.ceremony i{

    color:#03a9f4;
}
.card h3 {
    margin-top: 0;
    font-size: 22px;
    display: flex;
    align-items: center;
    text-align: center;
    color: inherit;
    position: relative;
}

.card h3 i {
    margin-left: 30px;
    font-size: 24px;
    margin-right: 20px;
    margin-bottom: 40px;
}


.card-ceremony h3 i {
    margin-right: 20px;
    margin-bottom: 30px;
}
.language-switcher {
    margin-left: 10px;
}

.language-switcher select {
    padding: 5px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
}
#google_translate_element {
    margin: 10px; 
    padding: 5px;
    border: 1px solid #ccc; 
    border-radius: 5px; 
    background: linear-gradient(90deg, #002856, #002856);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
    font-family: Arial, sans-serif; 
    text-align: center;
}

#google_translate_element select {
    padding: 3px; 
    border-radius: 3px; 
    border: 1px solid #aaa; 
    background-color: #0d6efd; 
    color: #ffffff; 
    font-size: 10px; 
}


#google_translate_element .skiptranslate {
    display: flex; 
}
@media (max-width: 1200px) {
    .sidebar {
        width: 170px;
    }
    .main-content {
        margin-left: 150px;
    }
}

@media (max-width: 992px) {
    .sidebar {
        width: 140px;
    }
    .main-content {
        margin-left: 120px;
    }
}

@media (max-width: 768px) {
    .sidebar {
        width: 160px;
      
    }
    .main-content {
        margin-left: 140px;
    }
    .card {
        flex: 1 1 10%;
    }

    .dashboard-cards {
        flex-direction: row;
        align-items: center;
    }
}

@media (max-width: 428px) {
    .sidebar {
        width: 140px;
    }
    .main-content {
        margin-left: 100px;
    }
    
    .header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header .header-left {
        margin-bottom: 10px;
    }
    
    .header .header-right {
        width: 100%;
        justify-content: space-between;
    }
    
    .card {
        flex: 1 1 10%;
    }

    .dashboard-cards {
        flex-direction: row;
        align-items: relative;
    }
}
@media (max-width: 320px) {
    .sidebar {
        width: 130px;
    }
    .main-content {
        margin-left: 100px;
    }
    
    .header {
        flex-direction: column;
        align-items: flex-start;
        padding-right:100%;
    }
    
    .header .header-left {
        margin-bottom: 10px;
    }
    
    .header .header-right {
        width: 110%;
        justify-content: space-between;
       
    }
    
    .card {
        flex: 1 1 10%;
    }

    .dashboard-cards {
        flex-direction: row;
        align-items: relative;
    }
}
</style>
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <img src="asset/image/img/e11b7541-268d-43bd-8658-22c2cb761d9d.jfif" alt="Logo">
    </div>
    <h2><i class="fa fa-home" aria-hidden="true"></i> <span class="trans" data-en="Dashboard">Dashboard</span></h2>
    <ul>
  <li class="dropdown">
                <a href="#" id="weddingDetailsToggle"><i class="fa fa-ring"></i><span class="trans" data-en="Wedding Details">Wedding Details</span><i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-menu" id="weddingDetailsMenu">
                    <li><a href="marriage.php"><i class="fa fa-heart" aria-hidden="true"></i>Add Wedding</a></li>
                    <li><a href="marriagedisplay.php"><i class="fa fa-heartbeat" aria-hidden="true"></i> List of Wedding </a></li>
                    <li><a href="addmoi.php"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add Moi</a></li>
                    <li><a href="addmoidisplay.php"><i class="fa fa-list" aria-hidden="true"></i>List of Moi</a></li>
                    <li><a href="maternaluncle.php"><i class="fa fa-plus-square" aria-hidden="true"></i>Add Maternal Uncle Moi</a></li>
                    <li><a href="maternaluncledisplay.php"><i class="fa fa-list-alt" aria-hidden="true"></i>List of Maternal Uncle Moi</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" id="ceremonyDetailsToggle"><i class="fa fa-calendar"></i><span class="trans" data-en="Ceremony Details">Ceremony Details</span><i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-menu" id="ceremonyDetailsMenu">
                    <li><a href="function.php"><i class="fa fa-user-plus" aria-hidden="true"></i>Add Function</a></li>
                    <li><a href="functiondisplay.php"><i class="fa fa-address-card" aria-hidden="true"></i>List of Function</a></li>
                    <li><a href="ceremonymoi.php"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add Ceremony Moi</a></li>
                    <li><a href="ceremony_display.php"><i class="fa fa-list" aria-hidden="true"></i>List of Ceremony Moi</a></li>
                    <li><a href="uncle_ceremony.php"><i class="fa fa-plus-square" aria-hidden="true"></i>Add Maternal Uncle Moi</a></li>
                    <li><a href="uncle_ceremony_display.php"><i class="fa fa-list-alt" aria-hidden="true"></i>List of Maternal Uncle Moi</a></li>
                </ul>
            </li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

<div class="main-content">
    <div class="header">
        <div class="header-left">
            <button class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></button> </div>
        <div class="header-right">
        <div id="google_translate_element"></div>
            <div class="admin-info">
                <img src="https://cdn.vectorstock.com/i/500p/30/97/flat-business-man-user-profile-avatar-icon-vector-4333097.avif" alt="Admin Image" class="admin-image">
                <div class="admin-name trans" data-en="Admin Name" data-ta="நிர்வாகியின் பெயர்">Admin Name</div>
            </div>
         </div>
    </div>
    <br><br>
    <div class="dashboard-cards">
    <div class="card card-wedding">
        <h3 class="trans" data-en="Total Wedding Ceremony">
            <i class="bi bi-heart"></i> Total Wedding Ceremony <?php echo htmlspecialchars($total_wedding_count); ?>
        </h3>
    </div>
    <div class="card card-wedding_moi">
        <h3 class="trans" data-en="Total Moi Amount">
            <i class="bi bi-clock"></i> Total Moi Amount ₹ <?php echo number_format($current_total_addmoi, 2); ?>
        </h3>
    </div>
    <div class="card card-wedding_uncle">
        <h3 class="trans" data-en="Maternal Uncle Moi">
            <i class="bi bi-person-fill"></i> Maternal Uncle Moi ₹ <?php echo number_format($current_total_uncle, 2); ?>
        </h3>
    </div>
    <div class="card card-overallwedding">
        <h3 class="trans" data-en="Overall Wedding Amount">
            <i class="bi bi-wallet"></i> Overall Wedding Moi Amount ₹ <?php echo number_format($combined_total, 2); ?>
        </h3>
    </div>
    <div class="card card-ceremony">
        <h3 class="trans" data-en="Total Ceremony">
            <i class="bi bi-calendar"></i> Total Ceremony<?php echo htmlspecialchars($total_ceremony_count); ?>
        </h3>
    </div>
    <div class="card card-ceremony_moi">
        <h3 class="trans" data-en="Total Ceremony Moi Amount">
            <i class="bi bi-clock"></i> Total Moi Amount ₹ <?php echo number_format($current_total_ceremony_moi, 2); ?>
        </h3>
    </div>
    <div class="card card-ceremony_uncle">
        <h3 class="trans" data-en="Ceremony Uncle Moi Amount">
            <i class="bi bi-person-fill"></i> maternal Uncle Moi Amount ₹ <?php echo number_format($current_total_uncle_ceremony, 2); ?>
        </h3>
    </div>
    <div class="card card-overall ceremony">
        <h3 class="trans" data-en="Overall Ceremony Amount">
            <i class="bi bi-wallet"></i> Overall Ceremony Moi Amount ₹ <?php echo number_format($overall_total, 2); ?>
        </h3>
    </div>
</div>

</div>
<script>
    document.getElementById('weddingDetailsToggle').addEventListener('click', function () {
        document.getElementById('weddingDetailsMenu').classList.toggle('show');
    });

    document.getElementById('ceremonyDetailsToggle').addEventListener('click', function () {
        document.getElementById('ceremonyDetailsMenu').classList.toggle('show');
    });

    document.getElementById('toggleBtn').addEventListener('click', function () {
        document.querySelector('.sidebar').classList.toggle('closed');
        document.querySelector('.main-content').classList.toggle('shifted');
    });
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
