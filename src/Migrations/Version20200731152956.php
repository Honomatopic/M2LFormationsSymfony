<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200731152956 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employe_session (employe_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_144BB9771B65292 (employe_id), INDEX IDX_144BB977613FECDF (session_id), PRIMARY KEY(employe_id, session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employe_session ADD CONSTRAINT FK_144BB9771B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe_session ADD CONSTRAINT FK_144BB977613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE formation_employe');
        $this->addSql('ALTER TABLE duree CHANGE datedebut datedebut DATE DEFAULT NULL, CHANGE datefin datefin DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE intervenant CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE prestataire CHANGE nom nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE salle CHANGE nom nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE session CHANGE formations_id formations_id INT DEFAULT NULL, CHANGE durees_id durees_id INT DEFAULT NULL, CHANGE salles_id salles_id INT DEFAULT NULL, CHANGE intervenants_id intervenants_id INT DEFAULT NULL, CHANGE prestataires_id prestataires_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_employe (formation_id INT NOT NULL, employe_id INT NOT NULL, INDEX IDX_BDFB96C21B65292 (employe_id), INDEX IDX_BDFB96C25200282E (formation_id), PRIMARY KEY(formation_id, employe_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE formation_employe ADD CONSTRAINT FK_BDFB96C21B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_employe ADD CONSTRAINT FK_BDFB96C25200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE employe_session');
        $this->addSql('ALTER TABLE duree CHANGE datedebut datedebut DATE DEFAULT \'NULL\', CHANGE datefin datefin DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE intervenant CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE prestataire CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE salle CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE session CHANGE formations_id formations_id INT DEFAULT NULL, CHANGE durees_id durees_id INT DEFAULT NULL, CHANGE salles_id salles_id INT DEFAULT NULL, CHANGE intervenants_id intervenants_id INT DEFAULT NULL, CHANGE prestataires_id prestataires_id INT DEFAULT NULL');
    }
}
