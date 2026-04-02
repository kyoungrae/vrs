<?php
// Laravel 없이 Oracle 직접 연결 확인
try {
    $tns = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = ORCL)))";
    $conn = oci_connect("your_username", "your_password", $tns);
    if (!$conn) {
        $e = oci_error();
        echo "Oracle connect error: " . $e['message'] . PHP_EOL;
    } else {
        echo "Oracle connected successfully" . PHP_EOL;
        $stid = oci_parse($conn, "SELECT USERNAME, ISACTIVE, ID FROM SYSTEM_USER WHERE USERNAME = 'admin'");
        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        if ($row) {
            echo "User: " . $row['USERNAME'] . PHP_EOL;
            echo "IsActive: " . $row['ISACTIVE'] . PHP_EOL;
            echo "ID: " . $row['ID'] . PHP_EOL;
        } else {
            echo "Admin user not found" . PHP_EOL;
        }
        oci_free_statement($stid);
        oci_close($conn);
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . PHP_EOL;
}
