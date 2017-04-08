<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160203140418 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE units_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE profiles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE accessories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE filling_types_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE app_settings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE projects_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE project_files_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE units (id INT NOT NULL, project_id INT DEFAULT NULL, profile_id INT DEFAULT NULL, mark VARCHAR(255) DEFAULT NULL, width NUMERIC(19, 4) DEFAULT NULL, height NUMERIC(19, 4) DEFAULT NULL, quantity INT DEFAULT NULL, type VARCHAR(100) DEFAULT NULL, description TEXT DEFAULT NULL, notes TEXT DEFAULT NULL, exceptions TEXT DEFAULT NULL, profile_name VARCHAR(255) DEFAULT NULL, customer_image TEXT DEFAULT NULL, internal_color VARCHAR(50) DEFAULT NULL, external_color VARCHAR(50) DEFAULT NULL, interior_handle VARCHAR(255) DEFAULT NULL, exterior_handle VARCHAR(255) DEFAULT NULL, hardware_type VARCHAR(255) DEFAULT NULL, lock_mechanism VARCHAR(255) DEFAULT NULL, glazing_bead VARCHAR(255) DEFAULT NULL, gasket_color VARCHAR(50) DEFAULT NULL, hinge_style VARCHAR(255) DEFAULT NULL, opening_direction VARCHAR(50) DEFAULT NULL, internal_sill VARCHAR(255) DEFAULT NULL, external_sill VARCHAR(255) DEFAULT NULL, glazing VARCHAR(255) DEFAULT NULL, uw NUMERIC(19, 4) DEFAULT NULL, original_cost NUMERIC(19, 4) DEFAULT NULL, original_currency VARCHAR(100) DEFAULT NULL, conversion_rate NUMERIC(19, 4) DEFAULT NULL, supplier_discount NUMERIC(7, 4) DEFAULT NULL, price_markup NUMERIC(19, 4) DEFAULT NULL, discount NUMERIC(7, 4) DEFAULT NULL, root_section TEXT DEFAULT NULL, glazing_bar_width NUMERIC(19, 4) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E9B07449166D1F9C ON units (project_id)');
        $this->addSql('CREATE INDEX IDX_E9B07449CCFA12B8 ON units (profile_id)');
        $this->addSql('CREATE TABLE profiles (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, unit_type VARCHAR(255) DEFAULT NULL, system VARCHAR(255) DEFAULT NULL, frame_width NUMERIC(19, 4) DEFAULT NULL, mullion_width NUMERIC(19, 4) DEFAULT NULL, sash_frame_width NUMERIC(19, 4) DEFAULT NULL, sash_frame_overlap NUMERIC(19, 4) DEFAULT NULL, sash_mullion_overlap NUMERIC(19, 4) DEFAULT NULL, frame_corners VARCHAR(255) DEFAULT NULL, sash_corners VARCHAR(255) DEFAULT NULL, threshold_width NUMERIC(19, 4) DEFAULT NULL, low_threshold BOOLEAN DEFAULT NULL, frame_u_value NUMERIC(19, 4) DEFAULT NULL, spacer_thermal_bridge_value NUMERIC(19, 4) DEFAULT NULL, supplier_system VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE accessories (id INT NOT NULL, project_id INT DEFAULT NULL, description TEXT DEFAULT NULL, quantity NUMERIC(19, 4) DEFAULT NULL, extras_type VARCHAR(100) DEFAULT NULL, original_cost NUMERIC(19, 4) DEFAULT NULL, original_currency VARCHAR(100) DEFAULT NULL, conversion_rate NUMERIC(19, 4) DEFAULT NULL, price_markup NUMERIC(19, 4) DEFAULT NULL, discount NUMERIC(7, 4) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_210A2640166D1F9C ON accessories (project_id)');
        $this->addSql('CREATE TABLE filling_types (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, supplier_name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, locked BOOLEAN NOT NULL, expired BOOLEAN NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, credentials_expired BOOLEAN NOT NULL, credentials_expire_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E992FC23A8 ON users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)');
        $this->addSql('COMMENT ON COLUMN users.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE app_settings (id INT NOT NULL, system_name VARCHAR(255) NOT NULL, display_name VARCHAR(255) NOT NULL, group_name VARCHAR(255) DEFAULT NULL, value TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EDC5C0684FEFCDF0 ON app_settings (system_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EDC5C068D5499347 ON app_settings (display_name)');
        $this->addSql('CREATE TABLE projects (id INT NOT NULL, pipedrive_id VARCHAR(255) DEFAULT NULL, client_name VARCHAR(255) DEFAULT NULL, client_company_name VARCHAR(255) DEFAULT NULL, client_phone VARCHAR(255) DEFAULT NULL, client_email VARCHAR(255) DEFAULT NULL, client_address VARCHAR(255) DEFAULT NULL, project_name VARCHAR(255) DEFAULT NULL, project_address VARCHAR(255) DEFAULT NULL, quote_date VARCHAR(255) DEFAULT NULL, quote_revision INT DEFAULT NULL, sync_datetime TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A4777C91F8 ON projects (pipedrive_id)');
        $this->addSql('CREATE TABLE project_files (id INT NOT NULL, project_id INT DEFAULT NULL, pipedrive_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(100) NOT NULL, url VARCHAR(1024) NOT NULL, sync_datetime TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_156049C7777C91F8 ON project_files (pipedrive_id)');
        $this->addSql('CREATE INDEX IDX_156049C7166D1F9C ON project_files (project_id)');
        $this->addSql('ALTER TABLE units ADD CONSTRAINT FK_E9B07449166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE units ADD CONSTRAINT FK_E9B07449CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profiles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE accessories ADD CONSTRAINT FK_210A2640166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_files ADD CONSTRAINT FK_156049C7166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE units DROP CONSTRAINT FK_E9B07449CCFA12B8');
        $this->addSql('ALTER TABLE units DROP CONSTRAINT FK_E9B07449166D1F9C');
        $this->addSql('ALTER TABLE accessories DROP CONSTRAINT FK_210A2640166D1F9C');
        $this->addSql('ALTER TABLE project_files DROP CONSTRAINT FK_156049C7166D1F9C');
        $this->addSql('DROP SEQUENCE units_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE profiles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE accessories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE filling_types_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE app_settings_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE projects_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE project_files_id_seq CASCADE');
        $this->addSql('DROP TABLE units');
        $this->addSql('DROP TABLE profiles');
        $this->addSql('DROP TABLE accessories');
        $this->addSql('DROP TABLE filling_types');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE app_settings');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE project_files');
    }
}
