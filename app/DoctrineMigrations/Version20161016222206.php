<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161016222206 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE dictionary_entry DROP CONSTRAINT FK_CAC92220AF5E5B3C;');
        $this->addSql('ALTER TABLE dictionary_entry ADD CONSTRAINT FK_CAC92220AF5E5B3C FOREIGN KEY (dictionary_id) REFERENCES dictionary (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;');
        $this->addSql('ALTER TABLE dictionary_entry_profile DROP CONSTRAINT FK_C109BE971B06BF2E;');
        $this->addSql('ALTER TABLE dictionary_entry_profile ADD CONSTRAINT FK_C109BE971B06BF2E FOREIGN KEY (dictionary_entry_id) REFERENCES dictionary_entry (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE dictionary_entry DROP CONSTRAINT FK_CAC92220AF5E5B3C;');
        $this->addSql('ALTER TABLE dictionary_entry ADD CONSTRAINT FK_CAC92220AF5E5B3C FOREIGN KEY (dictionary_id) REFERENCES dictionary (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
        $this->addSql('ALTER TABLE dictionary_entry_profile DROP CONSTRAINT FK_C109BE971B06BF2E;');
        $this->addSql('ALTER TABLE dictionary_entry_profile ADD CONSTRAINT FK_C109BE971B06BF2E FOREIGN KEY (dictionary_entry_id) REFERENCES dictionary_entry (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
    }
}
