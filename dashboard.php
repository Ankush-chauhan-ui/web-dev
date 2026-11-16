<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require __DIR__ . '/includes/db.php';


function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}


$statsQuery = $pdo->query(
    "SELECT
        COUNT(*) AS total,
        COALESCE(SUM(status = 'new'), 0) AS pending,
        COALESCE(SUM(status = 'contacted'), 0) AS contacted
     FROM enquiries"
);
$stats = $statsQuery->fetch();


$recentQuery = $pdo->query(
    'SELECT id, name, email, course, status, created_at
     FROM enquiries
     ORDER BY created_at DESC, id DESC
     LIMIT 5'
);
$recentEnquiries = $recentQuery->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TechNova Institute</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6fa;
            color: #172b4d;
        }

        .topbar {
            background: #0b2a4a;
            color: #fff;
            padding: 18px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .brand {
            font-size: 21px;
            font-weight: 700;
        }

        .topbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 18px;
            font-size: 14px;
        }

        .topbar a:hover {
            text-decoration: underline;
        }

        .container {
            width: min(1100px, 92%);
            margin: 35px auto;
        }

        .heading {
            margin-bottom: 25px;
        }

        .heading h1 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .heading p {
            margin: 0;
            color: #64748b;
        }

        .notice {
            background: #fff4d6;
            color: #775600;
            border: 1px solid #f1d78b;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 22px;
            line-height: 1.5;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            padding: 23px;
            border-radius: 12px;
            box-shadow: 0 3px 14px rgba(15, 35, 65, 0.06);
            border: 1px solid #e8edf3;
        }

        .stat-card .label {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .stat-card .number {
            font-size: 34px;
            font-weight: 700;
            color: #0b2a4a;
        }

        .stat-card.pending {
            border-top: 4px solid #e5a000;
        }

        .stat-card.contacted {
            border-top: 4px solid #249653;
        }

        .stat-card.total {
            border-top: 4px solid #2474c6;
        }

        .panel {
            background: #fff;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 3px 14px rgba(15, 35, 65, 0.06);
            border: 1px solid #e8edf3;
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 17px;
        }

        .panel-heading h2 {
            margin: 0;
            font-size: 20px;
        }

        .manage-link {
            display: inline-block;
            background: #0b2a4a;
            color: #fff;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .manage-link:hover {
            background: #16436f;
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 13px 12px;
            text-align: left;
            border-bottom: 1px solid #e9eef4;
            font-size: 14px;
        }

        th {
            color: #52647b;
            background: #f7f9fc;
            font-weight: 600;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status.new {
            background: #fff0d2;
            color: #8a5b00;
        }

        .status.contacted {
            background: #ddf5e6;
            color: #176b37;
        }

        .empty {
            text-align: center;
            padding: 28px 12px;
            color: #64748b;
        }

        footer {
            text-align: center;
            color: #718096;
            padding: 25px 12px;
            font-size: 13px;
        }

        @media (max-width: 700px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .heading h1 {
                font-size: 25px;
            }

            .topbar {
                padding: 16px 4%;
            }

            .topbar a {
                margin-left: 0;
                margin-right: 14px;
            }

            .panel {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="brand">TechNova | Admin Panel</div>
    <nav>
        <a href="index.html">View Website</a>
        <a href="enquiries.php">Manage Enquiries</a>
    </nav>
</header>

<main class="container">
    <section class="heading">
        <h1>Dashboard Overview</h1>
        <p>Monitor admission enquiries submitted through the TechNova website.</p>
    </section>

    <div class="notice">
        <strong>Local demo only:</strong> This dashboard currently has no login protection.
        Run it on your own XAMPP localhost and do not publish it on a public server
        until admin authentication is implemented.
    </div>

    <section class="stats" aria-label="Enquiry statistics">
        <div class="stat-card total">
            <div class="label">Total Enquiries</div>
            <div class="number"><?= e($stats['total']) ?></div>
        </div>

        <div class="stat-card pending">
            <div class="label">New / Pending Enquiries</div>
            <div class="number"><?= e($stats['pending']) ?></div>
        </div>

        <div class="stat-card contacted">
            <div class="label">Contacted Enquiries</div>
            <div class="number"><?= e($stats['contacted']) ?></div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <h2>Recent Enquiries</h2>
            <a class="manage-link" href="enquiries.php">Manage All Enquiries</a>
        </div>

        <?php if (count($recentEnquiries) === 0): ?>
            <div class="empty">
                No enquiries have been submitted yet. Submit the admission form
                on the website to see records here.
            </div>
        <?php else: ?>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Date Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentEnquiries as $enquiry): ?>
                            <tr>
                                <td><?= e($enquiry['name']) ?></td>
                                <td><?= e($enquiry['email']) ?></td>
                                <td><?= e($enquiry['course']) ?></td>
                                <td>
                                    <span class="status <?= e($enquiry['status']) ?>">
                                        <?= e($enquiry['status']) ?>
                                    </span>
                                </td>
                                <td><?= e($enquiry['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>

<footer>
    TechNova Institute of Engineering &copy; <?= date('Y') ?>. Admin Dashboard.
</footer>

</body>
</html>
