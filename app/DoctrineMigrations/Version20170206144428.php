<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170206144428 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE dictionary_entry_profile ADD pricing_equation_params TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE profiles ADD pricing_scheme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profiles ADD pricing_equation_params TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE filling_type_profile ADD pricing_equation_params TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE filling_types ADD pricing_scheme VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE profiles DROP pricing_scheme');
        $this->addSql('ALTER TABLE profiles DROP pricing_equation_params');
        $this->addSql('ALTER TABLE filling_types DROP pricing_scheme');
        $this->addSql('ALTER TABLE filling_type_profile DROP pricing_equation_params');
        $this->addSql('ALTER TABLE dictionary_entry_profile DROP pricing_equation_params');
    }
}
