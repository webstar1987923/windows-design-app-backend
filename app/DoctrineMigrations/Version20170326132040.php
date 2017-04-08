<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170326132040 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE quotes_id_seq INCREMENT BY 1 MINVALUE 1 START 1;');

        $this->addSql('CREATE TABLE quotes (
          id INT NOT NULL,
          project_id INT DEFAULT NULL,
          position INT DEFAULT NULL,
          name VARCHAR(255) DEFAULT NULL,
          revision INT DEFAULT NULL,
          date VARCHAR(255) DEFAULT NULL,
          is_default BOOLEAN NOT NULL,
          PRIMARY KEY(id));
        ');
        $this->addSql('CREATE INDEX IDX_A1B588C5166D1F9C ON quotes (project_id);');
        $this->addSql('ALTER TABLE quotes ADD CONSTRAINT FK_A1B588C5166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE quotes_id_seq CASCADE');
        $this->addSql('DROP TABLE quotes;');
    }
}
