<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519141728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        /**$this->addSql('CREATE TABLE employe_formation (employe_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_816E27E91B65292 (employe_id), INDEX IDX_816E27E95200282E (formation_id), PRIMARY KEY(employe_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_employe (formation_id INT NOT NULL, employe_id INT NOT NULL, INDEX IDX_BDFB96C25200282E (formation_id), INDEX IDX_BDFB96C21B65292 (employe_id), PRIMARY KEY(formation_id, employe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employe_formation ADD CONSTRAINT FK_816E27E91B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe_formation ADD CONSTRAINT FK_816E27E95200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_employe ADD CONSTRAINT FK_BDFB96C25200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_employe ADD CONSTRAINT FK_BDFB96C21B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');*/
        $this->addSql('ALTER TABLE inscrire ADD employe_id INT DEFAULT NULL, ADD formation_id INT DEFAULT NULL, DROP employe_id, DROP formation_id');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8325980C0 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A89CF0022 FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_84CA37A8325980C0 ON inscrire (employe_id)');
        $this->addSql('CREATE INDEX IDX_84CA37A89CF0022 ON inscrire (formation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE employe_formation');
        $this->addSql('DROP TABLE formation_employe');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8325980C0');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A89CF0022');
        $this->addSql('DROP INDEX IDX_84CA37A8325980C0 ON inscrire');
        $this->addSql('DROP INDEX IDX_84CA37A89CF0022 ON inscrire');
        $this->addSql('ALTER TABLE inscrire ADD employe_id INT NOT NULL, ADD formation_id INT NOT NULL, DROP employe_id_id, DROP formation_id_id');
    }
}
