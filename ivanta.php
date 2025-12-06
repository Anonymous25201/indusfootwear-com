<?php
include 'config.php';

// Filter by Brand 'IVANTA'
// Ensure the name matches exactly what is in your 'brands' table
$whereClauses = ["b.name = 'IVANTA'"];

$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC";
if($sortOption == 'price_low') $orderBy = "min_price ASC";
if($sortOption == 'price_high') $orderBy = "min_price DESC";

$sql = "SELECT p.*, b.name as brand_name, 
        (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        WHERE " . implode(' AND ', $whereClauses) . "
        ORDER BY $orderBy";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVANTA - Exclusive Loafers | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        /* Custom Theme for Ivanta - Luxurious dark theme */
        .theme-ivanta { background-color: #f8fafc; }
        .text-gold { color: #d4af37; }
        .bg-gold { background-color: #d4af37; }
        .border-gold { border-color: #d4af37; }
    </style>
</head>
<body class="bg-slate-50 theme-ivanta font-sans">

    <?php include 'header.php'; ?>

    <!-- Hero Banner -->
    <div class="relative bg-slate-900 h-80 flex items-center justify-center overflow-hidden">
        <!-- You might want to upload a specific banner for Ivanta -->
        <img src="https://placehold.co/1920x600/0f172a/d4af37?text=IVANTA+Loafers" alt="Ivanta Loafers" class="absolute inset-0 w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-slate-900 opacity-90"></div>
        
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-white tracking-widest uppercase mb-2">IVANTA</h1>
            <div class="w-24 h-1 bg-gold mx-auto mb-4"></div>
            <p class="text-slate-300 mt-2 font-light tracking-widest text-lg uppercase">The Art of Loafers</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <div class="max-w-3xl mx-auto text-center mb-16">
            <h2 class="text-3xl font-serif font-bold text-slate-800 mb-4">Exclusively Loafers</h2>
            <p class="text-slate-600 leading-relaxed text-lg">
                Discover the epitome of sophistication with IVANTA. A curated collection dedicated solely to premium loafers, crafted for the modern individual who values timeless style and unmatched comfort.
            </p>
        </div>

        <!-- Filters -->
        <div class="flex justify-end mb-8 border-b border-slate-200 pb-4">
            <form id="sortForm" method="GET">
                <select name="sort" onchange="document.getElementById('sortForm').submit()" class="block w-48 pl-3 pr-10 py-2 text-base border-slate-300 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm rounded-md shadow-sm bg-white cursor-pointer">
                    <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Newest</option>
                    <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                    <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                </select>
            </form>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="group bg-white rounded-none shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-100">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-50">
                            <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-700 group-hover:scale-105" onerror="this.src='https://placehold.co/400x400/f8fafc/333?text=Loafer'">
                            <!-- Elegant Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-5 transition-all duration-500"></div>
                        </div>
                        <div class="p-6 text-center">
                            <p class="text-xs text-gold font-bold tracking-widest uppercase mb-2">IVANTA</p>
                            <h3 class="text-slate-900 font-serif text-lg mb-2"><?php echo $row['name']; ?></h3>
                            <div class="text-slate-600 font-medium">
                                ₹<?php echo $row['min_price']; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full py-20 text-center">
                    <p class="text-xl text-slate-400 font-serif italic">Our exclusive collection is coming soon.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>