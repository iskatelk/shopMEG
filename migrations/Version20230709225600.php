<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709225600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sellers_products (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sellers_products_products (sellers_products_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_227D905A4E5B4FA5 (sellers_products_id), INDEX IDX_227D905A6C8A81A9 (products_id), PRIMARY KEY(sellers_products_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sellers_products_products ADD CONSTRAINT FK_227D905A4E5B4FA5 FOREIGN KEY (sellers_products_id) REFERENCES sellers_products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sellers_products_products ADD CONSTRAINT FK_227D905A6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sellers_products_products DROP FOREIGN KEY FK_227D905A4E5B4FA5');
        $this->addSql('ALTER TABLE sellers_products_products DROP FOREIGN KEY FK_227D905A6C8A81A9');
        $this->addSql('DROP TABLE sellers_products');
        $this->addSql('DROP TABLE sellers_products_products');
    }
}
