<?php
require 'config.php';
$page_title = 'All Students';
$students = getStudents();
$msg = $_GET['msg'] ?? '';
require 'header.php';

function statusBadge($status) {
    $map = [
        'Enrolled'        => 'enrolled',
        'Irregular'       => 'irregular',
        'Dropped'         => 'dropped',
        'Leave of Absence'=> 'leave',
        'Graduated'       => 'graduated',
    ];
    $cls = $map[$status] ?? 'enrolled';
    return "<span class='badge badge-{$cls}'>{$status}</span>";
}
?>

<main>
  <div class="page-header">
    <h1>Student Records</h1>
    <p>Manage all enrolled students in the system.</p>
  </div>

  <?php if ($msg === 'added'):   ?><div class="alert alert-success">✅ Student successfully enrolled!</div><?php endif; ?>
  <?php if ($msg === 'updated'): ?><div class="alert alert-info">✏️ Student record updated successfully.</div><?php endif; ?>
  <?php if ($msg === 'deleted'): ?><div class="alert alert-danger">🗑️ Student record has been deleted.</div><?php endif; ?>

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
    <span style="color:var(--muted); font-size:0.875rem;"><?= count($students) ?> student(s) found</span>
    <a href="add.php" class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Enroll Student
    </a>
  </div>

  <div class="card">
    <?php if (empty($students)): ?>
      <div class="card-body" style="text-align:center; padding:3rem; color:var(--muted);">
        <p style="font-size:2rem;">📭</p>
        <p style="margin-top:8px;">No students enrolled yet. <a href="add.php" style="color:var(--accent2);">Add one now.</a></p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Course</th>
          <th>Year</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($students as $s): ?>
        <tr>
          <td><span class="id-chip"><?= htmlspecialchars($s['id']) ?></span></td>
          <td><strong><?= htmlspecialchars($s['name']) ?></strong></td>
          <td style="color:var(--muted);"><?= htmlspecialchars($s['email']) ?></td>
          <td style="font-size:0.82rem;"><?= htmlspecialchars($s['course']) ?></td>
          <td><?= htmlspecialchars($s['year']) ?></td>
          <td><?= statusBadge($s['status']) ?></td>
          <td>
            <div style="display:flex; gap:6px;">
              <a href="view.php?id=<?= urlencode($s['id']) ?>" class="btn btn-ghost btn-sm">👁 View</a>
              <a href="edit.php?id=<?= urlencode($s['id']) ?>" class="btn btn-edit btn-sm">✏️ Edit</a>
              <button onclick="confirmDelete('<?= urlencode($s['id']) ?>', '<?= htmlspecialchars(addslashes($s['name'])) ?>')"
                      class="btn btn-danger btn-sm">🗑 Del</button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</main>

<!-- Confirm Delete Modal -->
<div class="confirm-overlay" id="confirmOverlay">
  <div class="confirm-box">
    <p style="font-size:2.5rem; margin-bottom:12px;">⚠️</p>
    <h3>Delete Student?</h3>
    <p id="confirmMsg">This action cannot be undone.</p>
    <div class="confirm-actions">
      <button class="btn btn-ghost" onclick="closeConfirm()">Cancel</button>
      <a id="confirmLink" href="#" class="btn btn-danger">Yes, Delete</a>
    </div>
  </div>
</div>

<script>
function confirmDelete(id, name) {
  document.getElementById('confirmMsg').textContent = 'Delete "' + name + '"? This cannot be undone.';
  document.getElementById('confirmLink').href = 'delete.php?id=' + id;
  document.getElementById('confirmOverlay').classList.add('show');
}
function closeConfirm() {
  document.getElementById('confirmOverlay').classList.remove('show');
}
document.getElementById('confirmOverlay').addEventListener('click', function(e){
  if(e.target === this) closeConfirm();
});
</script>

<?php require 'footer.php'; ?>
