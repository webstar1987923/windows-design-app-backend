<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160927232148 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE project_files_id_seq CASCADE');
        $this->addSql('DROP TABLE project_files');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE project_files_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE project_files (id INT NOT NULL, project_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(100) NOT NULL, url VARCHAR(1024) NOT NULL, pipedrive_id VARCHAR(255) DEFAULT NULL, sync_datetime TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_156049c7166d1f9c ON project_files (project_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_156049c7777c91f8 ON project_files (pipedrive_id)');
        $this->addSql('ALTER TABLE project_files ADD CONSTRAINT fk_156049c7166d1f9c FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
