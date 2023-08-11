<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809101810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `category` (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, products_id INT NOT NULL, name VARCHAR(255) NOT NULL, review LONGTEXT NOT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_9474526C6C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_category (products_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_134D09726C8A81A9 (products_id), INDEX IDX_134D097212469DE2 (category_id), PRIMARY KEY(products_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, products_id INT NOT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6F7494E6C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `category` ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES `category` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE products_category ADD CONSTRAINT FK_134D09726C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_category ADD CONSTRAINT FK_134D097212469DE2 FOREIGN KEY (category_id) REFERENCES `category` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE sellers_products_products DROP FOREIGN KEY FK_227D905A6C8A81A9');
        $this->addSql('ALTER TABLE sellers_products_products DROP FOREIGN KEY FK_227D905A4E5B4FA5');
        $this->addSql('DROP TABLE sellers_products_products');
        $this->addSql('ALTER TABLE `order` DROP customer_name, DROP email, CHANGE created_at created_at DATETIME NOT NULL, CHANGE order_number user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE order_products CHANGE order_number order_ref_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EBE238517C FOREIGN KEY (order_ref_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_5242B8EBE238517C ON order_products (order_ref_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sellers_products_products (sellers_products_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_227D905A6C8A81A9 (products_id), INDEX IDX_227D905A4E5B4FA5 (sellers_products_id), PRIMARY KEY(sellers_products_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sellers_products_products ADD CONSTRAINT FK_227D905A6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sellers_products_products ADD CONSTRAINT FK_227D905A4E5B4FA5 FOREIGN KEY (sellers_products_id) REFERENCES sellers_products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `category` DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C6C8A81A9');
        $this->addSql('ALTER TABLE products_category DROP FOREIGN KEY FK_134D09726C8A81A9');
        $this->addSql('ALTER TABLE products_category DROP FOREIGN KEY FK_134D097212469DE2');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E6C8A81A9');
        $this->addSql('DROP TABLE `category`');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE products_category');
        $this->addSql('DROP TABLE question');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD customer_name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE user_id order_number INT NOT NULL');
        $this->addSql('ALTER TABLE order_products DROP FOREIGN KEY FK_5242B8EBE238517C');
        $this->addSql('DROP INDEX IDX_5242B8EBE238517C ON order_products');
        $this->addSql('ALTER TABLE order_products CHANGE order_ref_id order_number INT NOT NULL');
    }
}
