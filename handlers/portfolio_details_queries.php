<?php
// portfolio_details_queries.php
require_once 'admin/Database.php';

function getPortfolioDetails($portfolioItemId) {
    $db = new Database();
    $conn = $db->getConnection();

    // Prepare the SQL query to fetch portfolio item details and images
    $sql = "SELECT pi.id AS portfolio_item_id, pi.title, pi.description, pi.created_at, pimg.image_path
        FROM portfolio_items pi
        LEFT JOIN portfolio_images pimg ON pi.id = pimg.portfolio_item_id
        WHERE pi.id = :portfolio_item_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':portfolio_item_id', $portfolioItemId);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>