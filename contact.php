<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-700 font-sans">

    <?php include 'header.php'; ?>

    <div class="relative bg-teal-900 py-20 md:py-28">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://placehold.co/1920x600/115e59/ffffff?text=Contact+Indus+Footwear" alt="Contact Hero" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4 tracking-wide">Get in Touch</h1>
            <p class="text-teal-100 text-lg max-w-2xl mx-auto font-light">We'd love to hear from you.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 -mt-16 relative z-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <!-- Contact Info Cards (Same as before) -->
                <div class="bg-white rounded-xl shadow-md p-8 border-l-4 border-teal-500">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Visit Us</h3>
                    <p class="text-gray-600 leading-relaxed">
                        <strong>Indus Footprints Limited</strong><br>
                        Khasra no 3851, near RIICO industrial Area,<br>
                        Khairthal, Rajasthan 301404<br>India
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-8 border-l-4 border-teal-500">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Contact Info</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Sales & Distribution</p>
                            <a href="mailto:sales@indusfootwear.com" class="text-teal-600 hover:text-teal-800 font-medium transition">sales@indusfootwear.com</a>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Phone</p>
                            <a href="tel:+919251954760" class="text-gray-700 hover:text-teal-600 transition">+91 9251954760</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-xl shadow-lg p-8 md:p-10">
                    <h2 class="text-2xl font-serif font-bold text-gray-900 mb-6">Send Us a Message</h2>
                    
                    <!-- Status Messages -->
                    <?php if(isset($_GET['status'])): ?>
                        <?php if($_GET['status'] == 'success'): ?>
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                                <p class="font-bold">Thank you!</p>
                                <p>Your message has been sent successfully. We will contact you shortly.</p>
                            </div>
                        <?php elseif($_GET['status'] == 'error'): ?>
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                                <p class="font-bold">Error!</p>
                                <p><?php echo isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'Something went wrong.'; ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form action="save_contact.php" method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3 px-4 bg-gray-50 border transition-colors hover:bg-white">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3 px-4 bg-gray-50 border transition-colors hover:bg-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3 px-4 bg-gray-50 border transition-colors hover:bg-white">
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <input type="text" name="subject" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3 px-4 bg-gray-50 border transition-colors hover:bg-white">
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="message" rows="5" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3 px-4 bg-gray-50 border transition-colors hover:bg-white"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-teal-600 text-white font-bold py-4 rounded-lg shadow-md hover:bg-teal-700 transition transform hover:-translate-y-0.5 active:translate-y-0">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>