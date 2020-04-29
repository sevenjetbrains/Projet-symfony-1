<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200427212147 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE solution (id INT AUTO_INCREMENT NOT NULL, exercise_id INT NOT NULL, title_exercise VARCHAR(255) NOT NULL, INDEX IDX_9F3329DBE934951A (exercise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DBE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE classes CHANGE author_id author_id INT DEFAULT NULL, CHANGE update_date update_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise CHANGE classes_id classes_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE solution');
        $this->addSql('ALTER TABLE classes CHANGE author_id author_id INT DEFAULT NULL, CHANGE update_date update_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE exercise CHANGE classes_id classes_id INT DEFAULT NULL');
    }
}
