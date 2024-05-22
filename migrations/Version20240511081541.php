<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240511081541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__budget AS SELECT id, owner_id, current_value, start_date, end_date, deleted, starting_value FROM budget');
        $this->addSql('DROP TABLE budget');
        $this->addSql('CREATE TABLE budget (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, current_value NUMERIC(8, 2) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, deleted BOOLEAN NOT NULL, starting_value NUMERIC(8, 2) NOT NULL, CONSTRAINT FK_73F2F77B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO budget (id, owner_id, current_value, start_date, end_date, deleted, starting_value) SELECT id, owner_id, current_value, start_date, end_date, deleted, starting_value FROM __temp__budget');
        $this->addSql('DROP TABLE __temp__budget');
        $this->addSql('CREATE INDEX IDX_73F2F77B7E3C61F9 ON budget (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__budget AS SELECT id, owner_id, starting_value, current_value, start_date, end_date, deleted FROM budget');
        $this->addSql('DROP TABLE budget');
        $this->addSql('CREATE TABLE budget (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, starting_value INTEGER NOT NULL, current_value INTEGER NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, deleted BOOLEAN NOT NULL, CONSTRAINT FK_73F2F77B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO budget (id, owner_id, starting_value, current_value, start_date, end_date, deleted) SELECT id, owner_id, starting_value, current_value, start_date, end_date, deleted FROM __temp__budget');
        $this->addSql('DROP TABLE __temp__budget');
        $this->addSql('CREATE INDEX IDX_73F2F77B7E3C61F9 ON budget (owner_id)');
    }
}
