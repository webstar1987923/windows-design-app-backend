<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161102194138 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE filling_type_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE filling_type_profile (id INT NOT NULL, profile_id INT DEFAULT NULL, filling_type_id INT DEFAULT NULL, is_default BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52CC6556CCFA12B8 ON filling_type_profile (profile_id)');
        $this->addSql('CREATE INDEX IDX_52CC6556241E6227 ON filling_type_profile (filling_type_id)');
        $this->addSql('CREATE UNIQUE INDEX idx_fillingtype_profile ON filling_type_profile (filling_type_id, profile_id)');
        $this->addSql('ALTER TABLE filling_type_profile ADD CONSTRAINT FK_52CC6556CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profiles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE filling_type_profile ADD CONSTRAINT FK_52CC6556241E6227 FOREIGN KEY (filling_type_id) REFERENCES filling_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dictionary_entry_profile ALTER is_default DROP DEFAULT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE filling_type_profile_id_seq CASCADE');
        $this->addSql('DROP TABLE filling_type_profile');
        $this->addSql('ALTER TABLE dictionary_entry_profile ALTER is_default SET DEFAULT \'false\'');
    }
}
