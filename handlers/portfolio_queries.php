<?php
// portfolio_queries.php

//include 'database.php'; // Include your database connection class
require_once 'admin/Database.php';

function getPortfolioItemsWithImages() {
    $db = new Database();
    $conn = $db->getConnection();

    // Prepare the SQL query to fetch portfolio items with at least one image
    $sql = "
        SELECT pi.id AS portfolio_item_id, pi.title, pi.description, pi.created_at, 
               pimg.image_path
        FROM portfolio_items pi
        LEFT JOIN portfolio_images pimg ON pi.id = pimg.portfolio_item_id
        GROUP BY pi.id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>