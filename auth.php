<?php
session_start();
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>