<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161226235145 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE dictionary_entry_profile ADD pricing_grids TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE dictionary_entry_profile ADD cost_per_item NUMERIC(19, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE filling_type_profile ADD pricing_grids TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE dictionary ADD pricing_scheme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE dictionary_entry DROP price');
        $this->addSql('ALTER TABLE dictionary_entry ALTER data TYPE TEXT');
        $this->addSql('ALTER TABLE dictionary_entry ALTER data DROP DEFAULT');
        $this->addSql('ALTER TABLE dictionary_entry ALTER data DROP NOT NULL');
        $this->addSql('ALTER TABLE dictionary_entry ALTER data TYPE TEXT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE filling_type_profile DROP pricing_grids');
        $this->addSql('ALTER TABLE dictionary_entry ADD price VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE dictionary_entry ALTER data TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE dictionary_entry ALTER data DROP DEFAULT');
        $this->addSql('ALTER TABLE dictionary_entry ALTER data SET NOT NULL');
        $this->addSql('ALTER TABLE dictionary_entry_profile DROP pricing_grids');
        $this->addSql('ALTER TABLE dictionary_entry_profile DROP cost_per_item');
        $this->addSql('ALTER TABLE dictionary DROP pricing_scheme');
    }
}
