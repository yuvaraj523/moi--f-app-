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
        $date = $row['date'];
        $ceremony = $row['ceremony'];
        $ceremonyowner = $row['ceremonyowner'];
        $name = $row['name'];
        $address = $row['address'];
        $mobile = $row['mobile'];
        $sequence = $row['sequence'];
        $extra_input = $row['extra_input'];
        $amount = $row['amount'];
    } else {
        echo "<p>Record not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid ID.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $con->real_escape_string($_POST['id']);
    $date = $con->real_escape_string($_POST['date']);
    $ceremony = $con->real_escape_string($_POST['ceremony']);
    $ceremonyowner = $con->real_escape_string($_POST['ceremonyowner']);
    $name = $con->real_escape_string($_POST['name']);
    $address = $con->real_escape_string($_POST['address']);
    $mobile = $con->real_escape_string($_POST['mobile']);
    $sequence = $con->real_escape_string($_POST['sequence']);
    $extra_input= $con->real_escape_string($_POST['extra_input']);
    $amount = $con->real_escape_string($_POST['amount']);
    
    $updateSql = "UPDATE uncle_ceremony  SET date='$date', ceremony='$ceremony', ceremonyowner='$ceremonyowner',  name='$name', address='$address', mobile='$mobile',sequence='$sequence',extra_input='$extra_input', amount='$amount' WHERE id='$id'";

    if ($con->query($updateSql) === TRUE) {
        $_SESSION['success_message'] = 'Record updated successfully!';
        header("Location:uncle_ceremony_display.php?message=update_success");
        exit;
    } else {
        echo "<p>Error updating record: " . $con->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ceremony_uncle_editDashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
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

.form-section {
    margin-bottom: 30px;
}

.form-container {
    margin: 20px auto;
    max-width: 800px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.extra-text-box {
    display: flex;
}

.form-control, .form-select {
    max-width: 100%;
}

.form-check-input {
    margin-top: 0.3rem;
}

.submit-btn,
.cancel-btn {
    display: inline-block;
    padding: 15px 25px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    text-align: center;
    text-decoration: none;
    margin-right: 10px;
    transition: transform 0.2s, box-shadow 0.3s;
}
.submit-btn {
    background: #007bff;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}
.submit-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 123, 255, 0.4);
}
.cancel-btn {
    background: #dc3545;
    color: white;
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}
.cancel-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(220, 53, 69, 0.4);
}
i {
    font-size: 16px;
    margin-right: 10px;
}
.form-group .icon {
    color: #002856;
    font-size: 20px; /* Ensure icons are consistent */
    margin-right: 10px; /* Adjust spacing if needed */
}
.form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
    color: #333;
    font-weight: 700;
}
.form-container {
    border: 1px solid #ddd;
}

/* Custom border colors */
.form-border-success {
    border: 2px solid #28a745; /* Green for success */
}

.form-border-error {
    border: 2px solid #dc3545; /* Red for error */
}

