<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170327133953 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE profiles ADD fixed_uf NUMERIC(19, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE profiles ADD operable_uf NUMERIC(19, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE profiles ADD mullion_uf NUMERIC(19, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE profiles ADD edge_of_glazing_u_value NUMERIC(19, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE profiles DROP fixed_uf');
        $this->addSql('ALTER TABLE profiles DROP operable_uf');
        $this->addSql('ALTER TABLE profiles DROP mullion_uf');
        $this->addSql('ALTER TABLE profiles DROP edge_of_glazing_u_value');
    }
}
