<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250727173739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(8) NOT NULL, phone VARCHAR(8) NOT NULL, pass VARCHAR(8) NOT NULL, public_id VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9B5B48B91 (public_id), UNIQUE INDEX unique_login_pass (login, pass), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, public_id VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, login VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, pass VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX unique_login_pass (login, pass), UNIQUE INDEX UNIQ_8D93D649B5B48B91 (public_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE `users`');
    }
}
