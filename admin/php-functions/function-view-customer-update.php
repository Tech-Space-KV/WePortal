<?php
function handleCustomerUpdate($con, $pown_id) {
    $fieldsToUpdate = [
        'pown_name', 'pown_username', 'pown_user_type', 'pown_country', 'pown_state',
        'pown_address', 'pown_pincode', 'pown_contact', 'pown_email', 'pown_about',
        'pown_organisation_name', 'pown_cin', 'pown_gstpin', 'pown_adhaar',
        'pown_refered_by', 'pown_login_flag', 'pown_profile_completion_flag',
        'pown_password'
    ];

    $updates = [];
    $params = [];
    $types = '';

    foreach ($fieldsToUpdate as $field) {
        $value = trim($_POST[$field] ?? '');
        if ($field === 'pown_password') {
            // Hash the password if it's not already hashed
            $value = sha1($value);
        }
        $params[] = $value !== '' ? $value : null;
        $types .= 's';
    }

    $params[] = $pown_id;
    $types .= 'i';

    $sql = "UPDATE project_owners SET " . implode(", ", array_map(fn($f) => "$f = ?", $fieldsToUpdate)) . " WHERE pown_id = ?";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param($types, ...$params);
    return $stmt->execute();
}
?>
