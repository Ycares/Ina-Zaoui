<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260506115500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Resynchronise les sequences PostgreSQL sur les IDs max existants';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("SELECT setval('album_id_seq', COALESCE((SELECT MAX(id) FROM album), 0) + 1, false)");
        $this->addSql("SELECT setval('media_id_seq', COALESCE((SELECT MAX(id) FROM media), 0) + 1, false)");
        $this->addSql("SELECT setval('user_id_seq', COALESCE((SELECT MAX(id) FROM \"user\"), 0) + 1, false)");
    }

    public function down(Schema $schema): void
    {
        // No-op: migration de maintenance non reversible.
    }
}
