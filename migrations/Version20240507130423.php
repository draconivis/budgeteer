<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507130423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__budget AS SELECT id, owner_id, current_value, start_date, end_date FROM budget');
        $this->addSql('DROP TABLE budget');
        $this->addSql('CREATE TABLE budget (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, current_value DOUBLE PRECISION NOT NULL, start_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_date DATETIME NOT NULL, CONSTRAINT FK_73F2F77B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO budget (id, owner_id, current_value, start_date, end_date) SELECT id, owner_id, current_value, start_date, end_date FROM __temp__budget');
        $this->addSql('DROP TABLE __temp__budget');
        $this->addSql('CREATE INDEX IDX_73F2F77B7E3C61F9 ON budget (owner_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, name FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, name VARCHAR(100) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, name) SELECT id, username, name FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__budget AS SELECT id, owner_id, current_value, start_date, end_date FROM budget');
        $this->addSql('DROP TABLE budget');
        $this->addSql('CREATE TABLE budget (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, current_value DOUBLE PRECISION NOT NULL, start_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_date DATETIME NOT NULL, CONSTRAINT FK_73F2F77B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO budget (id, owner_id, current_value, start_date, end_date) SELECT id, owner_id, current_value, start_date, end_date FROM __temp__budget');
        $this->addSql('DROP TABLE __temp__budget');
        $this->addSql('CREATE INDEX IDX_73F2F77B7E3C61F9 ON budget (owner_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, name FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(50) NOT NULL, name VARCHAR(100) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, username, name) SELECT id, username, name FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
