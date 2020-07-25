<?php

declare(strict_types=1);

/*
 * This file is part of joopdt.nl.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200725174914 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE File (id INT AUTO_INCREMENT NOT NULL, story_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, originalName VARCHAR(255) NOT NULL, mimeType VARCHAR(255) NOT NULL, size INT NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, INDEX IDX_2CAD992EAA5D4036 (story_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Story (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, text LONGTEXT NOT NULL, notify TINYINT(1) NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE File ADD CONSTRAINT FK_2CAD992EAA5D4036 FOREIGN KEY (story_id) REFERENCES Story (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE File DROP FOREIGN KEY FK_2CAD992EAA5D4036');
        $this->addSql('DROP TABLE File');
        $this->addSql('DROP TABLE Story');
    }
}
