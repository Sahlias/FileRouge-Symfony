<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926092439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chambre_reservation (chambre_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_B3C537269B177F54 (chambre_id), INDEX IDX_B3C53726B83297E7 (reservation_id), PRIMARY KEY(chambre_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chambre_reservation ADD CONSTRAINT FK_B3C537269B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chambre_reservation ADD CONSTRAINT FK_B3C53726B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre_reservation DROP FOREIGN KEY FK_B3C537269B177F54');
        $this->addSql('ALTER TABLE chambre_reservation DROP FOREIGN KEY FK_B3C53726B83297E7');
        $this->addSql('DROP TABLE chambre_reservation');
    }
}
