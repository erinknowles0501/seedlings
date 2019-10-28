<?php
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}
?>