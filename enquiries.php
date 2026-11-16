<?php
// ============================================================
// enquiries.php - view and manage enquiries (READ, UPDATE, DELETE)
//
// WARNING: this page has NO LOGIN yet. Anyone who knows the address can
// see student names, emails and phone numbers. Use it only on your own
// computer (localhost). Do not upload it to a public server until you add
// login (password_hash + sessions - the next thing in your course).
// ============================================================

require __DIR__ . '/includes/db.php';

// Small helper: makes text safe to print inside HTML.
// If a visitor typed <script>...</script> in the message box, this turns it
// into harmless text instead of running it (XSS protection).
function e($text): string
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

// ---------- UPDATE and DELETE ----------
// The buttons below are small forms that send POST requests.
// Changing data uses POST, not links (GET), so a crawler or a stray click
// on a link can never delete something.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int) ($_POST['id'] ?? 0);      // (int) makes sure it is a number
    $action = $_POST['action'] ?? '';

    if ($id > 0) {
        if ($action === 'contacted') {
            $stmt = $pdo->prepare("UPDATE enquiries SET status = 'contacted' WHERE id = :id");
            $stmt->execute([':id' => $id]);
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM enquiries WHERE id = :id');
            $stmt->execute([':id' => $id]);
        }
    }

    // Redirect so refreshing the page does not repeat the action
    header('Location: enquiries.php');
    exit;
}

// ---------- READ ----------
// Newest enquiries first
$rows = $pdo->query(
    'SELECT id, name, email, phone, course, message, status, created_at
     FROM enquiries
     ORDER BY created_at DESC, id DESC'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Enquiries | TechNova Institute</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f9; color: #222; }
    .wrap { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
    h1 { margin-bottom: 4px; }
    .note { background: #fff3cd; border: 1px solid #ffe08a; padding: 10px 14px; border-radius: 6px; font-size: 14px; margin: 12px 0 20px; }
    .table-scroll { overflow-x: auto; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
    table { border-collapse: collapse; width: 100%; min-width: 800px; }
    th, td { text-align: left; padding: 10px 12px; border-bottom: 1px solid #e5e8ec; vertical-align: top; font-size: 14px; }
    th { background: #0b2a4a; color: #fff; }
    .badge { padding: 2px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
    .badge.new { background: #ffe5e0; color: #b3261e; }
    .badge.contacted { background: #dff3e4; color: #1b6e32; }
    .actions form { display: inline; }
    button { cursor: pointer; border: 0; border-radius: 4px; padding: 6px 10px; font-size: 13px; }
    .btn-ok { background: #1b6e32; color: #fff; }
    .btn-del { background: #b3261e; color: #fff; }
    .empty { padding: 24px; text-align: center; color: #666; }
    a { color: #0b2a4a; }
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Admission Enquiries</h1>
    <div><a href="index.html">&larr; Back to website</a></div>

    <div class="note">
      This page has no login yet, so use it on localhost only. Total enquiries: <strong><?= count($rows) ?></strong>
    </div>

    <div class="table-scroll">
      <?php if (count($rows) === 0): ?>
        <div class="empty">No enquiries yet. Submit the form on the website and refresh this page.</div>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Course</th>
              <th>Message</th><th>Received</th><th>Status</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?= e($row['id']) ?></td>
                <td><?= e($row['name']) ?></td>
                <td><?= e($row['email']) ?></td>
                <td><?= e($row['phone']) ?></td>
                <td><?= e($row['course']) ?></td>
                <td><?= nl2br(e($row['message'])) ?></td>
                <td><?= e($row['created_at']) ?></td>
                <td><span class="badge <?= e($row['status']) ?>"><?= e($row['status']) ?></span></td>
                <td class="actions">
                  <?php if ($row['status'] === 'new'): ?>
                    <form method="POST">
                      <input type="hidden" name="id" value="<?= e($row['id']) ?>">
                      <input type="hidden" name="action" value="contacted">
                      <button type="submit" class="btn-ok">Mark contacted</button>
                    </form>
                  <?php endif; ?>
                  <form method="POST" onsubmit="return confirm('Delete this enquiry permanently?');">
                    <input type="hidden" name="id" value="<?= e($row['id']) ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="btn-del">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
