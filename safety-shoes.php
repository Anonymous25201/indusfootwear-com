<?php
include 'config.php';

// 1. Base Query: Fetch by Category 'Safety' OR Brand 'Safety'
$whereClauses = ["(c.name LIKE '%Safety%' OR b.name LIKE '%Safety%')"];

// 2. Sorting Logic
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC";
if($sortOption == 'price_low') $orderBy = "min_price ASC";
if($sortOption == 'price_high') $orderBy = "min_price DESC";

$sql = "SELECT p.*, b.name as brand_name, 
        (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE " . implode(' AND ', $whereClauses) . "
        ORDER BY $orderBy";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Shoes - Industrial Protection | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-100 theme-safety">
<?php include 'header.php'; ?>

    <!-- Hero Banner -->
    <div class="relative bg-slate-900 h-64 md:h-80 flex items-center justify-center overflow-hidden">
        <img src="assets/img/products/RHINO-01.jpg" alt="Safety Background" class="absolute inset-0 w-full h-full object-cover opacity-30 grayscale" onerror="this.src='https://placehold.co/1920x600/111/fff?text=Industrial+Zone'">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-transparent to-slate-900 opacity-90"></div>
        
        <!-- Caution Tape Effect -->
        <div class="absolute top-0 left-0 w-full h-2 bg-yellow-500 repeating-linear-gradient(45deg, transparent, transparent 10px, #000 10px, #000 20px)"></div>
        <div class="absolute bottom-0 left-0 w-full h-2 bg-yellow-500 repeating-linear-gradient(45deg, transparent, transparent 10px, #000 10px, #000 20px)"></div>

        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-3xl md:text-5xl font-black text-white tracking-widest uppercase drop-shadow-lg">Safety First</h1>
            <div class="inline-block bg-yellow-500 text-black font-bold px-3 py-1 mt-2 rounded text-sm md:text-base tracking-wide">INDUSTRIAL GRADE PROTECTION</div>
            <p class="text-slate-300 mt-2 text-lg">Steel Toe | Anti-Skid | Heavy Duty</p>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm text-gray-500">
                <a href="index.html" class="hover:text-slate-800">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-slate-800 font-semibold">Safety Shoes</span>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar (Static Info for Safety) -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-md sticky top-24 border border-slate-200">
                    <h3 class="font-bold text-lg mb-4 border-b pb-2 text-slate-800">Specifications</h3>
                    
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Standards</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span> IS 15298 Certified</li>
                            <li class="flex items-center"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span> Steel Toe Protection</li>
                            <li class="flex items-center"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span> Anti-Skid Sole</li>
                            <li class="flex items-center"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span> Oil & Acid Resistant</li>
                        </ul>
                    </div>

                    <a href="contact.html" class="block text-center w-full bg-slate-800 text-white py-2 rounded-md hover:bg-black transition shadow-md border border-slate-900">
                        Bulk Enquiry
                    </a>
                </div>
            </aside>

            <!-- Product Grid -->
            <main class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-500 text-sm">Showing <?php echo $result->num_rows; ?> Safety Products</p>
                    <form id="sortForm" method="GET">
                        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border-gray-300 rounded-md text-sm focus:ring-yellow-500 focus:border-yellow-500 p-2 border">
                            <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Newest</option>
                            <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 group border border-gray-200">
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                                <div class="aspect-[4/3] overflow-hidden bg-gray-100 relative">
                                    <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain group-hover:scale-110 transition-transform" onerror="this.src='https://placehold.co/400x400/f0f0f0/333?text=Safety+Shoe'">
                                    
                                    <!-- Steel Toe Badge -->
                                    <div class="absolute top-2 right-2 bg-yellow-500 text-black text-[10px] font-bold px-2 py-1 rounded shadow-sm">STEEL TOE</div>
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-slate-500 font-semibold uppercase"><?php echo $row['brand_name']; ?></p>
                                    <h3 class="text-slate-900 font-bold text-lg truncate"><?php echo $row['name']; ?></h3>
                                    <p class="text-slate-700 font-bold mt-1">₹<?php echo $row['min_price']; ?></p>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-10 text-gray-500">No safety products found.</div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
<?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>