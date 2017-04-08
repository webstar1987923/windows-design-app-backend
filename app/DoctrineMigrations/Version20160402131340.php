<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160402131340 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE users_files (user_id INT NOT NULL, file_uuid UUID NOT NULL, PRIMARY KEY(user_id, file_uuid))');
        $this->addSql('CREATE INDEX IDX_E142E410A76ED395 ON users_files (user_id)');
        $this->addSql('CREATE INDEX IDX_E142E410588338C8 ON users_files (file_uuid)');
        $this->addSql('CREATE TABLE projects_files (user_id INT NOT NULL, file_uuid UUID NOT NULL, PRIMARY KEY(user_id, file_uuid))');
        $this->addSql('CREATE INDEX IDX_93B41467A76ED395 ON projects_files (user_id)');
        $this->addSql('CREATE INDEX IDX_93B41467588338C8 ON projects_files (file_uuid)');
        $this->addSql('CREATE TABLE binary_files (uuid UUID NOT NULL, created_by_id INT NOT NULL, updated_by_id INT NOT NULL, original_name VARCHAR(1024) NOT NULL, content_type VARCHAR(256) NOT NULL, size INT NOT NULL, filesystem VARCHAR(512) NOT NULL, filesystem_name VARCHAR(1024) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_BA593312B03A8386 ON binary_files (created_by_id)');
        $this->addSql('CREATE INDEX IDX_BA593312896DBBDE ON binary_files (updated_by_id)');
        $this->addSql('ALTER TABLE users_files ADD CONSTRAINT FK_E142E410A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_files ADD CONSTRAINT FK_E142E410588338C8 FOREIGN KEY (file_uuid) REFERENCES binary_files (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects_files ADD CONSTRAINT FK_93B41467A76ED395 FOREIGN KEY (user_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects_files ADD CONSTRAINT FK_93B41467588338C8 FOREIGN KEY (file_uuid) REFERENCES binary_files (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binary_files ADD CONSTRAINT FK_BA593312B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE binary_files ADD CONSTRAINT FK_BA593312896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users_files DROP CONSTRAINT FK_E142E410588338C8');
        $this->addSql('ALTER TABLE projects_files DROP CONSTRAINT FK_93B41467588338C8');
        $this->addSql('DROP TABLE users_files');
        $this->addSql('DROP TABLE projects_files');
        $this->addSql('DROP TABLE binary_files');
    }
}
