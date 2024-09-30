<?php
session_start();
include('db.php');
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $con->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM ceremony WHERE id='$id'";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $swaminame = $row['swaminame'];
        $ceremony = $row['ceremony'];
        $ceremonyowner = $row['ceremonyowner'];
        $date = $row['date'];
        $mahal = $row['mahal'];
        $place = $row['place'];
        $timing = $row['timing'];

        list($hours, $minutes_ampm) = explode(':', $timing);
        $minutes = substr($minutes_ampm, 0, 2);
        $ampm = strtoupper(substr($minutes_ampm, -2));
    } else {
        echo "<p>No record found with ID: $id</p>";
        exit();
    }
} else {
    echo "<p>No ID provided!</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marriage Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
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
            margin: 0;
            flex: 1;
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
            margin-left: 20px;
        }

        .admin-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #FFFFFF;
            margin-bottom: 5px;
        }

        .admin-name {
            font-size: 14px;
            color: #FFFFFF;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        .form-container {
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            margin-top: 40px; 
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 26px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 24px;
        }

.form-group i {
    color: #002856;
    padding-right: 5px;
}

.form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 8px;
    color: #555;
}

.form-group input, .form-group select {
    width: 100%;
    padding: 12px;
    font-size: 15px;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    background-color: #f9f9f9;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-group input:focus, .form-group select:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    outline: none;
}

.error {
    color: #d9534f;
    font-size: 13px;
    margin-top: 5px;
}

.submit-btn, .cancel-btn {
    display: inline-block;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    text-align: center;
    text-decoration: none;
    margin-right: 10px;
    transition: background-color 0.3s, box-shadow 0.3s, transform 0.3s;
}

.submit-btn {
    background-color: #007bff;
    color: #ffffff;
}

.submit-btn:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

.cancel-btn {
    background-color: #dc3545;
    color: #ffffff;
}

.cancel-btn:hover {
    background-color: #c82333;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th, table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    font-size: 16px;
    color: #333;
}

table th {
    background-color: #f8f9fa;
    color: #002856;
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #e9ecef;
}

table td {
    border-bottom: 1px solid #e9ecef;
}

table td:last-child {
    border-bottom: none;
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

</style>
</head>
<body>
    
<div class="sidebar">
<div class="logo">
    <img src="asset/image/img/e11b7541-268d-43bd-8658-22c2cb761d9d.jfif" alt="Logo">
</div>

<ul>
<li><a href="dashboard.php" class="active"><i class="fa fa-home" aria-hidden="true"></i> <span class="trans" data-en="Dashboard">Dashboard</span></a></li>
    <li class="dropdown">
        <a href="#" id="weddingDetailsToggle"><i class="fa fa-ring"></i><span class="trans" data-en="Wedding Details">Wedding Details</span><i class="fa fa-chevron-down"></i></a>
        <ul class="dropdown-menu" id="weddingDetailsMenu">
            <li><a href="marriage.php"><i class="fa fa-heart" aria-hidden="true"></i>Add Wedding</a></li>
            <li><a href="marriagedisplay.php"><i class="bi bi-calendar-heart"></i>List Wedding</a></li>
            <li><a href="addmoi.php"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add Moi</a></li>
            <li><a href="addmoidisplay.php"><i class="fa fa-list" aria-hidden="true"></i>List Moi</a></li>
            <li><a href="maternaluncle.php"><i class="fa fa-plus-square" aria-hidden="true"></i>Add Maternal Uncle Moi</a></li>
            <li><a href="maternaluncledisplay.php"><i class="fa fa-list-alt" aria-hidden="true"></i>List Maternal Uncle Moi</a></li>
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" id="ceremonyDetailsToggle"><i class="fa fa-calendar"></i><span class="trans" data-en="Ceremony Details">Ceremony Details</span><i class="fa fa-chevron-down"></i></a>
        <ul class="dropdown-menu" id="ceremonyDetailsMenu">
            <li><a href="function.php"><i class="fa fa-user-plus" aria-hidden="true"></i>Add Function</a></li>
            <li><a href="functiondisplay.php"><i class="fa fa-address-card" aria-hidden="true"></i>List Function</a></li>
            <li><a href="ceremonymoi.php"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add Ceremony Moi</a></li>
            <li><a href="ceremony_display.php"><i class="fa fa-list" aria-hidden="true"></i>List Ceremony Moi</a></li>
            <li><a href="uncle_ceremony.php"><i class="fa fa-plus-square" aria-hidden="true"></i>Add Maternal Uncle Moi</a></li>
            <li><a href="uncle_ceremony_display.php"><i class="fa fa-list-alt" aria-hidden="true"></i>List Maternal Uncle Moi</a></li>
        </ul>
    </li>
    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
</ul>
</div>

<div class="main-content">
<div class="header">
    <div class="header-left">
        <button class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></button>
        <div class="trans" data-en="Welcome to Your Dashboard" data-ta="உங்கள் டாஷ்போர்டு">Welcome to Your Dashboard</div>
    </div>
    <div class="header-right">
    <div id="google_translate_element"></div>
        <div class="admin-info">
            <img src="https://cdn.vectorstock.com/i/500p/30/97/flat-business-man-user-profile-avatar-icon-vector-4333097.avif" alt="Admin Image" class="admin-image">
            <div class="admin-name">Admin Name</div>
        </div>
    </div>
</div>
<br>
<br>
<br>

<div class="container">
<table>
        <tr>
            <th>Attribute</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Swami Name</td>
            <td><?php echo htmlspecialchars($swaminame); ?></td>
        </tr>
        <tr>
            <td>Date</td>
            <td><?php echo htmlspecialchars($date); ?></td>
        </tr>
        <tr>
            <td>Ceremony</td>
            <td><?php echo htmlspecialchars($ceremony); ?></td>
        </tr>
        <tr>
            <td>Ceremony Owner</td>
            <td><?php echo htmlspecialchars($ceremonyowner); ?></td>
        </tr>
        <tr>
            <td>Mahal</td>
            <td><?php echo htmlspecialchars($mahal); ?></td>
        </tr>
        <tr>
            <td>Place</td>
            <td><?php echo htmlspecialchars($place); ?></td>
        </tr>
        <tr>
            <td>Timing</td>
            <td><?php echo htmlspecialchars($hours . ':' . $minutes . ' ' . $ampm); ?></td>
        </tr>
    </table>
</div>
</div>

<script>
const toggleBtn = document.getElementById('toggleBtn');
const sidebar = document.querySelector('.sidebar');
const mainContent = document.querySelector('.main-content');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('closed');
    mainContent.classList.toggle('shifted');
});

document.getElementById('weddingDetailsToggle').addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById('weddingDetailsMenu').classList.toggle('show');
});

document.getElementById('ceremonyDetailsToggle').addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById('ceremonyDetailsMenu').classList.toggle('show');
});


</script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,ta,ml,kn,hi', // English, Tamil, Malayalam, Kannada, Hindi
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
