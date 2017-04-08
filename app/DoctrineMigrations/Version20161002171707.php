<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161002171707 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE dictionary_entry_profile ADD is_default BOOLEAN;');
        $this->addSql('ALTER TABLE dictionary_entry_profile ALTER COLUMN is_default SET DEFAULT false;');
        $this->addSql('UPDATE dictionary_entry_profile SET is_default=false;');
        $this->addSql('ALTER TABLE dictionary_entry_profile ALTER COLUMN is_default SET NOT NULL;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE dictionary_entry_profile DROP is_default;');
    }
}
