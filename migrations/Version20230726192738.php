<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726192738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_products ADD order_ref_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EBE238517C FOREIGN KEY (order_ref_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_5242B8EBE238517C ON order_products (order_ref_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_products DROP FOREIGN KEY FK_5242B8EBE238517C');
        $this->addSql('DROP INDEX IDX_5242B8EBE238517C ON order_products');
        $this->addSql('ALTER TABLE order_products DROP order_ref_id');
    }
}
