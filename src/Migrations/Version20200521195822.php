<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521195822 extends AbstractMigration
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
        $this->addSql('ALTER TABLE inscrire DROP id, CHANGE employe_id employe_id INT NOT NULL, CHANGE formation_id formation_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscrire ADD PRIMARY KEY (employe_id, formation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscrire ADD id INT AUTO_INCREMENT NOT NULL, CHANGE employe_id employe_id INT DEFAULT NULL, CHANGE formation_id formation_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
