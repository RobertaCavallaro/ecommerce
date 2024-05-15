<?php

include 'connect.php';
function createProductsTable($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS products (
            product_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            image_url VARCHAR(255),
            stock INT NOT NULL DEFAULT 0,
            season ENUM('summer', 'spring', 'autumn', 'winter') NOT NULL,
            gender ENUM('male', 'female', 'unisex') NOT NULL,
            full_description VARCHAR(600) NOT NULL,
            category VARCHAR(60) NOT NULL,
            weight VARCHAR(60) NOT NULL,
            dimensions VARCHAR(60) NOT NULL,
            materials VARCHAR(60) NOT NULL,
            color VARCHAR(60) NOT NULL
            )";

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Products table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating products table:  $conn->error . \n');</script>";
    }
}

function createCartTable($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS cart (
            cart_id INT AUTO_INCREMENT PRIMARY KEY,
            customer_id VARCHAR(255) NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            added_on DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(product_id)
            )";

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Cart table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating cart table: " . $conn->error . "');</script>";
    }
}


function createCustomersTable($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS customers (
            customer_id VARCHAR(255) PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
            )";

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Customers table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating Customers table:  $conn->error . ');</script>";
    }
}


// Add more fields here as per your e-commerce needs
function createOrdersTable($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS orders (
            order_id INT AUTO_INCREMENT PRIMARY KEY,
            customer_id VARCHAR(255) NOT NULL,
            order_date DATETIME NOT NULL,
            total_amount DECIMAL(10,2) NOT NULL,
            payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending'
            )";
    // ... (more fields for shipping, billing, etc.)

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Orders table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating Orders table: $conn->error .');</script>";
    }

}
function createAddressTable($conn)
{
    $sql = "
            CREATE TABLE IF NOT EXISTS addresses (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                customer_id VARCHAR(255) NOT NULL,
                fullname VARCHAR(255) NOT NULL,
                address_line1 VARCHAR(255) NOT NULL,
                address_line2 VARCHAR(255),
                city VARCHAR(100) NOT NULL,
                state VARCHAR(100) NOT NULL,
                zip_code INT(11) NOT NULL,
                country VARCHAR(100) NOT NULL
            )";
    // ... (more fields for shipping, billing, etc.)

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Address table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating Address table: $conn->error .');</script>";
    }
}

function createOrderItems($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS order_items (
            item_id INT(11) AUTO_INCREMENT PRIMARY KEY,
            order_id INT(11) NOT NULL,
            product_id INT(11) NOT NULL,
            quantity INT(11) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
        )";
    // ... (more fields for shipping, billing, etc.)

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Orders Items table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating Orders Items table: $conn->error .');</script>";
    }
}

