<?php
function isLoggedIn()
{
  return isset($_SESSION['user_id']);
}

function isAdmin()
{
  return isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'super_admin');
}

function isSuperAdmin()
{
  return isset($_SESSION['role']) && $_SESSION['role'] == 'super_admin';
}

function requireLogin()
{
  if (!isLoggedIn()) {
    header('Location: ' . BASE_URL . 'modules/auth/login.php');
    exit();
  }
}

function requireAdmin()
{
  if (!isAdmin()) {
    header('Location: ' . BASE_URL . 'index.php');
    exit();
  }
}

function generateReportId()
{
  return 'CR' . date('Ymd') . rand(1000, 9999);
}
