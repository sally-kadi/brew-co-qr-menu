
<?php
include "db.php";

$categoriesResult = $conn->query(
    "SELECT COUNT(*) AS total FROM categories"
);
$totalCategories = $categoriesResult
    ? (int)$categoriesResult->fetch_assoc()["total"] : 0;

$itemsResult = $conn->query(
    "SELECT COUNT(*) AS total FROM menu_items"
);
$totalItems = $itemsResult
    ? (int)$itemsResult->fetch_assoc()["total"] : 0;

$activeResult = $conn->query(
    "SELECT COUNT(*) AS total FROM menu_items WHERE status = 1"
);
$activeItems = $activeResult
    ? (int)$activeResult->fetch_assoc()["total"] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Brew Co.</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f4ef;
            color: #2e241f;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 245px;
            flex-shrink: 0;
            background: #4b3024;
            color: white;
            padding: 28px 16px;
        }

        .brand {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 3px;
            padding-bottom: 8px;
        }

        .brand-subtitle {
            text-align: center;
            font-size: 10px;
            letter-spacing: 3px;
            color: #d9c2ad;
            margin-bottom: 35px;
        }

        .nav-title {
            font-size: 11px;
            color: #cbb5a1;
            letter-spacing: 2px;
            margin: 20px 12px 12px;
        }

        .sidebar a {
            display: block;
            color: #f7eee7;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 8px;
            margin-bottom: 7px;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.current {
            background: #79563f;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 32px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        h1 {
            color: #65452f;
            margin: 0 0 8px;
            font-size: 28px;
        }

        .subtitle {
            color: #82766d;
            margin: 0;
        }

        .date-label {
            color: #79563f;
            background: white;
            padding: 12px 16px;
            border-radius: 9px;
            font-size: 13px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin: 25px 0 32px;
        }

        .card {
            padding: 24px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 3px 12px #39271912;
            border-left: 4px solid #8b5e3c;
        }

        .card h2 {
            margin: 0 0 15px;
            font-size: 15px;
            color: #75675e;
        }

        .number {
            font-size: 34px;
            font-weight: bold;
            color: #8b5e3c;
        }

        .section-title {
            font-size: 20px;
            margin-bottom: 16px;
        }

        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .quick-card {
            display: block;
            padding: 22px;
            background: white;
            color: #4b3024;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 3px 12px #39271910;
            transition: transform 0.2s;
        }

        .quick-card:hover {
            transform: translateY(-3px);
        }

        .quick-card strong {
            display: block;
            margin-bottom: 9px;
            font-size: 16px;
        }

        .quick-card span {
            color: #82766d;
            font-size: 13px;
            line-height: 1.5;
        }

        @media (max-width: 800px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
                padding: 18px;
            }

            .brand {
                font-size: 21px;
            }

            .brand-subtitle {
                margin-bottom: 15px;
            }

            .nav-title {
                margin-top: 10px;
            }

            .main {
                padding: 22px 16px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">BREW CO.</div>
        <div class="brand-subtitle">COFFEE &amp; MORE</div>

        <div class="nav-title">MAIN MENU</div>

        <a href="index.php" class="current">☕ Dashboard</a>
        <a href="categories.php">▦ Categories</a>
        <a href="menu-items.php">☕ Menu Items</a>

        <div class="nav-title">OTHER</div>

        <a href="../index.php">↗ Customer Menu</a>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>Dashboard</h1>
                <p class="subtitle">
                    Welcome to your Brew Co. management system.
                </p>
            </div>

            <div class="date-label">☕ Brew Co. Admin Panel</div>
        </div>

        <h2 class="section-title">Overview</h2>

        <div class="cards">
            <div class="card">
                <h2>Total Categories</h2>
                <div class="number">
                    <?= $totalCategories ?>
                </div>
            </div>

            <div class="card">
                <h2>Total Menu Items</h2>
                <div class="number">
                    <?= $totalItems ?>
                </div>
            </div>

            <div class="card">
                <h2>Active Menu Items</h2>
                <div class="number">
                    <?= $activeItems ?>
                </div>
            </div>
        </div>

        <h2 class="section-title">Quick Access</h2>

        <div class="quick-links">
            <a href="categories.php" class="quick-card">
                <strong>▦ Manage Categories</strong>
                <span>Add, edit, activate, or deactivate menu categories.</span>
            </a>

            <a href="menu-items.php" class="quick-card">
                <strong>☕ Manage Menu Items</strong>
                <span>Add products, update prices, and manage item status.</span>
            </a>

            <a href="../index.php" class="quick-card">
                <strong>↗ View Customer Menu</strong>
                <span>Preview the digital menu displayed to customers.</span>
            </a>
        </div>
    </main>

</div>
</body>
</html>
