
<?php
include "db.php";

$sql = "SELECT menu_items.*, categories.name AS category_name
        FROM menu_items
        LEFT JOIN categories ON menu_items.category_id = categories.id
        ORDER BY menu_items.id DESC";

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
            font-family: Arial, sans-serif;
            background: #f7f3ee;
            margin: 0;
            padding: 30px;
            color: #3b2a20;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
            overflow-x: auto;
        }

        h1 {
            color: #6f4e37;
            margin-top: 0;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .add-button,
        .back-button {
            display: inline-block;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
        }

        .add-button {
            background: #6f4e37;
        }

        .back-button {
            background: #8c8178;
        }

        #itemsTable {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        #itemsTable thead th {
            background: #6f4e37;
            color: white;
            padding: 12px;
            text-align: left;
        }

        #itemsTable tbody td {
            padding: 12px;
            border-bottom: 1px solid #eee5dc;
            vertical-align: middle;
        }

        #itemsTable tbody tr:hover {
            background: #fbf8f4;
        }

        .item-image {
            width: 65px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .button {
            display: inline-block;
            padding: 8px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            margin: 2px;
            font-size: 12px;
            white-space: nowrap;
        }

        .edit-button,
        .activate-button {
            background: #287a52;
        }

        .delete-button {
            background: #b33a3a;
        }

        .toggle-button {
            background: #b87924;
        }

        .active {
            display: inline-block;
            color: #216b36;
            background: #d9f2df;
            padding: 6px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
        }

        .inactive {
            display: inline-block;
            color: #a12b2b;
            background: #f8dddd;
            padding: 6px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
        }

        .counter {
            font-weight: bold;
            color: #6f4e37;
        }

        .actions {
            min-width: 190px;
        }

        .image-error {
            color: #78675c;
            font-size: 12px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #6f4e37;
            text-decoration: none;
        }

        .dataTables_wrapper {
            color: #3b2a20;
            font-size: 14px;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #cbb9aa;
            border-radius: 5px;
            padding: 7px;
            background: white;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #6f4e37 !important;
            color: white !important;
            border: 1px solid #6f4e37 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #8c6750 !important;
            color: white !important;
            border: 1px solid #8c6750 !important;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
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
            <p>Manage your coffee shop menu items.</p>
        </div>

        <div>
            <a class="back-button" href="index.php">Dashboard</a>
            <a class="add-button" href="add-item.php">+ Add Item</a>
        </div>
    </div>

    <table id="itemsTable">
        <thead>
            <tr>
                <th>Counter</th>
                <th>Category</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price ($)</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $displayId = 1;

        if ($result->num_rows > 0):
            while ($item = $result->fetch_assoc()):

                $isActive = (int)($item['status'] ?? 0) === 1;

                $imagePath = trim($item['image'] ?? '');
                $imagePath = str_replace('\\', '/', $imagePath);
                $imageName = basename($imagePath);
                $imageUrl = '';

                if (
                    $imageName !== '' &&
                    $imageName !== '.' &&
                    $imageName !== '..'
                ) {
                    $imageUrl = '../images/' . rawurlencode($imageName);
                }
        ?>

            <tr>
                <td class="counter">
                    <?= $displayId++ ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $item['category_name'] ?? 'No Category',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $item['name'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $item['description'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    $<?= number_format((float)($item['price'] ?? 0), 2) ?>
                </td>

                <td>
                    <?php if ($imageUrl !== ''): ?>
                        <img
                            class="item-image"
                            src="<?= htmlspecialchars(
                                $imageUrl,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            alt="<?= htmlspecialchars(
                                $item['name'] ?? 'Menu item',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
                        >
                        <span class="image-error" style="display:none;">
                            Image not found
                        </span>
                    <?php else: ?>
                        <span class="image-error">No image</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($isActive): ?>
                        <span class="active">Active</span>
                    <?php else: ?>
                        <span class="inactive">Inactive</span>
                    <?php endif; ?>
                </td>

                <td>
                    <div class="actions">

                        <a
                            class="button <?= $isActive ? 'toggle-button' : 'activate-button' ?>"
                            href="toggle-item.php?id=<?= (int)$item['id'] ?>"
                            onclick="return confirm('Change this item status?')">
                            <?= $isActive ? 'Deactivate' : 'Activate' ?>
                        </a>

                        <a
                            class="button edit-button"
                            href="edit-item.php?id=<?= (int)$item['id'] ?>">
                            Edit
                        </a>

                        <a
                            class="button delete-button"
                            href="delete-item.php?id=<?= (int)$item['id'] ?>"
                            onclick="return confirm('Are you sure you want to delete this item?')">
                            Delete
                        </a>

                    </div>
                </td>
            </tr>

        <?php
            endwhile;
        endif;
        ?>
        </tbody>
    </table>

    <a class="back-link" href="index.php">Back to Dashboard</a>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#itemsTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        ordering: true,
        searching: true,
        paging: true,
        info: true,
        order: [],
        columnDefs: [
            { orderable: false, targets: [0, 5, 7] }
        ],
        language: {
            search: "Search menu items:",
            lengthMenu: "Show _MENU_ items",
            info: "Showing _START_ to _END_ of _TOTAL_ items",
            infoEmpty: "No menu items available",
            emptyTable: "No menu items found",
            zeroRecords: "No matching menu items found",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });
});
</script>

</body>
</html>
