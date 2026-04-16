<?php
session_start();

echo "<h3>Debug Session:</h3>";
echo "<pre>";
echo "is_logged_in: " . (isset($_SESSION['is_logged_in']) ? 'Yes' : 'No') . "<br>";
echo "username: " . (isset($_SESSION['username']) ? $_SESSION['username'] : 'Not Set') . "<br>";
echo "user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not Set') . "<br>";
echo "is_super_admin: " . (isset($_SESSION['is_super_admin']) ? $_SESSION['is_super_admin'] : 'Not Set') . "<br>";
echo "</pre>";

echo "<h3>Raw Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<a href='index.php'>Kembali ke Dashboard</a>";
?>