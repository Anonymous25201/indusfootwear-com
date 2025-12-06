<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-700 font-sans">

    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <div class="relative bg-teal-900 py-24 md:py-32">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://placehold.co/1920x600/115e59/ffffff?text=About+Indus+Footwear" alt="About Hero" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-4 tracking-wide">Our Story</h1>
            <p class="text-teal-100 text-lg md:text-xl max-w-2xl mx-auto font-light">Crafting comfort and style since 1999. A journey from humble beginnings to global footprints.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Our History Section -->
        <div class="flex flex-col md:flex-row items-center gap-12 mb-24">
            <div class="md:w-1/2">
                <div class="relative">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-teal-100 rounded-full z-0"></div>
                    <img src="https://placehold.co/600x400/f0fdfa/115e59?text=Our+History+Image" alt="Indus History" class="relative z-10 rounded-lg shadow-xl w-full object-cover h-80">
                </div>
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-6 relative inline-block">
                    Our History
                    <span class="absolute bottom-0 left-0 w-1/2 h-1 bg-teal-500 rounded"></span>
                </h2>
                <p class="mb-4 text-lg leading-relaxed text-gray-600">
                    Founded in 1999 in Khairthal, Rajasthan, by <strong>Mr. Mahesh Kumar Chachlani</strong>, Indus Footwear began with a singular focus on slipper distribution. Starting with a small, dedicated team and basic resources, we laid the foundation for quality and trust.
                </p>
                <p class="text-lg leading-relaxed text-gray-600">
                    Over time, we expanded our operations, adopting advanced machinery to revolutionize our manufacturing capabilities. In 2011, we introduced a new line of men's footwear, marking a pivotal phase in our growth. This expansion wasn't just local; we proudly took our brand international, establishing a strong presence in the Middle East while strengthening our roots in India.
                </p>
            </div>
        </div>

        <!-- Vision & Mission Section (Centered with Icon) -->
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-24 text-center border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-orange-50 rounded-full opacity-50"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-teal-50 rounded-full opacity-50"></div>
            
            <div class="relative z-10 max-w-4xl mx-auto">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-teal-100 text-teal-600 rounded-full mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-6">Our Vision & Mission</h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    Today, we serve diverse markets across the Middle East, Africa, and India, with ambitious plans for further global expansion. Our aim is to become one of India's largest and most trusted footwear brands, synonymous with high-quality, comfortable, and durable footwear.
                </p>
                <p class="text-lg text-gray-600 font-medium">
                    We prioritize innovation, sustainable practices, and meeting the evolving needs of our customers, continually pushing the boundaries of what's possible in the footwear industry.
                </p>
            </div>
        </div>

        <!-- Board of Directors Section -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">Leadership Team</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Indus Footwear is led by a dynamic and experienced Board of Directors, responsible for guiding the company’s strategic growth and vision.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text List -->
                <div class="order-2 lg:order-1">
                    <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-teal-500">
                        <ul class="space-y-6">
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-teal-100 flex items-center justify-center mt-1 mr-4">
                                    <span class="text-teal-600 text-xs font-bold">1</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800">Mr. Mahesh Kumar Chachlani</h4>
                                    <p class="text-teal-600 font-medium">Managing Director</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-teal-100 flex items-center justify-center mt-1 mr-4">
                                    <span class="text-teal-600 text-xs font-bold">2</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800">CA S.L. Agrawal</h4>
                                    <p class="text-teal-600 font-medium">CEO & Executive Director</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-teal-100 flex items-center justify-center mt-1 mr-4">
                                    <span class="text-teal-600 text-xs font-bold">3</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800">Mr. Sachin Chachlani</h4>
                                    <p class="text-teal-600 font-medium">Whole Time Director</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-teal-100 flex items-center justify-center mt-1 mr-4">
                                    <span class="text-teal-600 text-xs font-bold">4</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800">Mr. Anil Chachlani</h4>
                                    <p class="text-teal-600 font-medium">Whole Time Director</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-teal-100 flex items-center justify-center mt-1 mr-4">
                                    <span class="text-teal-600 text-xs font-bold">5</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800">Mr. Nikhil Chachlani</h4>
                                    <p class="text-teal-600 font-medium">International Sales Director</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Image Side -->
                <div class="order-1 lg:order-2">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-teal-900 rounded-lg transform translate-x-3 translate-y-3 transition-transform group-hover:translate-x-2 group-hover:translate-y-2"></div>
                        <img src="https://placehold.co/600x700/f3f4f6/374151?text=Board+of+Directors" alt="Board of Directors" class="relative z-10 w-full rounded-lg shadow-lg object-cover h-[500px] grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                    <p class="text-center text-sm text-gray-500 mt-4 italic">
                        The Board’s focus on innovation, quality, and market expansion has positioned Indus Footwear as a leading player in India’s footwear industry.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>