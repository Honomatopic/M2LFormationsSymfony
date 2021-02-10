<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200731151021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, formations_id INT DEFAULT NULL, durees_id INT DEFAULT NULL, salles_id INT DEFAULT NULL, intervenants_id INT DEFAULT NULL, prestataires_id INT DEFAULT NULL, INDEX IDX_D044D5D45200282E (formation_id), INDEX IDX_D044D5D43BF5B0C2 (formations_id), INDEX IDX_D044D5D491A0EF74 (durees_id), INDEX IDX_D044D5D4B11E4946 (salles_id), INDEX IDX_D044D5D4130E9263 (intervenants_id), INDEX IDX_D044D5D4B2CAA6B8 (prestataires_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D43BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D491A0EF74 FOREIGN KEY (durees_id) REFERENCES duree (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4B11E4946 FOREIGN KEY (salles_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4130E9263 FOREIGN KEY (intervenants_id) REFERENCES intervenant (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4B2CAA6B8 FOREIGN KEY (prestataires_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE duree CHANGE datedebut datedebut DATE DEFAULT NULL, CHANGE datefin datefin DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE intervenant CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE prestataire CHANGE nom nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE salle CHANGE nom nom VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE session');
        $this->addSql('ALTER TABLE duree CHANGE datedebut datedebut DATE DEFAULT \'NULL\', CHANGE datefin datefin DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE intervenant CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE prestataire CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE salle CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
