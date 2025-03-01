<?php
declare(strict_types=1);

// Constant values for this project
const INCLUDES_DIR = __DIR__ . '/../includes';
const ROUTE_DIR = __DIR__ . '/../routes';
const TEMPLATES_DIR = __DIR__ . '/../template';
const DATABASE_DIR = __DIR__ . '/../databases';

session_start();

// Include router to index.php 
require_once INCLUDES_DIR . '/router.php';
require_once INCLUDES_DIR . '/view.php';
require_once INCLUDES_DIR . '/db.php';

//dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
// echo '$_SERVER["REQUEST_URI"]='.$_SERVER['REQUEST_URI'];
const PUBLIC_ROUTES = ['/', '/login','/sign_in'];

if (in_array(strtolower($_SERVER['REQUEST_URI']), PUBLIC_ROUTES)) {
    // ถ้าเป็นหน้า public (หน้า login หรือหน้าแรก) ให้ดำเนินการปกติ
    dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    exit;
} elseif (isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] < 1000) {
    // ถ้าผู้ใช้เข้าสู่ระบบแล้วและ session ยังไม่หมดอายุ
    $unix_timestamp = time();
    $_SESSION['timestamp'] = $unix_timestamp;
    dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} else {
    unset($_SESSION['timestamp']);
    header('Location: /login'); 
    exit;
}

