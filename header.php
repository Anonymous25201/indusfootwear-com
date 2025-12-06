<!-- Header/Navbar -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div id="preloader" class="fixed inset-0 bg-white flex items-center justify-center z-[100] transition-opacity duration-500 ease-out">
        <img class="logo-preloader w-48 h-auto" src="assets/img/indus-logo.png" alt="Indus Logo" onerror="this.src='https://placehold.co/192x100/ffffff/333333?text=Indus+Logo'">
    </div>
    <div id="cursor-dot"></div>
    <div id="cursor-outline"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="index.php">
                    <img class="h-14 w-auto" src="assets/img/indus-logo.png" alt="Indus Footwear" onerror="this.src='https://placehold.co/150x56/ffffff/333333?text=Indus+Logo'">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8 items-center" id="desktop-menu">
                <a href="index.php" class="nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-cyan-500 hover:text-gray-900 transition-all duration-300">Home</a>
                
                <!-- Shop Dropdown -->
                <div class="relative group">
                    <div class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 group-hover:border-cyan-500 group-hover:text-gray-900 transition-all duration-300 cursor-default">
                        <span>Shop</span>
                        <svg class="ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="absolute left-0 z-10 mt-0 w-auto bg-white shadow-lg rounded-md hidden group-hover:block ring-1 ring-black ring-opacity-5 opacity-0 group-hover:opacity-100 transition-all ease-in-out duration-150">
                        <div class="flex">
                            <div class="p-4 border-r border-gray-100 w-48">
                                <h3 class="font-semibold text-gray-900 mb-2">Men</h3>
                                <a href="men-pu-slippers.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">PU Slippers</a>
                                <a href="men-eva-sports.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">EVA & Sports</a>
                                <a href="men-hawai-fabrication.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">Hawai & Fab</a>
                                <a href="safety-shoes.php" class="block px-4 py-2 text-sm text-cyan-600 font-semibold hover:bg-gray-100 hover:text-cyan-700 rounded-md">Safety Shoes</a>
                            </div>
                            <div class="p-4 border-r border-gray-100 w-48">
                                <h3 class="font-semibold text-gray-900 mb-2">Women</h3>
                                <a href="women-pu-slippers.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">PU Slippers</a>
                                <a href="women-eva.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">EVA & Sandals</a>
                                <a href="women-hawai-fabrication.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">Hawai & Fab</a>
                            </div>
                            <div class="p-4 w-48">
                                <h3 class="font-semibold text-gray-900 mb-2">Kids</h3>
                                <a href="school-shoes.php" class="block px-4 py-2 text-sm text-cyan-600 font-semibold hover:bg-gray-100 hover:text-cyan-700 rounded-md">School Shoes</a>
                                <a href="kids-pu-slippers.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">PU Slippers</a>
                                <a href="kids-eva-sports.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">EVA & Sports</a>
                                <a href="kids-hawai-fabrication.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">Hawai & Fab</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Brands Dropdown -->
                <div class="relative group">
                    <div class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 group-hover:border-cyan-500 group-hover:text-gray-900 transition-all duration-300 cursor-default">
                        <span>Brands</span>
                        <svg class="ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="absolute left-0 z-10 mt-0 w-48 bg-white shadow-lg rounded-md hidden group-hover:block ring-1 ring-black ring-opacity-5 opacity-0 group-hover:opacity-100 transition-all ease-in-out duration-150">
                        <div class="py-1">
                            <a href="indus-gold.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Indus Gold</a>
                            <a href="indus-lite.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Induslite</a>
                            <a href="indus-prime.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Indus Prime</a>
                            <a href="indus-originals.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Indus Originals</a>
                            <a href="ivanta.php" class="block px-4 py-2 text-sm text-teal-700 font-semibold hover:bg-gray-100">IVANTA</a>
                        </div>
                    </div>
                </div>

                <a href="about.php" class="nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-cyan-500 hover:text-gray-900 transition-all duration-300">About Us</a>
                <a href="contact.php" class="nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-cyan-500 hover:text-gray-900 transition-all duration-300">Contact Us</a>
                
                <a href="https://wa.me/919251954762" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-cyan-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-cyan-700 transition-all duration-300 shadow-lg ml-4">
                    <span>Enquire Now</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button type="button" id="mobile-menu-button" class="ml-3 p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="index.php" class="mobile-link block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50">Home</a>
            
            <!-- Mobile Shop Dropdown -->
            <button class="mobile-menu-dropdown-toggle flex justify-between items-center w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50">
                <span>Shop</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 8.293a1 1 0 011.414 0L10 9.586l1.293-1.293a1 1 0 111.414 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div class="mobile-menu-dropdown-content hidden mt-1 space-y-1 bg-gray-50">
                <a href="men-pu-slippers.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Men's PU Slippers</a>
                <a href="men-eva-sports.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Men's EVA & Sports</a>
                <a href="men-hawai-fabrication.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Men's Hawai & Fab</a>
                <a href="safety-shoes.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Safety Shoes</a>
                <a href="women-pu-slippers.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Women's PU</a>
                <a href="women-eva.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Women's EVA</a>
                <a href="women-hawai-fabrication.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Women's Hawai</a>
                <a href="school-shoes.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">School Shoes</a>
                <a href="kids-pu-slippers.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Kids PU Slippers</a>
                <a href="kids-eva-sports.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Kids EVA</a>
                <a href="kids-hawai-fabrication.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Kids Hawai</a>
            </div>

            <!-- Mobile Brands Dropdown -->
            <button class="mobile-menu-dropdown-toggle flex justify-between items-center w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50">
                <span>Brands</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 8.293a1 1 0 011.414 0L10 9.586l1.293-1.293a1 1 0 111.414 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div class="mobile-menu-dropdown-content hidden mt-1 space-y-1 bg-gray-50">
                <a href="indus-gold.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Indus Gold</a>
                <a href="indus-lite.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Induslite</a>
                <a href="indus-prime.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Indus Prime</a>
                <a href="indus-originals.php" class="block pl-8 pr-4 py-2 text-sm text-gray-600">Indus Originals</a>
                <a href="ivanta.php" class="block pl-8 pr-4 py-2 text-sm text-teal-700">IVANTA</a>
            </div>

            <a href="about.php" class="mobile-link block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50">About Us</a>
            <a href="contact.php" class="mobile-link block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50">Contact Us</a>
        </div>
    </div>
</nav>