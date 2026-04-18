<?php
require 'config.php';
$page_title = 'Enroll Student';
$errors = [];
$form = ['name'=>'','email'=>'','course'=>'','year'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name']   = trim($_POST['name'] ?? '');
    $form['email']  = trim($_POST['email'] ?? '');
    $form['course'] = trim($_POST['course'] ?? '');
    $form['year']   = trim($_POST['year'] ?? '');

    if (empty($form['name']))   $errors[] = 'Full name is required.';
    if (empty($form['email']) || !filter_var($form['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = 'A valid email address is required.';
    if (empty($form['course'])) $errors[] = 'Please select a course.';
    if (empty($form['year']))   $errors[] = 'Please select a year level.';

    // Check duplicate email
    if (empty($errors)) {
        foreach (getStudents() as $s) {
            if (strtolower($s['email']) === strtolower($form['email'])) {
                $errors[] = 'A student with this email already exists.';
                break;
            }
        }
    }

    if (empty($errors)) {
        // Write to XML
        $xml = simplexml_load_file(XML_FILE);
        $id = generateID();
        $student = $xml->addChild('student');
        $student->addChild('id', $id);
        $student->addChild('n', sanitize($form['name']));
        $student->addChild('email', sanitize($form['email']));
        $student->addChild('course', sanitize($form['course']));
        $student->addChild('year', sanitize($form['year']));
        $student->addChild('status', 'Enrolled');
        $xml->asXML(XML_FILE);

        header('Location: index.php?msg=added');
        exit;
    }
}

require 'header.php';
?>

<main>
  <div class="page-header">
    <h1>➕ Enroll New Student</h1>
    <p>Fill in the form below to register a student into the system.</p>
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
            <input type="text" name="name" placeholder="e.g. Maria Santos"
                   value="<?= htmlspecialchars($form['name']) ?>" required>
          </div>
          <div class="form-group" style="grid-column:1/-1;">
            <label>Email Address *</label>
            <input type="email" name="email" placeholder="e.g. maria@email.com"
                   value="<?= htmlspecialchars($form['email']) ?>" required>
          </div>
          <div class="form-group" style="grid-column:1/-1;">
            <label>Course / Program *</label>
            <select name="course" required>
              <option value="">— Select Course —</option>
              <?php foreach ($courses as $c): ?>
                <option value="<?= htmlspecialchars($c) ?>"
                  <?= $form['course']===$c ? 'selected':'' ?>>
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
        </div>

        <div style="display:flex; gap:10px; margin-top:0.5rem;">
          <button type="submit" class="btn btn-primary">✅ Enroll Student</button>
          <a href="index.php" class="btn btn-ghost">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</main>

<?php require 'footer.php'; ?>
