<?php
require 'config.php';
$page_title = 'Search Students';

$query = trim($_GET['q'] ?? '');
$results = [];

if ($query !== '') {
    $all = getStudents();
    foreach ($all as $s) {
        $haystack = strtolower($s['name'] . ' ' . $s['email'] . ' ' . $s['course'] . ' ' . $s['id'] . ' ' . $s['status']);
        if (strpos($haystack, strtolower($query)) !== false) {
            $results[] = $s;
        }
    }
}

require 'header.php';

function highlight($text, $query) {
    if (!$query) return htmlspecialchars($text);
    $safe = htmlspecialchars($text);
    $safeQ = htmlspecialchars($query);
    return preg_replace('/(' . preg_quote($safeQ, '/') . ')/i',
        '<mark style="background:rgba(46,160,67,0.3);color:var(--accent2);border-radius:2px;">$1</mark>', $safe);
}
?>

<main>
  <div class="page-header">
    <h1>🔍 Search Students</h1>
    <p>Search by name, email, course, ID, or status.</p>
  </div>

  <form method="GET" style="margin-bottom:1.5rem;">
    <div style="display:flex; gap:10px; max-width:500px;">
      <input type="text" name="q" value="<?= htmlspecialchars($query) ?>"
             placeholder="Type to search..."
             style="flex:1; padding:10px 14px; background:var(--bg2); border:1px solid var(--border);
                    border-radius:6px; color:var(--text); font-size:0.9rem; font-family:Sora,sans-serif; outline:none;"
             autofocus>
      <button type="submit" class="btn btn-primary">Search</button>
      <?php if ($query): ?>
        <a href="search.php" class="btn btn-ghost">Clear</a>
      <?php endif; ?>
    </div>
  </form>

  <?php if ($query !== ''): ?>
    <p style="color:var(--muted); font-size:0.875rem; margin-bottom:1rem;">
      <?= count($results) ?> result(s) for "<strong style="color:var(--text);"><?= htmlspecialchars($query) ?></strong>"
    </p>

    <?php if (empty($results)): ?>
      <div class="card">
        <div class="card-body" style="text-align:center; padding:2.5rem; color:var(--muted);">
          <p style="font-size:2rem;">🔎</p>
          <p style="margin-top:8px;">No students matched your search.</p>
        </div>
      </div>
    <?php else: ?>
      <div class="card">
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
            <?php foreach ($results as $s): ?>
            <tr>
              <td><span class="id-chip"><?= highlight($s['id'], $query) ?></span></td>
              <td><strong><?= highlight($s['name'], $query) ?></strong></td>
              <td style="color:var(--muted);"><?= highlight($s['email'], $query) ?></td>
              <td style="font-size:0.82rem;"><?= highlight($s['course'], $query) ?></td>
              <td><?= htmlspecialchars($s['year']) ?></td>
              <td><?= highlight($s['status'], $query) ?></td>
              <td>
                <div style="display:flex; gap:6px;">
                  <a href="view.php?id=<?= urlencode($s['id']) ?>" class="btn btn-ghost btn-sm">👁 View</a>
                  <a href="edit.php?id=<?= urlencode($s['id']) ?>" class="btn btn-edit btn-sm">✏️ Edit</a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</main>

<?php require 'footer.php'; ?>
