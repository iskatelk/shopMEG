<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230811023747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE history_view (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F5C8DBF2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history_view_products (history_view_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_C4A0C72A2772342D (history_view_id), INDEX IDX_C4A0C72A6C8A81A9 (products_id), PRIMARY KEY(history_view_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE history_view ADD CONSTRAINT FK_F5C8DBF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE history_view_products ADD CONSTRAINT FK_C4A0C72A2772342D FOREIGN KEY (history_view_id) REFERENCES history_view (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history_view_products ADD CONSTRAINT FK_C4A0C72A6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history_view DROP FOREIGN KEY FK_F5C8DBF2A76ED395');
        $this->addSql('ALTER TABLE history_view_products DROP FOREIGN KEY FK_C4A0C72A2772342D');
        $this->addSql('ALTER TABLE history_view_products DROP FOREIGN KEY FK_C4A0C72A6C8A81A9');
        $this->addSql('DROP TABLE history_view');
        $this->addSql('DROP TABLE history_view_products');
    }
}
