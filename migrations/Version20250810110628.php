<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250810110628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX unique_login_pass ON users');
        $this->addSql('ALTER TABLE users ADD password_hash VARCHAR(255) NOT NULL, ADD roles JSON NOT NULL, DROP pass, CHANGE public_id public_id CHAR(36) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9AA08CB10 ON users (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1483A5E9AA08CB10 ON `users`');
        $this->addSql('ALTER TABLE `users` ADD pass VARCHAR(8) NOT NULL, DROP password_hash, DROP roles, CHANGE public_id public_id VARCHAR(8) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX unique_login_pass ON `users` (login, pass)');
    }
}
