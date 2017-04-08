<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161104180902 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("ALTER TABLE binary_files ADD has_thumbnail BOOLEAN DEFAULT NULL;");
        $this->addSql("UPDATE binary_files SET has_thumbnail=TRUE WHERE thumbnail IS NOT NULL;");
        $this->addSql("ALTER TABLE binary_files DROP thumbnail;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("ALTER TABLE binary_files ADD thumbnail VARCHAR(50) DEFAULT NULL;");
        $this->addSql("UPDATE binary_files SET thumbnail=uuid || '-thumbnail' WHERE has_thumbnail=TRUE;");
        $this->addSql("ALTER TABLE binary_files DROP has_thumbnail;");
    }
}
