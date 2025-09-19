<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250919133615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_roles (users_id INT NOT NULL, roles_id INT NOT NULL, PRIMARY KEY(users_id, roles_id))');
        $this->addSql('CREATE INDEX IDX_54FCD59F67B3B43D ON user_roles (users_id)');
        $this->addSql('CREATE INDEX IDX_54FCD59F38C751C4 ON user_roles (roles_id)');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59F67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59F38C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_roles DROP CONSTRAINT fk_51498a8e38c751c4');
        $this->addSql('ALTER TABLE users_roles DROP CONSTRAINT fk_51498a8e67b3b43d');
        $this->addSql('DROP TABLE users_roles');
        $this->addSql('ALTER TABLE permission ALTER category DROP DEFAULT');
        $this->addSql('ALTER TABLE permission ALTER category TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE users_roles (users_id INT NOT NULL, roles_id INT NOT NULL, PRIMARY KEY(users_id, roles_id))');
        $this->addSql('CREATE INDEX idx_51498a8e38c751c4 ON users_roles (roles_id)');
        $this->addSql('CREATE INDEX idx_51498a8e67b3b43d ON users_roles (users_id)');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT fk_51498a8e38c751c4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT fk_51498a8e67b3b43d FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_roles DROP CONSTRAINT FK_54FCD59F67B3B43D');
        $this->addSql('ALTER TABLE user_roles DROP CONSTRAINT FK_54FCD59F38C751C4');
        $this->addSql('DROP TABLE user_roles');
        $this->addSql('ALTER TABLE permission ALTER category SET DEFAULT \'default\'');
        $this->addSql('ALTER TABLE permission ALTER category TYPE VARCHAR(50)');
    }
}
