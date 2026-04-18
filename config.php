<?php
define('XML_FILE', __DIR__ . '/students.xml');
define('SITE_NAME', 'ScholarMS');

function initXML() {
    if (!file_exists(XML_FILE)) {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><students></students>');
        $xml->asXML(XML_FILE);
    }
}

function getStudents() {
    initXML();
    $xml = simplexml_load_file(XML_FILE);
    $students = [];
    foreach ($xml->student as $s) {
        $students[] = [
            'id'     => (string)$s->id,
            'name'   => (string)$s->n,
            'email'  => (string)$s->email,
            'course' => (string)$s->course,
            'year'   => (string)$s->year,
            'status' => (string)$s->status,
        ];
    }
    return $students;
}

function getStudent($id) {
    initXML();
    $xml = simplexml_load_file(XML_FILE);
    foreach ($xml->student as $s) {
        if ((string)$s->id === $id) {
            return [
                'id'     => (string)$s->id,
                'name'   => (string)$s->n,
                'email'  => (string)$s->email,
                'course' => (string)$s->course,
                'year'   => (string)$s->year,
                'status' => (string)$s->status,
            ];
        }
    }
    return null;
}

function generateID() {
    initXML();
    $xml = simplexml_load_file(XML_FILE);
    $max = 0;
    foreach ($xml->student as $s) {
        $num = (int)substr((string)$s->id, 1);
        if ($num > $max) $max = $num;
    }
    return 'S' . str_pad($max + 1, 4, '0', STR_PAD_LEFT);
}

function sanitize($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

$courses = [
    
    'Bachelor of Science in Information Technology',
    'Bachelor of Science in Architecture',
    'Bachelor of Science in Education',
    'Bachelor of Science in Nursing',
    'Bachelor of Science in Business Administration',
    'Bachelor of Science in Accountancy',
    'Bachelor of Arts in Communication',
    'Bachelor of Engineering',
];

$years = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
$statuses = ['Enrolled', 'Irregular', 'Leave of Absence', 'Dropped', 'Graduated'];
?>