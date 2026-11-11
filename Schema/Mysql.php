<?php

namespace Kanboard\Plugin\Notes\Schema;

use PDO;

const VERSION = 2;

function version_1(PDO $pdo)
{
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS notes (
            id INTEGER AUTO_INCREMENT PRIMARY KEY,
            note_owner_id INTEGER NOT NULL,
            note_owner_type TEXT NOT NULL,
            note_title TEXT NOT NULL,
            note_content TEXT NOT NULL,
            created_on BIGINT NOT NULL,
            created_by INTEGER NOT NULL,
            modified_on BIGINT NOT NULL,
            modified_by INTEGER NOT NULL
        );'
    );
}

function version_2(PDO $pdo)
{
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS notes_user_tags (
            id INTEGER AUTO_INCREMENT PRIMARY KEY,
            name TEXT NOT NULL,
            user_id INTEGER NOT NULL, color_id TEXT DEFAULT NULL,
            UNIQUE(user_id, name)
        );'
    );

    $pdo->exec('
        CREATE TABLE IF NOT EXISTS note_has_user_tags (
            note_id INTEGER NOT NULL,
            tag_id INTEGER NOT NULL,
            FOREIGN KEY(note_id) REFERENCES notes(id) ON DELETE CASCADE,
            FOREIGN KEY(tag_id) REFERENCES notes_user_tags(id) ON DELETE CASCADE,
            UNIQUE(tag_id, note_id)
        );'
    );
}