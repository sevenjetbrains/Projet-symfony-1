<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200422001744 extends AbstractMigration
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
        $this->addSql('ALTER TABLE `lines` ADD exercise_id INT NOT NULL');
        $this->addSql('ALTER TABLE `lines` ADD CONSTRAINT FK_4F018C96E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)');
        $this->addSql('CREATE INDEX IDX_4F018C96E934951A ON `lines` (exercise_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE classes CHANGE author_id author_id INT DEFAULT NULL, CHANGE update_date update_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE exercise CHANGE classes_id classes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `lines` DROP FOREIGN KEY FK_4F018C96E934951A');
        $this->addSql('DROP INDEX IDX_4F018C96E934951A ON `lines`');
        $this->addSql('ALTER TABLE `lines` DROP exercise_id');
    }
}
