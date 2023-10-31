<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928074430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FFB83297E7');
        $this->addSql('DROP INDEX IDX_C509E4FFB83297E7 ON chambre');
        $this->addSql('ALTER TABLE chambre CHANGE reservation_id chambre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF9B177F54 FOREIGN KEY (chambre_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_C509E4FF9B177F54 ON chambre (chambre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF9B177F54');
        $this->addSql('DROP INDEX IDX_C509E4FF9B177F54 ON chambre');
        $this->addSql('ALTER TABLE chambre CHANGE chambre_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_C509E4FFB83297E7 ON chambre (reservation_id)');
    }
}
