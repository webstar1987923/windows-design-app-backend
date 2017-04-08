<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170211202832 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE projects ADD dapulse_pulse_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD extra_id_data TEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A421BB1C55 ON projects (dapulse_pulse_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A4FE08E883 ON projects (extra_id_data)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX UNIQ_5C93B3A421BB1C55');
        $this->addSql('DROP INDEX UNIQ_5C93B3A4FE08E883');
        $this->addSql('ALTER TABLE projects DROP dapulse_pulse_id');
        $this->addSql('ALTER TABLE projects DROP extra_id_data');
    }
}
