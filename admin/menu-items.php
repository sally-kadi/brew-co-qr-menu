
<?php
include "db.php";

$sql = "SELECT
            menu_items.id,
            menu_items.name,
            menu_items.description,
            menu_items.price,
            menu_items.image,
            menu_items.status,
            categories.name AS category_name
        FROM menu_items
        LEFT JOIN categories
            ON menu_items.category_id = categories.id
        ORDER BY menu_items.id ASC";

$result = $conn->query($sql);

if (!$result) {
    die("Error loading menu items: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items - Brew Co.</title>

    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f7f3ee;
            color: #3b2a20;
        }

        .container {
            max-width: 1250px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 8px;
            color: #4b3024;
        }

        .subtitle {
            color: #78675c;
            margin-bottom: 25px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 9px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            border: none;
            cursor: pointer;
            color: white !important;
            margin: 2px;
        }

        .add-btn {
            background: #6f4e37;
        }

        .back-btn {
            background: #8b86ad;
        }

        .edit-btn {
            background: #319b91;
        }

        .delete-btn {
            background: #b84d68;
        }

        .activate-btn {
            background: #43815c;
        }

        .deactivate-btn {
            background: #c18a39;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        #menuTable {
            width: 100% !important;
            border-collapse: collapse;
        }

        #menuTable thead th {
            background: #8b6b61;
            color: white;
            padding: 12px 10px;
            text-align: left;
        }

        #menuTable tbody td {
            padding: 12px 10px;
            vertical-align: middle;
        }

        #menuTable tbody tr:hover {
            background: #fbf8f4;
        }

        .item-image {
            width: 60px;
            height: 55px;
            object-fit: cover;
            border-radius: 7px;
            display: block;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .active {
            background: #d9f2df;
            color: #216b36;
        }

        .inactive {
            background: #f8dddd;
            color: #a12b2b;
        }

        .counter {
            font-weight: bold;
            color: #6f4e37;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #6f4e37;
            text-decoration: none;
        }

        .dataTables_wrapper {
            margin-top: 15px;
            color: #3b2a20;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            padding: 6px;
            border: 1px solid #d8c9bd;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #8b6b61 !important;
            color: white !important;
            border: 1px solid #8b6b61 !important;
        }

        @media (max-width: 700px) {
            body {
                padding: 12px;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="top-bar">
        <div>
            <h1>Brew Co. - Menu Items</h1>
            <p class="subtitle">Manage your coffee shop menu items.</p>
        </div>

        <div>
            <a href="index.php" class="btn back-btn">Dashboard</a>
            <a href="add-menu-item.php" class="btn add-btn">+ Add Menu Item</a>
        </div>
    </div>

    <div class="table-wrapper">
        <table id="menuTable">
            <thead>
                <tr>
                    <th>Counter</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $counter = 1;

            if ($result->num_rows > 0):
                while ($item = $result->fetch_assoc()):

                    $isActive = (int)$item["status"] === 1;

                    $imagePath = trim($item["image"] ?? "");
                    $imagePath = str_replace("\\", "/", $imagePath);
                    $imageName = basename($imagePath);

                    $imageUrl = "";

                    if (
                        $imageName !== "" &&
                        $imageName !== "." &&
                        $imageName !== ".."
                    ) {
                        $imageUrl = "../images/" . rawurlencode($imageName);
                    }
            ?>

                <tr>
                    <td class="counter"><?= $counter++ ?></td>

                    <td>
                        <?php if ($imageUrl !== ""): ?>
                            <img
                                class="item-image"
                                src="<?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($item["name"], ENT_QUOTES, 'UTF-8') ?>"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
                            >
                            <span style="display:none;">No image</span>
                        <?php else: ?>
                            No image
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["name"] ?? "", ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["description"] ?? "", ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        $<?= number_format((float)$item["price"], 2) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item["category_name"] ?? "No category", ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?php if ($isActive): ?>
                            <span class="status active">Active</span>
                        <?php else: ?>
                            <span class="status inactive">Inactive</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a
                            class="btn <?= $isActive ? 'deactivate-btn' : 'activate-btn' ?>"
                            href="toggle-menu-item.php?id=<?= (int)$item["id"] ?>"
                            onclick="return confirm('Change this item status?')">
                            <?= $isActive ? 'Deactivate' : 'Activate' ?>
                        </a>

                        <a
                            class="btn edit-btn"
                            href="edit-menu-item.php?id=<?= (int)$item["id"] ?>">
                            Edit
                        </a>

                        <a
                            class="btn delete-btn"
                            href="delete-menu-item.php?id=<?= (int)$item["id"] ?>"
                            onclick="return confirm('Are you sure you want to delete this item?')">
                            Delete
                        </a>
                    </td>
                </tr>

            <?php
                endwhile;
            endif;
            ?>
            </tbody>
        </table>
    </div>

    <a href="index.php" class="back-link">Back to Dashboard</a>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#menuTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        paging: true,
        info: true,
        columnDefs: [
            { orderable: false, targets: [0, 1, 7] }
        ],
        language: {
            search: "Search menu items:",
            lengthMenu: "Show _MENU_ items",
            info: "Showing _START_ to _END_ of _TOTAL_ items",
            infoEmpty: "Showing 0 to 0 of 0 items",
            zeroRecords: "No matching menu items found",
            emptyTable: "No menu items available",
            paginate: {
                previous: "Previous",
                next: "Next"
            }
        }
    });
});
</script>

</body>
</html>
