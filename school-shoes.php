<?php
include 'config.php';

// 1. Base Query: Fetch by Category 'School' OR Brand 'School'
$whereClauses = ["(c.name LIKE '%School%' OR b.name LIKE '%School%')"];

// Filter by Gender (Audience)
if (isset($_GET['gender'])) {
    $g = $conn->real_escape_string($_GET['gender']);
    $whereClauses[] = "a.name LIKE '%$g%'";
}

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
        LEFT JOIN audiences a ON p.audience_id = a.id
        WHERE " . implode(' AND ', $whereClauses) . "
        ORDER BY $orderBy";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Shoes - Durable & Comfortable | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom Cursor - Navy Blue Theme */
        body, a[href], button, .cursor-pointer { cursor: none !important; }
        @media (hover: none) { body, a[href], button, .cursor-pointer { cursor: auto !important; } #cursor-dot, #cursor-outline { display: none !important; } }
        #cursor-dot { position: fixed; top: 0; left: 0; width: 8px; height: 8px; background-color: rgba(30, 58, 138, 0.8); border-radius: 50%; pointer-events: none; z-index: 9999; transform: translate(-50%, -50%); transition: all 0.1s; }
        #cursor-outline { position: fixed; top: 0; left: 0; width: 40px; height: 40px; background-color: transparent; border: 2px solid rgba(30, 58, 138, 0.5); border-radius: 50%; pointer-events: none; z-index: 9999; transform: translate(-50%, -50%); transition: all 0.2s; }
        #cursor-dot.hover-link { width: 6px; height: 6px; }
        #cursor-outline.hover-link { width: 60px; height: 60px; background-color: rgba(30, 58, 138, 0.1); border-color: transparent; }
    </style>
</head>
<body class="bg-blue-50">

    <div id="cursor-dot"></div>
    <div id="cursor-outline"></div>

<?php include 'header.php' ?>
    <!-- Hero Banner -->
    <div class="relative bg-blue-900 h-64 md:h-80 flex items-center justify-center overflow-hidden">
        <img src="assets/img/school-bg.jpg" alt="School Background" class="absolute inset-0 w-full h-full object-cover opacity-40" onerror="this.src='https://placehold.co/1920x600/1e3a8a/white?text=Back+To+School'">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 via-transparent to-blue-900 opacity-80"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-widest uppercase drop-shadow-md">Smart Steps</h1>
            <p class="text-blue-100 mt-2 font-medium tracking-wide text-lg">Durable School Shoes for Active Kids</p>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm text-gray-500">
                <a href="index.html" class="hover:text-blue-800">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-blue-800 font-semibold">School Shoes</span>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Filters -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-24 border border-blue-100">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="font-bold text-lg text-blue-800">Filter</h3>
                        <a href="school-shoes.php" class="text-xs text-blue-500 hover:underline">Reset</a>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Gender</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>
                                <a href="school-shoes.php?gender=Boys" class="flex items-center <?php echo (isset($_GET['gender']) && $_GET['gender']=='Boys') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?>">
                                    <span class="w-4 h-4 border border-gray-300 rounded mr-2 inline-block"></span> Boys
                                </a>
                            </li>
                            <li>
                                <a href="school-shoes.php?gender=Girls" class="flex items-center <?php echo (isset($_GET['gender']) && $_GET['gender']=='Girls') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?>">
                                    <span class="w-4 h-4 border border-gray-300 rounded mr-2 inline-block"></span> Girls
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <main class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-500 text-sm">Showing <?php echo $result->num_rows; ?> Products</p>
                    <form id="sortForm" method="GET">
                        <?php if(isset($_GET['gender'])): ?><input type="hidden" name="gender" value="<?php echo $_GET['gender']; ?>"><?php endif; ?>
                        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                            <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Newest</option>
                            <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group border border-gray-100">
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                                <div class="aspect-[4/3] overflow-hidden bg-gray-50">
                                    <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain group-hover:scale-110 transition-transform" onerror="this.src='https://placehold.co/400x400/f0f0f0/333?text=School+Shoe'">
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-blue-600 font-semibold uppercase"><?php echo $row['brand_name']; ?></p>
                                    <h3 class="text-gray-900 font-medium"><?php echo $row['name']; ?></h3>
                                    <p class="text-gray-800 font-bold mt-1">Starting ₹<?php echo $row['min_price']; ?></p>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-10 text-gray-500">No school shoes found.</div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

   <?php 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
    <script>
        // Custom Cursor Logic
        const dot=document.getElementById('cursor-dot'),out=document.getElementById('cursor-outline');
        window.addEventListener('mousemove',e=>{if(dot){dot.style.left=`${e.clientX}px`;dot.style.top=`${e.clientY}px`;}if(out){out.style.left=`${e.clientX}px`;out.style.top=`${e.clientY}px`;}});
        document.querySelectorAll('a,button,input,select').forEach(el=>{el.addEventListener('mouseenter',()=>{dot.classList.add('hover-link');out.classList.add('hover-link')});el.addEventListener('mouseleave',()=>{dot.classList.remove('hover-link');out.classList.remove('hover-link')});});
    </script>
</body>
</html>