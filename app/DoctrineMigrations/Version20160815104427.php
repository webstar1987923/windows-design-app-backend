<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160815104427 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX uniq_1483a5e992fc23a8');
        $this->addSql('DROP INDEX uniq_1483a5e9a0d96fbf');
        $this->addSql('ALTER TABLE users ADD lastname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE users DROP last_login');
        $this->addSql('ALTER TABLE users DROP expired');
        $this->addSql('ALTER TABLE users DROP expires_at');
        $this->addSql('ALTER TABLE users DROP confirmation_token');
        $this->addSql('ALTER TABLE users DROP password_requested_at');
        $this->addSql('ALTER TABLE users DROP credentials_expired');
        $this->addSql('ALTER TABLE users DROP credentials_expire_at');
        $this->addSql('ALTER TABLE users RENAME COLUMN email_canonical TO firstname');
        $this->addSql('ALTER TABLE binary_files ADD thumbnail VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE binary_files ADD thumbnail_width SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE binary_files ADD thumbnail_height SMALLINT DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_5c93b3a4777c91f8');
        $this->addSql('ALTER TABLE projects ADD project_notes TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD shipping_notes TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE projects DROP pipedrive_id');
        $this->addSql('ALTER TABLE projects DROP sync_datetime');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE binary_files DROP thumbnail');
        $this->addSql('ALTER TABLE binary_files DROP thumbnail_width');
        $this->addSql('ALTER TABLE binary_files DROP thumbnail_height');
        $this->addSql('ALTER TABLE projects ADD pipedrive_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD sync_datetime TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE projects DROP project_notes');
        $this->addSql('ALTER TABLE projects DROP shipping_notes');
        $this->addSql('CREATE UNIQUE INDEX uniq_5c93b3a4777c91f8 ON projects (pipedrive_id)');
        $this->addSql('ALTER TABLE users ADD email_canonical VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD expired BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE users ADD expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD confirmation_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD credentials_expired BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE users ADD credentials_expire_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE users DROP firstname');
        $this->addSql('ALTER TABLE users DROP lastname');
        $this->addSql('ALTER TABLE users RENAME COLUMN deleted_at TO last_login');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e992fc23a8 ON users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9a0d96fbf ON users (email_canonical)');
    }
}
