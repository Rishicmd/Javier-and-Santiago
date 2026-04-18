<?php
require 'config.php';
$page_title = 'Edit Student';

$id = $_GET['id'] ?? '';
$student = $id ? getStudent($id) : null;

if (!$student) {
    header('Location: index.php');
    exit;
}

$errors = [];
$form = $student; // pre-fill form

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name']   = trim($_POST['name'] ?? '');
    $form['email']  = trim($_POST['email'] ?? '');
    $form['course'] = trim($_POST['course'] ?? '');
    $form['year']   = trim($_POST['year'] ?? '');
    $form['status'] = trim($_POST['status'] ?? '');

    if (empty($form['name']))   $errors[] = 'Full name is required.';
    if (empty($form['email']) || !filter_var($form['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = 'A valid email address is required.';
    if (empty($form['course'])) $errors[] = 'Please select a course.';
    if (empty($form['year']))   $errors[] = 'Please select a year level.';
    if (empty($form['status'])) $errors[] = 'Please select a status.';

    // Check duplicate email (exclude self)
    if (empty($errors)) {
        foreach (getStudents() as $s) {
            if (strtolower($s['email']) === strtolower($form['email']) && $s['id'] !== $id) {
                $errors[] = 'Another student already uses this email.';
                break;
            }
        }
    }

    if (empty($errors)) {
        // Update XML
        $xml = simplexml_load_file(XML_FILE);
        foreach ($xml->student as $s) {
            if ((string)$s->id === $id) {
                $s->n      = sanitize($form['name']);
                $s->email  = sanitize($form['email']);
                $s->course = sanitize($form['course']);
                $s->year   = sanitize($form['year']);
                $s->status = sanitize($form['status']);
                break;
            }
        }
        $xml->asXML(XML_FILE);
        header('Location: index.php?msg=updated');
        exit;
    }
}

require 'header.php';
?>

<main>
  <div class="page-header">
    <h1>✏️ Edit Student Record</h1>
    <p>Updating record for <span class="id-chip"><?= htmlspecialchars($id) ?></span></p>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <div>
        <strong>Please fix the following:</strong>
        <ul style="margin-top:6px; padding-left:18px;">
          <?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>

  <div class="card" style="max-width:680px;">
    <div class="card-body">
      <form method="POST">
        <div class="form-grid">
          <div class="form-group" style="grid-column:1/-1;">
            <label>Full Name *</label>
            <input type="text" name="name" value="<?= htmlspecialchars($form['name']) ?>" required>
          </div>
          <div class="form-group" style="grid-column:1/-1;">
            <label>Email Address *</label>
            <input type="email" name="email" value="<?= htmlspecialchars($form['email']) ?>" required>
          </div>
          <div class="form-group" style="grid-column:1/-1;">
            <label>Course / Program *</label>
            <select name="course" required>
              <option value="">— Select Course —</option>
              <?php foreach ($courses as $c): ?>
                <option value="<?= htmlspecialchars($c) ?>" <?= $form['course']===$c ? 'selected':'' ?>>
                  <?= htmlspecialchars($c) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Year Level *</label>
            <select name="year" required>
              <option value="">— Select Year —</option>
              <?php foreach ($years as $y): ?>
                <option value="<?= $y ?>" <?= $form['year']===$y ? 'selected':'' ?>><?= $y ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Status *</label>
            <select name="status" required>
              <?php foreach ($statuses as $st): ?>
                <option value="<?= $st ?>" <?= $form['status']===$st ? 'selected':'' ?>><?= $st ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:0.5rem;">
          <button type="submit" class="btn btn-primary">💾 Save Changes</button>
          <a href="index.php" class="btn btn-ghost">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</main>

<?php require 'footer.php'; ?>
