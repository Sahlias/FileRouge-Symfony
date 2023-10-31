<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009205245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre ADD chaines_a_la_carte INT NOT NULL, ADD television_a_ecran_plat INT NOT NULL, DROP chaines_à_la_carte, DROP television_à_ecran_plat, CHANGE categorie_id categorie_id INT NOT NULL, CHANGE superficie superficie VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE chambre_id chambre_id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP is_verified, CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre ADD chaines_à_la_carte INT NOT NULL, ADD television_à_ecran_plat INT NOT NULL, DROP chaines_a_la_carte, DROP television_a_ecran_plat, CHANGE categorie_id categorie_id INT DEFAULT NULL, CHANGE superficie superficie VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE chambre_id chambre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE prenom prenom VARCHAR(100) NOT NULL, CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
