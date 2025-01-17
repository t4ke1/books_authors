<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703093845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (
            id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
            name VARCHAR(255) NOT NULL,
            book_count INT NOT NULL DEFAULT 0, 
            created_at TIMESTAMP not null default current_timestamp, 
            updated_at TIMESTAMP not null default current_timestamp,
            PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDAFD8C85E237E06 ON author (name)');
        $this->addSql('CREATE TABLE book (
            id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
            name VARCHAR(255) NOT NULL, 
            genre VARCHAR(255) NOT NULL, 
            created_at TIMESTAMP not null default current_timestamp, 
            updated_at TIMESTAMP not null default current_timestamp, 
            PRIMARY KEY(id))');
       $this->addSql('CREATE TABLE users (
            id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL,
            name VARCHAR(255) NOT NULL, 
            email VARCHAR(255) NOT NULL, 
            password VARCHAR(255) NOT NULL, 
            verify BOOLEAN NOT NULL default false, 
            token INT DEFAULT NULL, 
            role VARCHAR(255),
            created_at TIMESTAMP not null default current_timestamp, 
            updated_at TIMESTAMP not null default current_timestamp, 
            PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A3315E237E06 ON book (name)');
        $this->addSql('CREATE TABLE book_author (book_id INT NOT NULL, author_id INT NOT NULL, PRIMARY KEY(book_id, author_id))');
        $this->addSql('CREATE INDEX IDX_9478D34516A2B381 ON book_author (book_id)');
        $this->addSql('CREATE INDEX IDX_9478D345F675F31B ON book_author (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E95E237E06 ON users (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE book_author ADD CONSTRAINT FK_9478D34516A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_author ADD CONSTRAINT FK_9478D345F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book_author DROP CONSTRAINT FK_9478D34516A2B381');
        $this->addSql('ALTER TABLE book_author DROP CONSTRAINT FK_9478D345F675F31B');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_author');
        $this->addSql('DROP TABLE users');
    }
}
