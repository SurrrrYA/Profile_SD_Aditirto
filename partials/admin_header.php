<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($title)) {
    $title = 'Admin - MI Aditirto';
}

$currentPage = basename($_SERVER['SCRIPT_NAME']);

?>

<!doctype html>

<html lang="id">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title><?= e($title) ?></title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family:
                'Segoe UI',
                Arial,
                sans-serif;

            background: #f5f7fa;
            color: #1c2733;
        }


        /* =========================================
           ADMIN LAYOUT
        ========================================= */

        .admin-layout {
            min-height: 100vh;
            display: flex;
        }


        /* =========================================
           SIDEBAR
        ========================================= */

        .admin-sidebar {
            position: fixed;

            top: 0;
            left: 0;

            width: 255px;
            height: 100vh;

            background: #ffffff;

            border-right:
                1px solid #e8edf3;

            z-index: 1000;

            display: flex;
            flex-direction: column;

            transition:
                transform .3s ease;
        }


        /* =========================================
           SIDEBAR BRAND
        ========================================= */

        .sidebar-brand {
            height: 74px;

            padding: 0 20px;

            display: flex;
            align-items: center;

            gap: 11px;

            border-bottom:
                1px solid #edf0f4;

            text-decoration: none;
        }


        .sidebar-logo {
            width: 40px;
            height: 40px;

            border-radius: 11px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #0d6efd,
                    #0a4fc4
                );

            color: #ffffff;

            font-size: 13px;
            font-weight: 800;

            box-shadow:
                0 4px 12px rgba(13,110,253,.20);
        }


        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
        }


        .sidebar-brand-text strong {
            font-size: 15px;
            color: #1c2733;
        }


        .sidebar-brand-text span {
            margin-top: 2px;

            font-size: 11px;

            color: #8a96a3;
        }


        /* =========================================
           SIDEBAR MENU
        ========================================= */

        .sidebar-menu {
            flex: 1;

            padding: 18px 12px;

            overflow-y: auto;
        }


        .menu-label {
            padding:
                0 12px 8px;

            font-size: 11px;

            font-weight: 700;

            color: #9aa5b1;

            text-transform: uppercase;

            letter-spacing: .7px;
        }


        .sidebar-menu a {
            display: flex;

            align-items: center;

            gap: 12px;

            padding:
                11px 12px;

            margin-bottom: 4px;

            border-radius: 9px;

            color: #687585;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            transition:
                background .2s ease,
                color .2s ease;
        }


        .sidebar-menu a:hover {
            background: #f0f5ff;

            color: #0d6efd;
        }


        .sidebar-menu a.active {
            background: #e8f1ff;

            color: #0d6efd;

            font-weight: 700;
        }


        .menu-icon {
            width: 22px;

            text-align: center;

            font-size: 17px;
        }


        .sidebar-divider {
            height: 1px;

            background: #edf0f4;

            margin: 14px 8px;
        }


        /* =========================================
           SIDEBAR BOTTOM
        ========================================= */

        .sidebar-bottom {
            padding: 12px;

            border-top:
                1px solid #edf0f4;
        }


        .sidebar-bottom a {
            display: flex;

            align-items: center;

            gap: 12px;

            padding:
                11px 12px;

            border-radius: 9px;

            color: #687585;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;
        }


        .sidebar-bottom a:hover {
            background: #f0f5ff;

            color: #0d6efd;
        }


        .sidebar-bottom a.logout:hover {
            background: #fff0f0;

            color: #dc3545;
        }


        /* =========================================
           MAIN AREA
        ========================================= */

        .admin-main {
            width: calc(100% - 255px);

            margin-left: 255px;

            min-height: 100vh;

            display: flex;
            flex-direction: column;
        }


        /* =========================================
           TOP HEADER
        ========================================= */

        .admin-topbar {
            height: 74px;

            background: #ffffff;

            border-bottom:
                1px solid #e8edf3;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding:
                0 30px;

            position: sticky;

            top: 0;

            z-index: 900;
        }


        .admin-page-title {
            font-size: 18px;

            font-weight: 700;

            color: #1c2733;
        }


        .admin-user {
            display: flex;

            align-items: center;

            gap: 10px;
        }


        .admin-avatar {
            width: 36px;
            height: 36px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #e8f1ff;

            color: #0d6efd;

            font-size: 15px;

            font-weight: 700;
        }


        .admin-user-info {
            display: flex;
            flex-direction: column;
        }


        .admin-user-info strong {
            font-size: 13px;
            color: #263442;
        }


        .admin-user-info span {
            font-size: 11px;
            color: #8a96a3;
        }


        /* =========================================
           CONTENT
        ========================================= */

        .admin-content {
            padding: 30px;

            flex: 1;
        }


        /* =========================================
           MOBILE TOGGLE
        ========================================= */

        .sidebar-toggle {
            display: none;

            width: 38px;
            height: 38px;

            border: none;

            border-radius: 9px;

            background: #f0f5ff;

            color: #0d6efd;

            font-size: 20px;

            cursor: pointer;
        }


        .sidebar-overlay {
            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(0,0,0,.35);

            z-index: 999;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 900px) {

            .admin-sidebar {
                transform:
                    translateX(-100%);
            }


            .admin-sidebar.open {
                transform:
                    translateX(0);
            }


            .admin-main {
                width: 100%;

                margin-left: 0;
            }


            .sidebar-toggle {
                display: inline-flex;

                align-items: center;

                justify-content: center;
            }


            .sidebar-overlay.active {
                display: block;
            }


            .admin-topbar {
                padding:
                    0 18px;

                gap: 12px;
            }


            .admin-content {
                padding: 22px 18px;
            }

        }


        @media (max-width: 500px) {

            .admin-user-info {
                display: none;
            }


            .admin-page-title {
                font-size: 16px;
            }

        }

    </style>

</head>


<body>


<div class="admin-layout">