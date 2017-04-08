<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170326141202 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $conn = $this->connection;

        $this->addSql('ALTER TABLE units ADD quote_id INT DEFAULT NULL;');
        $this->addSql('ALTER TABLE units ADD CONSTRAINT FK_E9B07449DB805178 FOREIGN KEY (quote_id) REFERENCES quotes (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
        $this->addSql('CREATE INDEX IDX_E9B07449DB805178 ON units (quote_id);');

        $this->addSql('ALTER TABLE accessories ADD quote_id INT DEFAULT NULL;');
        $this->addSql('ALTER TABLE accessories ADD CONSTRAINT FK_210A2640DB805178 FOREIGN KEY (quote_id) REFERENCES quotes (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
        $this->addSql('CREATE INDEX IDX_210A2640DB805178 ON accessories (quote_id);');

        if ($projects = $conn->fetchAll('SELECT DISTINCT u.project_id, p.quote_date, p.quote_revision FROM units AS u JOIN projects AS p ON p.id = u.project_id')) {
            $stmt = $conn->prepare("INSERT INTO quotes (id, project_id, date, revision, is_default) VALUES (nextval('quotes_id_seq'), :projectId, :date, :revision, true)");

            foreach ($projects as $project) {
                $stmt->execute([
                    ':projectId' => $project['project_id'],
                    ':date'      => $project['quote_date'],
                    ':revision'  => $project['quote_revision'],
                ]);
            }

            $quotes = $conn->fetchAll('SELECT q.* FROM quotes AS q WHERE q.is_default = true');

            foreach ($quotes as $quote) {
                $this->addSql(sprintf(
                    "UPDATE units SET quote_id=%d WHERE project_id=%d",
                    intval($quote['id']),
                    intval($quote['project_id'])
                ));

                $this->addSql(sprintf(
                    "UPDATE accessories SET quote_id=%d WHERE project_id=%d",
                    intval($quote['id']),
                    intval($quote['project_id'])
                ));
            }
        }

        $this->addSql('ALTER TABLE units DROP CONSTRAINT fk_e9b07449166d1f9c;');
        $this->addSql('DROP INDEX idx_e9b07449166d1f9c;');
        $this->addSql('ALTER TABLE units DROP COLUMN project_id;');

        $this->addSql('ALTER TABLE accessories DROP CONSTRAINT fk_210a2640166d1f9c;');
        $this->addSql('DROP INDEX idx_210a2640166d1f9c;');
        $this->addSql('ALTER TABLE accessories DROP COLUMN project_id;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE units ADD project_id INT DEFAULT NULL;');
        $this->addSql('ALTER TABLE units ADD CONSTRAINT FK_E9B07449166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
        $this->addSql('CREATE INDEX IDX_E9B07449166D1F9C ON units (project_id);');

        $conn = $this->connection;

        $quoteIds = [];

        if ($units = $conn->fetchAll('SELECT DISTINCT u.quote_id, q.project_id FROM units AS u JOIN quotes AS q ON q.id = u.quote_id WHERE q.is_default=true')) {
            foreach ($units as $unit) {
                $this->addSql(sprintf(
                    "UPDATE units SET project_id=%d, quote_id=null WHERE quote_id=%d",
                    intval($unit['project_id']),
                    intval($unit['quote_id'])
                ));
            }

            $quoteIds += array_column($units, 'quote_id');
        }

        $this->addSql('ALTER TABLE accessories ADD project_id INT DEFAULT NULL;');
        $this->addSql('ALTER TABLE accessories ADD CONSTRAINT fk_210a2640166d1f9c FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
        $this->addSql('CREATE INDEX idx_210a2640166d1f9c ON accessories (project_id);');

        if ($accessories = $conn->fetchAll('SELECT DISTINCT a.quote_id, q.project_id FROM accessories AS a JOIN quotes AS q ON q.id = a.quote_id WHERE q.is_default=true')) {
            foreach ($accessories as $accessory) {
                $this->addSql(sprintf(
                    "UPDATE accessories SET project_id=%d, quote_id=null WHERE quote_id=%d",
                    intval($accessory['project_id']),
                    intval($accessory['quote_id'])
                ));
            }

            $quoteIds += array_column($accessories, 'quote_id');
        }

        if (!empty($quoteIds)) {
            $quoteIds = array_unique($quoteIds);
            $quoteIds = array_map('intval', $quoteIds);

            $this->addSql("DELETE FROM quotes WHERE id IN(" . implode(',', $quoteIds) . ")");
        }

        $this->addSql('ALTER TABLE units DROP CONSTRAINT FK_E9B07449DB805178;');
        $this->addSql('DROP INDEX IDX_E9B07449DB805178;');
        $this->addSql('ALTER TABLE units DROP COLUMN quote_id;');

        $this->addSql('ALTER TABLE accessories DROP CONSTRAINT FK_210A2640DB805178;');
        $this->addSql('DROP INDEX IDX_210A2640DB805178;');
        $this->addSql('ALTER TABLE accessories DROP COLUMN quote_id;');
    }
}
