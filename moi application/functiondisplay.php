<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
include('db.php'); 

$sql = "SELECT * FROM ceremony ORDER BY date DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ceremony Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
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
    width: 220px;
    background-color: #ffffff;
    padding: 10px;
    display: flex;
    flex-direction: column;
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




table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

table th {
    background-color: #f4f4f4;
    font-weight: bold;
    text-align: left;
    padding: 12px;
    border-bottom: 2px solid #ddd;
    color: #333;
}

table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
    color: #555;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

.actions a .fas.fa-edit {
    color: #007bff;
    transition: color 0.3s ease;
}

.actions a .fas.fa-edit:hover {
    color: #0056b3;
}

.actions a .fas.fa-eye {
    color: #28a745;
    transition: color 0.3s ease;
}

.actions a .fas.fa-eye:hover {
    color: #1e7e34;
}

.actions a .fas.fa-trash {
    color: #dc3545;
    transition: color 0.3s ease;
}

.actions a .fas.fa-trash:hover {
    color: #c82333;
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

.button-container {
    display: flex; 
    justify-content: center;
    align-items: center; 
    margin-top: 20px; 
    gap: 20px; 
}


#downloadPdfBtn {
    background-color: whitesmoke; 
    color: black; 
    border: 1px solid lightgray; 
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

#downloadPdfBtn:hover {
    background-color: white; 
    transform: translateY(-2px); 
}


#downloadPdfBtn i {
    margin-right: 8px; 
    color: blue; 
}


button[type="submit"] {
    background-color: whitesmoke; 
    color: black; 
    border: 1px solid lightgray; 
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px; 
    cursor: pointer; 
    transition: background-color 0.3s, transform 0.2s;
    display: inline-flex; 
    align-items: center; 
}

button[type="submit"]:hover {
    background-color: white; 
    transform: translateY(-2px); 
}


button[type="submit"] i {
    margin-right: 8px; 
    font-size: 18px; 
    color: red; 
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

    button[type="submit"],
    #downloadPdfBtn {
        font-size: 14px; 
        padding: 8px 16px; 
       
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

    button[type="submit"],
    #downloadPdfBtn {
        font-size: 14px; 
        padding: 8px 16px; 
        margin-bottom:20px;
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
    }

    .admin-info {
        margin-left: 0; 
    }

    button[type="submit"],
    #downloadPdfBtn {
        font-size: 14px; 
        padding: 8px 16px;
        margin-bottom:20px;
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
        padding-right:120%;
    }

    .admin-info {
        margin-left: 0;
    }

    button[type="submit"],
    #downloadPdfBtn {
        font-size: 14px;
        padding: 8px 15px; 
        margin-bottom:20px;

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


<?php
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>
<div class="container">
    <form method="POST" action="function_delete_record.php">
   
        <div class="button-container">

            <button id="downloadPdfBtn" type="button">
                <i class="fas fa-file-pdf"></i> Download PDF
            </button>
            <button type="submit" class="delete-btn">
    <i class="fa-solid fa-trash"></i> Delete
</button>
        </div>
        <table id="dataTable">
    <thead>
        <tr>
            <th><input type="checkbox" id="select-all"></th>
            <th>ID</th>
            <th>Swami Name</th>
            <th>Date</th>
            <th>Ceremony</th>
            <th>Ceremony Owner</th>
            <th>Mahal</th>
            <th>Place</th>
            <th>Timing</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php $sno = 1; ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><input type="checkbox" name="selected_ids[]" value="<?php echo $row['id']; ?>"></td>
                    <td><?= htmlspecialchars($sno++); ?></td>
                    <td><?php echo htmlspecialchars($row['swaminame']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['ceremony']); ?></td>
                    <td><?php echo htmlspecialchars($row['ceremonyowner']); ?></td>
                    <td><?php echo htmlspecialchars($row['mahal']); ?></td>
                    <td><?php echo htmlspecialchars($row['place']); ?></td>
                    <td><?php echo htmlspecialchars($row['timing']); ?></td>
                    <td class="actions">
                        <a href="function_edit.php?id=<?php echo htmlspecialchars($row['id']); ?>" title="Edit" class="edit"><i class="fas fa-edit"></i></a>
                        <a href="function_view.php?id=<?php echo htmlspecialchars($row['id']); ?>" title="View" class="view"><i class="fas fa-eye"></i></a>
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo htmlspecialchars($row['id']); ?>)" title="Delete" class="delete"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="10">No records found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
        </form>
         
