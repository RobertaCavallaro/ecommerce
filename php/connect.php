<?php
// Database credentials
$servername = "localhost"; // Replace with your MySQL server hostname 
$port = "8889";
$username = "mamp"; // Replace with your MySQL username 
$password = ""; // Replace with your MySQL password 
$dbname = "trekkingtale_db"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<script>console.log('Connected successfully');</script>";


// Functions for table creation
function createProductsTable($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS products (
                product_id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT,
                price DECIMAL(10,2) NOT NULL,
                image_url VARCHAR(255),
                stock INT NOT NULL DEFAULT 0
            )";

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Products table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating products table:  $conn->error . \n');</script>";
    }
}


function createCategoriesTable($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS categories (
                category_id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL
            )";

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Categories table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating Categories table:  $conn->error .');</script>";
    }
}


function createProductsCategoriesTable($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS products_categories (
                product_id INT NOT NULL,
                category_id INT NOT NULL,
                PRIMARY KEY (product_id, category_id),
                FOREIGN KEY (product_id) REFERENCES products(product_id),
                FOREIGN KEY (category_id) REFERENCES categories(category_id)
            )";

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Products Category table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating Products Category table: $conn->error . ');</script>";
    }
}


function createCustomersTable($conn)
{
    $sql = "CREATE TABLE IF NOT EXISTS customers (
                customer_id INT AUTO_INCREMENT PRIMARY KEY,
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
                customer_id INT NOT NULL,
                order_date DATETIME NOT NULL,
                total_amount DECIMAL(10,2) NOT NULL,
                FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
            )";
    // ... (more fields for shipping, billing, etc.)

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Orders table created successfully');</script>";
    } else {
        echo "<script>console.log('Error creating Orders table: $conn->error .');</script>";
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
        $sql = "INSERT INTO products (name, description, price, image_url, stock) VALUES
        ('Trekking Backpack', 'A durable and spacious backpack ideal for long treks.', 99.99, 'images/backpack.jpg', 10),
        ('Hiking Boots', 'Waterproof and sturdy boots for all terrains.', 149.99, 'images/boots.jpg', 10),
        ('Trekking Poles', 'Lightweight and adjustable trekking poles.', 39.99, 'images/poles.jpg', 15),
        ('Waterproof Jacket', 'Breathable, waterproof jacket for all-weather protection.', 129.99, 'images/jacket.jpg', 12),
        ('Camping Tent', 'Compact and lightweight tent suitable for 3 persons.', 250.00, 'images/tent.jpg', 8),
        ('Sleeping Bag', 'Comfortable sleeping bag for cold conditions.', 70.00, 'images/sleepingbag.jpg', 10),
        ('Portable Stove', 'Portable and efficient stove for cooking outdoors.', 45.00, 'images/stove.jpg', 20),
        ('Trekking Socks', 'Warm and durable socks for long treks.', 12.99, 'images/socks.jpg', 50),
        ('Hiking Shorts', 'Quick-drying and flexible shorts for hiking.', 45.99, 'images/shorts.jpg', 25),
        ('Trekking Hat', 'Sun hat with UV protection.', 24.99, 'images/hat.jpg', 30),
        ('Trail Food Pack', 'High-energy trail snacks and meals.', 19.99, 'images/trailfood.jpg', 40),
        ('First Aid Kit', 'Comprehensive first aid kit for emergencies.', 29.99, 'images/firstaidkit.jpg', 15),
        ('Navigation Compass', 'Accurate and durable compass for navigation.', 34.99, 'images/compass.jpg', 20),
        ('Solar Charger', 'Portable solar charger for electronic devices.', 59.99, 'images/solarcharger.jpg', 25),
        ('Trekking Gloves', 'Insulated gloves for cold weather conditions.', 32.99, 'images/gloves.jpg', 20),
        ('Insulated Bottle', 'Stainless steel bottle to keep liquids hot or cold.', 25.99, 'images/bottle.jpg', 30),
        ('Night Vision Binoculars', 'High-quality binoculars for low-light conditions.', 180.99, 'images/binoculars.jpg', 15),
        ('LED Headlamp', 'Bright and lightweight headlamp for night time.', 23.99, 'images/headlamp.jpg', 40),
        ('Multi-tool Knife', 'Compact multi-tool knife for various outdoor tasks.', 29.99, 'images/multitool.jpg', 25),
        ('Thermal Mat', 'Lightweight thermal mat for added insulation.', 42.99, 'images/thermalmat.jpg', 25),
        ('Climbing Harness', 'Ergonomic climbing harness for safety and comfort.', 59.99, 'images/climbingharness.jpg', 15),
        ('Weatherproof Maps', 'Durable, waterproof maps for various trails.', 14.99, 'images/maps.jpg', 20),
        ('Trail GPS', 'High-precision GPS device for trail navigation.', 299.99, 'images/gps.jpg', 12),
        ('Water Purifier', 'Compact and efficient water purifier for hikers.', 69.99, 'images/waterpurifier.jpg', 18),
        ('Energy Bars', 'High-calorie energy bars for long treks.', 2.99, 'images/energybars.jpg', 100),
        ('Insulated Jacket', 'Lightweight and insulated jacket for cold weather.', 129.99, 'images/insulatedjacket.jpg', 10),
        ('Climbing Shoes', 'Precision shoes for rock and wall climbing.', 89.99, 'images/climbingshoes.jpg', 15),
        ('Base Layer Clothing', 'Moisture-wicking and thermal clothing for base layers.', 49.99, 'images/baselayer.jpg', 30),
        ('Camping Chair', 'Lightweight and foldable camping chair.', 24.99, 'images/campingchair.jpg', 20),
        ('Campfire Grill', 'Portable grill for campfire cooking.', 39.99, 'images/campfiregrill.jpg', 25),
        ('Tactical Flashlight', 'High-intensity flashlight with long battery life.', 35.99, 'images/flashlight.jpg', 40),
        ('Bear Spray', 'Effective bear deterrent spray for safety in bear country.', 27.99, 'images/bearspray.jpg', 22),
        ('Camping Hammock', 'Durable and comfortable hammock for camping.', 59.99, 'images/hammock.jpg', 15),
        ('Portable Battery Pack', 'High-capacity battery pack for charging devices.', 49.99, 'images/batterypack.jpg', 25),
        ('Sunscreen Lotion', 'SPF 50+ sunscreen lotion for long sun exposure.', 13.99, 'images/sunscreen.jpg', 50),
        ('Insect Repellent', 'Strong insect repellent for hiking and camping.', 8.99, 'images/insectrepellent.jpg', 45),
        ('Hiking Gloves', 'Durable gloves for protection and grip.', 22.99, 'images/hikinggloves.jpg', 20),
        ('Rain Cover', 'Waterproof cover to protect backpack and gear.', 19.99, 'images/raincover.jpg', 30),
        ('Thermal Blanket', 'Compact emergency thermal blanket.', 7.99, 'images/thermalblanket.jpg', 50),
        ('Lantern', 'Battery-powered lantern for nighttime illumination.', 29.99, 'images/lantern.jpg', 20)";

        if ($conn->multi_query($sql) === TRUE) {
            echo "<script>console.log('Product entries created successfully');</script>";
        } else {
            echo "<script>console.log('Error creating product entries: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>console.log('Product entries already exist');</script>";
    }
}


// Call the functions to create tables
createProductsTable($conn);
createCategoriesTable($conn);
createProductsCategoriesTable($conn);
createCustomersTable($conn);
createOrdersTable($conn);
createProducts($conn);

// Close connection (optional, but good practice)
$conn->close();
?>