.form-border-warning {
    border: 2px solid #ffc107; /* Yellow for warning */
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
@media (max-width: 1024px) {
    .sidebar {
        width: 200px; 
    }
    
    .main-content {
        margin-left: 200px; 
    }

    .header {
        font-size: 16px;
    }

    .admin-info {
        margin-left: 10px; 
    }
    .submit-btn,
    .cancel-btn {
        font-size: 14px;
        padding: 10px 15px;
    }
}


@media (max-width: 760px) {
    .sidebar {
        width: 200px; 
    }
    
    .main-content {
        margin-left: 200px; 
    }

    .header {
        font-size: 16px; 
    }

    .admin-info {
        margin-left: 10px; 
    }

    .submit-btn,
    .cancel-btn {
        font-size: 14px;
        padding: 10px 15px;
    }
}

@media (max-width: 375px) {
    .sidebar {
        width: 200px; 
    }
    
    .main-content {
        margin-left: 200px; 
    }

    .header {
        font-size: 20px; 
        padding-right:300px;
    }

    .admin-info {
        margin-left: 0; 
    }

    .submit-btn,
    .cancel-btn {
        font-size: 14px;
        padding: 10px 15px;
    }
}

@media (max-width: 320px) {
    .sidebar {
        width: 200px; 
    }
    
    .main-content {
        margin-left: 200px;
    }

    .header {
        font-size: 10px; 
        padding-right:0;
    }

    .admin-info {
        margin-left: 0;
    }
    #google_translate_element {
        margin: 5px;  
        padding: 3px; 
        border-radius: 3px;
        background: linear-gradient(90deg, #002856, #002856); 
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); 
        font-size: 9px; 
    }

    #google_translate_element select {
        padding: 2px; 
        border-radius: 2px; 
        font-size: 8px; 
    }

    #google_translate_element .skiptranslate {
        display: block; 
        justify-content: center;
    }
     .submit-btn,
    .cancel-btn {
        font-size: 14px;
        padding: 10px 15px;
       
    }
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
                <button class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></button>
             </div>
            <div class="header-right">
            <div id="google_translate_element"></div> 
                <div class="admin-info">
                    <img src="https://cdn.vectorstock.com/i/500p/30/97/flat-business-man-user-profile-avatar-icon-vector-4333097.avif" alt="Admin Image" class="admin-image">
                    <div class="admin-name">Admin Name</div>
                </div>
            </div>
        </div>
