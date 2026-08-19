<?php
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user details
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $event_title = $_POST['event_title'];
    $event_date = $_POST['event_date'];
    $event_venue = $_POST['event_venue'];
    $event_id = $_POST['event_id'];

    // Handle file upload for the user's image
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }
    // Insert the data into the database using MySQLi
    $sql = "INSERT INTO event_registrations (name, email, phone, event_id ) 
            VALUES ('$name', '$email', '$phone', '$event_id')";
             if (mysqli_query($conn, $sql)) {
                "";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }


    // Generate the pass card image
    generatePassImage($name, $email, $phone, $image_path, $event_title, $event_date, $event_venue);
}

// Function to generate the pass card as an image
function generatePassImage($name, $email, $phone, $image_path, $event_title, $event_date, $event_venue) {
    // Create a blank image (width: 600px, height: 400px)
    $width = 600;
    $height = 400;
    $image = imagecreatetruecolor($width, $height);

    // Set colors
    $background_color = imagecolorallocate($image, 255, 255, 255); // white background
    $text_color = imagecolorallocate($image, 0, 0, 0); // black text
    $border_color = imagecolorallocate($image, 0, 0, 0); // black border

    // Fill the background
    imagefilledrectangle($image, 0, 0, $width, $height, $background_color);

    // Add a border
    imagerectangle($image, 0, 0, $width - 1, $height - 1, $border_color);

    // Set font path (you need a valid .ttf font file on your server)
    $font_path = 'Rosemary/DroidSans.ttf'; // You can use a TTF font stored on the server

    // Add event and user details text
    imagettftext($image, 16, 0, 20, 40, $text_color, $font_path, 'Event: ' . $event_title);
    imagettftext($image, 16, 0, 20, 80, $text_color, $font_path, 'Date: ' . $event_date);
    imagettftext($image, 16, 0, 20, 120, $text_color, $font_path, 'Venue: ' . $event_venue);

    imagettftext($image, 16, 0, 20, 180, $text_color, $font_path, 'Name: ' . $name);
    imagettftext($image, 16, 0, 20, 220, $text_color, $font_path, 'Email: ' . $email);
    imagettftext($image, 16, 0, 20, 260, $text_color, $font_path, 'Phone: ' . $phone);

    // If the user uploaded an image, place it on the pass
    if (!empty($image_path) && file_exists($image_path)) {
        $user_image = imagecreatefromjpeg($image_path);
        // Resize and place the user image (max 100x100px)
        $user_image_resized = imagescale($user_image, 100, 100);
        imagecopy($image, $user_image_resized, 450, 50, 0, 0, 100, 100);
        imagedestroy($user_image_resized);
    }

    // Output the final image to the browser
    header('Content-Type: image/png');
    imagepng($image);

    // Clean up
    imagedestroy($image);
}
?>
