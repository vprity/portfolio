<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716084541 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE option_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE option (id INT NOT NULL, is_hidden BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE portfolio ADD option_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED1062A7C41D6F FOREIGN KEY (option_id) REFERENCES option (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9ED1062A7C41D6F ON portfolio (option_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE portfolio DROP CONSTRAINT FK_A9ED1062A7C41D6F');
        $this->addSql('DROP SEQUENCE option_id_seq CASCADE');
        $this->addSql('DROP TABLE option');
        $this->addSql('DROP INDEX UNIQ_A9ED1062A7C41D6F');
        $this->addSql('ALTER TABLE portfolio DROP option_id');
    }
}
