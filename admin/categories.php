
<?php
require_once "db.php";

$sql = "SELECT id, name, status FROM categories ORDER BY id ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Error loading categories: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Brew Co.</title>

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
            background: #f8f5f1;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        h1 {
            color: #6f4e37;
            margin-top: 0;
        }

        .add-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 11px 16px;
            background: #8b6b91;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        #categoriesTable {
            width: 100%;
            border-collapse: collapse;
        }

        #categoriesTable thead th {
            padding: 12px;
            background: #8b6b91;
            color: white;
            text-align: left;
        }

        #categoriesTable tbody td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        #categoriesTable tbody tr:nth-child(even) {
            background: #f8f5f1;
        }

        a {
            text-decoration: none;
        }

        .edit {
            color: #287c8e;
            font-weight: bold;
        }

        .delete {
            color: #c7475a;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 7px 10px;
            margin: 2px;
            color: white;
            border-radius: 5px;
            font-size: 12px;
        }

        .toggle {
            background: #c58b35;
        }

        .activate {
            background: #56860a;
        }

        .active {
            color: green;
            font-weight: bold;
        }

        .inactive {
            color: red;
            font-weight: bold;
        }

        .counter {
            color: #6f4e37;
            font-weight: bold;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #6f4e37;
        }

        .dataTables_wrapper {
            font-size: 14px;
            color: #333;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #cbb9aa;
            border-radius: 5px;
            padding: 7px;
            background: white;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #8b6b91 !important;
            color: white !important;
            border: 1px solid #8b6b91 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #6f4e37 !important;
            color: white !important;
            border: 1px solid #6f4e37 !important;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 12px;
            }

            #categoriesTable th,
            #categoriesTable td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <h1>Categories</h1>

    <a class="add-button" href="add-category.php">+ Add Category</a>

    <table id="categoriesTable">
        <thead>
            <tr>
                <th>Counter</th>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $counter = 1;

        while ($row = $result->fetch_assoc()):
            $isActive = (int)$row['status'] === 1;
        ?>
            <tr>
                <td class="counter"><?= $counter++ ?></td>

                <td>
                    <?= htmlspecialchars(
                        $row['name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?php if ($isActive): ?>
                        <span class="active">Active</span>
                    <?php else: ?>
                        <span class="inactive">Inactive</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a
                        class="button <?= $isActive ? 'toggle' : 'activate' ?>"
                        href="toggle-category.php?id=<?= (int)$row['id'] ?>"
                        onclick="return confirm('Change this category status?')">
                        <?= $isActive ? 'Deactivate' : 'Activate' ?>
                    </a>

                    <a
                        class="edit"
                        href="edit-category.php?id=<?= (int)$row['id'] ?>">
                        Edit
                    </a>

                    |

                    <a
                        class="delete"
                        href="delete-category.php?id=<?= (int)$row['id'] ?>"
                        onclick="return confirm('Are you sure you want to delete this category?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a class="back" href="index.php">Back to Dashboard</a>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#categoriesTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        ordering: true,
        searching: true,
        paging: true,
        info: true,
        order: [],
        columnDefs: [
            { orderable: false, targets: [0, 3] }
        ],
        language: {
            search: "Search categories:",
            lengthMenu: "Show _MENU_ categories",
            info: "Showing _START_ to _END_ of _TOTAL_ categories",
            infoEmpty: "No categories available",
            emptyTable: "No categories found",
            zeroRecords: "No matching categories found",
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
