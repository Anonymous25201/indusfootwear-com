<?php
include 'config.php';

if (!isset($_GET['id'])) die("Product ID missing");
$id = intval($_GET['id']);

// Fetch Product
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
if (!$product || empty($product['catalogue_path'])) {
    die("Catalogue not found for this product.");
}

$error = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $pid = intval($_POST['product_id']);
    
    // Validation
    if (empty($name)) {
        $error = "Please enter your name.";
    } elseif (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
        $error = "Please enter a valid 10-digit phone number.";
    } else {
        // Save Request
        $stmt = $conn->prepare("INSERT INTO catalogue_requests (product_id, user_name, user_phone) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $pid, $name, $phone);
        
        if ($stmt->execute()) {
            // Success! Force Download
            $file = $product['catalogue_path'];
            if (file_exists($file)) {
                // Clear output buffer to avoid corrupt downloads
                if (ob_get_level()) ob_end_clean();
                
                header('Content-Description: File Transfer');
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            } else {
                $error = "File missing from server.";
            }
        } else {
            $error = "Database error. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Download Catalogue | <?php echo $product['name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-teal-100 text-teal-600 mb-4">
                <i class="fas fa-file-pdf text-xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Download Catalogue</h2>
            <p class="text-gray-500 mt-2 text-sm">Please enter your details to download the brochure for <strong><?php echo $product['name']; ?></strong></p>
        </div>

        <?php if(!empty($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded mb-6 text-sm">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Your Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-teal-500 focus:outline-none transition" placeholder="Enter full name">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" name="phone" required pattern="[0-9]{10}" class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-teal-500 focus:outline-none transition" placeholder="10-digit mobile number">
                <p class="text-xs text-gray-400 mt-1">We will only use this to contact you regarding your enquiry.</p>
            </div>

            <button type="submit" class="w-full bg-teal-600 text-white font-bold py-3 rounded-lg hover:bg-teal-700 transition duration-300 shadow-md flex items-center justify-center gap-2">
                Download Now <i class="fas fa-download"></i>
            </button>
        </form>
        
        <div class="text-center mt-6">
            <a href="product_detail.php?id=<?php echo $id; ?>" class="text-sm text-gray-500 hover:text-teal-600 font-medium">Cancel and go back</a>
        </div>
    </div>

</body>
</html>