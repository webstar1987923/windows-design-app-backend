<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170201001621 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE projects ADD frontapp_thread_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD frontapp_gdrive_folder_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A4908A37F7 ON projects (frontapp_thread_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A49E36D039 ON projects (frontapp_gdrive_folder_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX UNIQ_5C93B3A4908A37F7');
        $this->addSql('DROP INDEX UNIQ_5C93B3A49E36D039');
        $this->addSql('ALTER TABLE projects DROP frontapp_thread_id');
        $this->addSql('ALTER TABLE projects DROP frontapp_gdrive_folder_id');
    }
}
