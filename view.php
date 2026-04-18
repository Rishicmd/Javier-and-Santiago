<?php
require 'config.php';
$page_title = 'View Student';

$id = $_GET['id'] ?? '';
$student = $id ? getStudent($id) : null;

if (!$student) {
    header('Location: index.php');
    exit;
}

require 'header.php';

$statusColors = [
    'Enrolled'         => 'var(--accent2)',
    'Irregular'        => 'var(--warn)',
    'Dropped'          => 'var(--danger)',
    'Leave of Absence' => 'var(--info)',
    'Graduated'        => '#d2a8ff',
];
$color = $statusColors[$student['status']] ?? 'var(--text)';
?>

<main>
  <div class="page-header">
    <h1>👁 Student Profile</h1>
    <p>Viewing full record for <strong><?= htmlspecialchars($student['name']) ?></strong></p>
  </div>

  <div class="card" style="max-width:600px;">
    <div style="background:var(--bg3); padding:1.5rem; display:flex; align-items:center; gap:1rem; border-bottom:1px solid var(--border);">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:1.4rem;font-weight:700;flex-shrink:0;">
        <?= strtoupper(substr($student['name'], 0, 1)) ?>
      </div>
      <div>
        <div style="font-size:1.2rem; font-weight:700;"><?= htmlspecialchars($student['name']) ?></div>
        <div style="color:var(--muted); font-size:0.85rem;"><?= htmlspecialchars($student['email']) ?></div>
      </div>
      <span class="id-chip" style="margin-left:auto;"><?= htmlspecialchars($student['id']) ?></span>
    </div>
    <div class="card-body">
      <table style="width:100%;">
        <?php
        $rows = [
            'Course'     => $student['course'],
            'Year Level' => $student['year'],
            'Status'     => "<span style='color:{$color};font-weight:600;'>{$student['status']}</span>",
            'Student ID' => "<span class='id-chip'>{$student['id']}</span>",
        ];
        foreach ($rows as $label => $val): ?>
        <tr>
          <td style="color:var(--muted); font-size:0.82rem; text-transform:uppercase; letter-spacing:0.4px; font-weight:600; padding:10px 0; width:120px; vertical-align:top;"><?= $label ?></td>
          <td style="padding:10px 0; font-size:0.9rem;"><?= $val ?></td>
        </tr>
        <?php endforeach; ?>
      </table>

      <div style="display:flex; gap:10px; margin-top:1.5rem; padding-top:1.2rem; border-top:1px solid var(--border);">
        <a href="edit.php?id=<?= urlencode($student['id']) ?>" class="btn btn-edit">✏️ Edit Record</a>
        <a href="index.php" class="btn btn-ghost">← Back to List</a>
      </div>
    </div>
  </div>
</main>

<?php require 'footer.php'; ?>
