<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522145329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscrire MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE inscrire DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE inscrire ADD employe_id INT NOT NULL, ADD formation_id INT NOT NULL, DROP id, DROP employe, DROP formation');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A81B65292 FOREIGN KEY (employe_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A85200282E FOREIGN KEY (formation_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_84CA37A81B65292 ON inscrire (employe_id)');
        $this->addSql('CREATE INDEX IDX_84CA37A85200282E ON inscrire (formation_id)');
        $this->addSql('ALTER TABLE inscrire ADD PRIMARY KEY (employe_id, formation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A81B65292');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A85200282E');
        $this->addSql('DROP INDEX IDX_84CA37A81B65292 ON inscrire');
        $this->addSql('DROP INDEX IDX_84CA37A85200282E ON inscrire');
        $this->addSql('ALTER TABLE inscrire ADD id INT AUTO_INCREMENT NOT NULL, ADD employe INT NOT NULL, ADD formation INT NOT NULL, DROP employe_id, DROP formation_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
