<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928074630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF9B177F54');
        $this->addSql('DROP INDEX IDX_C509E4FF9B177F54 ON chambre');
        $this->addSql('ALTER TABLE chambre DROP chambre_id');
        $this->addSql('ALTER TABLE reservation ADD chambre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('CREATE INDEX IDX_42C849559B177F54 ON reservation (chambre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre ADD chambre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF9B177F54 FOREIGN KEY (chambre_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_C509E4FF9B177F54 ON chambre (chambre_id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559B177F54');
        $this->addSql('DROP INDEX IDX_42C849559B177F54 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP chambre_id');
    }
}
