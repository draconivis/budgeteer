<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703183803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__transaction AS SELECT id, budget_id, value, reimbursement, date, deleted FROM "transaction"');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('CREATE TABLE "transaction" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, budget_id INTEGER DEFAULT NULL, value INTEGER NOT NULL, reimbursement BOOLEAN NOT NULL, date VARCHAR(25) NOT NULL, deleted BOOLEAN NOT NULL, title VARCHAR(100) NOT NULL, CONSTRAINT FK_723705D136ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "transaction" (id, budget_id, value, reimbursement, date, deleted) SELECT id, budget_id, value, reimbursement, date, deleted FROM __temp__transaction');
        $this->addSql('DROP TABLE __temp__transaction');
        $this->addSql('CREATE INDEX IDX_723705D136ABA6B8 ON "transaction" (budget_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__transaction AS SELECT id, budget_id, value, reimbursement, date, deleted FROM "transaction"');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('CREATE TABLE "transaction" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, budget_id INTEGER DEFAULT NULL, value INTEGER NOT NULL, reimbursement BOOLEAN NOT NULL, date VARCHAR(25) NOT NULL, deleted BOOLEAN DEFAULT FALSE NOT NULL, CONSTRAINT FK_723705D136ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "transaction" (id, budget_id, value, reimbursement, date, deleted) SELECT id, budget_id, value, reimbursement, date, deleted FROM __temp__transaction');
        $this->addSql('DROP TABLE __temp__transaction');
        $this->addSql('CREATE INDEX IDX_723705D136ABA6B8 ON "transaction" (budget_id)');
    }
}
