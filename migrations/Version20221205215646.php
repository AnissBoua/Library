<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221205215646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier_item (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, livre_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_EBFD0067F77D927C (panier_id), INDEX IDX_EBFD006737D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier_item ADD CONSTRAINT FK_EBFD0067F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE panier_item ADD CONSTRAINT FK_EBFD006737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier_item DROP FOREIGN KEY FK_EBFD0067F77D927C');
        $this->addSql('ALTER TABLE panier_item DROP FOREIGN KEY FK_EBFD006737D925CB');
        $this->addSql('DROP TABLE panier_item');
    }
}
