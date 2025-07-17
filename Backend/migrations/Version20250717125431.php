<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717125431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
    // Création de la table messenger_messages
       $this->addSql('CREATE TABLE messenger_messages (
        id BIGINT AUTO_INCREMENT NOT NULL,
        body LONGTEXT NOT NULL,
        headers LONGTEXT NOT NULL,
        queue_name VARCHAR(190) NOT NULL,
        created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
        available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
        delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
        INDEX IDX_75EA56E0FB7336F0 (queue_name),
        INDEX IDX_75EA56E0E3BD61CE (available_at),
        INDEX IDX_75EA56E016BA31DB (delivered_at),
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

    // Supprime la contrainte de clé étrangère
    $this->addSql('ALTER TABLE users DROP FOREIGN KEY fk_role');

    // Supprime l'index
    $this->addSql('DROP INDEX fk_role ON users');

    // Recrée l'index avec un nouveau nom
    $this->addSql('CREATE INDEX IDX_1483A5E9D60322AC ON users (role_id)');

    // Recrée la clé étrangère si nécessaire
    $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_ROLE FOREIGN KEY (role_id) REFERENCES roles (id)');
}
}