function createProducts($conn)
{
    // Check if the products table is empty
    $checkQuery = "SELECT COUNT(*) as count FROM products";
    $checkResult = $conn->query($checkQuery);
    $row = $checkResult->fetch_assoc();

    if ($row['count'] == 0) {
        // Prepare SQL to insert multiple products
        $sql = "INSERT INTO products (
                                        name,
                                        description,
                                        price,
                                        image_url,
                                        stock,
                                        season,
                                        gender,
                                        full_description,
                                        category,
                                        weight,
                                        dimensions,
                                        materials,
                                        color
                                    ) VALUES
                                    ('Trekking Backpack', 'A durable and spacious backpack ideal for long treks.', 99.99, 'images/backpack.jpg', 10, 'autumn', 'unisex', 
                                    'This high-capacity trekking backpack is designed for multi-day adventures. It features a durable water-resistant exterior, multiple compartments for organization, and a comfortable padded back panel and shoulder straps for carrying heavy loads. With a large main compartment and numerous pockets, this backpack allows you to keep all your essential gear organized and easily accessible during your hike.',
                                    'Backpacks', '2.5 kg', '55 x 35 x 25 cm', 'Nylon, Polyester', 'Black'),
                                    ('Hiking Boots', 'Waterproof and sturdy boots for all terrains.', 149.99, 'images/boots.jpg', 10, 'autumn', 'unisex', 
                                    'These hiking boots are built for comfort and durability, offering support and protection on any terrain. Featuring a waterproof membrane to keep your feet dry, a sturdy outsole for excellent traction, and a padded collar and tongue for maximum comfort, these boots are perfect for long hikes and challenging trails.',
                                    'Boots', '1.2 kg', '30 x 20 x 10 cm', 'Leather, Synthetic', 'Brown'),
                                    ('Trekking Poles', 'Lightweight and adjustable trekking poles.', 39.99, 'images/poles.jpg', 15, 'summer', 'unisex', 
                                    'These trekking poles provide stability and reduce strain on your joints, making hiking easier and more enjoyable. Featuring a lightweight aluminum construction, adjustable length, and comfortable grips, these poles are perfect for all levels of hikers.',
                                    'Trekking Poles', '0.5 kg', '65 x 10 x 10 cm', 'Aluminum, Rubber', 'Black'),
                                    ('Waterproof Jacket', 'Breathable, waterproof jacket for all-weather protection.', 129.99, 'images/jacket.jpg', 12, 'winter', 'unisex', 
                                    'Stay dry and comfortable in any weather with this breathable and waterproof jacket. Featuring a durable water-resistant outer layer, sealed seams, and a comfortable fleece lining, this jacket offers excellent protection from rain, snow, and wind. With adjustable hood and cuffs, it provides a customized fit for maximum comfort.',
                                    'Jackets', '0.7 kg', '60 x 45 x 10 cm', 'Nylon, Polyester', 'Blue'),
                                    ('Camping Tent', 'Compact and lightweight tent suitable for 3 persons.', 250.00, 'images/tent.jpg', 8, 'summer', 'unisex', 
                                    'This compact and lightweight tent is perfect for camping trips with friends or family. It features a spacious interior with enough room for three people, a waterproof flysheet for protection from rain and wind, and a durable construction for stability. With a quick and easy setup, this tent is a convenient choice for any camping adventure.',
                                    'Tents', '3.5 kg', '50 x 25 x 15 cm', 'Polyester, Nylon', 'Green'),
                                    ('Sleeping Bag', 'Comfortable sleeping bag for cold conditions.', 70.00, 'images/sleepingbag.jpg', 10, 'winter', 'unisex', 
                                    'This comfortable sleeping bag is designed for cold weather conditions. Featuring a high-quality synthetic fill for warmth and a water-resistant outer layer for protection, this sleeping bag provides a cozy and comfortable night''s sleep. With a snug fit for warmth and a convenient carrying bag, it''s an essential item for any camping trip.',
                                    'Sleeping Bags', '1.5 kg', '50 x 20 x 15 cm', 'Polyester, Nylon', 'Red'),
                                    ('Portable Stove', 'Portable and efficient stove for cooking outdoors.', 45.00, 'images/stove.jpg', 20, 'autumn', 'unisex',
                                    'This portable and efficient stove is perfect for cooking meals on your camping trips. It features a compact design for easy storage and transport, a powerful flame for quick cooking, and a wind shield for stability. With a durable construction and easy-to-use controls, this stove is a reliable companion for any outdoor adventure.',
                                    'Stoves', '0.8 kg', '20 x 15 x 10 cm', 'Stainless Steel', 'Silver'),
                                    ('Trekking Socks', 'Warm and durable socks for long treks.', 12.99, 'images/socks.jpg', 50, 'winter', 'unisex', 
                                    'These trekking socks are designed for comfort and durability on long hikes. Featuring a blend of wool and synthetic fibers for warmth and moisture-wicking properties, these socks provide excellent breathability and comfort. With reinforced heels and toes for added durability, these socks are perfect for keeping your feet warm and dry.',
                                    'Socks', '0.1 kg', '20 x 10 x 5 cm', 'Wool, Polyester', 'Gray'),
                                    ('Hiking Shorts', 'Quick-drying and flexible shorts for hiking.', 45.99, 'images/shorts.jpg', 25, 'summer', 'male', 
                                    'These hiking shorts are designed for comfort and freedom of movement on the trail. Featuring a quick-drying fabric that wicks away moisture, these shorts keep you cool and comfortable during your hikes. With multiple pockets for storage and a comfortable fit, these shorts are perfect for outdoor activities.',
                                    'Shorts', '0.3 kg', '40 x 25 x 5 cm', 'Nylon, Polyester', 'Blue'),
                                    ('Trekking Hat', 'Sun hat with UV protection.', 24.99, 'images/hat.jpg', 30, 'summer', 'unisex',
                                    'Stay cool and protected from the sun with this trekking hat. Featuring a wide brim for shade and a breathable fabric that wicks away moisture, this hat provides excellent sun protection while hiking. With a comfortable fit and adjustable strap, this hat is perfect for outdoor adventures.',
                                    'Hats', '0.1 kg', '25 x 20 x 5 cm', 'Cotton, Polyester', 'Beige'),
                                    ('Trail Food Pack', 'High-energy trail snacks and meals.', 19.99, 'images/trailfood.jpg', 40, 'summer', 'unisex', 
                                    'This trail food pack provides high-energy snacks and meals for your hiking adventures. Featuring a mix of protein bars, dried fruit, nuts, and energy gels, this pack provides the fuel you need to stay energized on the trail. With a convenient resealable bag for easy transport, this pack is perfect for any hike.',
                                    'Food', '0.5 kg', '30 x 20 x 10 cm', 'Various', 'Assorted'),
                                    ('First Aid Kit', 'Comprehensive first aid kit for emergencies.', 29.99, 'images/firstaidkit.jpg', 15, 'autumn', 'unisex',
                                    'Be prepared for any emergency with this comprehensive first aid kit. Featuring a wide range of essential supplies, including bandages, antiseptic wipes, pain relievers, and more, this kit is designed to provide basic medical care in case of an accident or injury. With a compact and portable design, this kit is easy to carry on your hikes.',
                                    'First Aid', '0.5 kg', '20 x 15 x 10 cm', 'Various', 'Red'),
                                    ('Navigation Compass', 'Accurate and durable compass for navigation.', 34.99, 'images/compass.jpg', 20, 'spring', 'unisex',
                                    'This accurate and durable compass is essential for navigation on the trail. Featuring a reliable magnetic needle and a clear compass rose, this compass helps you find your way and stay on track. With a durable construction and easy-to-read markings, this compass is a reliable tool for any hiker.',
                                    'Navigation', '0.1 kg', '10 x 8 x 2 cm', 'Metal, Plastic', 'Silver'),
                                    ('Solar Charger', 'Portable solar charger for electronic devices.', 59.99, 'images/solarcharger.jpg', 25, 'summer', 'unisex',
                                    'This portable solar charger provides a convenient way to charge your electronic devices while hiking. Featuring a solar panel that converts sunlight into electricity, this charger is a reliable source of power for your phone, GPS, and other devices. With a compact and lightweight design, this charger is easy to carry on your hikes.',
                                    'Electronics', '0.2 kg', '15 x 10 x 5 cm', 'Solar Panel, Plastic', 'Black'),
                                    ('Trekking Gloves', 'Insulated gloves for cold weather conditions.', 32.99, 'images/gloves.jpg', 20, 'winter', 'unisex', 
                                    'These insulated gloves provide warmth and protection for your hands during cold weather hikes. Featuring a water-resistant outer layer and a warm fleece lining, these gloves keep your hands comfortable in cold and wet conditions. With a durable construction and a touchscreen compatible fingertip, these gloves are perfect for any winter hike.',
                                    'Gloves', '0.1 kg', '20 x 15 x 5 cm', 'Polyester, Fleece', 'Black'),
                                    ('Insulated Bottle', 'Stainless steel bottle to keep liquids hot or cold.', 25.99, 'images/bottle.jpg', 30, 'summer', 'unisex', 
                                    'Stay hydrated with this insulated stainless steel bottle. Featuring double-wall insulation that keeps your drinks hot or cold for hours, this bottle is perfect for hiking and other outdoor activities. With a leak-proof lid and a durable construction, this bottle is a reliable companion for any adventure.',
                                    'Bottles', '0.5 kg', '25 x 8 x 8 cm', 'Stainless Steel', 'Silver'),
                                    ('Night Vision Binoculars', 'High-quality binoculars for low-light conditions.', 180.99, 'images/binoculars.jpg', 15, 'autumn', 'unisex',
                                    'These high-quality night vision binoculars provide clear and bright images in low-light conditions. Featuring a powerful magnification and a durable construction, these binoculars are perfect for birdwatching, wildlife viewing, and other outdoor activities. With a comfortable grip and a convenient carrying case, these binoculars are a valuable tool for any hiker.',
                                    'Binoculars', '1.2 kg', '15 x 10 x 5 cm', 'Metal, Plastic', 'Black'),
                                    ('LED Headlamp', 'Bright and lightweight headlamp for night time.', 23.99, 'images/headlamp.jpg', 40, 'autumn', 'unisex',
                                    'This bright and lightweight headlamp provides hands-free illumination for your nighttime hikes. Featuring a powerful LED light with adjustable brightness and a comfortable headband, this headlamp provides excellent visibility on the trail. With a long battery life and a water-resistant design, this headlamp is perfect for any outdoor adventure.',
                                    'Headlamps', '0.2 kg', '10 x 8 x 5 cm', 'Plastic, LED', 'Black'),
                                    ('Multi-tool Knife', 'Compact multi-tool knife for various outdoor tasks.', 29.99, 'images/multitool.jpg', 25, 'spring', 'unisex', 
                                    'This compact multi-tool knife is perfect for various outdoor tasks. Featuring a variety of tools, including a knife blade, pliers, screwdriver, and more, this tool is a valuable addition to any hiker\'s gear. With a durable construction and a convenient carrying case, this multi-tool knife is an essential item for any adventure.',
                                    'Tools', '0.2 kg', '10 x 5 x 2 cm', 'Stainless Steel', 'Silver'),
                                    ('Thermal Mat', 'Lightweight thermal mat for added insulation.', 42.99, 'images/thermalmat.jpg', 25, 'winter', 'unisex', 
                                    'This lightweight thermal mat provides added insulation for your camping trips. Featuring a durable and water-resistant outer layer and a comfortable foam padding, this mat provides warmth and comfort on cold nights. With a compact and portable design, this mat is easy to carry and store.',
                                    'Mats', '0.5 kg', '50 x 25 x 5 cm', 'Foam, Polyester', 'Blue'),
                                    ('Climbing Harness', 'Ergonomic climbing harness for safety and comfort.', 59.99, 'images/climbingharness.jpg', 15, 'summer', 'unisex',
                                    'This ergonomic climbing harness provides safety and comfort for rock climbing. Featuring a secure and adjustable fit with multiple attachment points, this harness offers a safe and comfortable experience for any climber. With a durable construction and a lightweight design, this harness is perfect for any climbing adventure.',
                                    'Climbing Gear', '0.5 kg', '30 x 20 x 10 cm', 'Nylon, Polyester', 'Black'),
                                    ('Weatherproof Maps', 'Durable, waterproof maps for various trails.', 14.99, 'images/maps.jpg', 20, 'spring', 'unisex',
                                    'These durable and waterproof maps provide essential information for navigating trails. Featuring detailed topography, trail markings, and points of interest, these maps are essential for hikers and backpackers. With a laminated finish for protection from the elements, these maps are a reliable tool for any outdoor adventure.',
                                    'Maps', '0.1 kg', '30 x 20 x 0.5 cm', 'Paper, Laminate', 'Assorted'),
                                    ('Trail GPS', 'High-precision GPS device for trail navigation.', 299.99, 'images/gps.jpg', 12, 'summer', 'unisex',
                                    'This high-precision GPS device provides accurate navigation on the trail. Featuring a built-in map and tracking capabilities, this GPS device helps you stay on track and find your way. With a durable construction and a long battery life, this GPS device is a reliable tool for any hiker.',
                                    'Electronics', '0.3 kg', '10 x 8 x 3 cm', 'Plastic, Metal', 'Black'),
                                    ('Water Purifier', 'Compact and efficient water purifier for hikers.', 69.99, 'images/waterpurifier.jpg', 18, 'summer', 'unisex',
                                    'This compact and efficient water purifier provides clean and safe drinking water on the trail. Featuring a powerful filtration system that removes harmful bacteria and contaminants, this purifier provides peace of mind when sourcing water in the wild. With a lightweight and portable design, this purifier is easy to carry on your hikes.',
                                    'Water Filters', '0.2 kg', '15 x 10 x 5 cm', 'Plastic, Filter', 'Blue'),
                                    ('Energy Bars', 'High-calorie energy bars for long treks.', 2.99, 'images/energybars.jpg', 100, 'summer', 'unisex',
                                    'These high-calorie energy bars provide sustained energy for long hikes. Featuring a blend of carbohydrates, protein, and healthy fats, these bars provide the fuel you need to stay energized on the trail. With a convenient packaging and a variety of flavors, these bars are perfect for any hiker.',
                                    'Food', '0.1 kg', '10 x 5 x 2 cm', 'Various', 'Assorted'),
                                    ('Insulated Jacket', 'Lightweight and insulated jacket for cold weather.', 129.99, 'images/insulatedjacket.jpg', 10, 'winter', 'unisex', 
                                    'Stay warm and comfortable on cold weather hikes with this lightweight insulated jacket. Featuring a durable water-resistant outer layer and a lightweight synthetic insulation, this jacket provides excellent warmth without adding bulk. With a comfortable fit and adjustable hood, this jacket is perfect for any winter adventure.',
                                    'Jackets', '0.6 kg', '55 x 40 x 10 cm', 'Nylon, Polyester', 'Red'),
                                    ('Climbing Shoes', 'Precision shoes for rock and wall climbing.', 89.99, 'images/climbingshoes.jpg', 15, 'spring', 'unisex',
                                    'These precision shoes are designed for performance and comfort on rock and wall climbing. Featuring a sticky rubber outsole for maximum grip and a comfortable fit that allows for precise footwork, these shoes provide the support and control you need for challenging climbs. With a durable construction and a variety of sizes and styles, these shoes are perfect for any climber.',
                                    'Shoes', '0.8 kg', '30 x 20 x 10 cm', 'Synthetic, Rubber', 'Black'),
                                    ('Base Layer Clothing', 'Moisture-wicking and thermal clothing for base layers.', 49.99, 'images/baselayer.jpg', 30, 'winter', 'unisex', 
                                    'These moisture-wicking and thermal base layers provide comfort and warmth on cold weather hikes. Featuring a breathable fabric that wicks away moisture and a comfortable fit, these layers keep you dry and warm during any outdoor adventure. With a variety of styles and sizes, these layers are perfect for any winter hike.',
                                    'Clothing', '0.2 kg', '40 x 30 x 5 cm', 'Polyester, Synthetic', 'Gray'),
                                    ('Camping Chair', 'Lightweight and foldable camping chair.', 24.99, 'images/campingchair.jpg', 20, 'summer', 'unisex',
                                    'This lightweight and foldable camping chair provides comfortable seating on your camping trips. Featuring a durable construction and a compact design, this chair is easy to carry and set up. With a comfortable seat and back, this chair is perfect for relaxing around the campsite.',
                                    'Chairs', '1.5 kg', '50 x 20 x 10 cm', 'Aluminum, Polyester', 'Blue'),
                                    ('Campfire Grill', 'Portable grill for campfire cooking.', 39.99, 'images/campfiregrill.jpg', 25, 'summer', 'unisex',
                                    'This portable campfire grill is perfect for cooking meals over the campfire. Featuring a durable construction and a compact design, this grill is easy to transport and set up. With a large cooking surface and adjustable height, this grill is perfect for any camping adventure.',
                                    'Grills', '2 kg', '40 x 30 x 10 cm', 'Stainless Steel', 'Silver'),
                                    ('Tactical Flashlight', 'High-intensity flashlight with long battery life.', 35.99, 'images/flashlight.jpg', 40, 'autumn', 'unisex',
                                    'This high-intensity flashlight provides powerful illumination for your nighttime adventures. Featuring a bright LED light with adjustable brightness and a long battery life, this flashlight is perfect for hiking, camping, and other outdoor activities. With a durable construction and a waterproof design, this flashlight is a reliable companion for any adventure.',
                                    'Flashlights', '0.3 kg', '15 x 5 x 5 cm', 'Aluminum, LED', 'Black'),
                                    ('Bear Spray', 'Effective bear deterrent spray for safety in bear country.', 27.99, 'images/bearspray.jpg', 22, 'spring', 'unisex',
                                    'This effective bear deterrent spray provides protection in bear country. Featuring a powerful and effective formula that is designed to deter bears, this spray is an essential safety item for any hiker. With a convenient and easy-to-use design, this spray is perfect for any outdoor adventure.',
                                    'Safety', '0.2 kg', '15 x 5 x 5 cm', 'Pepper Spray', 'Red'),
                                    ('Camping Hammock', 'Durable and comfortable hammock for camping.', 59.99, 'images/hammock.jpg', 15, 'summer', 'unisex',
                                    'This durable and comfortable hammock provides a relaxing place to rest on your camping trips. Featuring a strong and lightweight construction, this hammock is easy to set up and provides a comfortable and relaxing experience. With a convenient carrying bag and a variety of colors, this hammock is perfect for any camping adventure.',
                                    'Hammocks', '1 kg', '25 x 15 x 10 cm', 'Nylon, Polyester', 'Green'),
                                    ('Portable Battery Pack', 'High-capacity battery pack for charging devices.', 49.99, 'images/batterypack.jpg', 25, 'spring', 'unisex',
                                    'This high-capacity portable battery pack provides a convenient way to charge your electronic devices on the go. Featuring a powerful battery that can charge your phone, GPS, and other devices multiple times, this pack is perfect for hiking, camping, and other outdoor activities. With a compact and lightweight design, this pack is easy to carry and store.',
                                    'Electronics', '0.2 kg', '10 x 8 x 3 cm', 'Plastic, Battery', 'Black'),
                                    ('Sunscreen Lotion', 'SPF 50+ sunscreen lotion for long sun exposure.', 13.99, 'images/sunscreen.jpg', 50, 'summer', 'unisex',
                                    'This SPF 50+ sunscreen lotion provides broad-spectrum protection from the sun''s harmful rays. Featuring a water-resistant formula that is gentle on the skin, this lotion is perfect for hiking, camping, and other outdoor activities. With a convenient pump bottle and a variety of sizes, this lotion is perfect for any adventure.',
                                    'Sun Protection', '0.1 kg', '15 x 5 x 5 cm', 'Lotion', 'White'),
                                    ('Insect Repellent', 'Strong insect repellent for hiking and camping.', 8.99, 'images/insectrepellent.jpg', 45, 'summer', 'unisex',
                                    'This strong insect repellent provides protection from pesky insects. Featuring a long-lasting formula that is effective against mosquitoes, ticks, and other biting insects, this repellent is perfect for hiking, camping, and other outdoor activities. With a convenient pump bottle and a variety of sizes, this repellent is perfect for any adventure.',
                                    'Insect Repellent', '0.1 kg', '15 x 5 x 5 cm', 'Repellent', 'Green'),
                                    ('Hiking Gloves', 'Durable gloves for protection and grip.', 22.99, 'images/hikinggloves.jpg', 20, 'autumn', 'unisex',
                                    'These durable hiking gloves provide protection and grip for your hands on the trail. Featuring a breathable and water-resistant fabric that provides protection from the elements, these gloves also have a textured palm for enhanced grip. With a comfortable fit and a variety of sizes, these gloves are perfect for any outdoor adventure.',
                                    'Gloves', '0.1 kg', '20 x 15 x 5 cm', 'Polyester, Synthetic', 'Black'),
                                    ('Rain Cover', 'Waterproof cover to protect backpack and gear.', 19.99, 'images/raincover.jpg', 30, 'spring', 'unisex',
                                    'This waterproof rain cover protects your backpack and gear from the elements. Featuring a durable and waterproof fabric that is designed to keep your belongings dry, this cover is perfect for hiking, camping, and other outdoor activities. With a convenient drawstring closure and a variety of sizes, this cover is perfect for any adventure.',
                                    'Backpack Accessories', '0.2 kg', '30 x 20 x 5 cm', 'Polyester', 'Blue'),
                                    ('Thermal Blanket', 'Compact emergency thermal blanket.', 7.99, 'images/thermalblanket.jpg', 50, 'winter', 'unisex',
                                    'This compact emergency thermal blanket provides warmth and protection in case of an emergency. Featuring a lightweight and durable material that reflects body heat, this blanket can help prevent hypothermia. With a convenient and compact design, this blanket is easy to carry in your backpack.',
                                    'Emergency Gear', '0.1 kg', '20 x 15 x 2 cm', 'Mylar', 'Silver'),
                                    ('Lantern', 'Battery-powered lantern for nighttime illumination.', 29.99, 'images/lantern.jpg', 20, 'autumn', 'unisex',
                                    'This battery-powered lantern provides bright and reliable illumination for your campsite. Featuring a powerful LED light with adjustable brightness and a long battery life, this lantern is perfect for camping, hiking, and other outdoor activities. With a durable construction and a compact design, this lantern is easy to transport and set up.',
                                    'Lanterns', '0.5 kg', '15 x 10 x 5 cm', 'Plastic, LED', 'Black')
                                    ";
        if ($conn->multi_query($sql) === TRUE) {
            echo "<script>console.log('Product entries created successfully');</script>";
        } else {
            echo "<script>console.log('Error creating product entries: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>console.log('Product entries already exist');</script>";
    }
}

$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Call the functions to create tables
createProductsTable($conn);
createCustomersTable($conn);
createOrdersTable($conn);
createCartTable($conn);
createOrderItems($conn);
createProducts($conn);
createAddressTable($conn);

// Close connection (optional, but good practice)
$conn->close();
?>