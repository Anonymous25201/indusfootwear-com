<?php
include 'config.php';

// 1. Setup Query Logic (Flexible for 'Kids', 'Kids (Boys)', etc.)
$whereClauses = ["a.name LIKE '%Kids%'"];

if (isset($_GET['brand'])) $whereClauses[] = "p.brand_id = " . intval($_GET['brand']);
if (isset($_GET['cat'])) $whereClauses[] = "p.category_id = " . intval($_GET['cat']);

$whereSQL = "WHERE " . implode(' AND ', $whereClauses);

// Sorting
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC";
if($sortOption == 'price_low') $orderBy = "min_price ASC";
if($sortOption == 'price_high') $orderBy = "min_price DESC";

$sql = "SELECT p.*, b.name as brand_name, 
        (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        LEFT JOIN audiences a ON p.audience_id = a.id
        LEFT JOIN categories c ON p.category_id = c.id
        $whereSQL
        ORDER BY $orderBy";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kids' Collection | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-orange-50">

<?php include 'header.php'; ?>

    <!-- Banner -->
    <div class="relative h-64 bg-orange-100 flex items-center justify-center overflow-hidden">
        <img src="https://placehold.co/1920x400/fb923c/white?text=Kids+Banner" alt="Kids' Collection" class="absolute inset-0 w-full h-full object-cover opacity-70">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-900 via-transparent to-orange-900 opacity-70"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 tracking-widest uppercase shadow-sm">Kids' World</h1>
            <p class="text-gray-100 mt-2 font-semibold">Little Steps, Big Adventures</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-24 border border-orange-100">
                    <div class="flex justify-between items-center mb-4 border-b border-orange-100 pb-2">
                        <h3 class="font-bold text-lg text-orange-600">Filters</h3>
                        <a href="kids.php" class="text-xs text-orange-500 hover:underline">Reset</a>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Category</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <?php 
                            $c_res = $conn->query("SELECT * FROM categories");
                            while($c = $c_res->fetch_assoc()):
                                $act = (isset($_GET['cat']) && $_GET['cat'] == $c['id']) ? 'text-orange-500 font-bold' : 'hover:text-orange-500';
                            ?>
                            <li><a href="kids.php?cat=<?php echo $c['id']; ?>" class="flex items-center <?php echo $act; ?>"><span class="w-4 h-4 border border-gray-300 rounded mr-2 inline-block"></span> <?php echo $c['name']; ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Brand</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <?php 
                            $b_res = $conn->query("SELECT * FROM brands");
                            while($b = $b_res->fetch_assoc()):
                                $act = (isset($_GET['brand']) && $_GET['brand'] == $b['id']) ? 'text-orange-500 font-bold' : 'hover:text-orange-500';
                            ?>
                            <li><a href="kids.php?brand=<?php echo $b['id']; ?>" class="flex items-center <?php echo $act; ?>"><span class="w-4 h-4 border border-gray-300 rounded mr-2 inline-block"></span> <?php echo $b['name']; ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Grid -->
            <main class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-500 text-sm">Showing <?php echo $result->num_rows; ?> Products</p>
                    <form id="sortForm" method="GET">
                        <?php if(isset($_GET['cat'])): ?><input type="hidden" name="cat" value="<?php echo $_GET['cat']; ?>"><?php endif; ?>
                        <?php if(isset($_GET['brand'])): ?><input type="hidden" name="brand" value="<?php echo $_GET['brand']; ?>"><?php endif; ?>
                        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border-gray-300 rounded-md text-sm focus:ring-orange-500 focus:border-orange-500 p-2 border">
                            <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Newest</option>
                            <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group">
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                                <div class="aspect-[4/3] overflow-hidden">
                                    <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-orange-500 font-semibold uppercase"><?php echo $row['brand_name']; ?></p>
                                    <h3 class="text-gray-900 font-medium"><?php echo $row['name']; ?></h3>
                                    <p class="text-gray-800 font-bold mt-1">₹<?php echo $row['min_price']; ?></p>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-10 text-gray-500">No kids' products found.</div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
<?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>