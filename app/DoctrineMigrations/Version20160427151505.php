<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160427151505 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE projects_files DROP CONSTRAINT fk_93b41467a76ed395');
        $this->addSql('DROP INDEX idx_93b41467a76ed395');
        $this->addSql('ALTER TABLE projects_files DROP CONSTRAINT projects_files_pkey');
        $this->addSql('ALTER TABLE projects_files RENAME COLUMN user_id TO project_id');
        $this->addSql('ALTER TABLE projects_files ADD CONSTRAINT FK_93B41467166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_93B41467166D1F9C ON projects_files (project_id)');
        $this->addSql('ALTER TABLE projects_files ADD PRIMARY KEY (project_id, file_uuid)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE projects_files DROP CONSTRAINT FK_93B41467166D1F9C');
        $this->addSql('DROP INDEX IDX_93B41467166D1F9C');
        $this->addSql('ALTER TABLE projects_files DROP CONSTRAINT projects_files_pkey');
        $this->addSql('ALTER TABLE projects_files RENAME COLUMN project_id TO user_id');
        $this->addSql('ALTER TABLE projects_files ADD CONSTRAINT fk_93b41467a76ed395 FOREIGN KEY (user_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_93b41467a76ed395 ON projects_files (user_id)');
        $this->addSql('ALTER TABLE projects_files ADD PRIMARY KEY (user_id, file_uuid)');
    }
}
