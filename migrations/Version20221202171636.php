<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202171636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livre_category (livre_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_6A87FF6837D925CB (livre_id), INDEX IDX_6A87FF6812469DE2 (category_id), PRIMARY KEY(livre_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre_category ADD CONSTRAINT FK_6A87FF6837D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_category ADD CONSTRAINT FK_6A87FF6812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre_category DROP FOREIGN KEY FK_6A87FF6837D925CB');
        $this->addSql('ALTER TABLE livre_category DROP FOREIGN KEY FK_6A87FF6812469DE2');
        $this->addSql('DROP TABLE livre_category');
    }
}