<script>
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
    <script>
                $(document).ready(function () {
                    // Initialize DataTable
                    $('#dataTable').DataTable();

                    // Select/Deselect all checkboxes
                    $('#select-all').on('change', function () {
                        const isChecked = $(this).is(':checked');
                        $('input[name="selected_ids[]"]').prop('checked', isChecked);
                    });
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
    
        function setCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const timeString = `${hours}:${minutes}`;
            document.getElementById('timing').value = timeString;
        }
    
        window.onload = function() {
            setCurrentTime();
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        };
        function closeAlert() {
        var alertPopup = document.getElementById('success-message');
        if (alertPopup) {
            alertPopup.style.display = 'none';
        }
    }

    window.onload = function() {
        var alertPopup = document.getElementById('success-message');
        if (alertPopup) {
            setTimeout(function() {
                alertPopup.style.display = 'none';
            }, 5000);
        }
    };
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const { jsPDF } = window.jspdf;

    function generatePDF() {
        const doc = new jsPDF({ orientation: "landscape" });
        const table = document.querySelector('table');
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
        const rows = Array.from(table.querySelectorAll('tbody tr')).map(tr =>
            Array.from(tr.querySelectorAll('td')).map(td => td.textContent.trim())
        );

       // Calculate column widths based on content
        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        const marginX = 5;
        let currentY = 23;
        const cellPadding = 8;
        const columnWidths = headers.map(header => Math.max(header.length * 5.4, 23));
        
        // Print headers
        let currentX = marginX;
        headers.forEach((header, i) => {
            doc.text(header, currentX, currentY);
            currentX += columnWidths[i];
        });

        // Add space below headers
        currentY +=10;

        // Print rows
        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");
        rows.forEach(row => {
            currentX = marginX;
            row.forEach((cell, i) => {
                doc.text(cell, currentX, currentY);
                currentX += columnWidths[i];
            });
            currentY += 10;
            // Check if we need to add a new page
            if (currentY > 260) { // Adjust if needed
                doc.addPage();
                currentY = 20; // Reset to top of new page
                // Print headers on new page
                currentX = marginX;
                headers.forEach((header, i) => {
                    doc.text(header, currentX, currentY);
                    currentX += columnWidths[i];
                });
                currentY += 10;
            }
        });

        // Save the PDF
        doc.save('ceremony_details.pdf');
    }

    // Attach the generatePDF function to the button
    document.getElementById('downloadPdfBtn').addEventListener('click', generatePDF);
});

</script>
<Script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this record? This process cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',  
        cancelButtonColor: '#3085d6', 
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {

            window.location.href = `function_delete.php?id=${id}`;
        }
    });
}


document.querySelector('button[type="submit"].delete-btn').addEventListener('click', function(event) {
    event.preventDefault(); 

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', 
        cancelButtonColor: '#3085d6', 
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
   
            this.closest('form').submit();
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const message = "<?php echo $message; ?>";
    
    if (message) {
        Swal.fire({
            title: 'Notice',
            text: message,
            icon: 'success', 
            confirmButtonColor: '#d33', 
            confirmButtonText: 'OK',
            timer: 3000  
        });
    }
});
</script>
<?php if (isset($_GET['message'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
 
            const message = "<?php echo $_GET['message']; ?>";
            
            if (message === 'delete_success') {
                Swal.fire({
                    title: 'Success!',
                    text: 'Record deleted successfully.',
                    icon: 'success',
                    confirmButtonColor: '#d33',  
                    timer: 5000,  
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Remove 'message' parameter from the URL after showing the alert
                    window.history.replaceState(null, null, window.location.pathname);
                });
            } else if (message === 'update_success') {
                Swal.fire({
                    title: 'Success!',
                    text: 'Record updated successfully.',
                    icon: 'success',
                    confirmButtonColor: '#3085d6', 
                    timer: 5000, 
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Remove 'message' parameter from the URL after showing the alert
                    window.history.replaceState(null, null, window.location.pathname);
                });
            }
        });
    </script>
<?php endif; ?>
<?php
if (isset($con)) {
    $con->close();
}
?>
</body>
</html>

