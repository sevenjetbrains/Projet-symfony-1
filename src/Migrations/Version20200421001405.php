<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421001405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE classes CHANGE author_id author_id INT DEFAULT NULL, CHANGE update_date update_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise ADD classes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51C9E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id)');
        $this->addSql('CREATE INDEX IDX_AEDAD51C9E225B24 ON exercise (classes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE classes CHANGE author_id author_id INT DEFAULT NULL, CHANGE update_date update_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51C9E225B24');
        $this->addSql('DROP INDEX IDX_AEDAD51C9E225B24 ON exercise');
        $this->addSql('ALTER TABLE exercise DROP classes_id');
    }
}
