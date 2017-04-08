<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160930170942 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE unit_option_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dictionary_entry_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dictionary_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dictionary_entry_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE unit_option (id INT NOT NULL, unit_id INT DEFAULT NULL, dictionary_id INT DEFAULT NULL, dictionary_entry_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CDDFEB46F8BD700D ON unit_option (unit_id)');
        $this->addSql('CREATE INDEX IDX_CDDFEB46AF5E5B3C ON unit_option (dictionary_id)');
        $this->addSql('CREATE INDEX IDX_CDDFEB461B06BF2E ON unit_option (dictionary_entry_id)');
        $this->addSql('CREATE TABLE dictionary_entry_profile (id INT NOT NULL, dictionary_entry_id INT DEFAULT NULL, profile_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C109BE971B06BF2E ON dictionary_entry_profile (dictionary_entry_id)');
        $this->addSql('CREATE INDEX IDX_C109BE97CCFA12B8 ON dictionary_entry_profile (profile_id)');
        $this->addSql('CREATE TABLE dictionary (id INT NOT NULL, name VARCHAR(255) NOT NULL, rules_and_restrictions VARCHAR(8192) DEFAULT NULL, position INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE dictionary_entry (id INT NOT NULL, dictionary_id INT DEFAULT NULL, position INT NOT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, data VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CAC92220AF5E5B3C ON dictionary_entry (dictionary_id)');
        $this->addSql('ALTER TABLE unit_option ADD CONSTRAINT FK_CDDFEB46F8BD700D FOREIGN KEY (unit_id) REFERENCES units (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE unit_option ADD CONSTRAINT FK_CDDFEB46AF5E5B3C FOREIGN KEY (dictionary_id) REFERENCES dictionary (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE unit_option ADD CONSTRAINT FK_CDDFEB461B06BF2E FOREIGN KEY (dictionary_entry_id) REFERENCES dictionary_entry (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dictionary_entry_profile ADD CONSTRAINT FK_C109BE971B06BF2E FOREIGN KEY (dictionary_entry_id) REFERENCES dictionary_entry (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dictionary_entry_profile ADD CONSTRAINT FK_C109BE97CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profiles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dictionary_entry ADD CONSTRAINT FK_CAC92220AF5E5B3C FOREIGN KEY (dictionary_id) REFERENCES dictionary (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE units DROP CONSTRAINT fk_units_profiles');
        $this->addSql('ALTER TABLE units ADD CONSTRAINT FK_E9B07449CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE unit_option DROP CONSTRAINT FK_CDDFEB46AF5E5B3C');
        $this->addSql('ALTER TABLE dictionary_entry DROP CONSTRAINT FK_CAC92220AF5E5B3C');
        $this->addSql('ALTER TABLE unit_option DROP CONSTRAINT FK_CDDFEB461B06BF2E');
        $this->addSql('ALTER TABLE dictionary_entry_profile DROP CONSTRAINT FK_C109BE971B06BF2E');
        $this->addSql('DROP SEQUENCE unit_option_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dictionary_entry_profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dictionary_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dictionary_entry_id_seq CASCADE');
        $this->addSql('DROP TABLE unit_option');
        $this->addSql('DROP TABLE dictionary_entry_profile');
        $this->addSql('DROP TABLE dictionary');
        $this->addSql('DROP TABLE dictionary_entry');
        $this->addSql('ALTER TABLE units DROP CONSTRAINT FK_E9B07449CCFA12B8');
        $this->addSql('ALTER TABLE units ADD CONSTRAINT fk_units_profiles FOREIGN KEY (profile_id) REFERENCES profiles (id) ON UPDATE CASCADE ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