<br><br>
<div class="container form-container">
<form id="marriageForm" action="uncle_ceremony_edit.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

    <!-- Date Section -->
    <div class="form-section">
        <div class="mb-3">
            <h2 class="mb-4">Edit Maternal Uncle Moi</h2>
            <label for="date" class="form-label"><i class="fas fa-calendar-day form-icon"></i>Date</label>
            <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($row['date']); ?>" required>
        </div>
    </div>

    <!-- Wedding Details Section -->
    <div class="form-section">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ceremony" class="form-label"><i class="fa fa-user-secret" aria-hidden="true"></i>Ceremony Name</label>
                    <input type="text" id="ceremony" name="ceremony" class="form-control" value="<?php echo htmlspecialchars($row['ceremony']); ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ceremonyowner" class="form-label"><i class="fa fa-users" aria-hidden="true"></i>Ceremony Owner Name</label>
                    <input type="text" id="ceremonyowner" name="ceremonyowner" class="form-control" value="<?php echo htmlspecialchars($row['ceremonyowner']); ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Personal Details Section -->
    <div class="form-section">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label"><i class="fas fa-user-circle form-icon"></i>Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label"><i class="fas fa-map-marker-alt form-icon"></i>Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($row['address']); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mobile" class="form-label"><i class="fas fa-phone form-icon"></i>Mobile No</label>
                    <input type="tel" id="mobile" name="mobile" class="form-control" value="<?php echo htmlspecialchars($row['mobile']); ?>" pattern="\d{10}" maxlength="10" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="amount" class="form-label"><i class="fa fa-inr" aria-hidden="true"></i>Amount</label>
                    <input type="number" id="amount" name="amount" class="form-control" value="<?php echo htmlspecialchars($row['amount']); ?>" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Sequence Section -->
    <div class="form-section">
        <div class="mb-3">
            <label for="sequence" class="form-label"><i class="fas fa-list form-icon"></i>Sequence</label>
            <select id="sequence" name="sequence" class="form-select" required>
                <option value="" disabled>Select one</option>
                <option value="gold" <?php echo ($row['sequence'] === 'gold') ? 'selected' : ''; ?>>Gold</option>
                <option value="sofa" <?php echo ($row['sequence'] === 'sofa') ? 'selected' : ''; ?>>Sofa</option>
                <option value="bed" <?php echo ($row['sequence'] === 'bed') ? 'selected' : ''; ?>>The Bed</option>
                <option value="biro" <?php echo ($row['sequence'] === 'biro') ? 'selected' : ''; ?>>Biro</option>
                <option value="thambalam" <?php echo ($row['sequence'] === 'thambalam') ? 'selected' : ''; ?>>Thambalam</option>
                <option value="bike" <?php echo ($row['sequence'] === 'bike') ? 'selected' : ''; ?>>Bike</option>
                <option value="car" <?php echo ($row['sequence'] === 'car') ? 'selected' : ''; ?>>Car</option>
                <option value="others" <?php echo ($row['sequence'] === 'others') ? 'selected' : ''; ?>>Others</option>
                <option value="null" <?php echo ($row['sequence'] === 'null') ? 'selected' : ''; ?>>Null</option>
            </select>
        </div>
    </div>

    <!-- Additional Information Section -->
    <div class="form-section extra-text-box" id="extraTextBox">
        <div class="mb-3">
            <label for="extraInput" id="extraInputLabel" class="form-label"><i class="fas fa-info-circle form-icon"></i>Additional Information</label>
            <input type="text" id="extraInput" name="extra_input" class="form-control" value="<?php echo htmlspecialchars($row['extra_input']); ?>" placeholder="Enter additional information">
        </div>
    </div>

    <!-- Submit and Cancel Buttons -->
    <div class="form-section">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="uncle_ceremony_display.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

        </form>
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
document.addEventListener('DOMContentLoaded', function() {
            const sequenceSelect = document.getElementById('sequence');
            const extraTextBox = document.getElementById('extraTextBox');
            const extraInputLabel = document.getElementById('extraInputLabel');
            const extraInput = document.getElementById('extraInput');

            sequenceSelect.addEventListener('change', function() {
                const selectedValue = sequenceSelect.value;

                switch (selectedValue) {
                    case 'gold':
                        extraTextBox.style.display = 'block';
                        extraInputLabel.textContent = 'Details about Gold:';
                        extraInput.placeholder = 'Enter details about Gold';
                        break;
                    case 'bed':
                        extraTextBox.style.display = 'block';
                        extraInputLabel.textContent = 'Details about The Bed:';
                        extraInput.placeholder = 'Enter details about The Bed';
                        break;
                    case 'sofa':
                        extraTextBox.style.display = 'block';
                        extraInputLabel.textContent = 'Details about Sofa:';
                        extraInput.placeholder = 'Enter details about Sofa';
                        break;
                    case 'biro':
                        extraTextBox.style.display = 'block';
                        extraInputLabel.textContent = 'Details about Biro:';
                        extraInput.placeholder = 'Enter details about Biro';
                        break;
                    case 'thambalam':
                        extraTextBox.style.display = 'block';
                        extraInputLabel.textContent = 'Details about Thambalam:';
                        extraInput.placeholder = 'Enter details about Thambalam';
                        break;
                    case 'bike':
                        extraTextBox.style.display = 'block';
                        extraInputLabel.textContent = 'Details about Bike:';
                        extraInput.placeholder = 'Enter details about Bike';
                        break;
                    case 'car':
                        extraTextBox.style.display = 'block';
                        extraInputLabel.textContent = 'Details about Car:';
                        extraInput.placeholder = 'Enter details about Car';
                        break;
                    case 'others':
                        extraTextBox.style.display = 'block';
                        extraInputLabel.textContent = 'Details about Others:';
                        extraInput.placeholder = 'Enter details about Others';
                        break;
                    default:
                        extraTextBox.style.display = 'none';
                }
            });

       
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;

            document.getElementById('mobile').addEventListener('input', function() {
                const value = this.value;
                if (/^\d{10}$/.test(value)) {
                    this.setCustomValidity('');
                } else {
                    this.setCustomValidity('Please enter exactly 10 digits.');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
    // Example conditions to change border color
    const formContainer = document.querySelector('.form-container');

    // Replace with your actual condition
    const hasError = false; // Change based on actual validation

    if (hasError) {
        formContainer.classList.add('form-border-error');
    } else {
        formContainer.classList.add('form-border-success'); // or .form-border-warning
    }
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
