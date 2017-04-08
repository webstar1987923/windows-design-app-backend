<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160426175319 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // convert profile_name to profile_id
        $this->addSql('UPDATE units SET profile_id = (SELECT id FROM profiles WHERE profiles.name = units.profile_name)');
        $this->addSql('ALTER TABLE units DROP CONSTRAINT fk_e9b07449ccfa12b8;');
        $this->addSql('ALTER TABLE units ADD CONSTRAINT fk_units_profiles FOREIGN KEY (profile_id) REFERENCES profiles (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE SET NULL;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('UPDATE units SET profile_id = null');
        $this->addSql('ALTER TABLE units DROP CONSTRAINT fk_units_profiles ;');
        $this->addSql('ALTER TABLE units ADD CONSTRAINT fk_e9b07449ccfa12b8 FOREIGN KEY (profile_id) REFERENCES profiles (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;');
    }
}
