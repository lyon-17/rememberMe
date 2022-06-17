<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617084716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, priority INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recall ADD state_id INT DEFAULT NULL');
        //Default values, except done, can be removed or modified later
        $this->addSql("INSERT INTO `status` (`name`, `priority`) VALUES ('done', 3), ('urgent',1), ('progress',2) ");
        $this->addSql('ALTER TABLE recall ADD CONSTRAINT FK_4B3005765D83CC1 FOREIGN KEY (state_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_4B3005765D83CC1 ON recall (state_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recall DROP FOREIGN KEY FK_4B3005765D83CC1');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP INDEX IDX_4B3005765D83CC1 ON recall');
        $this->addSql('ALTER TABLE recall DROP state_id');
    }
}
