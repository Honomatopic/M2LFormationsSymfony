<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200731151242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE duree CHANGE datedebut datedebut DATE DEFAULT NULL, CHANGE datefin datefin DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE intervenant CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE prestataire CHANGE nom nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE salle CHANGE nom nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45200282E');
        $this->addSql('DROP INDEX IDX_D044D5D45200282E ON session');
        $this->addSql('ALTER TABLE session DROP formation_id, CHANGE formations_id formations_id INT DEFAULT NULL, CHANGE durees_id durees_id INT DEFAULT NULL, CHANGE salles_id salles_id INT DEFAULT NULL, CHANGE intervenants_id intervenants_id INT DEFAULT NULL, CHANGE prestataires_id prestataires_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE duree CHANGE datedebut datedebut DATE DEFAULT \'NULL\', CHANGE datefin datefin DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE intervenant CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE prestataire CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE salle CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE session ADD formation_id INT DEFAULT NULL, CHANGE formations_id formations_id INT DEFAULT NULL, CHANGE durees_id durees_id INT DEFAULT NULL, CHANGE salles_id salles_id INT DEFAULT NULL, CHANGE intervenants_id intervenants_id INT DEFAULT NULL, CHANGE prestataires_id prestataires_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_D044D5D45200282E ON session (formation_id)');
    }
}
