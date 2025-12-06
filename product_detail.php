<?php
include 'config.php';

if (!isset($_GET['id'])) die("Product ID missing");
$id = intval($_GET['id']);

$product = $conn->query("SELECT p.*, b.name as brand_name, c.name as cat_name FROM products p LEFT JOIN brands b ON p.brand_id = b.id LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id")->fetch_assoc();
if (!$product) die("Product not found");

// Fetch Variants
$variants = $conn->query("SELECT * FROM product_variants WHERE product_id = $id ORDER BY mrp ASC");
$variantData = [];
while($v = $variants->fetch_assoc()) { $variantData[] = $v; }

// Fetch Images
$images = $conn->query("SELECT * FROM product_images WHERE product_id = $id");
$imageData = [];
while($img = $images->fetch_assoc()) { 
    $imageData[] = $img;
}

// Unique Sizes
$uniqueSizes = [];
foreach($variantData as $v) {
    $uniqueSizes[$v['size']] = $v['mrp'];
}

// Identify unique colors
$availableColors = [];
foreach($imageData as $img) {
    if(!empty($img['color']) && !in_array($img['color'], $availableColors)) {
        $availableColors[] = $img['color'];
    }
}

// Initial WhatsApp Logic (Default)
$adminPhone = "919876543210"; 
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$imageLink = "http://$_SERVER[HTTP_HOST]/" . $product['image_path'];

// Base message without specific selection
$waMessage = "*Enquiry for Product*\n";
$waMessage .= "Name: " . $product['name'] . "\n";
$waMessage .= "Link: " . $currentURL . "\n";
$waMessage .= "Image: " . $imageLink;

$defaultWaLink = "https://wa.me/$adminPhone?text=" . urlencode($waMessage);

// QR Code Data String
$minP = !empty($uniqueSizes) ? min($uniqueSizes) : 0;
$maxP = !empty($uniqueSizes) ? max($uniqueSizes) : 0;
$priceStr = ($minP == $maxP) ? "Rs. $minP" : "Rs. $minP - $maxP";

