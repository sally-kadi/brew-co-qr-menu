
<?php
require_once __DIR__ . "/admin/db.php";

/* Product images */
function getProductImage($item) {
    $image = trim($item["image"] ?? "");

    if ($image !== "") {
        return $image;
    }

    $name = strtolower(trim($item["name"] ?? ""));

    $images = [
        "latte" => "images/coffee.jpg",
        "cappuccino" => "images/coffee.jpg",
        "iced coffee" => "images/iced-coffee.jpg",
        "americano" => "images/americano.jpg",
        "matcha latte" => "images/matcha.jpg",
        "chocolate cake" => "images/cake.jpg",
        "chocolate cookie" => "images/cake.jpg"
    ];

    return $images[$name] ?? "images/coffee.jpg";
}

/* Category icon */
function getCategoryIcon($name) {
    $name = strtolower($name);

    if (strpos($name, "coffee") !== false ||
        strpos($name, "drink") !== false) {
        return "☕";
    }

    if (strpos($name, "non") !== false ||
        strpos($name, "matcha") !== false) {
        return "🍵";
    }

    if (strpos($name, "food") !== false ||
        strpos($name, "pastr") !== false ||
        strpos($name, "cake") !== false) {
        return "🍰";
    }

    return "☕";
}

/* Load categories */
$categories = [];

$categoryResult = $conn->query(
    "SELECT id, name FROM categories ORDER BY id ASC"
);

if ($categoryResult) {
    while ($row = $categoryResult->fetch_assoc()) {
        $categories[] = $row;
    }
}

