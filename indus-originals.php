<?php
include 'config.php';

$whereClauses = ["b.name = 'Indus Originals'"];

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
    <title>Indus Originals - Timeless Fashion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-rose-50 theme-rose">

    <?php include 'header.php'; ?>

    <div class="relative bg-rose-900 h-64 md:h-80 flex items-center justify-center overflow-hidden">
        <img src="assets/img/indusoriginals-bg.jpg" alt="Indus Originals Background" class="absolute inset-0 w-full h-full object-cover opacity-40" onerror="this.src='https://placehold.co/1920x600/881337/white?text=Elegant+Pattern'">
        <div class="absolute inset-0 bg-gradient-to-r from-rose-900 via-transparent to-rose-900 opacity-80"></div>
        
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
                <div class="inline-block bg-white/90 p-3 rounded-lg mb-4 shadow-lg">
                <img src="assets/img/indus-logonew.png" alt="Indus Originals Logo" class="h-20 md:h-24 w-auto object-contain">
            </div>
            <h1 class="text-3xl md:text-5xl font-serif text-white tracking-widest italic drop-shadow-md">Timeless Elegance</h1>
            <p class="text-rose-200 mt-2 font-medium tracking-wide text-lg">Fashion That Never Fades</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Crafted for Her</h2>
            <p class="text-gray-600 leading-relaxed">
                Indus Originals embodies our heritage of blending fashion with function. Discover our exclusive collection of Ladies' PU footwear.
            </p>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 sticky top-20 bg-rose-50 z-30 py-4 border-b border-gray-200 md:border-none">
            <div class="w-full md:w-auto ml-auto">
                <form id="sortForm" method="GET">
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="block w-full md:w-48 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm rounded-md shadow-sm bg-white cursor-pointer">
                        <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Featured</option>
                        <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-transparent hover:border-rose-100">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                        <div class="relative aspect-[4/3] overflow-hidden bg-white">
                            <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110" onerror="this.src='https://placehold.co/400x400/fdf2f8/333?text=Product'">
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-rose-600 font-semibold tracking-wider uppercase mb-1"><?php echo $row['brand_name']; ?></p>
                            <h3 class="text-gray-900 font-medium text-sm md:text-base mb-2 line-clamp-1"><?php echo $row['name']; ?></h3>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">₹<?php echo $row['min_price']; ?></span>
                                <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-rose-100 hover:text-rose-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12 text-gray-500">No products found for Indus Originals.</div>
            <?php endif; ?>
        </div>
    </div>
  
    <?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>