$qrContent = "Product Details:\nName: " . $product['name'] . "\nBrand: " . $product['brand_name'] . "\nPrice: " . $priceStr . "\nLink: " . $currentURL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        .active-size { background-color: #111827; color: white; border-color: #111827; }
        .active-color { ring-width: 2px; ring-color: #0d9488; border-color: #0d9488; background-color: #f0fdfa; color: #0f766e; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <?php include 'header.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <button onclick="history.back()" class="text-gray-500 hover:text-teal-600 mb-4 inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </button>
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-6xl mx-auto">
            <div class="md:flex">
                
                <!-- LEFT: IMAGE GALLERY -->
                <div class="md:w-1/2 p-4 bg-gray-50">
                    <div class="aspect-square bg-white rounded-lg overflow-hidden mb-4 border border-gray-200 relative shadow-sm">
                        <img id="mainImage" src="<?php echo $product['image_path']; ?>" class="w-full h-full object-contain p-2" crossorigin="anonymous">
                        <div id="imageColorLabel" class="absolute bottom-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded hidden"></div>
                    </div>
                    
                    <!-- Thumbnails -->
                    <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide" id="galleryContainer">
                        <?php if(empty($imageData)): ?>
                            <img onclick="changeImage(this.src, 'Default')" src="<?php echo $product['image_path']; ?>" class="w-20 h-20 object-contain bg-white rounded border cursor-pointer hover:border-teal-500 transition flex-shrink-0" crossorigin="anonymous">
                        <?php endif; ?>
                        
                        <?php foreach($imageData as $img): ?>
                            <div class="relative group flex-shrink-0 cursor-pointer" 
                                 onclick="changeImage('<?php echo $img['image_path']; ?>', '<?php echo $img['color']; ?>')">
                                <img src="<?php echo $img['image_path']; ?>" 
                                     data-color="<?php echo $img['color']; ?>"
                                     class="gallery-item w-20 h-20 object-contain bg-white rounded border hover:border-teal-500 transition" crossorigin="anonymous">
                                <span class="absolute bottom-0 left-0 right-0 bg-gray-800 text-white text-[10px] text-center opacity-75 truncate px-1">
                                    <?php echo $img['color']; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- RIGHT: PRODUCT INFO -->
                <div class="md:w-1/2 p-8 relative">
                    <span class="text-teal-600 font-bold uppercase tracking-wider text-xs"><?php echo $product['brand_name']; ?></span>
                    
                    <div class="flex justify-between items-start">
                        <h1 class="text-3xl font-bold text-gray-900 mt-1 mb-2"><?php echo $product['name']; ?></h1>
                        <button onclick="toggleQRCode()" class="text-gray-400 hover:text-gray-600" title="Show QR Code">
                            <i class="fas fa-qrcode text-2xl"></i>
                        </button>
                    </div>

                    <div id="qr-container" class="hidden absolute top-20 right-8 bg-white p-4 shadow-xl border border-gray-200 rounded-lg z-10 text-center">
                        <div id="qrcode" class="mb-2"></div>
                        <p class="text-xs text-gray-500 mb-2">Scan for details</p>
                        <button id="pdfBtn" onclick="downloadPDF()" class="text-xs bg-teal-600 text-white px-2 py-1 rounded hover:bg-teal-700">Download Full PDF</button>
                    </div>
                    
                    <div class="text-4xl font-bold text-gray-900 mb-6" id="priceDisplay">
                        <?php echo $priceStr; ?>
                    </div>

                    <!-- AVAILABLE COLORS -->
                    <?php if(!empty($availableColors)): ?>
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase">Available Colors</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach($availableColors as $col): ?>
                                <button onclick="filterImages('<?php echo $col; ?>', this)" class="color-btn px-3 py-1 border rounded text-sm font-medium hover:border-teal-500 transition uppercase">
                                    <?php echo $col; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- SIZE SELECTION -->
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase">Select Size</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach($uniqueSizes as $size => $price): ?>
                                <button onclick="selectSize('<?php echo $size; ?>', <?php echo $price; ?>, this)" 
                                        class="size-btn w-12 h-12 flex items-center justify-center border border-gray-300 rounded-md text-sm font-bold hover:border-gray-800 transition">
                                    <?php echo $size; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- ENQUIRY BUTTON -->
                    <div class="space-y-3">
                        <!-- ID added to button for JS targeting -->
                        <a id="waEnquiryBtn" href="<?php echo $defaultWaLink; ?>" target="_blank" class="block w-full bg-slate-900 text-white text-center py-4 rounded-lg font-bold hover:bg-slate-800 transition shadow-lg transform active:scale-95">
                            <i class="fab fa-whatsapp mr-2 text-xl"></i> Enquire Now
                        </a>
                        
                        <?php if(!empty($product['catalogue_path'])): ?>
                        <a href="download_catalogue.php?id=<?php echo $id; ?>" class="block w-full bg-white border-2 border-teal-600 text-teal-700 text-center py-3 rounded-lg font-bold hover:bg-teal-50 transition shadow-sm">
                            <i class="fas fa-file-pdf mr-2"></i> Download Catalogue
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Store current selections
        let selectedSize = null;
        let selectedColor = null;
        const productName = "<?php echo $product['name']; ?>";
        const productLink = "<?php echo $currentURL; ?>";
        const adminPhone = "<?php echo $adminPhone; ?>";

        function updateWhatsAppLink() {
            let message = "*Enquiry for Product*\n";
            message += "Name: " + productName + "\n";
            
            if(selectedSize) {
                message += "Selected Size: " + selectedSize + "\n";
            }
            if(selectedColor) {
                message += "Selected Color: " + selectedColor + "\n";
            }
            
            message += "Link: " + productLink;
            
            const newHref = "https://wa.me/" + adminPhone + "?text=" + encodeURIComponent(message);
            document.getElementById('waEnquiryBtn').href = newHref;
        }

        function changeImage(src, colorName) {
            document.getElementById('mainImage').src = src;
            const label = document.getElementById('imageColorLabel');
            if(colorName && colorName !== 'Default') {
                label.innerText = colorName;
                label.classList.remove('hidden');
                // Auto-select color when image clicked
                // But we don't want to break the UI button state unless necessary
            } else {
                label.classList.add('hidden');
            }
        }

        function selectSize(size, price, btn) {
            document.getElementById('priceDisplay').innerText = "Rs. " + price;
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active-size'));
            btn.classList.add('active-size');
            
            // Update State & Link
            selectedSize = size;
            updateWhatsAppLink();
        }

        function filterImages(color, btn) {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active-color'));
            btn.classList.add('active-color');

            const images = document.querySelectorAll('.gallery-item');
            const wrappers = document.querySelectorAll('.group.flex-shrink-0');
            let foundFirst = false;

            wrappers.forEach(wrapper => {
                const img = wrapper.querySelector('img');
                const imgColor = img.getAttribute('data-color');
                if (imgColor === color) {
                    wrapper.style.display = 'block';
                    if (!foundFirst) {
                        changeImage(img.src, color);
                        foundFirst = true;
                    }
                } else {
                    wrapper.style.display = 'none';
                }
            });
            
            // Update State & Link
            selectedColor = color;
            updateWhatsAppLink();
        }

        // --- PDF & QR Logic from previous steps (Kept same) ---
        const pdfData = {
            name: "<?php echo $product['name']; ?>",
            brand: "<?php echo $product['brand_name']; ?>",
            category: "<?php echo $product['cat_name']; ?>",
            mainImage: "<?php echo $product['image_path']; ?>", 
            colors: <?php echo json_encode($availableColors); ?>,
            sizes: <?php echo json_encode($uniqueSizes); ?>,
            images: <?php echo json_encode($imageData); ?>,
            link: "<?php echo $currentURL; ?>"
        };

        function removePreloader() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(() => { preloader.style.display = 'none'; }, 500);
            }
        }
        document.addEventListener("DOMContentLoaded", removePreloader);
        window.addEventListener("load", removePreloader);
        setTimeout(removePreloader, 2000);

        let qrGenerated = false;
        const qrContainer = document.getElementById('qr-container');
        function toggleQRCode() {
            qrContainer.classList.toggle('hidden');
            if (!qrGenerated) {
                const qrText = <?php echo json_encode($qrContent); ?>;
                new QRCode(document.getElementById("qrcode"), {
                    text: qrText, width: 128, height: 128,
                    colorDark : "#000000", colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.M 
                });
                qrGenerated = true;
            }
        }

        async function downloadPDF() {
            const btn = document.getElementById('pdfBtn');
            btn.innerText = "Generating...";
            btn.disabled = true;
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const margin = 20;
            const pageWidth = doc.internal.pageSize.getWidth();
            const maxContentWidth = pageWidth - (margin * 2);
            let currentY = 20;

            doc.setFontSize(24); doc.setFont("helvetica", "bold");
            doc.text(pdfData.name, margin, currentY); currentY += 10;
            doc.setFontSize(16); doc.setFont("helvetica", "normal"); doc.setTextColor(100);
            doc.text(pdfData.brand + " - " + pdfData.category, margin, currentY); currentY += 15;

            try {
                const mainImgBase64 = await toBase64(pdfData.mainImage);
                const imgProps = doc.getImageProperties(mainImgBase64);
                const pdfHeight = (imgProps.height * maxContentWidth) / imgProps.width;
                doc.addImage(mainImgBase64, 'JPEG', margin, currentY, maxContentWidth, pdfHeight);
                currentY += pdfHeight + 15;
            } catch (e) { console.error("Main image load failed", e); }

            doc.setTextColor(0); doc.setFontSize(14); doc.setFont("helvetica", "bold");
            doc.text("Product Details", margin, currentY); currentY += 8;
            doc.setFontSize(11); doc.setFont("helvetica", "normal");
            
            doc.text("Sizes & Prices:", margin, currentY); currentY += 6;
            for (const [size, price] of Object.entries(pdfData.sizes)) {
                if (currentY > 280) { doc.addPage(); currentY = 20; }
                doc.text(`- Size ${size}: Rs. ${price}`, margin + 5, currentY); currentY += 6;
            }
            
            if (currentY > 280) { doc.addPage(); currentY = 20; }
            currentY += 5; doc.setTextColor(0, 0, 255);
            doc.text("View Product Online", margin, currentY);
            doc.link(margin, currentY - 5, 50, 10, { url: pdfData.link });
            doc.setTextColor(0); currentY += 10;

            doc.setFontSize(14); doc.setFont("helvetica", "bold");
            if (currentY > 260) { doc.addPage(); currentY = 20; }
            doc.text("Color Variants", margin, currentY); currentY += 10;

            const colWidth = (maxContentWidth / 3) - 5; 
            const rowHeight = 60; 
            let colIndex = 0;

            for (const imgObj of pdfData.images) {
                try {
                    const imgBase64 = await toBase64(imgObj.image_path);
                    const imgProps = doc.getImageProperties(imgBase64);
                    const ratio = imgProps.width / imgProps.height;
                    let drawW = colWidth; let drawH = colWidth / ratio;
                    if (drawH > 50) { drawH = 50; drawW = 50 * ratio; }

                    if (currentY + rowHeight > 280) { doc.addPage(); currentY = 20; colIndex = 0; }
                    const xPos = margin + (colIndex * (colWidth + 5));
                    doc.addImage(imgBase64, 'JPEG', xPos, currentY, drawW, drawH);
                    doc.setFontSize(9); doc.setFont("helvetica", "normal");
                    doc.text(imgObj.color || "View", xPos, currentY + drawH + 5);

                    colIndex++; if (colIndex >= 3) { colIndex = 0; currentY += rowHeight; }
                } catch (e) { console.log("Skipped an image"); }
            }
            doc.save(pdfData.name.replace(/ /g, "_") + "_Full_Catalogue.pdf");
            btn.innerText = "Download Full PDF"; btn.disabled = false;
        }

        function toBase64(url) {
            return new Promise((resolve, reject) => {
                const img = new Image(); img.crossOrigin = "Anonymous"; img.src = url;
                img.onload = () => {
                    const canvas = document.createElement("canvas"); canvas.width = img.naturalWidth; canvas.height = img.naturalHeight;
                    const ctx = canvas.getContext("2d"); ctx.fillStyle = "#ffffff"; ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0); resolve(canvas.toDataURL("image/jpeg"));
                }; img.onerror = reject;
            });
        }
    </script>
</body>
</html>