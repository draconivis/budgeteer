<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507111222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, current_value DOUBLE PRECISION NOT NULL, start_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_date DATETIME NOT NULL, CONSTRAINT FK_73F2F77B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_73F2F77B7E3C61F9 ON budget (owner_id)');
        $this->addSql('CREATE TABLE "transaction" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, budget_id INTEGER DEFAULT NULL, date DATE NOT NULL, value DOUBLE PRECISION NOT NULL, reimbursement BOOLEAN NOT NULL, CONSTRAINT FK_723705D136ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_723705D136ABA6B8 ON "transaction" (budget_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(50) NOT NULL, name VARCHAR(100) DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('DROP TABLE user');
    }
}
