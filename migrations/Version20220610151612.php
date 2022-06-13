<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610151612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE products_promo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_promo (products_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_504A642B6C8A81A9 (products_id), INDEX IDX_504A642BD0C07AFF (promo_id), PRIMARY KEY(products_id, promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE products_promo ADD CONSTRAINT FK_504A642B6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_promo ADD CONSTRAINT FK_504A642BD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
