<?php
require 'config.php';

$id = $_GET['id'] ?? '';

if ($id) {
    $xml = simplexml_load_file(XML_FILE);
    foreach ($xml->student as $s) {
        if ((string)$s->id === $id) {
            $node = dom_import_simplexml($s);
            $node->parentNode->removeChild($node);
            $xml->asXML(XML_FILE);
            break;
        }
    }
}

header('Location: index.php?msg=deleted');
exit;
