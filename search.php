<?php
    $approval_status = $_GET['request_user'];
    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
    
    $sql = "SELECT * FROM transport WHERE request_user = ?";
    $params = [$approval_status];
    
    // Modify SQL to include search query if provided
    if ($search_query) {
        $sql .= " AND (request_user LIKE ? OR location LIKE ?)";
        $params[] = "%$search_query%";
        $params[] = "%$search_query%";
    }
    
?>