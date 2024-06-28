<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627135339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id CHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, user_id CHAR(36) DEFAULT NULL, INDEX IDX_3AF34668A76ED395 (user_id), PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE receipts (id CHAR(36) NOT NULL, file_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, transaction_id CHAR(36) DEFAULT NULL, INDEX IDX_1DEBE3A22FC0CB0F (transaction_id), PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transactions (id CHAR(36) NOT NULL, description VARCHAR(255) NOT NULL, amount NUMERIC(13, 2) NOT NULL, date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, user_id CHAR(36) DEFAULT NULL, category_id CHAR(36) DEFAULT NULL, INDEX IDX_EAA81A4CA76ED395 (user_id), INDEX IDX_EAA81A4C12469DE2 (category_id), PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE receipts ADD CONSTRAINT FK_1DEBE3A22FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transactions (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668A76ED395');
        $this->addSql('ALTER TABLE receipts DROP FOREIGN KEY FK_1DEBE3A22FC0CB0F');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CA76ED395');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C12469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE receipts');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE users');
    }
}
