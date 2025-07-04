<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database/config.php';
include 'session/security.php';

// Check if user logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?status=unauthorized");
    exit();
}

// Set nokp to user_id
$nokp = $_SESSION['user_id'];

// Get user info
$stmt = $connect->prepare("SELECT * FROM user WHERE nokp = ?");
$stmt->bind_param("s", $nokp);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$page = 'Borang Tempahan | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Sistem Cetakan Atas Talian - MPP CatS">
    <meta name="description" content="Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar, Kolej Vokasional Kuala Selangor">
    <link rel="shortcut icon" href="images/icon-mpp.png" type="image/x-icon">

    <!--==================CSS=================-->
    <link rel="stylesheet" href="styles/main-styles.css?v=<?php echo time(); ?>">

    <!--===============Bootstrap 5.2==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">

    <!--=============== BoxIcons ===============-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!--=============== Google Fonts ===============-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

    <title><?php echo $page; ?></title>

    <style>
        #pdf-container {
            display: flex;
            gap: 10px;
        }

        #pdf-preview {
            height: 80vh;
            width: 40%; /* Adjust to fill the container */
            overflow-y: auto;
            border: 1px solid black;
            padding: 10px;
            background-color: white;
            box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.4); 
        }

        .pdf-page {
            margin-bottom: 10px;
            padding: 10px;
            border: 1.5px solid black;
            border-radius: 5px;
            background-color: white;
        }

        #pdf-info {
            width: 35%;
            padding: 10px;
        }

        .btn-primary {
            background-color: transparent; 
            border: 2px solid black; 
            color: black; 
            padding: 5px 10px; 
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease; 
        }

        .btn-primary:hover {
            background-color: var(--main-purple2); 
            color: white; 
            border-color: var(--main-purple2); 
        }

        .btn-secondary {
            background-color: transparent; 
            border: 2px solid black; 
            color: black; 
            padding: 5px 10px; 
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease; 
        }

        .btn-secondary:hover {
            background-color: var(--red); 
            color: white; 
            border-color: var(--red); 
        }
        
        .small-input {
            width: 70%; 
            max-width: 200px; 
        }
    </style>
