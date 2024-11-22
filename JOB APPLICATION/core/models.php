<?php  

require_once 'dbConfig.php';

function getAllUsers($pdo) {
    $sql = "SELECT * FROM search_users_data ORDER BY first_name ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();
    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}

function getUserByID($pdo, $id) {
    $sql = "SELECT * FROM search_users_data WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$id]);
    if ($executeQuery) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}

function searchForAUser($pdo, $searchQuery) {
    $sql = "SELECT * FROM search_users_data WHERE 
            CONCAT(first_name, last_name, email, phone_number, hire_date, job_title, salary, department, date_added) 
            LIKE ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%".$searchQuery."%"]);
    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}

function insertNewUser($pdo, $first_name, $last_name, $email, $phone_number, $hire_date, $job_title, $salary, $department) {
    $sql = "INSERT INTO search_users_data 
            (first_name, last_name, email, phone_number, hire_date, job_title, salary, department)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $email, $phone_number, $hire_date, $job_title, $salary, $department]);
    return $executeQuery;
}

function editUser($pdo, $first_name, $last_name, $email, $phone_number, $hire_date, $job_title, $salary, $department, $id) {
    $sql = "UPDATE search_users_data
            SET first_name = ?, last_name = ?, email = ?, phone_number = ?, hire_date = ?, job_title = ?, salary = ?, department = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $email, $phone_number, $hire_date, $job_title, $salary, $department, $id]);
    return $executeQuery;
}

function deleteUser($pdo, $id) {
    $sql = "DELETE FROM search_users_data WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$id]);
    return $executeQuery;
}
?>
