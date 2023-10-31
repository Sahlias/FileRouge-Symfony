<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */

final class Version20230917205801 extends AbstractMigration



{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE reservation CHANGE user_id user_id INT DEFAULT NULL, CHANGE date_entrée date_entree DATE NOT NULL');

        $this->addSql('ALTER TABLE categorie DROP chambre_double_superieure, DROP chambre_double_deluxe, DROP suite_junior');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE reservation CHANGE user_id user_id INT NOT NULL, CHANGE date_entree date_entrée DATE NOT NULL');

        $this->addSql('ALTER TABLE categorie ADD chambre_double_superieure VARCHAR(255) NOT NULL, ADD chambre_double_deluxe VARCHAR(255) NOT NULL, ADD suite_junior VARCHAR(255) NOT NULL');
    }
}