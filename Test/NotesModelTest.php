<?php

require_once "tests/units/Base.php";

use Kanboard\Core\Plugin\Loader;
use Kanboard\Plugin\Notes\Plugin;
use Kanboard\Plugin\Notes\Model\NotesModel;

class NotesModelTest extends Base
{
    const USER_ID = 1;

    public function setUp(): void
    {
        parent::setUp();

        $plugin = new Loader($this->container);
        $plugin->scan();
    }

    public function testCreateNote()
    {
        $plugin = new Plugin($this->container);
        $plugin->initialize();
        $notesModel = new NotesModel($this->container);
        $result = $this->createTestNote($notesModel);
        $this->assertNotNull($result);
    }

    public function testGetAll()
    {
        $plugin = new Plugin($this->container);
        $plugin->initialize();
        $notesModel = new NotesModel($this->container);
        $this->createTestNote($notesModel);
        $result = $notesModel->getUserViewQuery(self::USER_ID)->findAll();
        $this->assertNotNull($result);
        $this->assertEquals($result[0]['note_content'], "Test 123");
    }

    public function testViewNote()
    {
        $plugin = new Plugin($this->container);
        $plugin->initialize();
        $notesModel = new NotesModel($this->container);
        $newNoteId = $this->createTestNote($notesModel);
        $result = $notesModel->getNoteByIdForUser($newNoteId, self::USER_ID);
        $this->assertNotNull($result);
        $this->assertEquals($result['note_content'], "Test 123");
    }

    public function testUpdateNote() {
        $plugin = new Plugin($this->container);
        $plugin->initialize();
        $notesModel = new NotesModel($this->container);
        $newNoteId = $this->createTestNote($notesModel);
        $note = [
            "noteId" => $newNoteId,
            "note_content" => "Test 456",
            "note_title" => "Testing the spoony",
            "tags" => [],
        ];
        $result = $notesModel->saveNote($note, self::USER_ID);
        $this->assertNotNull($result);
        $this->assertTrue($result);
    }

    public function testDeleteNote() {
        $plugin = new Plugin($this->container);
        $plugin->initialize();
        $notesModel = new NotesModel($this->container);
        $newNoteId = $this->createTestNote($notesModel);
        $result = $notesModel->deleteNote($newNoteId, self::USER_ID);
        $this->assertNotNull($result);
        $this->assertTrue($result);
    }

    public function createTestNote($notesModel) {
        $note = [
            "note_content" => "Test 123",
            "note_title" => "Testing the bard",
            "tags" => ["blue", "green", "orange"],
        ];
        $newNoteId = $notesModel->createNote($note, self::USER_ID);
        return $newNoteId;
    }
}
