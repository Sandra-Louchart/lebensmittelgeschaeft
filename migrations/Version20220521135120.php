<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521135120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE home');
        $this->addSql('DROP TABLE home_pictures');
        $this->addSql('ALTER TABLE category DROP slug');
        $this->addSql('ALTER TABLE products DROP slug, DROP picture');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE home (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, picture LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE home_pictures (id INT AUTO_INCREMENT NOT NULL, picture LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE category ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE products ADD slug VARCHAR(255) NOT NULL, ADD picture VARCHAR(255) NOT NULL');
    }
}
