<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200430110601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE list_exercise (id INT AUTO_INCREMENT NOT NULL, student_try_id INT NOT NULL, nomber_try INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_D0B7E67CA362766F (student_try_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE list_exercise ADD CONSTRAINT FK_D0B7E67CA362766F FOREIGN KEY (student_try_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE classes CHANGE author_id author_id INT DEFAULT NULL, CHANGE update_date update_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise CHANGE classes_id classes_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE list_exercise');
        $this->addSql('ALTER TABLE classes CHANGE author_id author_id INT DEFAULT NULL, CHANGE update_date update_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE exercise CHANGE classes_id classes_id INT DEFAULT NULL');
    }
}
