<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250316161907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, statut INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, date_debut DATE NOT NULL, nbre_heures INT NOT NULL, departement VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_404021BFF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, luser_id INT DEFAULT NULL, la_formation_id INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_5E90F6D6D8646676 (luser_id), INDEX IDX_5E90F6D6C6E58DBA (la_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6D8646676 FOREIGN KEY (luser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6C6E58DBA FOREIGN KEY (la_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D8646676');
        $this->addSql('DROP INDEX IDX_8D93D649D8646676 ON user');
        $this->addSql('ALTER TABLE user DROP luser_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BFF347EFB');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6D8646676');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6C6E58DBA');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE produit');
        $this->addSql('ALTER TABLE user ADD luser_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D8646676 FOREIGN KEY (luser_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649D8646676 ON user (luser_id)');
    }
}
