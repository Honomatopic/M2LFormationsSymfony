<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520172237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE employe_formation');
        $this->addSql('DROP TABLE formation_employe');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employe_formation (employe_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_816E27E91B65292 (employe_id), INDEX IDX_816E27E95200282E (formation_id), PRIMARY KEY(employe_id, formation_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formation_employe (formation_id INT NOT NULL, employe_id INT NOT NULL, INDEX IDX_BDFB96C25200282E (formation_id), INDEX IDX_BDFB96C21B65292 (employe_id), PRIMARY KEY(formation_id, employe_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE employe_formation ADD CONSTRAINT FK_816E27E91B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe_formation ADD CONSTRAINT FK_816E27E95200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_employe ADD CONSTRAINT FK_BDFB96C21B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_employe ADD CONSTRAINT FK_BDFB96C25200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
    }
}
