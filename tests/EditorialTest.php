<?php
require_once __DIR__ . '/../models/Editorial.php';

class EditorialTest {
    public function testEditorialCreation() {
        $editorial = new Editorial(1, 'Penguin Random House', 'USA');
        assert($editorial->id_editorial === 1);
        assert($editorial->nombre === 'Penguin Random House');
        assert($editorial->pais === 'USA');
        echo "EditorialTest passed.\n";
    }
}

$test = new EditorialTest();
$test->testEditorialCreation();
?>