</head>
<body>
    
    <?php include 'includes/sidebar.php'; ?>

    <div class="container height-125">
        <br>
        <h3>Borang Tempahan</h3>
        <hr>
        <form action="backend/process-reservation.php" method="post" enctype="multipart/form-data" id="reservation-form">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="nama_penuh" class="form-label">Nama Penuh</label>
                <input type="text" class="form-control" id="nama_penuh" name="nama_penuh" value="<?php echo htmlspecialchars($user['nama_penuh']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="notel" class="form-label">No. Telefon</label>
                <input type="text" class="form-control" id="notel" name="notel" value="<?php echo htmlspecialchars($user['notel']); ?>" readonly>
            </div>
            <input type="hidden" class="form-control" id="nokp" name="nokp" value="<?php echo htmlspecialchars($user['nokp']); ?>" readonly>
            <div class="mb-3">
                <label for="reserve_date" class="form-label">Tarikh Tempahan</label>
                <input type="date" class="form-control small-input" id="reserve_date" name="reserve_date" required>
            </div>
            <div class="mb-3">
                <label for="reserve_time" class="form-label">Masa Tempahan</label>
                <input type="time" class="form-control small-input" id="reserve_time" name="reserve_time" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Masukkan Fail (PDF / PNG / JPEG / JPG)</label>
                <input type="file" class="form-control" id="file" name="file" accept=".pdf,.png,.jpg,.jpeg" required>
                <div id="pdf-container" style="margin-top: 10px;">
                    <div id="pdf-preview"></div>
                    <div id="pdf-info">
                        <h5>File Information</h5>
                        <hr>
                        <p>Colored Pages: <span id="colored-pages">0</span></p>
                        <p>Black & White Pages: <span id="bw-pages">0</span></p>
                        <b><p>Total Pages: <span id="total-pages">0</span></p></b>
                        <br><br>
                        <p style="color: red;"><b>Notice :</b> Make sure to reset first, before choosing new file*.<br> The system is still indevelop, sorry for all the inconvenience.</p>
                        <br>
                        <input type="hidden" name="status_tempahan" value="1">
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">Tempah</button>
                        <!-- Reset button -->
                        <button type="button" class="btn btn-secondary" id="reset-btn" style="margin-left: 10px;">Reset</button>
                    </div>
                    <div id="price-info" style="margin-top: 10px;">
                        <h5>Price Calculation</h5>
                        <hr>
                        <p>Price per Colored Page: RM 0.20</p>
                        <p>Price per Black & White Page: RM 0.10</p>
                        <b><p>Total Price: RM <span id="total-price">0.00</span></p></b>
                    </div>
                    <input type="hidden" name="colored_pages" id="hidden-colored-pages" value="0">
                    <input type="hidden" name="bw_pages" id="hidden-bw-pages" value="0">
                    <input type="hidden" name="total_pages" id="hidden-total-pages" value="0">
                    <input type="hidden" name="total_prices" id="hidden-total-prices" value="0.00">
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.7.107/pdf.min.js"></script>
    
    <script>
        document.getElementById('file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const pdfViewer = document.getElementById('pdf-preview');
            const pdfInfo = {
                totalPages: 0,
                coloredPages: 0,
                bwPages: 0
            };
            pdfViewer.innerHTML = ''; // Clear previous preview

            if (file && file.type === 'application/pdf') {
                const fileReader = new FileReader();
                fileReader.onload = function(e) {
                    const typedarray = new Uint8Array(e.target.result);
                    pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
                        pdfInfo.totalPages = pdf.numPages;
                        for (let i = 1; i <= pdf.numPages; i++) {
                            pdf.getPage(i).then(function(page) {
                                const viewport = page.getViewport({scale: 0.9});
                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;
                                pdfViewer.appendChild(canvas);

                                const renderTask = page.render({canvasContext: context, viewport: viewport});
                                renderTask.promise.then(function() {
                                    analyzeColor(context.getImageData(0, 0, canvas.width, canvas.height), pdfInfo);
                                });
                            });
                        }
                    });
                };
                fileReader.readAsArrayBuffer(file);
            } else if (file && (file.type === 'image/png' || file.type === 'image/jpeg' || file.type === 'image/jpg')) {
                const img = new Image();
                img.src = URL.createObjectURL(file);
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    context.drawImage(img, 0, 0);
                    pdfViewer.appendChild(canvas);

                    // Count this as a page
                    pdfInfo.totalPages = 1; // For single image file
                    analyzeColor(context.getImageData(0, 0, canvas.width, canvas.height), pdfInfo);
                };
            }

            function analyzeColor(imageData, pdfInfo) {
                const pixels = imageData.data;
                let isColored = false;

                for (let j = 0; j < pixels.length; j += 4) {
                    const r = pixels[j];
                    const g = pixels[j + 1];
                    const b = pixels[j + 2];

                    // Check if the pixel is colored
                    if (r !== g || g !== b || b !== r) {
                        isColored = true;
                        break;
                    }
                }

                if (isColored) {
                    pdfInfo.coloredPages++;
                } else {
                    pdfInfo.bwPages++;
                }

                // Update the page and price info
                document.getElementById('colored-pages').innerText = pdfInfo.coloredPages;
                document.getElementById('bw-pages').innerText = pdfInfo.bwPages;
                document.getElementById('total-pages').innerText = pdfInfo.totalPages;

                // Update hidden input values
                document.getElementById('hidden-colored-pages').value = pdfInfo.coloredPages;
                document.getElementById('hidden-bw-pages').value = pdfInfo.bwPages;
                document.getElementById('hidden-total-pages').value = pdfInfo.totalPages;

                updatePrice();
            }
        });

        function updatePrice() {
            const coloredPagePrice = 0.20;
            const bwPagePrice = 0.10;

            const coloredPages = parseInt(document.getElementById('colored-pages').innerText);
            const bwPages = parseInt(document.getElementById('bw-pages').innerText);

            const totalPrice = (coloredPages * coloredPagePrice) + (bwPages * bwPagePrice);
            document.getElementById('total-price').innerText = totalPrice.toFixed(2);

            // Update hidden input values
            document.getElementById('hidden-total-prices').value = totalPrice.toFixed(2);
        }

        // Reset button logic
        document.getElementById('reset-btn').addEventListener('click', function() {
            document.getElementById('pdf-preview').innerHTML = '';
            document.getElementById('file').value = '';

            document.getElementById('colored-pages').innerText = '0';
            document.getElementById('bw-pages').innerText = '0';
            document.getElementById('total-pages').innerText = '0';
            document.getElementById('total-price').innerText = '0.00';

            document.getElementById('hidden-colored-pages').value = '0';
            document.getElementById('hidden-bw-pages').value = '0';
            document.getElementById('hidden-total-pages').value = '0';
            document.getElementById('hidden-total-prices').value = '0.00';
        });

    </script>

</body>
</html>
