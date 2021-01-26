<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522155736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_employe (formation_id INT NOT NULL, employe_id INT NOT NULL, INDEX IDX_BDFB96C25200282E (formation_id), INDEX IDX_BDFB96C21B65292 (employe_id), PRIMARY KEY(formation_id, employe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_employe ADD CONSTRAINT FK_BDFB96C25200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_employe ADD CONSTRAINT FK_BDFB96C21B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE inscrire');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inscrire (employe_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_84CA37A81B65292 (employe_id), INDEX IDX_84CA37A85200282E (formation_id), PRIMARY KEY(employe_id, formation_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A81B65292 FOREIGN KEY (employe_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A85200282E FOREIGN KEY (formation_id) REFERENCES employe (id)');
        $this->addSql('DROP TABLE formation_employe');
    }
}
