<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501115703 extends AbstractMigration
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
        $this->addSql('ALTER TABLE exercise CHANGE classes_id classes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE list_exercise ADD try TINYINT(1) NOT NULL, CHANGE nomber_try nomber_try INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE classes CHANGE author_id author_id INT DEFAULT NULL, CHANGE update_date update_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE exercise CHANGE classes_id classes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE list_exercise DROP try, CHANGE nomber_try nomber_try INT DEFAULT NULL');
    }
}