/* Load products for each category */
function getItemsForCategory($conn, $categoryId) {
    $items = [];

    $stmt = $conn->prepare(
        "SELECT id, name, description, price, image, status
         FROM menu_items
         WHERE category_id = ?
         AND (status = 1 OR status IS NULL)
         ORDER BY id DESC"
    );

    if ($stmt) {
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        $stmt->close();
    }

    return $items;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Brew Co. - Digital Menu</title>

    <link rel="stylesheet" href="style.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #eee8df;
            color: #33271e;
            padding: 25px 12px;
        }

        .container {
            width: 100%;
            max-width: 760px;
            margin: auto;
            padding: 25px;
            background: #fffdf8;
            border-radius: 25px;
        }

        .container header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .container .logo {
            text-align: center;
            font-size: 25px;
            letter-spacing: 5px;
            font-weight: bold;
        }

        .container .logo small {
            display: block;
            margin-top: 7px;
            font-size: 10px;
            letter-spacing: 3px;
            font-weight: normal;
        }

        .menu-icon,
        .cart {
            font-size: 25px;
            color: #675443;
        }

        .container .hero {
            position: relative;
            display: flex;
            align-items: center;
            min-height: 230px;
            background: #e8d9c9;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 25px;
            padding: 0;
            width: 100%;
            max-width: none;
        }

        .hero-text {
            position: relative;
            z-index: 2;
            flex: 1;
            padding: 22px;
            min-width: 0;
        }

        .hero-text h2 {
            font-size: 32px;
            line-height: 1.2;
            margin-bottom: 12px;
            color: #33271e;
        }

        .hero-text p {
            font-size: 13px;
            color: #776451;
        }

        .container .hero img {
            display: block;
            width: 43%;
            height: 230px;
            flex-shrink: 0;
            object-fit: cover;
            border-radius: 0;
        }

        .container .menu-title {
            text-align: center;
            letter-spacing: 7px;
            font-size: 23px;
            margin: 25px 0;
        }

        .container .category {
            margin-bottom: 28px;
        }

        .category-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .category-title h3 {
            font-size: 15px;
            letter-spacing: 3px;
        }

        .category-title span {
            color: #806b56;
            font-size: 12px;
        }

        .container .menu-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #eee5da;
            border-radius: 15px;
            min-height: 105px;
            width: 100%;
            background: #fffdf8;
        }

        .container .menu-item img {
            display: block;
            width: 85px;
            height: 85px;
            flex-shrink: 0;
            object-fit: cover;
            border-radius: 12px;
            background: #e9dfd2;
        }

        .container .item-info {
            flex: 1;
            min-width: 0;
        }

        .container .item-info h4 {
            font-size: 16px;
            margin-bottom: 7px;
            color: #33271e;
        }

        .container .item-info p {
            color: #82786e;
            font-size: 12px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .container .menu-item strong {
            display: block;
            flex-shrink: 0;
            font-size: 14px;
            white-space: nowrap;
            color: #33271e;
        }

        .container footer {
            text-align: center;
            font-size: 12px;
            letter-spacing: 2px;
            color: #806b56;
            padding: 25px 0 5px;
        }

        .container footer p {
            margin-top: 8px;
            letter-spacing: 1px;
        }

        @media (max-width: 500px) {
            body {
                padding: 8px;
            }

            .container {
                padding: 14px;
                border-radius: 18px;
            }

            .container .logo {
                font-size: 19px;
                letter-spacing: 3px;
            }

            .container .logo small {
                font-size: 8px;
                letter-spacing: 2px;
            }

            .container .hero {
                min-height: 180px;
            }

            .hero-text {
                padding: 12px;
            }

            .hero-text h2 {
                font-size: 23px;
            }

            .container .hero img {
                height: 180px;
                width: 38%;
            }

            .container .menu-item {
                gap: 9px;
                padding: 7px;
            }

            .container .menu-item img {
                width: 68px;
                height: 68px;
            }

            .container .item-info h4 {
                font-size: 13px;
            }

            .container .item-info p {
                font-size: 10px;
            }

            .container .menu-item strong {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <header>
        <div class="menu-icon">☰</div>

        <div class="logo">
            BREW CO.
            <small>COFFEE &amp; MORE</small>
        </div>

        <div class="cart">🛒</div>
    </header>

    <main>

        <section class="hero">
            <div class="hero-text">
                <h2>Good Coffee,<br>Good Day.</h2>
                <p>Made with love, just for you. ♡</p>
            </div>

            <img
                src="images/coffee.jpg"
                alt="Fresh coffee"
                onerror="this.onerror=null;this.src='images/latte.jpg';"
            >
        </section>

        <h2 class="menu-title">MENU</h2>

        <?php if (empty($categories)): ?>

            <p>No categories available yet.</p>

        <?php else: ?>

            <?php foreach ($categories as $category): ?>

                <?php
                $categoryId = (int)$category["id"];
                $categoryName = $category["name"];
                $items = getItemsForCategory($conn, $categoryId);

                if (empty($items)) {
                    continue;
                }
                ?>

                <section
                    class="category"
                    id="menu-<?= $categoryId ?>"
                >

                    <div class="category-title">
                        <h3>
                            <?= getCategoryIcon($categoryName) ?>
                            <?= htmlspecialchars(strtoupper($categoryName)) ?>
                        </h3>

                        <span>View all ›</span>
                    </div>

                    <?php foreach ($items as $item): ?>

                        <?php $imagePath = getProductImage($item); ?>

                        <article class="menu-item">

                            <img
                                src="<?= htmlspecialchars($imagePath) ?>"
                                alt="<?= htmlspecialchars($item["name"]) ?>"
                                onerror="this.onerror=null;this.src='images/coffee.jpg';"
                            >

                            <div class="item-info">
                                <h4>
                                    <?= htmlspecialchars($item["name"]) ?>
                                </h4>

                                <p>
                                    <?php
                                    $description = trim(
                                        $item["description"] ?? ""
                                    );

                                    echo htmlspecialchars(
                                        $description !== ""
                                            ? $description
                                            : "Freshly prepared with love."
                                    );
                                    ?>
                                </p>
                            </div>

                            <strong>
                                $<?= number_format(
                                    (float)$item["price"],
                                    2
                                ) ?>
                            </strong>

                        </article>

                    <?php endforeach; ?>

                </section>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>

    <footer>
        ☕ WE DELIVER TO YOU

        <p>Made with love ♡</p>
    </footer>

</div>

</body>
</html>
